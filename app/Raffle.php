<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    // raffle object
    //not much here
    protected $casts = [
        'result' => 'array',
        'config' => 'object',
    ];

    public function hash(){
        return \Hashids::connection('main')->encode($this->id);
    }
}
