<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    protected $fillable = [
        'voucher_no','voucher_date','voucher_type','payment_type',
        'description','total_value','cr_account_id','created_by','status'
    ];

    public function items()
    {
        return $this->hasMany(PaymentVoucherItem::class);
    }

    public function crAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'cr_account_id');
    }
}

