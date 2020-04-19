<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads(){
        return $this->hasMany(Thread::class);
    }
}
