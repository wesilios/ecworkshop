<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
	protected $location = 'images/';

    protected $fillable = [
    	'path'
    ];

    public function getPathAttribute($value)
    {
    	return $this->attributes['path'] = $this->location . $value;
    }
}
