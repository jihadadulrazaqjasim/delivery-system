<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
   /**
    * Get all of the posts for the Location
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function posts()
   {
       return $this->hasMany("App\Post"); 
   }
}
