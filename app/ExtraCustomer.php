<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraCustomer extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'password', 'phonenumber', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
