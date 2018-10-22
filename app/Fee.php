<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    //
    protected $fillable = [
    	'city', 'fee'
    ];

    public function feeDistricts()
    {
    	return $this->hasMany('App\FeeDistrict');
    }
}
