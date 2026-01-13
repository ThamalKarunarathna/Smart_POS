<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptInvoice extends Model
{
    protected $fillable = [
        'receipt_id',
        'order_id',
        'amount',
    ];

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

