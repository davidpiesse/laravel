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
        if(count($ipAddress) > 1)
            $ipAddress = implode('.',$ipAddress);
        else
            $ipAddress = '::1';
        $raffles = Raffle::where('user_ip',$ipAddress)->orderBy('request_time','desc')->simplePaginate(20);
        return view('user.show',compact('ipAddress','raffles','hash'));
    }

    public function admin_list(){
        //all raffles in a time period
        $raffles = Raffle::orderBy('request_time','desc')->simplePaginate(100);
        return view('admin.list',compact('raffles'));
    }

    public function create(Request $request)
    {
//        dd($request->all());
        $this->validate($request,[
            'type' => 'required',
        ]);
        //validation
        switch($request->type){
            case "raffle":
                $this->validate($request,[
                    'min_number' => 'required|integer|min:0|max:999999',
                    'max_number' => 'required|integer|min:0|max:999999',
                    'max_winners' => 'required|integer|min:0|max:999999',
                    'comment' => 'string|between:0,50'
                ]);
                break;
            case "custom":
                $this->validate($request,[
                    'custom_array' => 'required|string',
                    'custom_max_winners' => 'required|integer|min:0|max:999999',
                    'comment' => 'string|between:0,50'
                ]);
                break;
        }

        $comment = $request->comment;
        $current_dt = Carbon::now();
        $user_ip = request()->ip();
        $order_winners = isset($request->order_winners);
        $random_seed = random_int(100000000,999999999);
        $faker = \Faker\Factory::create();
        $faker->seed($random_seed);
        //create object
        $raffle = new Raffle();

        //build object
        switch($request->type){
            case "raffle":
                $min = $request->min_number;
                $max = $request->max_number;
                $winners = $request->max_winners;

                $raffle->min = $min;
                $raffle->max = $max;
                $raffle->winners = $winners;
                $raffle->comment = $comment;
                $raffle->order_winners = $order_winners;
                $raffle->type = 'raffle';
                $raffle->random_seed = $random_seed;
                $raffle->request_time = $current_dt;
                $raffle->microtime = microtime(false);
                $raffle->user_ip = $user_ip;
                $raffle->save();

                break;
            case "custom":
                $custom_array = explode("\n", str_replace("\r", "", $request->custom_array));
                foreach($custom_array as $key => $entry){
                    if($entry == "")
                        array_pull($custom_array,$key);
                }
                $custom_array = array_values($custom_array);
                //convert to array object...
                $winners = $request->custom_max_winners;
                //double check winners v entrants?
                if(count($custom_array) <= $winners)
                    abort(404); //return error

                $raffle->winners = $winners;
                $raffle->custom_array = $custom_array;
                $raffle->comment = $comment;
                $raffle->order_winners = $order_winners;
                $raffle->type = 'custom';
                $raffle->random_seed = $random_seed;
                $raffle->request_time = $current_dt;
                $raffle->microtime = microtime(false);
                $raffle->user_ip = $user_ip;
                $raffle->save();
                break;
        }

        //calc result
        switch($raffle->type){
            case "raffle":
                if($raffle->winners == 1)
                    $raffle->result = $faker->numberBetween($raffle->min, $raffle->max);
                else{
                    $raffle->result = $faker->randomElements(range($raffle->min, $raffle->max),$raffle->winners);
                }
                $raffle->save();
                break;
            case "custom":
                //now calculate result -single or multiple
                if($raffle->winners == 1)
                    $raffle->result = $faker->randomElement($raffle->custom_array);
                else{
                    $raffle->result = $faker->randomElements($raffle->custom_array,$raffle->winners);
                }
                $raffle->save();
                break;
        }

        $hash = Hashids::encode($raffle->id);

        return redirect()->route('raffle.show',$hash);
    }
}
