<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function cashback()
    {
        return $this->hasOne('App\Cashback');
    }
    public function discount()
    {
        return $this->hasOne('App\Discount');
    }
}
