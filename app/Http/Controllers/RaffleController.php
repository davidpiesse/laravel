<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Vinkla\Hashids\Facades\Hashids;

class RaffleController extends Controller
{
    public function show($hash)
    {
        $id = Hashids::decode($hash);
        $raffle = $id;
        return view('raffle.show',compact('raffle'));
    }

    public function widget($hash){
        //show a widget version of the result
    }

    public function create(Request $request)
    {
        dd($request->all());
        //get request
        //validate the data
        //create raffle object
        //save raffle object
        //return raffle object page
    }
}
