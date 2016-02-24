<?php
namespace App;

use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;

class Helpers{
    public static function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public static function encodeIP($ip){
        if(str_contains('.',$ip))
            $ipArray = explode(trim($ip),'.',4);
        else
            $ipArray = [1];
        return Hashids::connection('iphasher')->encode($ipArray);
    }
    public static function decodeIP($hash){
        return Hashids::connection('iphasher')->decode($hash);
    }
}