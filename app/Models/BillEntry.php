<?php

namespace App\Models;
use App\Models\BillEntryLine;

use Illuminate\Database\Eloquent\Model;

class BillEntry extends Model
{
    protected $fillable = [
        'bill_entry_no','bill_date','ref_no','ref_date',
        'creditor_id','cr_account_id','remark',
        'total_dr','total_cr','status','created_by','payable_amount','pay_status'
    ];

    public function lines()
    {
        return $this->hasMany(BillEntryLine::class, 'bill_entry_id');
    }

    public function creditor()
{
    return $this->belongsTo(Supplier::class, 'creditor_id');
}




    public function crAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'cr_account_id');
    }
}
