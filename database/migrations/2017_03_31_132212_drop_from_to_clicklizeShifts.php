<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFromToClicklizeShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clicklizeShifts', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);

        });
        Schema::table('clicklizeShifts', function (Blueprint $table) {

            $table->unsignedInteger('clicklizeAcYear_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
