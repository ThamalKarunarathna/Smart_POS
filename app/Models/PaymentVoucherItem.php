<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherItem extends Model
{
    protected $fillable = [
        'payment_voucher_id','ref_type','ref_id','payee','dr_account_id','amount'
    ];

    public function drAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'dr_account_id');
    }
}
