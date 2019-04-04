<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected  $table = 'orders';

    protected $fillable =[
        'email',
        'place_id'
    ];

    public function getRandomCode($placeId)
    {
        $rand = (string)rand(1000,9999);
        $code = (int)str_pad($placeId, 6,$rand,STR_PAD_LEFT );

        $order = Order::where('code',$code)->first();

         if($order){
            $code = $this->randomCode($placeId);
         }
         return $code;
    }

}
