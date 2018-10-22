<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
    protected $fillable = ['name'];

    public function sliderDetails()
    {
    	return $this->hasMany('App\SliderDetail');
    }
}
