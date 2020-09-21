<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Timetable extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'clicklizeTimetables';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name','start_time','end_time','late_min','early_min',
		'start_clockin_time','end_clockin_time','start_clockout_time','end_clockout_time','must_clock_in','must_clock_out'];
    // protected $hidden = [];
	protected $casts = [
  'id' => 'integer',
  'must_clock_in' => 'boolean',
  'must_clock_out' => 'boolean',
  ];
	protected $dates = [''];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

	public function getStartTimeAttribute($time)
	{
		return Carbon::parse($time)->format('g:i a');
	}
	public function getEndTimeAttribute($time)
	{
		return Carbon::parse($time)->format('g:i a');
	}
	public function getStartClockinTimeAttribute($time)
	{
		return Carbon::parse($time)->format('g:i a');
	}
	public function getEndClockinTimeAttribute($time)
	{
		return Carbon::parse($time)->format('g:i a');
	}
	public function getStartClockoutTimeAttribute($time)
	{
		return Carbon::parse($time)->format('g:i a');
	}
	public function getEndClockoutTimeAttribute($time)
	{
		return Carbon::parse($time)->format('g:i a');
	}
	public function getTimetableDetailAttribute()
	{
		return $this->name ." [ ".$this->start_time . " " . $this->end_time." ]";
	}
	public function getStartTime()
	{
		return $this->start_time;
	}

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
