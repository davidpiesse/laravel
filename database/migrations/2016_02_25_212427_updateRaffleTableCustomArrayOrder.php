<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRaffleTableCustomArrayOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raffles', function ($table) {
            $table->text('custom_array')->nullable();
            $table->boolean('order_winners')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raffles', function ($table) {
            $table->dropColumn('custom_array', 'order_winners');
        });
    }
}
