<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicklizetimetableClikclizeshiftPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicklizetimetable_clicklizeshift', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clicklizetimetable_id');

            $table->unsignedInteger('clicklizeshift_id');
            $table->string('day');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clicklizetimetable_clikclizeshift');
    }
}
