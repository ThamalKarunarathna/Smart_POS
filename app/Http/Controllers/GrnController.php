<?php

namespace App\Http\Controllers;

use App\Models\Grn;
use App\Models\PurchaseOrder;
use App\Models\StockLedger;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class GrnController extends Controller
{
    private function nextGrnNo(): string
    {
        $last = Grn::orderByDesc('id')->value('grn_no'); // GRN-000012

        if (!$last) {
            return 'GRN-000001';
        }

        $number = (int) substr($last, 4); // get numeric part
        $number++;
        return 'GRN-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $grns = Grn::with('purchaseOrder')->latest()->paginate(20);
        return view('inventory.grn.index', compact('grns'));
    }

    public function approvalIndex()
    {
        $grns = Grn::with('purchaseOrder')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('inventory.grn.approval', compact('grns'));
    }


    public function create(PurchaseOrder $po)
    {
        if ($po->status !== 'approved') abort(403, 'GRN can only be created for approved PO.');

        $po->load('items.item');
        $grnNo = $this->nextGrnNo();

        return view('inventory.grn.create', compact('po', 'grnNo'));
    }

    public function store(Request $request, PurchaseOrder $po)
{
    if ($po->status !== 'approved') abort(403);

    $validated = $request->validate([
        'grn_date' => 'required|date',

        'delivery_amount' => 'nullable|numeric|min:0',
        'sscl_enabled'     => 'nullable|in:1',
        'vat_enabled'      => 'nullable|in:1',

        'items' => 'required|array|min:1',
        'items.*.item_id'       => 'required|exists:items,id',
        'items.*.qty_received'  => 'required|numeric|min:0.001',
        'items.*.rate'          => 'required|numeric|min:0',
    ]);

    return DB::transaction(function () use ($validated, $po, $request) {

        $delivery = (float) ($validated['delivery_amount'] ?? 0);

        // ✅ Correct checkbox handling
        $ssclEnabled = $request->boolean('sscl_enabled');
        $vatEnabled  = $request->boolean('vat_enabled');

        // ✅ sub total from items
        $subTotal = 0;
        foreach ($validated['items'] as $row) {
            $subTotal += ((float)$row['qty_received']) * ((float)$row['rate']);
        }
        $subTotal = round($subTotal, 2);

        $base = $subTotal + $delivery;

        // ✅ SSCL 2.5% of (subTotal + delivery)
        $sscl = $ssclEnabled ? round($base * 0.025, 2) : 0;

        // ✅ VAT 18% of (subTotal + delivery + sscl)
        $vatBase = $base + $sscl;
        $vat = $vatEnabled ? round($vatBase * 0.18, 2) : 0;

        $grandTotal = round($subTotal + $delivery + $sscl + $vat, 2);

        $grn = Grn::create([
            'grn_no' => $this->nextGrnNo(),
            'purchase_order_id' => $po->id,
            'grn_date' => $validated['grn_date'],
            'status' => 'draft',
            'created_by' => auth()->id(),

            // totals
            'sub_total'       => $subTotal,
            'delivery_amount' => $delivery,
            'sscl_enabled'    => $ssclEnabled ? 1 : 0,
            'sscl_amount'     => $sscl,
            'vat_enabled'     => $vatEnabled ? 1 : 0,
            'vat_amount'      => $vat,
            'grand_total'     => $grandTotal,
        ]);

        foreach ($validated['items'] as $row) {
            $grn->items()->create($row);
        }

        // ✅ Fix: correct update syntax
        $po->update(['grn_status' => 'yes']);

        return redirect()->route('grn.show', $grn)->with('success', 'GRN created.');
    });
}

    public function show(Grn $grn)
    {
        $grn->load(['items.item', 'purchaseOrder']);
        return view('inventory.grn.show', compact('grn'));
    }

    public function pendingIndex()
    {
        $pos = PurchaseOrder::with('supplier')
            ->where('status', 'approved')
            ->where('grn_status', 'no')
            ->latest()
            ->paginate(20);

        return view('inventory.grn.pending_grn', compact('pos'));
    }

    public function edit(Grn $grn)
    {
        if ($grn->isLocked()) abort(403, 'GRN is approved and locked.');
        $grn->load(['items', 'purchaseOrder.items.item']);
        return view('inventory.grn.edit', compact('grn'));
    }

    public function update(Request $request, Grn $grn)
    {
        if ($grn->isLocked()) abort(403);

        $validated = $request->validate([
            'grn_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty_received' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated, $grn) {
            $grn->update(['grn_date' => $validated['grn_date']]);

            $grn->items()->delete();
            foreach ($validated['items'] as $row) {
                $grn->items()->create($row);
            }

            return redirect()->route('grn.index', $grn)->with('success', 'GRN updated.');
        });
    }

    public function destroy(Grn $grn)
    {
        if ($grn->isLocked()) abort(403);
        $grn->delete();
        return redirect()->route('grn.index')->with('success', 'GRN deleted.');
    }

    public function submit(Grn $grn)
    {
        if ($grn->isLocked()) abort(403);
        if ($grn->status !== 'draft') return back()->with('error', 'Only draft can be submitted.');
        $grn->update(['status' => 'pending']);
        return redirect()->route('grn.index')->with('success', 'GRN submitted for approval.');
    }

    public function approve(Grn $grn)
    {
        if ($grn->status !== 'pending') return back()->with('error', 'Only pending GRN can be approved.');

        return DB::transaction(function () use ($grn) {
            // Lock + approve
            $grn->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Stock update (ledger entries)
            $grn->load('items');
            foreach ($grn->items as $row) {
                StockLedger::create([
                    'item_id' => $row->item_id,
                    'ref_type' => 'GRN',
                    'ref_id' => $grn->id,
                    'qty_in' => $row->qty_received,
                    'qty_out' => 0,


                ]);
            }

            return redirect()->route('grn.approval')->with('success', 'GRN approved and stock updated.');
        });
    }

    public function reject(Grn $grn)
    {
        if ($grn->status !== 'pending') return back()->with('error', 'Only pending GRN can be rejected.');

        $grn->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'GRN rejected.');
    }
}
