<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_code',
        'name',
        'mobile',
        'contact_person',
        'email',
        'address',
        'vatreg_no',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
