<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    protected $table='users';

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','nick','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function order(){
        $this->hasMany('App\Order');
    }

    public function comment(){
        $this->hasMany('App\Comment');
    }


}
