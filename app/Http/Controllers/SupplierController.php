<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    // get all suppliers
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    // create supplier form load
    public function create()
    {
        // If you want to DISPLAY the code in the form (readonly), pass it:
        $nextSupplierCode = $this->generateSupplierCodeString();

        return view('suppliers.create', compact('nextSupplierCode'));
    }

    // store supplier
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'mobile'         => 'required|string|max:20',
            'contact_person' => 'nullable|string|max:100',
            'email'          => 'nullable|email|max:150',
            'address'        => 'required|string|max:255',
            'vatreg_no'      => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($validated) {

            Supplier::create([
                'supplier_code'  => $this->generateSupplierCodeString(), // server-side authority
                'name'           => $validated['name'],
                'mobile'         => $validated['mobile'],
                'contact_person' => $validated['contact_person'] ?? null,
                'email'          => $validated['email'] ?? null,
                'address'        => $validated['address'],
                'vatreg_no'      => $validated['vatreg_no'] ?? null,
                'created_by'     => auth()->id(), // IMPORTANT for your migration FK
            ]);
        });

        return redirect('/suppliers')->with('success', 'Supplier created successfully.');
    }

    // edit form load
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    // update supplier
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        // If supplier_code must never change, do NOT validate it and do NOT update it.
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'mobile'         => 'required|string|max:20',
            'contact_person' => 'nullable|string|max:100',
            'email'          => 'nullable|email|max:150',
            'address'        => 'required|string|max:255',
            'vatreg_no'      => 'nullable|string|max:50',
        ]);

        $supplier->update($validated);

        return redirect('/suppliers')->with('success', 'Supplier updated successfully.');
    }

    // OPTIONAL: API endpoint to fetch next code (only if you use AJAX)
    public function generateSupplierCode()
    {
        return response()->json(['supplier_code' => $this->generateSupplierCodeString()]);
    }

    // delete supplier (may fail if supplier is referenced elsewhere)
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // If you expect FK usage later, better to deactivate instead of delete:
        // $supplier->update(['is_active' => 0]); return redirect...

        $supplier->delete();

        return redirect('/suppliers')->with('success', 'Supplier deleted successfully.');
    }

    // ---- Helper: generate SUP0001 style code ----
    private function generateSupplierCodeString(): string
    {
        $lastCode = Supplier::max('supplier_code'); // e.g. "SUP0042"

        if ($lastCode && str_starts_with($lastCode, 'SUP')) {
            $number = (int) substr($lastCode, 3);
            return 'SUP' . str_pad((string)($number + 1), 4, '0', STR_PAD_LEFT);
        }

        return 'SUP0001';
    }
}
