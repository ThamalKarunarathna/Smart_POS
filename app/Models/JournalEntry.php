<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [
        'journal_no','voucher_date','total_amount','remark','status','created_by'
    ];

    public function lines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }
}

