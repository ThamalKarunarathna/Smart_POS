<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\ItemPrice;


use Illuminate\Http\Request;

class ItemPriceController extends Controller
{
    //load create price form
    public function create($itemId)
    {
        $item = Item::findOrFail($itemId);
        $prices = ItemPrice::where('item_id',$itemId)->orderByDesc('effective_from')->get();

        return view('items.prices', compact('item','prices'));

    }

        public function store(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);

        $validated = $request->validate([
            'selling_price'  => 'required|numeric|min:0',
            'cost_price'     => 'nullable|numeric|min:0',
            'effective_from' => 'nullable|date',
        ]);

        // If date empty, use today
        $validated['effective_from'] = $validated['effective_from'] ?? now()->toDateString();

        // Deactivate old prices
        ItemPrice::where('item_id', $item->id)->update(['is_active' => 0]);

        // Insert new active price
        ItemPrice::create([
            'item_id'        => $item->id,
            'selling_price'  => $validated['selling_price'],
            'cost_price'     => $validated['cost_price'] ?? null,
            'effective_from' => $validated['effective_from'],
            'is_active'      => 1,
        ]);

        return redirect("/items/{$item->id}/prices")->with('success', 'Price added and activated.');
    }

}





