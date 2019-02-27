<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //

    protected $fillable = [

    	'name', 'description', 'slug', 'category_id','page_id', 'id'

    ];

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

    public function menu()
    {
    	return $this->belongsToMany('App\Menu');
    }

    public function media()
    {
        return $this->morphToMany('App\Media', 'mediaable');
    }

    public function pageParent()
    {
        return $this->belongsTo('App\Page','page_id');
    }

    public function pageChildren()
    {
        return $this->hasMany('App\Page','page_id');
    }
}
