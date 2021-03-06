<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //
    protected $fillable = [
    	'name'
    ];

    public function folder()
    {
    	return $this->belongsTo('App\Folder');
    }

    public function medias()
    {
    	return $this->hasMany('App\Media');
    }
}
