<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetail');
    }
    public function refund()
    {
        return $this->hasOne('App\Refund');
    }
}
