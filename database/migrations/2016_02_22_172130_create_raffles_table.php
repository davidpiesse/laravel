<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRafflesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('random_seed');
            $table->enum('type',['raffle','integer','decimal','letter','array_single','array_multiple','bytes','boolean','sequence','head_tails','D6','D10','D12']);
            $table->integer('min')->default(0);
            $table->integer('max')->default(20);
            $table->integer('winners')->default(1);
            $table->string('comment',50)->nullable();
            $table->text('config')->nullable();
            $table->bigInteger('microtime')->nullable();
            $table->dateTimeTz('request_time');
            $table->text('result');
            $table->text('user_ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('raffles');
    }
}
