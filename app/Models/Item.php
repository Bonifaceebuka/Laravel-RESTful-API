<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
		'item_name', 
		'category', 
		'available_unit', 
		'unit_price', 
		'normal_price'
    ];

}
