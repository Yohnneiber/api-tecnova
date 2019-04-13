<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table='products';


    public function comment(){
        $this->hasMany('App\Comment');
    }

    public function category(){
        $this->belongsTo('App\Category','category_id');
    }

    public function orderProduct(){
        $this->hasMany('App\OrderProduct');
    }
}



