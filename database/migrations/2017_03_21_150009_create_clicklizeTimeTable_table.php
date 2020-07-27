<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicklizeTimeTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicklizeTimeTables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('late_min');
            $table->integer('early_min');
            $table->time('start_clockin_time');
            $table->time('end_clockin_time');
            $table->time('start_clockout_time');
            $table->time('end_clockout_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clicklizeTimeTable');
    }
}
