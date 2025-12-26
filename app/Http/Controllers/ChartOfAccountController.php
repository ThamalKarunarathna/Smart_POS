<?php

namespace App\Http\Controllers;
use App\Models\ChartOfAccount;

use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
     public function index()
    {
        $accounts = ChartOfAccount::orderBy('account_code')->latest()->paginate(20);
        return view('finance.chart_of_accounts.index', compact('accounts'));
    }

    public function create()
    {
        $parents = ChartOfAccount::orderBy('account_code')->get();
        return view('finance.chart_of_accounts.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'account_code' => 'required|unique:chart_of_accounts,account_code',
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:ASSET,LIABILITY,EQUITY,INCOME,EXPENSE',
            'parent_id'    => 'nullable|exists:chart_of_accounts,id',
        ]);

        ChartOfAccount::create($data);

        return redirect('/finance/chart_of_accounts')
            ->with('success', 'Account created successfully');
    }

    public function edit($id)
    {
        $account = ChartOfAccount::findOrFail($id);
        $parents = ChartOfAccount::where('id', '!=', $id)->get();

        return view('finance.chart_of_accounts.edit', compact('account', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $account = ChartOfAccount::findOrFail($id);

        // SYSTEM ACCOUNT PROTECTION
        if ($account->is_system) {
            $request->validate([
                'account_name' => 'required|string|max:255',
                'is_active'    => 'boolean'
            ]);

            $account->update($request->only('account_name', 'is_active'));
        } else {
            $data = $request->validate([
                'account_name' => 'required|string|max:255',
                'parent_id'    => 'nullable|exists:chart_of_accounts,id',
                'is_active'    => 'boolean'
            ]);

            $account->update($data);
        }

        return redirect('/finance/chart_of_accounts')
            ->with('success', 'Account updated successfully');
    }
}
