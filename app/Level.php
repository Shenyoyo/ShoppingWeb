<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $primaryKey = 'level';

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function offer()
    {
        return $this->hasOne('App\Offer');
    }
}
