<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'menus';

    public function pages()
    {
    	return $this->belongsToMany('App\Page')->withPivot('created_at','updated_at');
    }

    public function menu_details() {
        return $this->hasMany('App\MenuDetail');
    }

}
