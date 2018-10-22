<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    //
    public function item()
    {
    	return $this->belongsTo('App\Item');
    }

    public function brand()
    {
    	return $this->belongsTo('App\Brand');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function medias()
    {
        return $this->morphToMany('App\Media', 'mediaable');
    }

    public function itemCategory()
    {
        return $this->belongsTo('App\ItemCategory');
    }
}
