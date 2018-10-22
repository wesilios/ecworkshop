<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $fillable = [
    	'name', 'description', 'price', 'price_off'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function box()
    {
    	return $this->hasMany('App\Box');
    }

    public function fullkit()
    {
    	return $this->hasMany('App\FullKit');
    }

    public function tank()
    {
    	return $this->hasMany('App\Tank');
    }

    public function juice()
    {
    	return $this->hasMany('App\Juice');
    }

    public function assessory()
    {
    	return $this->hasMany('App\Assessory');
    }

    public function itemCategory()
    {
        return $this->belongsTo('App\ItemCategory');
    }

    public function itemStatus()
    {
        return $this->belongsTo('App\ItemStatus');
    }
}
