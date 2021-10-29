<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
