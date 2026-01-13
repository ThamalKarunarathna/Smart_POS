<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'receipt_no',
        'receipt_date',
        'customer_id',
        'received_amount',
        'payment_type',
        'cheque_no',
        'cheque_date',
        'cheque_bank',
        'bank_id',
        'created_by',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'cheque_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bank()
    {
        return $this->belongsTo(ChartOfAccount::class, 'bank_id');
    }

    public function receiptInvoices()
    {
        return $this->hasMany(ReceiptInvoice::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

