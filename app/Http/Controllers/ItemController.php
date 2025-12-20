<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
class ItemController extends Controller
{
    //get all items
    public function index()
    {
        $items = Item::latest()->paginate(10);
        return view('items.index', compact('items'));
    }

    //create item form load
    public function create()
    {
        return view('items.create');
    }

    //store item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code' => 'required|unique:items,item_code',
            'name' => 'required',
            'unit' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);

        Item::create($validated);

        return redirect('/items')->with('success', 'Item created successfully.');
    }

    //edit form load
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    //update item
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'item_code' => 'required|unique:items,item_code,'.$id,
            'name' => 'required',
            'unit' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);

        $item->update($validated);
        return redirect('/items')->with('success', 'Item updated successfully.');

    }

    //delete item
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect('/items')->with('success', 'Item deleted successfully.');
    }
}
