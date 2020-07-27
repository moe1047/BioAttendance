<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Carbon\Carbon;
Route::get('/', function () {
    //return \App\Department::all();
    //return \App\Models\Timetable::all();
    //return $total_time_table_min=Carbon::parse(Carbon::parse('13:00 am')->format('H:i'))->diffInMinutes('12:00 pm');
    return redirect('admin/dashboard');
});
Route::group(
    [
        'namespace'  => 'Backpack\Base\app\Http\Controllers',
        'middleware' => 'admin',
        'prefix'     => config('backpack.base.route_prefix'),
    ],
    function () {

        Route::get('dashboard', function () {

            $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
            $daily_reports=\App\Helpers\Helper::DailyReport();
            $time=Carbon::now()->format('g:i a');
            // Carbon::parse($time)->gt(Carbon::parse('2:03 pm'))  ? "True":"False";

            $date=Carbon::today()->format('Y-m-d');

            $emails=\App\Models\Email::all()->pluck('email_name','id');
            if(count($holiday=\App\Models\Holiday::where('from','<=',$date)->where('to','>=',$date)->get()) > 0){
                $holiday=$holiday->first();
            }else{
                $holiday=false;
            };

            return view("Dashboard",compact('daily_reports',$this->data,'date','emails','holiday','time'));

        });


    });

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['admin'],
    'namespace' => 'Admin'
], function() {
    Route::get('/test', function () {
        $date=null;
        $date==null?$date=\Carbon\Carbon::today()->format('Y-m-d'):$date;
        $holiday=\App\Models\Holiday::where('from','<=','2018-5-13')->where('to','>=','2018-5-13');
        return count($holiday->get());

        //if today is holiday
        if(count(\App\Models\Holiday::where('from','<=',$date)->where('to','>=',$date)->get()) > 0){
            return \App\Models\Holiday::where('from','<=',$date)->where('to','>=',$date)->whereHas('exceptions', function($q)
            {
                $q->where('USERID', '=', 67);

            })->get();


        }else{
            return "it is not";
        };
    });
    // your CRUD resources and other admin routes here
    CRUD::resource('timetable', 'TimeTableCrudController');
    CRUD::resource('shift', 'ShiftCrudController');
    CRUD::resource('advance', 'AdvanceCrudController');
    CRUD::resource('email', 'EmailCrudController');
    CRUD::resource('holiday', 'HolidayCrudController');
    CRUD::resource('leave', 'LeaveCrudController');
    //Route::post('shift/{id}/delete', 'ShiftCrudController@destroy');
    Route::get('user/assignShift', 'userController@index');
    Route::post('user/assignShift', 'userController@postAssignShift');
    Route::get('report/general', 'ReportController@generalReport');
    Route::post('report/general', 'ReportController@postGeneralReport');
    Route::get('report/detail', 'ReportController@payrollDetailReport');
    Route::post('report/detail', 'ReportController@postPayrollDetailReport');

    Route::get('report/payslip', 'ReportController@payslip');
    Route::get('report/schedule', 'ReportController@schedule');

    Route::get('report/workingHours', 'ReportController@getWorkingHours');
    Route::get('report/daily', 'ReportController@DailyReport');
    Route::get('admin/dashboard', 'ReportController@DailyReport');
    Route::get('report/dailyReport', 'ReportController@sendPrintDailyReport');

});
//Route::get('admin/shift/{id}/edit', 'ShiftCrudController@edit');

