<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_no',
        'customer_id',
        'status',
        'discount',
        'sub_total',
        'grand_total',
        'created_by',
        'credit_inv',
        'vat_applicable',
        'sscl_applicable',
        'sscl_amount',
        'vat_amount',
        'outstanding_amount',
        'paid_amount',
        'balance_amount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
