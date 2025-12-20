<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')
            ->latest()
            ->paginate(10);

        return view('pos.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::where('is_active', 1)->orderBy('name')->get();
        $items = Item::where('status', 1)->orderBy('name')->get();

        return view('pos.orders.create', compact('customers', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'discount'    => 'nullable|numeric|min:0',
            'items'       => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty'     => 'required|numeric|min:0.001',
        ]);

        return DB::transaction(function () use ($validated) {

            $order = Order::create([
                'order_no'    => $this->nextOrderNo(),
                'customer_id' => $validated['customer_id'] ?? null,
                'status'      => 'confirmed',
                'discount'    => $validated['discount'] ?? 0,
                'sub_total'   => 0,
                'grand_total' => 0,
                'created_by'  => auth()->id(),
            ]);

            foreach ($validated['items'] as $row) {
                $itemId = (int)$row['item_id'];
                $qty  = (float)$row['qty'];

                //get lates active selling price for the item
                $price = ItemPrice::where('item_id', $itemId)
                    ->where('is_active', 1)
                    ->orderByDesc('effective_from')
                    ->value('selling_price');

                if ($price === null) {
                    abort(422, "No active selling price found for item ID {$itemId}. Please add item price first.");
                }

                $lineTotal = round($qty * (float)$price, 2);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'item_id'    => $itemId,
                    'qty'        => $qty,
                    'unit_price' => $price,
                    'line_total' => $lineTotal,
                ]);
            }

            $this->recalculateTotals($order->id);

            return redirect("/pos/orders/{$order->id}/print")->with('success', 'Order created successfully.');
        });
    }


    public function edit($id)
    {
        $order = Order::with(['items.item', 'customer'])->findOrFail($id);

        if ($order->status === 'cancelled') {
            return redirect('/pos/orders')->with('success', 'Cannot edit a cancelled order.');
        }

        $customers = Customer::where('is_active', 1)->orderBy('name')->get();
        $items = Item::where('status', 1)->orderBy('name')->get();

        return view('pos.orders.edit', compact('order', 'customers', 'items'));
    }


    public function update(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->status === 'cancelled') {
            abort(403, 'Cancelled orders cannot be updated.');
        }

        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'discount'    => 'nullable|numeric|min:0',
            'items'       => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty'     => 'required|numeric|min:0.001',
        ]);

        return DB::transaction(function () use ($order, $validated) {

            $order->update([
                'customer_id' => $validated['customer_id'] ?? null,
                'discount'    => $validated['discount'] ?? 0,
            ]);

            // remove old items and re-add (simple and safe)
            OrderItem::where('order_id', $order->id)->delete();

            foreach ($validated['items'] as $row) {
                $itemId = (int)$row['item_id'];
                $qty = (float)$row['qty'];

                $price = ItemPrice::where('item_id', $itemId)
                    ->where('is_active', 1)
                    ->orderByDesc('effective_from')
                    ->value('selling_price');

                if ($price === null) {
                    abort(422, "No active selling price found for item ID {$itemId}. Please add item price first.");
                }


                $lineTotal = round($qty * (float)$price, 2);

                OrderItem::create([
                    'order_id'    => $order->id,
                    'item_id'     => $itemId,
                    'qty'         => $qty,
                    'unit_price'  => $price,
                    'line_total'  => $lineTotal,
                ]);
            }

            $this->recalculateTotals($order->id);

            return redirect("/pos/orders/{$order->id}/print")
                ->with('success', 'Order updated successfully.');
        });
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'cancelled') {
            return redirect('/pos/orders')->with('success', 'Order already cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect('/pos/orders')->with('success', 'Order cancelled.');
    }

    public function print($id)
    {
        $order = Order::with(['items.item', 'customer'])->findOrFail($id);
        return view('pos.orders.print', compact('order'));
    }

    private function nextOrderNo(): string
{
    $last = \App\Models\Order::orderByDesc('id')->value('order_no'); // ex: ORD-000001

    if (!$last) {
        return 'ORD-000001';
    }

    $num = (int) str_replace('ORD-', '', $last);
    $num++;

    return 'ORD-' . str_pad((string)$num, 6, '0', STR_PAD_LEFT);
}

    private function recalculateTotals(int $orderId): void
    {
        $subTotal = (float) OrderItem::where('order_id', $orderId)->sum('line_total');
        $order = Order::findOrFail($orderId);
        $discount = (float) ($order->discount ?? 0);
        $grand = max(0, $subTotal - $discount);

        $order->update([
            'sub_total'   => round($subTotal, 2),
            'grand_total' => round($grand, 2),
        ]);
    }
}
