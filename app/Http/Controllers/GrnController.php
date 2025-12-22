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

    public function create(PurchaseOrder $po)
    {
        if ($po->status !== 'approved') abort(403, 'GRN can only be created for approved PO.');

        $po->load('items.item');
        $grnNo = $this->nextGrnNo();

        return view('inventory.grn.create', compact('po','grnNo'));
    }

    public function store(Request $request, PurchaseOrder $po)
    {
        if ($po->status !== 'approved') abort(403);

        $validated = $request->validate([
            'grn_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty_received' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated, $po) {
            $grn = Grn::create([
                'grn_no' => $this->nextGrnNo(),
                'purchase_order_id' => $po->id,
                'grn_date' => $validated['grn_date'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['items'] as $row) {
                $grn->items()->create($row);
            }

            return redirect()->route('grn.show', $grn)->with('success', 'GRN created.');
        });
    }

    public function show(Grn $grn)
    {
        $grn->load(['items.item','purchaseOrder']);
        return view('inventory.grn.show', compact('grn'));
    }

    public function edit(Grn $grn)
    {
        if ($grn->isLocked()) abort(403, 'GRN is approved and locked.');
        $grn->load(['items','purchaseOrder.items.item']);
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

            return redirect()->route('grn.show', $grn)->with('success', 'GRN updated.');
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
        return back()->with('success', 'GRN submitted for approval.');
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

            return back()->with('success', 'GRN approved and stock updated.');
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
