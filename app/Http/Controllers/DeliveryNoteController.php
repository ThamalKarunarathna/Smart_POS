<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Illuminate\Http\Request;

class DeliveryNoteController extends Controller
{
    public function index()
    {
        $deliveryNotes = DeliveryNote::with(['order', 'customer', 'creator', 'items'])
            ->latest()
            ->paginate(20);

        return view('delivery_notes.index', compact('deliveryNotes'));
    }

    public function show($id)
    {
        $deliveryNote = DeliveryNote::with(['order', 'customer', 'items.item', 'creator'])
            ->findOrFail($id);

        return view('delivery_notes.print', compact('deliveryNote'));
    }

    public function print($id)
    {
        $deliveryNote = DeliveryNote::with(['order', 'customer', 'items.item', 'creator'])
            ->findOrFail($id);

        return view('delivery_notes.print', compact('deliveryNote'));
    }
}
