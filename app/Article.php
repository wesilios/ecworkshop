<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [

    	'title', 'content', 'photo_id', 'category_id','slug'

    ];

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function media()
    {
        return $this->morphToMany('App\Media', 'mediaable');
    }
}
