<?php
namespace App;

use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;

class Helpers
{
    public static function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }

    public static function encodeIP($ip)
    {
        if ($ip == "::1")
            $ipArray = [1];
        else
            $ipArray = explode('.', trim($ip));
        return Hashids::connection('iphasher')->encode($ipArray);
    }

    public static function decodeIP($hash)
    {
        return Hashids::connection('iphasher')->decode($hash);
    }

    public static function buildWidgetImage($raffle)
    {
//        $image = Image::cache(function($img) use($raffle){
        $img = \Image::make('fb_bg.png');
        $img->insert('trophy_fb_widget.png', 'left', 15, 0);
        $img->text('raffledraw.online/' . $raffle->hash(), 235, 210, function ($font) {
            $font->file(storage_path() . '/OpenSans-Regular.ttf');
            $font->size(24);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
        });
        $winner_text = "The " . str_plural("winner", $raffle->winners) . ngettext(' is', ' are', $raffle->winners);
        $img->text($winner_text, 290, 40, function ($font) {
            $font->file(storage_path() . '/OpenSans-Regular.ttf');
            $font->size(20);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
        });
        //customise this base on multiple values -
        //maximum number showm (9)?
        //-have row pixel y offset predetermined
        $img->text(self::resultToString($raffle->result), 290, 100, function ($font) {
            $font->file(storage_path() . '/OpenSans-Regular.ttf');
            $font->size(48);
            $font->color('#e74c3c');
            $font->align('center');
            $font->valign('top');
        });
//        });
        return $img->encode('png');
//        return $image->encode('png');
    }

    public static function buildWidget($raffle)
    {
//        $image = Image::cache(function($img) use($raffle){
        $img = \Image::make('fb_bg.png');
        $img->insert('trophy_fb_widget.png', 'left', 15, 0);
        $img->text('raffledraw.online/' . $raffle->hash(), 235, 210, function ($font) {
            $font->file(storage_path() . '/OpenSans-Regular.ttf');
            $font->size(24);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
        });
        $winner_text = "The " . str_plural("winner", $raffle->winners) . ngettext(' is', ' are', $raffle->winners);
        $img->text($winner_text, 290, 40, function ($font) {
            $font->file(storage_path() . '/OpenSans-Regular.ttf');
            $font->size(20);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
        });

        $string = wordwrap(self::resultToString($raffle->result), 15, ",");
        $strings = explode(",", $string);
        //split into columns if > 5?

        $i = 64; //top position of string
        $max_height = 140; //max text pixel height
        $fontsize = round($max_height / (count($strings)), 0);
        foreach ($strings as $string) {
            $img->text($string, 290, $i, function ($font) use ($fontsize) {
                $font->file(storage_path() . '/OpenSans-Regular.ttf');
                $font->size($fontsize);
                $font->color('#e74c3c');
                $font->align('center');
                $font->valign('top');
            });
            $i = $i + $fontsize + 5; //shift top postition down 42
        }
//        });
//        return $image->response('png');
        return $img->response('png');
    }

    public static function resultToString($result)
    {
        if (is_array($result))
            $result = implode(',', $result);
        return $result;
    }
}