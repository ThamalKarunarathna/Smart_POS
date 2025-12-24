<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    private function nextPoNo(): string
    {
        $last = PurchaseOrder::orderByDesc('id')->value('po_no'); // e.g. PO-000012

        if (!$last) return 'PO-000001';

        // Safe parsing: remove "PO-" then to int
        $number = (int) str_replace('PO-', '', $last);
        $number++;

        return 'PO-' . str_pad((string) $number, 6, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        // ✅ eager load supplier so table can show supplier name
        $pos = PurchaseOrder::with('supplier')->latest()->paginate(20);

        return view('inventory.po.index', compact('pos'));
    }


    public function approvalIndex()
{
    $pos = PurchaseOrder::with('supplier')
        ->where('status', 'pending')
        ->latest()
        ->paginate(20);

    return view('inventory.po.approval', compact('pos'));
}


    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $items = Item::orderBy('name')->get();
        $poNo = $this->nextPoNo();

        return view('inventory.po.create', compact('suppliers', 'items', 'poNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // ✅ use FK
            'po_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {

            $supplier = Supplier::findOrFail($validated['supplier_id']);

            $po = PurchaseOrder::create([
                'po_no' => $this->nextPoNo(),
                'supplier_id' => $supplier->id,
                'supplier_name' => $supplier->name, // optional fallback
                'po_date' => $validated['po_date'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['items'] as $row) {
                $po->items()->create([
                    'item_id' => $row['item_id'],
                    'qty'     => $row['qty'],
                    'rate'    => $row['rate'],
                ]);
            }

            return redirect()->route('po.show', $po)->with('success', 'PO created.');
        });
    }

    public function show(PurchaseOrder $po)
    {
        // ✅ correct eager loading
        $po->load(['items.item', 'supplier', 'creator', 'approver']);

        return view('inventory.po.show', compact('po'));
    }

    public function edit(PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403, 'PO is approved and locked.');

        $po->load(['items', 'supplier']);
        $suppliers = Supplier::orderBy('name')->get();
        $items = Item::orderBy('name')->get();

        return view('inventory.po.edit', compact('po', 'items', 'suppliers'));
    }

    public function update(Request $request, PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403, 'PO is approved and locked.');

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // ✅ use FK
            'po_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($po, $validated) {

            $supplier = Supplier::findOrFail($validated['supplier_id']);

            $po->update([
                'supplier_id' => $supplier->id,
                'supplier_name' => $supplier->name, // optional fallback
                'po_date' => $validated['po_date'],
            ]);

            $po->items()->delete();

            foreach ($validated['items'] as $row) {
                $po->items()->create([
                    'item_id' => $row['item_id'],
                    'qty'     => $row['qty'],
                    'rate'    => $row['rate'],
                ]);
            }

            return redirect()->route('po.show', $po)->with('success', 'PO updated.');
        });
    }

    public function destroy(PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403, 'PO is approved and locked.');

        $po->items()->delete();
        $po->delete();

        return redirect()->route('po.index')->with('success', 'PO deleted.');
    }

    public function submit(PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403);

        if ($po->status !== 'draft') {
            return back()->with('error', 'Only draft can be submitted.');
        }

        $po->update(['status' => 'pending']);

        return redirect()->route('po.index')->with('success', 'PO submitted for approval.');
    }

    public function approve(PurchaseOrder $po)
    {
        if ($po->status !== 'pending') {
            return back()->with('error', 'Only pending PO can be approved.');
        }

        $po->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('po.approval')->with('success', 'PO approved.');
    }

    public function reject(PurchaseOrder $po)
    {
        if ($po->status !== 'pending') {
            return back()->with('error', 'Only pending PO can be rejected.');
        }

        $po->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'PO rejected.');
    }
}
