<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStatus extends Model
{
    //
    protected $table = 'item_statuses';

    protected $fillable = ['name'];

    public function items()
    {
    	return $this->hasMany('App\Item','item_status_id');
    }
}
