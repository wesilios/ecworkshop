<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $table = 'settings';

    protected $fillable = [
    	'address',
    	'phone',
        'work_hour',
    	'facebook',
    	'youtube',
    	'instagram',
        'email',
        'keywords',
    	'description',
    	'google_id',
    	'webmaster',
    ];
}
