<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    //

    protected $location = 'images/';
    
    protected $fillable = [

    	'file_name', 
    	'url', 
    	'caption', 
    	'description', 
    	'admin_id', 
    	'title', 
    	'alt_text',
        'type',

    ];

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

    public function setUrlAttribute($value)
    {
        return $this->attributes['url'] = $this->location . $value;
    }

    public function articles()
    {
        return $this->morphedByMany('App\Article', 'mediaable');
    }

    public function boxes()
    {
        return $this->morphedByMany('App\Box', 'mediaable');
    }
}
