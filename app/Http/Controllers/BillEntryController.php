<?php

namespace App\Http\Controllers;

use App\Models\BillEntry;
use App\Models\BillEntryLine;
use App\Models\ChartOfAccount;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BillEntryController extends Controller
{
    public function index()
    {
        $entries = BillEntry::latest()->paginate(10);
        return view('finance.bill_entries.index', compact('entries'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $accounts = ChartOfAccount::orderBy('account_name')->get();
        $billEntryNo = $this->nextBillEntryNo();

        return view('finance.bill_entries.create', compact('suppliers', 'accounts', 'billEntryNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bill_date' => 'required|date',
            'ref_no' => 'nullable|string|max:100',
            'ref_date' => 'nullable|date',
            'cr_account_id' => 'required|exists:chart_of_accounts,id',
            'remark' => 'nullable|string',
            'creditor_id' => 'required|exists:suppliers,id',

            'lines' => 'required|array|min:1',
            'lines.*.dr_account_id' => 'required|exists:chart_of_accounts,id',
            'lines.*.acc_code' => 'nullable|string|max:50',
            'lines.*.description' => 'nullable|string|max:255',
            'lines.*.dr_amount' => 'required|numeric|min:0.01',
        ]);

        return DB::transaction(function () use ($validated) {

            $totalDr = collect($validated['lines'])->sum(function ($l) {
                return (float)$l['dr_amount'];
            });

            $entry = BillEntry::create([
                'bill_entry_no' => $this->nextBillEntryNo(),
                'bill_date' => $validated['bill_date'],
                'ref_no' => $validated['ref_no'] ?? null,
                'ref_date' => $validated['ref_date'] ?? null,
                'cr_account_id' => $validated['cr_account_id'],
                'remark' => $validated['remark'] ?? null,
                'total_dr' => $totalDr,
                'total_cr' => $totalDr,
                'created_by' => auth()->id(),
                'creditor_id' => $validated['creditor_id'],
                'status' => 'Pending',
                'payable_amount' => $totalDr,
                'pay_status' => 'Pending',
            ]);

            foreach ($validated['lines'] as $line) {
                BillEntryLine::create([
                    'bill_entry_id' => $entry->id,
                    'dr_account_id' => $line['dr_account_id'],
                    'acc_code' => $line['acc_code'] ?? null,
                    'description' => $line['description'] ?? null,
                    'dr_amount' => $line['dr_amount'],
                ]);
            }

            return redirect('/finance/bill_entries')->with('success', 'Bill Entry created successfully.');
        });
    }

    public function edit($id)
    {
        $entry = BillEntry::with('lines')->findOrFail($id);

        $suppliers = Supplier::orderBy('name')->get();
        $accounts  = ChartOfAccount::orderBy('account_name')->get();

        return view('finance.bill_entries.edit', compact('entry', 'suppliers', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $entry = BillEntry::with('lines')->findOrFail($id);

        $validated = $request->validate([
            'bill_date'     => 'required|date',
            'ref_no'        => 'nullable|string|max:100',
            'ref_date'      => 'nullable|date',

            // ✅ creditor (supplier)
            'creditor_id'   => 'required|exists:suppliers,id',

            'cr_account_id' => 'required|exists:chart_of_accounts,id',
            'remark'        => 'nullable|string',

            'lines'                 => 'required|array|min:1',
            'lines.*.dr_account_id' => 'required|exists:chart_of_accounts,id',
            'lines.*.acc_code'      => 'nullable|string|max:50',
            'lines.*.description'   => 'nullable|string|max:255',
            'lines.*.dr_amount'     => 'required|numeric|min:0.01',
        ]);

        return DB::transaction(function () use ($entry, $validated) {

            $totalDr = collect($validated['lines'])->sum(function ($l) {
                return (float) $l['dr_amount'];
            });

            // ✅ Update header
            $entry->update([
                'bill_date'     => $validated['bill_date'],
                'ref_no'        => $validated['ref_no'] ?? null,
                'ref_date'      => $validated['ref_date'] ?? null,

                'creditor_id'   => $validated['creditor_id'], // ✅ supplier id

                'cr_account_id' => $validated['cr_account_id'],
                'remark'        => $validated['remark'] ?? null,
                'total_dr'      => $totalDr,
                'total_cr'      => $totalDr,
                'payable_amount'=> $totalDr,
                'pay_status'    => 'Pending',
            ]);

            // ✅ Replace lines (simple + safe)
            BillEntryLine::where('bill_entry_id', $entry->id)->delete();

            foreach ($validated['lines'] as $line) {
                BillEntryLine::create([
                    'bill_entry_id' => $entry->id,
                    'dr_account_id' => $line['dr_account_id'],
                    'acc_code'      => $line['acc_code'] ?? null,
                    'description'   => $line['description'] ?? null,
                    'dr_amount'     => $line['dr_amount'],
                ]);
            }

            return redirect('/finance/bill_entries')
                ->with('success', 'Bill Entry updated successfully.');
        });
    }

    public function show($id)
{
    $entry = BillEntry::with(['lines.drAccount', 'crAccount', 'creditor'])->findOrFail($id);
    return view('finance.bill_entries.show', compact('entry'));
}

    // destroy
    public function destroy($id)
    {
        $entry = BillEntry::findOrFail($id);
        $entry->lines()->delete();
        $entry->delete();
        return redirect('/finance/bill_entries')
            ->with('success', 'Bill Entry deleted successfully.');
    }


    private function nextBillEntryNo(): string
    {
        // Format: BE-000001
        $last = BillEntry::orderBy('id', 'desc')->value('bill_entry_no');

        if (!$last) return 'BE-000001';

        $num = (int) str_replace('BE-', '', $last);
        $num++;

        return 'BE-' . str_pad((string)$num, 6, '0', STR_PAD_LEFT);
    }
}
