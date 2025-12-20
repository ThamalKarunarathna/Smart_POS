<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ItemPrice extends Model
{
    use Hasfactory;

    protected $fillable = [
        'item_id',
        'selling_price',
        'cost_price',
        'effective_from',
        'is_active',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
