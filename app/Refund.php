<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
