<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillEntryLine extends Model
{
    protected $fillable = [
        'bill_entry_id','dr_account_id','acc_code','description','dr_amount'
    ];

    public function billEntry()
    {
        return $this->belongsTo(BillEntry::class);
    }

    public function drAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'dr_account_id');
    }
}
