<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    //
    protected $table = 'item_categories';

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

    public function itemCategories()
    {
        return $this->hasMany('App\ItemCategory','item_category_id','id');
    }

    public function itemCategoryChild()
    {
        return $this->hasOne('App\ItemCategory', 'item_Category_id','id');
    }

}
