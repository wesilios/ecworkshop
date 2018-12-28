<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table = 'items';

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

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function itemCategoryMain()
    {
        return $this->belongsTo('App\ItemCategory' ,'item_category_id', 'id');
    }

    public function itemCategoryParent()
    {
        return $this->belongsTo('App\ItemCategory' ,'item_category_parent_id', 'id');
    }

    public function itemCategoryChild()
    {
        return $this->hasMany('App\ItemCategory' ,'item_category_parent_id', 'id');
    }

    public function itemStatus()
    {
        return $this->belongsTo('App\ItemStatus');
    }

    public function colors()
    {
        return $this->belongsToMany('App\Color', 'color_item','item_id','color_id');
    }

    public function sizes()
    {
        return $this->belongsToMany('App\Size','size_item','item_id','size_id');
    }

    public function medias()
    {
        return $this->morphToMany('App\Media', 'mediaable');
    }
}
