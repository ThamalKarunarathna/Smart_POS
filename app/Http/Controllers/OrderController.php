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

        $items = Item::query()
            ->where('status', 1)
            ->orderBy('name')
            ->select('items.*')
            ->addSelect([
                // latest active selling price
                'latest_price' => ItemPrice::query()
                    ->select('selling_price')
                    ->whereColumn('item_prices.item_id', 'items.id')
                    ->where('item_prices.is_active', 1)
                    ->orderByDesc('item_prices.effective_from')
                    ->limit(1),

                // available stock = SUM(qty_in) - SUM(qty_out)
                'available_stock' => DB::table('stock_ledgers')
                    ->selectRaw('COALESCE(SUM(qty_in),0) - COALESCE(SUM(qty_out),0)')
                    ->whereColumn('stock_ledgers.item_id', 'items.id')
                    ->limit(1),
            ])
            ->get();

        return view('pos.orders.create', compact('customers', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'     => 'nullable|exists:customers,id',
            'discount'        => 'nullable|numeric|min:0',

            'credit_enabled'  => 'nullable|boolean',
            'vat_enabled'     => 'nullable|boolean',
            'sscl_enabled'    => 'nullable|boolean',
            'vat_amount'      => 'nullable|numeric|min:0',
            'sscl_amount'     => 'nullable|numeric|min:0',

            'items'           => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty'     => 'required|numeric|min:0.001',
        ]);

        return DB::transaction(function () use ($validated) {

            // 1) Create Order
            $order = Order::create([
                'order_no'    => $this->nextOrderNo(),
                'customer_id' => $validated['customer_id'] ?? null,
                'status'      => 'confirmed',
                'discount'    => $validated['discount'] ?? 0,
                'sub_total'   => 0,
                'grand_total' => 0,
                'created_by'  => auth()->id(),

                'credit_inv'      => !empty($validated['credit_enabled']),
                'vat_applicable'  => !empty($validated['vat_enabled']),
                'sscl_applicable' => !empty($validated['sscl_enabled']),
                'vat_amount'      => $validated['vat_amount'] ?? 0,
                'sscl_amount'     => $validated['sscl_amount'] ?? 0,
            ]);

            // 2) (IMPORTANT) If same item selected multiple times, aggregate qty per item
            $qtyByItem = [];
            foreach ($validated['items'] as $row) {
                $itemId = (int) $row['item_id'];
                $qty    = (float) $row['qty'];
                $qtyByItem[$itemId] = ($qtyByItem[$itemId] ?? 0) + $qty;
            }

            // 3) OPTIONAL: stock check BEFORE inserting (prevents negative stock)
            // available stock = sum(qty_in) - sum(qty_out)
            foreach ($qtyByItem as $itemId => $sellQty) {
                $available = (float) DB::table('stock_ledgers')
                    ->where('item_id', $itemId)
                    ->selectRaw('COALESCE(SUM(qty_in),0) - COALESCE(SUM(qty_out),0) AS available')
                    ->value('available');

                if ($sellQty > $available) {
                    abort(422, "Not enough stock for item ID {$itemId}. Available: {$available}, Selling: {$sellQty}");
                }
            }

            // 4) Save Order Items + issue stock (qty_out)
            // We use the ORIGINAL rows to preserve lines, but stock will be based on actual qty per line.
            foreach ($validated['items'] as $row) {

                $itemId = (int) $row['item_id'];
                $qty    = (float) $row['qty'];

                // latest active selling price
                $price = ItemPrice::where('item_id', $itemId)
                    ->where('is_active', 1)
                    ->orderByDesc('effective_from')
                    ->value('selling_price');

                if ($price === null) {
                    abort(422, "No active selling price found for item ID {$itemId}. Please add item price first.");
                }

                $lineTotal = round($qty * (float) $price, 2);

                // Insert order item
                OrderItem::create([
                    'order_id'   => $order->id,
                    'item_id'    => $itemId,
                    'qty'        => $qty,
                    'unit_price' => $price,
                    'line_total' => $lineTotal,
                ]);

                // ✅ Stock issue row in ledger (SALE / ref_id = order id)
                DB::table('stock_ledgers')->insert([
                    'item_id'    => $itemId,
                    'ref_type'   => 'SALE',
                    'ref_id'     => $order->id,
                    'qty_in'     => 0,
                    'qty_out'    => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 5) Recalculate totals (sub_total & grand_total)
            $this->recalculateTotals($order->id);

            return redirect("/pos/orders/{$order->id}/print")
                ->with('success', 'Order created successfully.');
        });
    }



    public function edit($id)
    {
        $order = Order::with(['items.item', 'customer'])->findOrFail($id);

        if ($order->status === 'cancelled') {
            return redirect('/pos/orders')->with('success', 'Cannot edit a cancelled order.');
        }

        $customers = Customer::where('is_active', 1)->orderBy('name')->get();
        $items = Item::query()
            ->where('status', 1)
            ->orderBy('name')
            ->select('items.*')
            ->addSelect([
                // latest active selling price
                'latest_price' => ItemPrice::query()
                    ->select('selling_price')
                    ->whereColumn('item_prices.item_id', 'items.id')
                    ->where('item_prices.is_active', 1)
                    ->orderByDesc('item_prices.effective_from')
                    ->limit(1),

                // available stock = SUM(qty_in) - SUM(qty_out)
                'available_stock' => DB::table('stock_ledgers')
                    ->selectRaw('COALESCE(SUM(qty_in),0) - COALESCE(SUM(qty_out),0)')
                    ->whereColumn('stock_ledgers.item_id', 'items.id')
                    ->limit(1),
            ])
            ->get();

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

            'credit_enabled' => 'nullable|boolean',
            'vat_enabled'    => 'nullable|boolean',
            'sscl_enabled'   => 'nullable|boolean',
            'vat_amount'     => 'nullable|numeric|min:0',
            'sscl_amount'    => 'nullable|numeric|min:0',

            'items'       => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty'     => 'required|numeric|min:0.001',
        ]);

        return DB::transaction(function () use ($order, $validated) {

            // 1) OLD quantities from existing order items
            $oldMap = $order->items
                ->groupBy('item_id')
                ->map(fn($rows) => (float) $rows->sum('qty'))
                ->toArray();

            // 2) NEW quantities from request
            $newMap = [];
            foreach ($validated['items'] as $row) {
                $itemId = (int) $row['item_id'];
                $qty    = (float) $row['qty'];
                $newMap[$itemId] = ($newMap[$itemId] ?? 0) + $qty;
            }

            // 3) Update order header
            $order->update([
                'customer_id' => $validated['customer_id'] ?? null,
                'discount'    => $validated['discount'] ?? 0,

                'credit_inv'      => !empty($validated['credit_enabled']),
                'vat_applicable'  => !empty($validated['vat_enabled']),
                'sscl_applicable' => !empty($validated['sscl_enabled']),
                'vat_amount'      => $validated['vat_amount'] ?? 0,
                'sscl_amount'     => $validated['sscl_amount'] ?? 0,
            ]);

            // 4) Rebuild order items
            OrderItem::where('order_id', $order->id)->delete();

            foreach ($validated['items'] as $row) {
                $itemId = (int) $row['item_id'];
                $qty    = (float) $row['qty'];

                $price = ItemPrice::where('item_id', $itemId)
                    ->where('is_active', 1)
                    ->orderByDesc('effective_from')
                    ->value('selling_price');

                if ($price === null) {
                    abort(422, "No active selling price found for item ID {$itemId}. Please add item price first.");
                }

                $lineTotal = round($qty * (float) $price, 2);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'item_id'    => $itemId,
                    'qty'        => $qty,
                    'unit_price' => $price,
                    'line_total' => $lineTotal,
                ]);
            }

            // 5) Stock ledger DELTA entries (ref_type=SALE, ref_id=order.id)
            $allItemIds = array_unique(array_merge(array_keys($oldMap), array_keys($newMap)));

            foreach ($allItemIds as $itemId) {
                $oldQty = (float) ($oldMap[$itemId] ?? 0);
                $newQty = (float) ($newMap[$itemId] ?? 0);
                $diff   = $newQty - $oldQty;

                if (abs($diff) < 0.000001) continue;

                if ($diff > 0) {
                    DB::table('stock_ledgers')->insert([
                        'item_id'    => $itemId,
                        'ref_type'   => 'SALE',
                        'ref_id'     => $order->id,
                        'qty_in'     => 0,
                        'qty_out'    => $diff,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::table('stock_ledgers')->insert([
                        'item_id'    => $itemId,
                        'ref_type'   => 'SALE',
                        'ref_id'     => $order->id,
                        'qty_in'     => abs($diff),
                        'qty_out'    => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
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
