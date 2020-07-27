<?php

namespace App\Helpers;



use App\Models\Leave;
use Carbon\Carbon;
use App\AcademicYear;
use App\Attendance;
use App\Models\Advance;
use App\Models\Email;
use App\Models\Holiday;
use App\UserInfo;
use App\UserShift;

class Helper
{
    public static  function generateDateRange($start_date, $end_date)
    {
        $start_date=Carbon::createFromFormat('Y-m-d', $start_date);
        $end_date=Carbon::createFromFormat('Y-m-d', $end_date);
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }
    public static function attendanceDetailCalculation($user_id,$from_date,$to_date){
        $dates=Helper::generateDateRange($from_date,$to_date);
        $report=array();
        //$all_attendances=Attendance::all();
        //$distinct_attendances=Attendance::all()->groupBy(function($date) {
        //return Carbon::parse($date->CHECKTIME)->format('Y'); // grouping by years
        //return Carbon::parse($date->CHECKTIME)->format('Y-m-d'); // grouping by months
        //});
        foreach($dates as $date){
            //$date=Carbon::parse($distinct_attendance[0]->CHECKTIME)->format('Y-m-d');
            //get day of week
            $day= strtolower(substr(Carbon::parse($date)->format('l') , 0 , 3  ));
            $default_year=AcademicYear::where('default',true)->get()->first()->id;
            $user_shifts=UserShift::where('userinfo_id',$user_id)->where('clicklizeAcYear_id',$default_year)->get();



            /*** if this day is a working day */
            if(count($user_shifts->first()) and $user_shifts->first()->shift != null){
                $user_shifts=$user_shifts->first()
                    //get the shifts and the shift timetables.
                    ->shift->shiftTimetables()->where('day',$day)->get();
            }
            $holiday1=Holiday::where('from','<=',$date)->where('to','>=',$date);//a value will change after if its been used in the count() function
            $holiday=Holiday::where('from','<=',$date)->where('to','>=',$date);
            $holiday_count=count($holiday->get());

            $leave1=Leave::where('from','<=',$date)->where('to','>=',$date)->where('userinfo_id','=',$user_id);
            $leave=Leave::where('from','<=',$date)->where('to','>=',$date)->where('userinfo_id','=',$user_id);
            $leave_count=count($leave->get());
            if(($user_shifts!=null and $holiday_count> 0 and $leave_count ==0 and count($holiday->whereHas('exceptions', function($q) use($user_id){$q->where('USERID', '=', $user_id);})->get()) > 0)
                or $user_shifts!=null and $holiday_count== 0 and $leave_count ==0

            ){
                if($user_shifts->count() > 0){
                    $report["$date"]['absent_shifts']=0;$report["$date"]['late']=0;$report["$date"]['worked_day']=0;$report["$date"]['working_day']=1;
                    $report["$date"]['total_min']=0;$report["$date"]['total_absent_min']=0;$report["$date"]['total_worked_min']=0;
                    $report["$date"]['day']=Carbon::parse($date)->format('l');
                    $present=0;
                    //$time_table_report='';
                    foreach($user_shifts as $user_shift){

                        /*** get this timetable attendance and filter it */
                        $time_table_report=self::getTimeTableAttendance($user_id,$date,$user_shift->timetable);

                        /*** if user was present in the timetable */
                        if($time_table_report['present']==1 and $present==0)
                            $present=1;

                        /*** get the timetable attendance report and store it to general report array */
                        //$report["$date"]['shifts']=$report["$date"]['shifts']+$time_table_report['shift'];
                        $report["$date"]['absent_shifts']=$report["$date"]['absent_shifts']+$time_table_report['absent_shift'];
                        $report["$date"]['late']=$report["$date"]['late']+$time_table_report['late'];
                        $report["$date"]['total_min']=$report["$date"]['total_min']+$time_table_report['total_min'];
                        $report["$date"]['total_absent_min']=$report["$date"]['total_absent_min']+$time_table_report['total_absent_min'];
                        $report["$date"]['total_worked_min']=$report["$date"]['total_worked_min']+$time_table_report['total_worked_min'];

                            if($user_shift->timetable != null){
                              $report["$date"]['shifts'][]=["start_time"=>$user_shift->timetable->start_time,
                                  "end_time"=>$user_shift->timetable->end_time,
                                  "clock_in_time"=>$time_table_report['clock_in_time'],
                                  "clock_out_time"=>$time_table_report['clock_out_time'],
                                  "late"=>$time_table_report['late'],"early"=>$time_table_report['early'],
                                  "total_shift_min"=>$time_table_report['total_min']];

                            }else{
                              $report["$date"]['shifts'][]=["start_time"=>"-",
                                  "end_time"=>"-",
                                  "clock_in_time"=>"-",
                                  "clock_out_time"=>"-",
                                  "late"=>"-","early"=>"-",
                                  "total_shift_min"=>"-"];

                        }

                    }


                    /*** if user was present in one timetable */
                    if($present!==0 and $report["$date"]['worked_day']!==1)
                        $report["$date"]['worked_day']=1;

                    //break;

                }
                /*** if not */
                else{
                    $report["$date"]['day']=Carbon::parse($date)->format('l');
                    $report["$date"]['shifts'][]=[
                        "start_time"=>"Not Set","clock_in_time"=>0,"late"=>0,"total_shift_min"=>0,"early"=>0,"end_time"=>0,
                        "clock_out_time"=>0
                    ];
                    //global $report;
                    //$report["$date"]['shifts']=0;
                    $report["$date"]['absent_shifts']=0;$report["$date"]['late']=0;$report["$date"]['worked_day']=0;$report["$date"]['working_day']=0;
                    $report["$date"]['total_min']=0;
                    $report["$date"]['total_absent_min']=0;
                    $report["$date"]['total_worked_min']=0;
                    //return "no shift today";
                }

            }/*** if not */
            else{
                $report["$date"]['day']=Carbon::parse($date)->format('l');
                $label='';
                if ($holiday_count)
                    $label=$label.$holiday1->get()->first()->name." ";
                if ($leave_count)
                    $label=$label.$leave1->get()->first()->name;



                $report["$date"]['shifts'][]=[
                    "start_time"=>$label,"clock_in_time"=>0,"late"=>0,"total_shift_min"=>0,"early"=>0,"end_time"=>0,
                    "clock_out_time"=>0
                ];
                //global $report;
                //$report["$date"]['shifts']=0;
                $report["$date"]['absent_shifts']=0;$report["$date"]['late']=0;$report["$date"]['worked_day']=0;$report["$date"]['working_day']=0;
                $report["$date"]['total_min']=0;
                $report["$date"]['total_absent_min']=0;
                $report["$date"]['total_worked_min']=0;
                //return "no shift today";
            }





        }
        return $report;

    }

    public static function getTimeTableAttendance($user_id,$date,$timetable){
      if($timetable!=null){
        $attendances=Attendance::where('USERID',$user_id)->get();
        $start_time=Carbon::parse(Carbon::parse($timetable->start_time)->format('H:i:s'));
        $end_time=Carbon::parse(Carbon::parse($timetable->end_time)->format('H:i:s'));
        $start_clock_in=Carbon::parse($timetable->start_clockin_time);
        $end_clock_in=Carbon::parse($timetable->end_clockin_time);


        $start_clock_out=Carbon::parse($timetable->start_clockout_time);
        $end_clock_out=Carbon::parse($timetable->end_clockout_time);

        $late_min=$timetable->late_min;
        $early_min=$timetable->early_min;
        $start_time_with_late=$start_time->addMinutes($late_min);
        $end_time_with_early=$end_time->subMinutes($early_min);

        $clock_in_time=null;$clock_out_time=null;
        //$clock_in_time=array();
        $total_time_table_min=Carbon::parse(Carbon::parse($timetable->start_time)->format('H:i:s'))->diffInMinutes($end_time);
        /*** Get first clock in */
        foreach($attendances as $attendance){
            /*** if it is the passed day attendance */
            if(Carbon::parse($attendance->CHECKTIME)->format('Y-m-d') ==$date){
                /*** convert attendance datetime to only time (to compare) */
                $check_time=Carbon::parse($attendance->CHECKTIME->format('H:i:s'));
                if($check_time->between($start_clock_in, $end_clock_in)){
                    if($attendance->CHECKTYPE=="I" and $attendance->CHECKTIME < $clock_in_time or $clock_in_time==null)
                        $clock_in_time=$attendance->CHECKTIME->format('H:i:s');
                }
                if($check_time->between($start_clock_out, $end_clock_out) and $attendance->CHECKTYPE=="O"){
                    if($attendance->CHECKTIME < $clock_out_time or $clock_out_time==null)
                        $clock_out_time=$attendance->CHECKTIME->format('H:i:s');
                }
            }
        }
        $time_table_report['total_min']=$total_time_table_min;
        //$time_table_report['total_min']=$total_time_table_min;
        if($clock_in_time !=null){
            $time_table_report['clock_in_time']=Carbon::parse($clock_in_time)->format('g:i a');
            $clock_in_time=Carbon::parse($clock_in_time);
            $time_table_report['shift']=1;
            $time_table_report['absent_shift']=0;
            $time_table_report['present']=1;
            $time_table_report['total_absent_min']=0;
            //$time_table_report['clock_in_time']=0;

            //$time_table_report['total_min']=$total_time_table_min;
            if($clock_in_time->between($start_time_with_late,$end_clock_in)){
                $time_table_report['late']=$clock_in_time->diffInMinutes($start_time_with_late);
                $time_table_report['total_worked_min']=$total_time_table_min-$time_table_report['late'];
            }else{
                $time_table_report['late']=0;
                $time_table_report['total_worked_min']=$total_time_table_min;
            }


        }else{
            //$time_table_report['total_min']=$total_time_table_min;
            $time_table_report['clock_in_time']=0;
            $time_table_report['total_worked_min']=0;
            $time_table_report['total_absent_min']=$total_time_table_min;
            $time_table_report['shift']=0;
            $time_table_report['absent_shift']=1;
            $time_table_report['late']=0;
            $time_table_report['present']=0;
        }
        if($clock_out_time!=null){
            $time_table_report['clock_out_time']=Carbon::parse($clock_out_time)->format('g:i a');
            //$time_table_report['total_min']=$total_time_table_min;
			$clock_out_time=Carbon::parse($clock_out_time);
            if($clock_out_time->between($end_time_with_early,$end_clock_out)){
                $time_table_report['early']=$clock_out_time->diffInMinutes($end_time_with_early);
                $time_table_report['total_worked_min']=$total_time_table_min-$time_table_report['early'];
            }else{
                $time_table_report['early']=0;
                //$time_table_report['total_worked_min']=$total_time_table_min;
            }

        }else{
            $time_table_report['clock_out_time']=0;
            $time_table_report['early']=0;

        }
        ;

      }else{
        $time_table_report['total_min']=0;
        $time_table_report['clock_in_time']=0;
        $time_table_report['total_worked_min']=0;
        $time_table_report['total_absent_min']=0;
        $time_table_report['shift']=0;
        $time_table_report['absent_shift']=0;
        $time_table_report['late']=0;
        $time_table_report['present']=0;
        $time_table_report['clock_out_time']=0;
        $time_table_report['early']=0;

      }

        return $time_table_report;
    }

    public static function DailyReport($date=null){
        $date==null?$date=Carbon::today()->format('Y-m-d'):$date;
        //$users=UserInfo::orderBy('NAME', 'asc')->get();



        $users = UserInfo::with('Department')
          ->get()
          ->sortBy(function($user) {
              return $user->Department->DEPTNAME;
          });


        $reports=array();

        //if today is holiday
        if(count($holiday=Holiday::where('from','<=',$date)->where('to','>=',$date)->get()) > 0){
            $users=Holiday::where('from','<=',$date)->where('to','>=',$date)->get()->first()->exceptions;

        }



        foreach($users as $user){
            $reports["$user->USERID"]["name"]=$user->NAME;
            $reports["$user->USERID"]["department"]=$user->Department->DEPTNAME;
            $days_in_month=cal_days_in_month(CAL_GREGORIAN, Carbon::createFromFormat('Y-m-d', $date)->month, Carbon::createFromFormat('Y-m-d', $date)->year);
            $default_year=AcademicYear::where('default',true)->get()->first()->id;
            $reports["$user->USERID"]["date"]=self::attendanceDetailCalculation($user->USERID,$date,$date);

        }
        return $reports;




    }

}
