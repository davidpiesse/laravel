<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Raffle;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Vinkla\Hashids\Facades\Hashids;

class RaffleController extends Controller
{
    public function show($hash, $showImage = true)
    {
        $id = Hashids::decode($hash);
        $raffle = Raffle::find($id[0]);
        $raffle->hash = $hash;
        return view('raffle.show',compact('raffle','showImage'));
    }

    public function show_image($hash){
        //show raffle page but with a image included
        return $this->show($hash,true);
    }

    public function widget($hash){
        $id = Hashids::decode($hash);
        $raffle = Raffle::find($id[0]);
        $raffle->hash = $hash;
        return Helpers::buildWidget($raffle);
    }

    public function raffles_by_ip($hash){
        $ipAddress = Helpers::decodeIP($hash);
        dd($ipAddress);
        if(count($ipAddress) > 1)
            $ipAddress = implode('.',$ipAddress);
        else
            $ipAddress = '::1';
        dd($ipAddress);
        $raffles = Raffle::where('user_ip',$ipAddress)->orderBy('request_time','desc')->get();

        return view('user.show',compact('ipAddress','raffles','hash'));
    }

    public function raffles_by_timeframe($start,$end){
        //all raffles in a time period
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'min_number' => 'required|integer|min:0|max:999999',
            'max_number' => 'required|integer|min:0|max:999999',
            'max_winners' => 'required|integer|min:0|max:999999',
            'comment' => 'string|between:0,50'
        ]);
        //get request
        $min = $request->min_number;
        $max = $request->max_number;
        $winners = $request->max_winners;
        $comment = $request->comment;
        $current_dt = Carbon::now();
        $user_ip = request()->ip();
        //make random seed
        $random_seed = random_int(100000000,999999999);
        //setup random seed for this request
        $faker = \Faker\Factory::create();
        $faker->seed($random_seed);

        //create object
        $raffle = new Raffle();
        $raffle->min = $min;
        $raffle->max = $max;
        $raffle->winners = $winners;
        $raffle->comment = $comment;
        $raffle->type = 'raffle';
        $raffle->random_seed = $random_seed;
//        $raffle->code = Hashids::connection('validator')->encode($raffle->random_seed);
        $raffle->request_time = $current_dt;
        $raffle->microtime = microtime(false);
        $raffle->user_ip = $user_ip;
        //initial save
        $raffle->save();

        //now calculate result -single or multiple
        if($raffle->winners == 1)
            $raffle->result = $faker->numberBetween($raffle->min, $raffle->max);
        else{
            $raffle->result = $faker->randomElements(range($raffle->min, $raffle->max),$raffle->winners);
        }
        $raffle->save();

        $hash = Hashids::encode($raffle->id);

        //validate the data
        //create raffle object
        //save raffle object
        //return raffle object page
        return redirect()->route('raffle.show',$hash);
//        return $this->show($hash);
    }
}
