<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function level()
    {
        return $this->belongsTo('App\Level');
    }
    public function cashback()
    {
        return $this->hasOne('App\Cashback');
    }
    public function discount()
    {
        return $this->hasOne('App\Discount');
    }
    public function rebate()
    {
        return $this->hasOne('App\Rebate');
    }
}
