<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalEntryController extends Controller
{
    public function index()
    {
        $entries = JournalEntry::latest()->paginate(10);
        return view('finance.journal_entries.index', compact('entries'));
    }

    public function create()
    {
        $accounts = ChartOfAccount::orderBy('account_name')->get();
        $JournalEntryNo = $this->nextJournalEntryNo();
        return view('finance.journal_entries.create', compact('accounts', 'JournalEntryNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'voucher_date' => 'required|date',
            'remark'       => 'nullable|string',

            'lines'                 => 'required|array|min:1',
            'lines.*.description'   => 'nullable|string|max:255',
            'lines.*.cr_account_id' => 'required|exists:chart_of_accounts,id',
            'lines.*.dr_account_id' => 'required|exists:chart_of_accounts,id',
            'lines.*.amount'        => 'required|numeric|min:0.01',
        ]);

        return DB::transaction(function () use ($validated) {

            $total = collect($validated['lines'])->sum(fn($l) => (float)$l['amount']);

            $entry = JournalEntry::create([
                'journal_no'    => $this->nextJournalEntryNo(),
                'voucher_date'  => $validated['voucher_date'],
                'remark'        => $validated['remark'] ?? null,
                'total_amount'  => $total,
                'status'        => 'Pending',
                'created_by'    => auth()->id(),
            ]);

            foreach ($validated['lines'] as $line) {
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'description'      => $line['description'] ?? null,
                    'cr_account_id'    => $line['cr_account_id'],
                    'dr_account_id'    => $line['dr_account_id'],
                    'amount'           => $line['amount'],
                ]);
            }

            return redirect('/finance/journal_entries')->with('success', 'Journal Entry created successfully.');
        });
    }

    public function edit($id)
    {
        $entry = JournalEntry::with('lines')->findOrFail($id);
        $accounts = ChartOfAccount::orderBy('account_name')->get();
        return view('finance.journal_entries.edit', compact('entry','accounts'));
    }

    public function update(Request $request, $id)
    {
        $entry = JournalEntry::with('lines')->findOrFail($id);

        $validated = $request->validate([
            'journal_no'   => 'required|string|max:50|unique:journal_entries,journal_no,' . $entry->id,
            'voucher_date' => 'required|date',
            'remark'       => 'nullable|string',

            'lines'                 => 'required|array|min:1',
            'lines.*.description'   => 'nullable|string|max:255',
            'lines.*.cr_account_id' => 'required|exists:chart_of_accounts,id',
            'lines.*.dr_account_id' => 'required|exists:chart_of_accounts,id',
            'lines.*.amount'        => 'required|numeric|min:0.01',
        ]);

        return DB::transaction(function () use ($entry, $validated) {

            $total = collect($validated['lines'])->sum(fn($l) => (float)$l['amount']);

            $entry->update([
                'journal_no'   => $validated['journal_no'],
                'voucher_date' => $validated['voucher_date'],
                'remark'       => $validated['remark'] ?? null,
                'total_amount' => $total,
            ]);

            JournalEntryLine::where('journal_entry_id', $entry->id)->delete();

            foreach ($validated['lines'] as $line) {
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'description'      => $line['description'] ?? null,
                    'cr_account_id'    => $line['cr_account_id'],
                    'dr_account_id'    => $line['dr_account_id'],
                    'amount'           => $line['amount'],
                ]);
            }

            return redirect('/finance/journal_entries')->with('success', 'Journal Entry updated successfully.');
        });
    }

    public function show($id)
    {
        $entry = JournalEntry::with('lines.crAccount', 'lines.drAccount')->findOrFail($id);
        return view('finance.journal_entries.show', compact('entry'));
    }

    public function destroy($id)
    {
        $entry = JournalEntry::findOrFail($id);
        $entry->lines()->delete();
        $entry->delete();

        return redirect('/finance/journal_entries')->with('success', 'Journal Entry deleted successfully.');
    }

     private function nextJournalEntryNo(): string
    {
        // Format: BE-000001
        $last = JournalEntry::orderBy('id', 'desc')->value('journal_no');

        if (!$last) return 'JE-000001';

        $num = (int) str_replace('JE-', '', $last);
        $num++;

        return 'JE-' . str_pad((string)$num, 6, '0', STR_PAD_LEFT);
    }
}

