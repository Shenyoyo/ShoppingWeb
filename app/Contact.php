<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function contactDetail()
    {
        return $this->hasMany('App\ContactDetail');
    }
    
}
