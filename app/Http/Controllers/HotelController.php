<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;


class HotelController extends Controller
{
    public function index(){
        $hotels = Hotel::all();
        $hotels = Hotel::paginate(6);  // Número de hoteles por página
        return view('public.hotels.index',compact('hotels'));//
    }

    public function show($hotel){
        $hotel = Hotel::find($hotel); //busca el hotel en especifico
        //return $hotel;
        return view('public.hotels.show',compact('hotel'));
    }



}
