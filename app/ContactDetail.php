<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Contact');
    }
}
