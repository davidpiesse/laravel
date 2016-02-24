<?php
namespace App;

use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
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

    public static function buildWidgetImage($raffle){
        $img = Image::make('fb_bg.png');
        $img->insert('trophy_fb_widget.png', 'left', 15, 0);
        $img->text('raffledraw.online/'.$raffle->hash(), 235, 210, function($font) {
            $font->file(storage_path().'/OpenSans-Regular.ttf');
            $font->size(24);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
        });
        $img->text('The winner is', 290, 40, function($font) {
            $font->file(storage_path().'/OpenSans-Regular.ttf');
            $font->size(20);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
        });
        //customise this base on multiple values -
        //maximum number showm (9)?
        //-have row pixel y offset predetermined
        $img->text($raffle->result, 290, 100, function($font) {
            $font->file(storage_path().'/OpenSans-Regular.ttf');
            $font->size(48);
            $font->color('#e74c3c');
            $font->align('center');
            $font->valign('top');
        });
        return $img->encode('png');
    }
}