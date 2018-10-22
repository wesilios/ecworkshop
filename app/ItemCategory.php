<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    //
    protected $fillable = ['name','slug'];

    public function items()
    {
    	return $this->hasMany('App\Item');
    }

    public function page()
    {
    	return $this->belongsTo('App\Page','slug');
    }

    public function itemCategory()
    {
        return $this->belongsTo('App\ItemCategory');
    }
}
