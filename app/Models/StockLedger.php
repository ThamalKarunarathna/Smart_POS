<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
        protected $fillable = ['item_id','ref_type','ref_id','qty_in','qty_out'];

        public function item()
        {
            return $this->belongsTo(Item::class);
        }
}
