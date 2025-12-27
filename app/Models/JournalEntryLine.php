<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntryLine extends Model
{
    protected $fillable = [
        'journal_entry_id','description','cr_account_id','dr_account_id','amount'
    ];

    public function crAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'cr_account_id');
    }

    public function drAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'dr_account_id');
    }
}
