<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //
    protected  $table = 'places';

    protected  $fillable = [
        'name',
        'class'
    ];

    public function state(){
        return $this->hasOne('\App\Order');
    }

    public function getIsFreeAttribute()
    {
        if($this->class == 'coach'){
            return false;
        }
        return $this->state ? false : true;
    }
}
