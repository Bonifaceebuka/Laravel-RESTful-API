<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable =[
        'item_id',
        'quantity',
        'total_price',
        'payment_type',
        'buyer_name',
        'profit'
    ];

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
