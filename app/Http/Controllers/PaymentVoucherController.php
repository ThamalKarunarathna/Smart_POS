<?php

namespace App\Http\Controllers;

use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherItem;
use App\Models\Supplier;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentVoucherController extends Controller
{
    public function index()
    {
        $vouchers = PaymentVoucher::latest()->paginate(10);
        return view('finance.payment_vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $voucherNo = $this->nextVoucherNo();
        $suppliers = Supplier::orderBy('name')->get();
        $accounts  = ChartOfAccount::orderBy('account_name')->get();

        return view('finance.payment_vouchers.create', compact('voucherNo','suppliers','accounts'));
    }

    private function nextVoucherNo(): string
    {
        $last = PaymentVoucher::orderBy('id', 'desc')->value('voucher_no');
        if (!$last) return 'PV-000001';

        $num = (int) str_replace('PV-', '', $last);
        $num++;
        return 'PV-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    /**
     * AJAX pending list
     */
    public function pending(Request $request)
    {
        $type = $request->get('type');
        $supplierId = $request->get('supplier_id');
        $selectedIds = $request->get('selected_ids', []);

        if (!$type || !$supplierId) {
            return response()->json(['rows' => []]);
        }

        $rows = [];

        if ($type === 'PO') {
            $q = DB::table('purchase_orders')
                ->select(
                    'id',
                    'po_no as no',
                    'po_date as date',
                    DB::raw("COALESCE(payable_amount, 0) as amount")
                )
                ->where('supplier_id', $supplierId)
                ->where('pay_status', 'Pending');

            if (!empty($selectedIds)) {
                $q->orWhereIn('id', $selectedIds);
            }

            $rows = $q->orderByDesc('id')->get()->map(fn($r) => [
                'id' => $r->id,
                'no' => $r->no,
                'date' => $r->date,
                'amount' => (float)$r->amount,
            ]);

        } elseif ($type === 'GRN') {

            $q = DB::table('grns as g')
                ->join('purchase_orders as po', 'po.id', '=', 'g.purchase_order_id')
                ->select(
                    'g.id',
                    'g.grn_no as no',
                    'g.grn_date as date',
                    DB::raw("COALESCE(g.payable_amount, 0) as amount")
                )
                ->where(function ($w) use ($supplierId, $selectedIds) {
                    $w->where(function ($x) use ($supplierId) {
                        $x->where('po.supplier_id', $supplierId)
                          ->where('g.pay_status', 'Pending');
                    });

                    if (!empty($selectedIds)) {
                        $w->orWhereIn('g.id', $selectedIds);
                    }
                });

            $rows = $q->orderByDesc('g.id')->get()->map(fn($r) => [
                'id' => $r->id,
                'no' => $r->no,
                'date' => $r->date,
                'amount' => (float)$r->amount,
            ]);

        } elseif ($type === 'BILL') {

            $q = DB::table('bill_entries')
                ->select(
                    'id',
                    'bill_entry_no as no',
                    'bill_date as date',
                    DB::raw("COALESCE(payable_amount, 0) as amount")
                )
                ->where('creditor_id', $supplierId)
                ->where('pay_status', 'Pending');

            if (!empty($selectedIds)) {
                $q->orWhereIn('id', $selectedIds);
            }

            $rows = $q->orderByDesc('id')->get()->map(fn($r) => [
                'id' => $r->id,
                'no' => $r->no,
                'date' => $r->date,
                'amount' => (float)$r->amount,
            ]);
        }

        return response()->json(['rows' => $rows]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'voucher_date' => 'required|date',
            'voucher_type' => 'required|in:PO,GRN,BILL,OTHER',
            'payment_type' => 'nullable|string|max:50',
            'description'  => 'nullable|string',
            'cr_account_id'=> 'required|exists:chart_of_accounts,id',
            'supplier_id'  => 'nullable|exists:suppliers,id',

            'items'                 => 'required|array|min:1',
            'items.*.ref_type'      => 'required|in:PO,GRN,BILL,OTHER',
            'items.*.ref_id'        => 'nullable|integer',
            'items.*.payee'         => 'nullable|string|max:150',
            'items.*.dr_account_id' => 'nullable|exists:chart_of_accounts,id',
            'items.*.amount'        => 'required|numeric|min:0.01',
        ]);

        if (in_array($validated['voucher_type'], ['PO','GRN','BILL']) && empty($validated['supplier_id'])) {
            return back()->withErrors(['supplier_id' => 'Supplier is required for this voucher type'])->withInput();
        }

        return DB::transaction(function () use ($validated) {

            $total = collect($validated['items'])->sum(fn($i) => (float)$i['amount']);

            $voucher = PaymentVoucher::create([
                'voucher_no'   => $this->nextVoucherNo(),
                'voucher_date' => $validated['voucher_date'],
                'voucher_type' => $validated['voucher_type'],
                'payment_type' => $validated['payment_type'] ?? null,
                'description'  => $validated['description'] ?? null,
                'cr_account_id'=> $validated['cr_account_id'],
                'total_value'  => $total,
                'created_by'   => auth()->id(),
                'status'       => 'Pending',
            ]);

            foreach ($validated['items'] as $it) {
                PaymentVoucherItem::create([
                    'payment_voucher_id' => $voucher->id,
                    'ref_type'      => $it['ref_type'],
                    'ref_id'        => $it['ref_id'] ?? null,
                    'payee'         => $it['payee'] ?? null,
                    'dr_account_id' => $it['dr_account_id'] ?? null,
                    'amount'        => $it['amount'],
                ]);
            }

            return redirect('/finance/payment_vouchers')->with('success', 'Payment Voucher created successfully.');
        });
    }

    public function edit($id)
    {
        $voucher   = PaymentVoucher::with('items')->findOrFail($id);
        $suppliers = Supplier::orderBy('name')->get();
        $accounts  = ChartOfAccount::orderBy('account_name')->get();

        $itemsForJs = $voucher->items->map(function ($i) {
            return [
                'ref_type'      => $i->ref_type,
                'ref_id'        => $i->ref_id,
                'payee'         => $i->payee,
                'dr_account_id' => $i->dr_account_id,
                'amount'        => number_format((float)$i->amount, 2, '.', ''),
            ];
        })->values();

        // ✅ Detect supplier id from existing items (for edit page default)
        $selectedSupplierId = null;

        if (in_array($voucher->voucher_type, ['PO','GRN','BILL'])) {
            $firstRefId = optional($voucher->items->first())->ref_id;

            if ($firstRefId) {
                if ($voucher->voucher_type === 'PO') {
                    $selectedSupplierId = DB::table('purchase_orders')->where('id', $firstRefId)->value('supplier_id');
                } elseif ($voucher->voucher_type === 'GRN') {
                    $selectedSupplierId = DB::table('grns as g')
                        ->join('purchase_orders as po', 'po.id', '=', 'g.purchase_order_id')
                        ->where('g.id', $firstRefId)
                        ->value('po.supplier_id');
                } elseif ($voucher->voucher_type === 'BILL') {
                    $selectedSupplierId = DB::table('bill_entries')->where('id', $firstRefId)->value('creditor_id');
                }
            }
        }

        return view('finance.payment_vouchers.edit', compact(
            'voucher','suppliers','accounts','itemsForJs','selectedSupplierId'
        ));
    }

    public function update(Request $request, $id)
    {
        $voucher = PaymentVoucher::with('items')->findOrFail($id);

        $validated = $request->validate([
            'voucher_no'   => 'required|string|max:50|unique:payment_vouchers,voucher_no,' . $voucher->id,
            'voucher_date' => 'required|date',
            'voucher_type' => 'required|in:PO,GRN,BILL,OTHER',
            'payment_type' => 'nullable|string|max:50',
            'description'  => 'nullable|string',
            'cr_account_id'=> 'required|exists:chart_of_accounts,id',
            'supplier_id'  => 'nullable|exists:suppliers,id',

            // ✅ always require items (OTHER also uses items)
            'items'                 => 'required|array|min:1',
            'items.*.ref_type'      => 'required|in:PO,GRN,BILL,OTHER',
            'items.*.ref_id'        => 'nullable|integer',
            'items.*.payee'         => 'nullable|string|max:150',
            'items.*.dr_account_id' => 'nullable|exists:chart_of_accounts,id',
            'items.*.amount'        => 'required|numeric|min:0.01',
        ]);

        if (in_array($validated['voucher_type'], ['PO','GRN','BILL']) && empty($validated['supplier_id'])) {
            return back()->withErrors(['supplier_id' => 'Supplier is required for this voucher type'])->withInput();
        }

        return DB::transaction(function () use ($voucher, $validated) {

            $total = collect($validated['items'])->sum(fn($i) => (float)$i['amount']);

            $voucher->update([
                'voucher_no'   => $validated['voucher_no'],
                'voucher_date' => $validated['voucher_date'],
                'voucher_type' => $validated['voucher_type'],
                'payment_type' => $validated['payment_type'] ?? null,
                'description'  => $validated['description'] ?? null,
                'cr_account_id'=> $validated['cr_account_id'],
                'total_value'  => $total,
            ]);

            PaymentVoucherItem::where('payment_voucher_id', $voucher->id)->delete();

            foreach ($validated['items'] as $it) {
                PaymentVoucherItem::create([
                    'payment_voucher_id' => $voucher->id,
                    'ref_type'      => $it['ref_type'],
                    'ref_id'        => $it['ref_id'] ?? null,
                    'payee'         => $it['payee'] ?? null,
                    'dr_account_id' => $it['dr_account_id'] ?? null,
                    'amount'        => $it['amount'],
                ]);
            }

            return redirect('/finance/payment_vouchers')->with('success', 'Payment Voucher updated successfully.');
        });
    }

    public function destroy($id)
    {
        $voucher = PaymentVoucher::findOrFail($id);
        $voucher->items()->delete();
        $voucher->delete();

        return redirect('/finance/payment_vouchers')->with('success', 'Payment Voucher deleted successfully.');
    }
}
