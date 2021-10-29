<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [ 
        'name','phone_number', 'user_id'
    ];
}