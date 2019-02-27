<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuDetail extends Model
{
    //
    protected $table = 'menu_details';

    public function menu() {
        return $this->belongsTo('App\Menu');
    }

    public function getPage() {
        return $this->belongsTo('App\Page','page_item_cat_id','id');
    }

    public function getItemCat() {
        return $this->belongsTo('App\ItemCategory','page_item_cat_id','id');
    }
}
