<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    public function category()
    {
        return $this->belongsToMany('App\Category');
    }

    public function OrderDetail()
    {
        return $this->hasOne('App\OrderDetails');
    }


    public function scopeProductEnable($query)
    {
        return $query->where('enable', '!=', '0');
    }
    
    public function scopeProductDisplay($query)
    {
        return $query->where('enable', '!=', '0')->where('display_yn', '=', 'Y');
    }
}
