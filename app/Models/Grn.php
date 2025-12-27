<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    protected $fillable = [
        'grn_no','purchase_order_id','grn_date','status','created_by','approved_by','approved_at',

        // totals
    'sub_total','delivery_amount','sscl_enabled','sscl_amount',
    'vat_enabled','vat_amount','grand_total','payable_amount','pay_status'
    ];

    public function items()
    {
        return $this->hasMany(GrnItem::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function isLocked(): bool
    {
        return $this->status === 'approved';
    }
}
