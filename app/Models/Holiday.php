<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Holiday extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'holiday';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];


    protected $fillable = ['from','to','name'];
    // protected $hidden = [];
     protected $dates = ['from','to'];

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
    public function exceptFor()
    {
        return $this->hasMany('App\HolidayEmployee','holiday_id', 'id');
    }
    public function exceptions()
    {
        return $this->belongsToMany('App\UserInfo', 'holiday_employees', 'holiday_id', 'userinfo_id');
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
