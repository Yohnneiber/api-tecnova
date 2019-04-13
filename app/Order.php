<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $table='orders';

    public function orderProduct(){
        $this->hasMany('App\OrderProduct');
    }


}
