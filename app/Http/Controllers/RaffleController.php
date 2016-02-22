<?php

namespace App\Http\Controllers;

use App\Raffle;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Vinkla\Hashids\Facades\Hashids;

class RaffleController extends Controller
{
    public function show($hash)
    {
        $id = Hashids::decode($hash);
        $raffle = Raffle::firstOrFail($id);
        return view('raffle.show',compact('raffle'));
    }

    public function widget($hash){
        //show a widget version of the result
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'min_number' => 'required|integer|min:0|max:999999',
            'max_number' => 'required|integer|min:0|max:999999',
            'max_winners' => 'required|integer|min:0|max:999999',
            'comment' => 'string|between:0,255'
        ]);
        //get request
        $min = $request->min_number;
        $max = $request->max_number;
        $winners = $request->max_winners;
        $comment = $request->comment;
        $current_dt = Carbon::now();
        $user_ip = request()->ip();
        //make andom seed
        $random_seed = random_int(100000000,999999999);
        //setup random seed for this request
        mt_srand($random_seed);

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

        $raffle->save();

        //now calculate result -single or multiple
        if($raffle->winners == 0)
            $raffle->result = json_encode($this->random_single($raffle->min,$raffle->max));
        else{
            $raffle->result = json_encode($this->multi_vals($raffle->min,$raffle->max, $raffle->winners));
        }
        $raffle->save();

        $hash = Hashids::encode($raffle->id);
        //validate the data
        //create raffle object
        //save raffle object
        //return raffle object page

        dd($raffle);
        return $this->show($hash);
    }

    private function random_single($min,$max){
        //get a single random value
        return mt_rand($min,$max);
    }

    private function multi_vals($min, $max, $number)
    {
        $array = range($min, $max);

        $order = array_map(create_function('$val', 'return mt_rand();'), range(1, count($array)));
        array_multisort($order, $array);
        return array_slice($array, 0, $number);
    }
}
