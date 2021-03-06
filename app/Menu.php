<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    public function pages()
    {
    	return $this->belongsToMany('App\Page')->withPivot('created_at','updated_at');
    }
}
