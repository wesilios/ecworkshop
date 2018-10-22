<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $fillable = [
    	'item_name', 'quantity', 'price', 'feature'
    ];

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }
}
