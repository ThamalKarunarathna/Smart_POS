<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    protected $fillable = [
        'grn_no','purchase_order_id','grn_date','status','created_by','approved_by','approved_at'
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
