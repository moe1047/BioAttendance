<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'USERINFO';

    /**
     * The primary key for the model.
     *
     * @var string
     */
     protected $primaryKey = 'USERID';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    // public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    // protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['NAME','DEFAULTDEPTID'];

    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    // protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	public function defaultAcYearShift()
	{
		$academic_year=AcademicYear::where('default',true)->get()->first();
		return $this->userShifts()->where('clicklizeAcYear_id',$academic_year->id);
	}

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function userShifts()
	{
		return $this->hasMany('App\UserShift','userinfo_id', 'USERID');
	}

	public function OneUserShift()
	{
		return $this->hasOne('App\UserShift','userinfo_id', 'USERID');
	}
  public function Department()
	{
		return $this->belongsTo('App\Department','DEFAULTDEPTID', 'DEPTID');
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

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
