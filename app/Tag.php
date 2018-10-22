<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = [
    	'name'
    ];

    public function articles()
    {
    	return $this->belongsToMany('App\Article', 'article_tag');
    }

    public function boxes()
    {
    	return $this->belongsToMany('App\Box', 'article_tag');
    }
}
