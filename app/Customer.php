<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';

    protected $guard = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'phonenumber', 'created_at', 'updated_at', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customerInfo()
    {
        return $this->hasOne('App\CustomerInformation','customer_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
