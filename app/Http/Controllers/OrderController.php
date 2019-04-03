<?php

namespace App\Http\Controllers;

use App\Order;
use App\Http\Requests\OrderRequest;

use App\Mail\OrderPlace;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $request->validated();

        $order = new Order();
        $order->place_id = $request->place_id;
        $order->email = $request->email;
        $order->code =  $order->getRandomCode($request->place_id);;
        $order->save();

        // send mail

        Mail::to($order->email)->send(new OrderPlace($order));

        return response()->json(['success'=> true,
            'message'=>'Все ништяк! Ждем тебя, братишка ^_^'],
            200);
    }

}
