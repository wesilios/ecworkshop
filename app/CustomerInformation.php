<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInformation extends Model
{
    //
    protected $fillable = [
        'address', 'district_id', 'city_id'
    ];

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function city()
    {
    	return $this->belongsTo('App\Fee','city_id');
    }

    public function district()
    {
    	return $this->belongsTo('App\FeeDistrict','district_id');
    }
}
