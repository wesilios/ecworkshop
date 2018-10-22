<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MenuPage extends Pivot
{
    //
    protected $fillable = ['page_id','order','order_parent'];

    public function pages()
    {
    	return $this->belongsTo('App\Page','page_id');
    }
}