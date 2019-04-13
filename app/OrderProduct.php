<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model{
    protected $table='orders_products';

    public function order(){
        $this->belongsTo('App\Order','order_id');
    }

    public function product(){
        $this->belongsTo('App\Product','product_id');
    }

}
