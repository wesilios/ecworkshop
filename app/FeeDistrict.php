<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeDistrict extends Model
{
    //
    protected $fillable = [
    	'name'
    ];

    public function fee()
    {
    	return $this->belongsTo('App\Fee');
    }
}
