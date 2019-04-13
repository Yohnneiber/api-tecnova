<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    protected $table='comments';

    public function user(){
        $this->belongsTo('App\User','user_id');
    }

    public function product(){
        $this->belongsTo('App\Product','product_id');
    }









}
