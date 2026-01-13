<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Receipt;
use App\Models\ReceiptInvoice;
use App\Models\Order;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::with(['customer', 'creator'])
            ->latest()
            ->paginate(10);

        return view('pos.receipts.index', compact('receipts'));
    }

    public function create()
    {
        $receiptNo = $this->nextReceiptNo();
        $customers = Customer::where('is_active', 1)->orderBy('name')->get();
        $banks = ChartOfAccount::where('account_type', 'Bank')
            ->orWhere('account_name', 'like', '%bank%')
            ->where('is_active', 1)
            ->orderBy('account_name')
            ->get();

        return view('pos.receipts.create', compact('receiptNo', 'customers', 'banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receipt_no' => 'required|string|max:50|unique:receipts,receipt_no',
            'receipt_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'received_amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:cash,bank,cheque',
            'cheque_no' => 'nullable|required_if:payment_type,cheque|string|max:100',
            'cheque_date' => 'nullable|required_if:payment_type,cheque|date',
            'cheque_bank' => 'nullable|required_if:payment_type,cheque|string|max:100',
            'bank_id' => 'nullable|required_if:payment_type,bank|exists:chart_of_accounts,id',
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'exists:orders,id',
            'amounts' => 'required|array',
            'amounts.*' => 'numeric|min:0.01',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Create receipt
            $receipt = Receipt::create([
                'receipt_no' => $validated['receipt_no'],
                'receipt_date' => $validated['receipt_date'],
                'customer_id' => $validated['customer_id'],
                'received_amount' => $validated['received_amount'],
                'payment_type' => $validated['payment_type'],
                'cheque_no' => $validated['cheque_no'] ?? null,
                'cheque_date' => $validated['cheque_date'] ?? null,
                'cheque_bank' => $validated['cheque_bank'] ?? null,
                'bank_id' => $validated['bank_id'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Create receipt invoice entries and update order paid amounts
            $orderIds = $request->input('order_ids', []);
            $amounts = $request->input('amounts', []);

            foreach ($orderIds as $index => $orderId) {
                $amount = floatval($amounts[$index] ?? 0);

                if ($amount > 0) {
                    $order = Order::findOrFail($orderId);
                    $currentPaid = $order->paid_amount ?? 0;
                    $balanceAmount = $order->grand_total - $currentPaid;

                    // Validate that amount doesn't exceed balance
                    if ($amount > $balanceAmount) {
                        throw new \Exception("Amount for order {$order->order_no} exceeds balance amount.");
                    }

                    ReceiptInvoice::create([
                        'receipt_id' => $receipt->id,
                        'order_id' => $orderId,
                        'amount' => $amount,
                    ]);

                    // Update order paid_amount
                    $newPaidAmount = $currentPaid + $amount;
                    $order->update([
                        'paid_amount' => $newPaidAmount,
                        'balance_amount' => $order->grand_total - $newPaidAmount,
                    ]);
                }
            }
        });

        return redirect('/pos/receipts')->with('success', 'Receipt created successfully.');
    }

    public function getCustomerUnpaidOrders(Request $request)
    {
        $customerId = $request->input('customer_id');

        if (!$customerId) {
            return response()->json(['orders' => []]);
        }

        $orders = Order::where('customer_id', $customerId)
            ->where('credit_inv', 1)
            ->whereRaw('COALESCE(grand_total, 0) != COALESCE(paid_amount, 0)')
            ->select('id', 'order_no', 'created_at', 'grand_total', 'paid_amount')
            ->selectRaw('(COALESCE(grand_total, 0) - COALESCE(paid_amount, 0)) as balance_amount')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_no' => $order->order_no,
                    'created_at' => $order->created_at->format('Y-m-d'),
                    'balance_amount' => floatval($order->balance_amount),
                ];
            });

        return response()->json(['orders' => $orders]);
    }

    private function nextReceiptNo(): string
    {
        $last = Receipt::orderBy('id', 'desc')->value('receipt_no');
        if (!$last) return 'RCP-000001';

        $num = (int) str_replace('RCP-', '', $last);
        $num++;
        return 'RCP-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }
}

