<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicklizeshiftUserinfoPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicklizeshift_userinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clicklizeshift_id');

            $table->unsignedInteger('userinfo_id');

            $table->unsignedInteger('clicklizeAcYear_id');

            $table->unique(['clicklizeshift_id', 'userinfo_id', 'clicklizeAcYear_id']);
            $table->float('salary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clicklizeshift_userinfo');
    }
}
