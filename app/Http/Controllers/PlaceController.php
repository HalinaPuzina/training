<?php

namespace App\Http\Controllers;

use App\Place;
use App\Http\Resources\PlaceResource;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\PlaceResource
     */
    public function index()
    {
        return PlaceResource::collection(Place::all());

    }

}
