<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{

     protected $fillable = [
        'po_no','supplier_id','supplier_name','po_date','status','created_by','approved_by','approved_at'
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function supplier()
{
    return $this->belongsTo(Supplier::class);
}


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isLocked(): bool
    {
        return $this->status === 'approved';
    }
}
