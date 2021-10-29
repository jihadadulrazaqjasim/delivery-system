<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name', 'post_code', 'user_id','driver_id', 'store_id', 'location_id', 'address', 'check_out_time', 'price', 'transportation_price', 'status','created_at'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
     
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function store()
    {
        // return $this->belongsTo('App\Store');
        return $this->belongsTo('App\Store');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    
}