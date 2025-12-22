<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
   private function nextPoNo(): string
    {
        $last = PurchaseOrder::orderByDesc('id')->value('po_no'); // e.g. PO-000012

        if (!$last) {
            return 'PO-000001';
        }

        $number = (int) substr($last, 3); // get numeric part
        $number++;
        return 'PO-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $pos = PurchaseOrder::latest()->paginate(20);
        return view('inventory.po.index', compact('pos'));
    }

    public function create()
    {
        $items = Item::orderBy('name')->get();
        $poNo = $this->nextPoNo();
        return view('inventory.po.create', compact('items','poNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'nullable|string|max:255',
            'po_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            $po = PurchaseOrder::create([
                'po_no' => $this->nextPoNo(),
                'supplier_name' => $validated['supplier_name'] ?? null,
                'po_date' => $validated['po_date'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['items'] as $row) {
                $po->items()->create($row);
            }

            return redirect()->route('po.show', $po)->with('success', 'PO created.');
        });
    }

    public function show(PurchaseOrder $po)
    {
        $po->load(['items.item']);
        return view('inventory.po.show', compact('po'));
    }

    public function edit(PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403, 'PO is approved and locked.');
        $po->load('items');
        $items = Item::orderBy('name')->get();
        return view('inventory.po.edit', compact('po','items'));
    }

    public function update(Request $request, PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403, 'PO is approved and locked.');

        $validated = $request->validate([
            'supplier_name' => 'nullable|string|max:255',
            'po_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|numeric|min:0.001',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($po, $validated) {
            $po->update([
                'supplier_name' => $validated['supplier_name'] ?? null,
                'po_date' => $validated['po_date'],
            ]);

            $po->items()->delete();
            foreach ($validated['items'] as $row) {
                $po->items()->create($row);
            }

            return redirect()->route('po.show', $po)->with('success', 'PO updated.');
        });
    }

    public function destroy(PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403, 'PO is approved and locked.');
        $po->delete();
        return redirect()->route('po.index')->with('success', 'PO deleted.');
    }

    public function submit(PurchaseOrder $po)
    {
        if ($po->isLocked()) abort(403);
        if ($po->status !== 'draft') return back()->with('error', 'Only draft can be submitted.');
        $po->update(['status' => 'pending']);
        return back()->with('success', 'PO submitted for approval.');
    }

    public function approve(PurchaseOrder $po)
    {
        if ($po->status !== 'pending') return back()->with('error', 'Only pending PO can be approved.');
        $po->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        return back()->with('success', 'PO approved.');
    }

    public function reject(PurchaseOrder $po)
    {
        if ($po->status !== 'pending') return back()->with('error', 'Only pending PO can be rejected.');
        $po->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        return back()->with('success', 'PO rejected.');
    }
}
