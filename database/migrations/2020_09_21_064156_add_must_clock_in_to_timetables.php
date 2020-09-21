<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMustClockInToTimetables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('clicklizeTimeTables', function (Blueprint $table) {
          $table->boolean('must_clock_in')->default(0);
          $table->boolean('must_clock_out')->default(0);
      });
      $results = DB::table('clicklizeTimeTables')->select('id','name')->get();

      $i = 1;
      foreach ($results as $result){
          DB::table('clicklizeTimeTables')
              ->where('id',$result->id)
              ->update([
                  "must_clock_in" => 0,
                  "must_clock_out" => 0,
          ]);
          $i++;
    }}

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
