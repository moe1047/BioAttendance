<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Shift extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/
	protected $fillable = ['name','clicklizeAcYear_id'];

    protected $table = 'clicklizeShifts';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	public function saturdayTimetables()
	{
		return $this->shiftTimetables()->where('day','sat')->get();
	}

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function shiftTimetables()
	{
		return $this->hasMany('App\ShiftTimetable','clicklizeshift_id', 'id');
	}

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
	public function getStartDateAttribute($date)
	{
		return Carbon::parse($date)->format('m/d/Y');
	}
	public function getEndDateAttribute($date)
	{
		return Carbon::parse($date)->format('m/d/Y');
	}

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/

}
