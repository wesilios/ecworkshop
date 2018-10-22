<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SliderDetail extends Model
{
    //
    protected $fillable = ['link'];

    public function media()
    {
        return $this->belongsTo('App\Media');
    }

   	public function slider()
    {
    	return $this->belongsTo('App\Slider');
    }
}
