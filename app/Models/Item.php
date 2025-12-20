<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Item extends Model
{

    use HasFactory;

    protected $fillable = [
        'item_code',
        'name',
        'unit',
        'statsus',
    ];


public function prices()
{
    return $this->hasMany(ItemPrice::class);
}

public function activePrice()
{
    return $this->hasMany(ItemPrice::class)->where('is_active',1);
}


};
