<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    //use Searchable;
    protected $table = 'orders';

    protected $fillable = [
        'address', 'district', 'city', 'note', 'totalPrice', 'totalQty'
    ];

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function status()
    {
    	return $this->belongsTo('App\OrderStatus','order_status_id');
    }

    public function extraCustomer()
    {
        return $this->belongsTo('App\ExtraCustomer');
    }

    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetail');
    }
}
