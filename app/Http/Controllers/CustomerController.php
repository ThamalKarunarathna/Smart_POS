<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //get all customers
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    //create customer form load
    public function create()
    {
        return view('customers.create');
    }

    //store customer
    public function store (Request $request)
    {
        $validated = $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers,customer_code',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        Customer::create($validated + ['is_active' => true]);

        return redirect('/customers')->with('success', 'Customer created successfully');
    }

    //edit form load
    public function edit($id)
    {
         $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    //update customer
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers,customer_code,' . $customer->id,
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:30',
            'email'         => 'nullable|email|max:255',
            'address'       => 'nullable|string|max:255',
        ]);

        $customer->update($validated);

        return redirect('/customers')->with('success', 'Customer updated successfully.');

    }

    public function toggleActive($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->is_active = !$customer->is_active;
        $customer->save();

        return redirect('/customers')->with('success', 'Customer status updated successfully.');

    }

    //delete customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect('/customers')->with('success', 'Customer deleted successfully.');
    }
}
