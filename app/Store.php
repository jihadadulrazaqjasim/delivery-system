<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
