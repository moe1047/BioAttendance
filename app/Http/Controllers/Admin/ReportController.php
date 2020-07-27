<?php

namespace App\Http\Controllers\Admin;

use App\AcademicYear;
use App\Attendance;
use App\Department;
use App\Helpers\Helper;
use App\Models\Advance;
use App\Models\Email;
use App\Models\Holiday;
use App\Models\Leave;
use App\UserInfo;
use App\UserShift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function PayrollDetailReport(){
        /*$from_date='2016-08-01';
        $to_date='2016-08-31';
        $days_in_month=cal_days_in_month(CAL_GREGORIAN, Carbon::createFromFormat('Y-m-d', $from_date)->month, Carbon::createFromFormat('Y-m-d', $from_date)->year);
        $default_year=AcademicYear::where('default',true)->get()->first()->id;
        $salary=UserShift::where('userinfo_id',67)->where('clicklizeAcYear_id',$default_year)->get()->first()->salary;
        $day_rate=round($salary/$days_in_month,2);
        $reports=$this->attendanceDetailCalculation(67,$from_date,$to_date);*/
        $selected_id=0;
        $users=UserInfo::all()->pluck('NAME','USERID');
        $emails=Email::all()->pluck('email_name','id');
        return view('report.userPayrollDetails',compact('users','reports','day_rate','selected_id','emails'));
    }

    public function postPayrollDetailReport(Request $request){
        $user=UserInfo::find($request->input("user_id"));
        $user_full_name=$user->NAME;
        $from_date=$request->input("from_date");
        $to_date=$request->input("to_date");
        $days_in_month=cal_days_in_month(CAL_GREGORIAN, Carbon::createFromFormat('Y-m-d', $from_date)->month, Carbon::createFromFormat('Y-m-d', $from_date)->year);
        $default_year=AcademicYear::where('default',true)->get()->first()->id;

        $user_shift=UserShift::where('userinfo_id',$request->input("user_id"))->where('clicklizeAcYear_id',$default_year)->get()->first();
        if(count($user_shift)){
            if($user_shift->payment_type=='daily'){
                $diff_days=Carbon::createFromFormat('Y-m-d', $from_date)->diffInDays(Carbon::createFromFormat('Y-m-d', $to_date));
                $day_rate=$user_shift->salary;
            }elseif($user_shift->payment_type=='monthly'){
                $day_rate=round($user_shift->salary/$days_in_month,2);
            }
            //$day_rate=round($salary/$days_in_month,2);

            $reports=Helper::attendanceDetailCalculation($request->input("user_id"),$from_date,$to_date);
            $currency=$user_shift->currency;
            $users=UserInfo::all()->pluck('NAME','USERID');
            $selected_id=$request->input("user_id");

            $emails=Email::all()->pluck('email_name','id');
            //return $reports;
            //return dd($reports);

            if($request->input("search")!=''){
                //return dd($reports);
                return view('report.userPayrollDetails',compact('users','reports','day_rate','from_date','to_date','selected_id','currency','emails'));
            }elseif($request->input("print")!='')
            {
                return view('print.userPayrollDetails',compact('users','reports','day_rate','from_date','to_date','selected_id','currency','user_full_name'));
            }
            elseif($request->input("email")!='')
            {
                if($request->input("emails")!=''){
                    // view('mail.userPayrollDetails',compact('users','reports','day_rate','from_date','to_date','selected_id'));
                    $emails=$this->getEmailsByIds($request->input("emails")) ;
                    Mail::send('mail.userPayrollDetails', ['reports' => $reports,'from_date'=>$from_date,'to_date'=>$to_date,'day_rate'=>$day_rate,'currency'=>$currency,'user_full_name'=>$user_full_name], function ($message)use($emails,$user)  {
                        //$today=Carbon::now()->toDateString();
                        //$m->from('moe1047@gmail.com', 'Your Application');
                        //$message->embed(asset('img/Attendance_mail_header.png'));
                        $message->to($emails)->subject('Attendance Detail for '.$user->NAME);
                    });

                }
                return redirect()->back();
            }else{
                return "Sorry";
            }
        }else{
            return 'User Has no shift (assign shift)';
        }


    }

    public function generalReport(){
        //$from_date=Carbon::createFromFormat('Y-m-d', '2016-08-06');
        //$to_date=Carbon::createFromFormat('Y-m-d', '2016-08-08');
        $emails=Email::all()->pluck('email_name','id');
        $departments=Department::all()->pluck('DEPTNAME','DEPTID');
        return view('report.generalPayroll',compact('emails','departments'));
    }
    public function postGeneralReport(Request $request){
        //return $request->input("type");
        $request->input("departments");

        //return $request->input("daterange");
        $from_date=$request->input("from_date");
        $to_date=$request->input("to_date");
        $type=$request->input("type");
        if($request->input("departments") == 1){
            $users=UserInfo::all();
        }else{
            $users=UserInfo::where('DEFAULTDEPTID',$request->input("departments"))->orderBy('USERID', 'ASC')->get();
        }

        //$users=UserInfo::all();
        $days_in_month=cal_days_in_month(CAL_GREGORIAN, Carbon::createFromFormat('Y-m-d', $from_date)->month, Carbon::createFromFormat('Y-m-d', $from_date)->year);
        $default_year=AcademicYear::where('default',true)->get()->first()->id;

        $reports=array();
        $academic_year=AcademicYear::where('default',true)->get()->first();
        //$start = microtime(true);
        foreach($users as $user){

            $id=$user->USERID;
            $user_shift=UserShift::where('userinfo_id',$id)->where('clicklizeAcYear_id',$default_year)->get()->first();
            if(count($user_shift)){
                $reports["$id"]['currency']=$user_shift->currency;
                $reports["$id"]['salary']=$user_shift->salary;
                if($user_shift->payment_type=='daily'){
                    $day_rate=$user_shift->salary;
                }elseif($user_shift->payment_type=='monthly'){
                    $day_rate=round($user_shift->salary/$days_in_month,2);
                }
                $reports["$id"]['salary']=$user_shift->salary;
            }else{
                $reports["$id"]['currency']='';
                $day_rate=0;
                $reports["$id"]['salary']=0;

            }

            $reports["$id"]['name']=$user->NAME;

            $reports["$id"]['working_days']=0;$reports["$id"]['worked_days']=0;$reports["$id"]['worked_shifts']=0;$reports["$id"]['absent_shifts']=0;$reports["$id"]['late']=0;$reports["$id"]['total_min']=0;
            $reports["$id"]['total_absent_min']=0;$reports["$id"]['total_worked_min']=0;$reports["$id"]['deduction_amount']=0;$reports["$id"]['advance']=0;
            $dates=$this->attendanceCalculation($id,$from_date, $to_date,$day_rate);
            //return $from_date;break;
            /*** loop through the dates */
            foreach($dates as $day=>$date){
                //return  $day;break;
                $reports["$id"]['advance']+=Advance::whereDate('created_at',$day)->where('user_id',$id)->sum('amount');
                //return $date;break;
                $reports["$id"]['working_days']=$reports["$id"]['working_days']+$date['working_day'];
                $reports["$id"]['worked_days']=$reports["$id"]['worked_days']+$date['worked_day'];
                $reports["$id"]['worked_shifts']=$reports["$id"]['worked_shifts']+$date['shifts'];
                $reports["$id"]['late']=$reports["$id"]['late']+$date['late'];
                $reports["$id"]['absent_shifts']=$reports["$id"]['absent_shifts']+$date['absent_shifts'];
                $reports["$id"]['total_min']=$reports["$id"]['total_min']+$date['total_min'];
                $reports["$id"]['total_absent_min']=$reports["$id"]['total_absent_min']+$date['total_absent_min'];
                $reports["$id"]['total_worked_min']=$reports["$id"]['total_worked_min']+$date['total_worked_min'];
                $reports["$id"]['deduction_amount']=$reports["$id"]['deduction_amount']+$date['deduction_amount'];
            }

            $reports["$id"]['all_shifts']=$reports["$id"]['worked_shifts']+$reports["$id"]['absent_shifts'];
            $reports["$id"]['accumulated_rate']=$day_rate*$reports["$id"]['working_days'];

            /*** get userShifts for this user
            $userShift=UserShift::where('userinfo_id',$id)
            ->where('clicklizeAcYear_id',$academic_year->id);*/


            /*** if user has userShifts */

            /*if(count($userShift->get())){
                //return "there is";

            }else{
                //return "there is not";
                $reports["$id"]['salary']=0;
            }*/
            /*** calculate rate = salary/total_min
            if($reports["$id"]['salary']!==0 and $reports["$id"]['total_min']==!0){
            $reports["$id"]['rate']=round($reports["$id"]['salary']/$reports["$id"]['total_min'],4);
            }else{
            $reports["$id"]['rate']=0;
            }*/

            //$reports["$id"]['deduction_amount']=($reports["$id"]['late']+$reports["$id"]['total_absent_min'])*$reports["$id"]['rate'];
            //return $reports;


            /*** calculate rate = salary/total_min */


            //$report["$id"]['salary']=$report["$id"]['worked_shifts']+$report["$id"]['absent_shifts'];
            //$report["$id"]['rate']=$report["$id"]['working_days']+$report["$id"]['absent_shifts'];


        }
        //$time_elapsed_secs = microtime(true) - $start;
        //return $execution_time = ($time_elapsed_secs)/60;
        $departments=Department::all()->pluck('DEPTNAME','DEPTID');
        $emails=Email::all()->pluck('email_name','id');
        //return dd($reports);
        if($request->input("search")!=''){
            return view('report.generalPayroll',compact('reports','from_date','to_date','emails','departments','type'));
        }elseif($request->input("print")!='')
        {
            $department=Department::where('DEPTID',$request->input("departments"))->get()->first()->DEPTNAME;

            return view('print.generalReport',compact('reports','from_date','to_date','department','type'));
        }
        elseif($request->input("email")!='')
        {
            if($request->input("emails")!=''){
                $emails=$this->getEmailsByIds($request->input("emails")) ;
                Mail::send('mail.generalReport', ['reports' => $reports,'from_date'=>$from_date,'to_date'=>$to_date,'type'=>$type], function ($message)use($emails,$from_date,$to_date)  {
                    $today=Carbon::now()->toDateString();
                    //$m->from('moe1047@gmail.com', 'Your Application');
                    //$message->embed(asset('img/Attendance_mail_header.png'));
                    $message->to($emails)->subject('General Report From: '.$from_date.' To: '.$to_date);
                });

            }

            return redirect()->back()->with(['from_date','to_date']);
        }else{
            return "Sorry";
        }
        //return $hey;
        //return dd($reports);
        //return view('report.generalPayroll',compact('reports','from_date','to_date'));
    }

    public function attendanceCalculation($user_id,$from_date,$to_date,$day_rate){
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
            $user_shifts=UserShift::where('userinfo_id',$user_id)->where('clicklizeAcYear_id',$default_year)->get()->first();
            count($user_shifts)?$user_shifts=$user_shifts->shift->shiftTimetables()->where('day',$day)->get():$user_shifts=null;
            $leave1=Leave::where('from','<=',$date)->where('to','>=',$date)->where('userinfo_id','=',$user_id);
            $leave=Leave::where('from','<=',$date)->where('to','>=',$date)->where('userinfo_id','=',$user_id);
            $leave_count=count($leave->get());
            $holiday=Holiday::where('from','<=',$date)->where('to','>=',$date);
            $holiday_count=count($holiday->get());
            if(($user_shifts!=null and $holiday_count> 0 and $leave_count ==0 and count($holiday->whereHas('exceptions', function($q) use($user_id){$q->where('USERID', '=', $user_id);})->get()) > 0)
                or $user_shifts!=null and $holiday_count== 0 and $leave_count ==0

            )

            {
                /*** if this day is a working day and not a holiday*/
                if($user_shifts->count() > 0){
                    //global $report;
                    $report["$date"]['shifts']=0;$report["$date"]['absent_shifts']=0;$report["$date"]['late']=0;$report["$date"]['worked_day']=0;$report["$date"]['working_day']=1;$report["$date"]['total_min']=0;
                    $report["$date"]['total_absent_min']=0;$report["$date"]['total_worked_min']=0;
                    $present=0;
                    //$time_table_report='';
                    foreach($user_shifts as $user_shift){

                        /*** get this timetable attendance and filter it */
                        $time_table_report=$this->getTimeTableAttendance($user_id,$date,$user_shift->timetable);

                        /*** if user was present in the timetable */
                        if($time_table_report['present']==1 and $present==0)
                            $present=1;

                        /*** get the timetable attendance report and store it to general report array */
                        $report["$date"]['shifts']=$report["$date"]['shifts']+$time_table_report['shift'];
                        $report["$date"]['absent_shifts']=$report["$date"]['absent_shifts']+$time_table_report['absent_shift'];
                        $report["$date"]['late']=$report["$date"]['late']+$time_table_report['late'];
                        $report["$date"]['total_min']=$report["$date"]['total_min']+$time_table_report['total_min'];
                        $report["$date"]['total_absent_min']=$report["$date"]['total_absent_min']+$time_table_report['total_absent_min'];
                        $report["$date"]['total_worked_min']=$report["$date"]['total_worked_min']+$time_table_report['total_worked_min'];

                    }
                    $rate_per_min=round($day_rate/$report["$date"]['total_min'],4);
                    $report["$date"]['deduction_amount']=$report["$date"]['total_absent_min']!==0?($rate_per_min*$report["$date"]['late'])+($rate_per_min*$report["$date"]['total_absent_min']):$rate_per_min*$report["$date"]['late'];

                    /*** if user was present in one timetable */
                    if($present!==0 and $report["$date"]['worked_day']!==1)
                        $report["$date"]['worked_day']=1;

                    //break;

                }
                /*** if not */
                else{
                    $report["$date"]['deduction_amount']=0;
                    //global $report;
                    $report["$date"]['shifts']=0;$report["$date"]['absent_shifts']=0;$report["$date"]['late']=0;$report["$date"]['worked_day']=0;$report["$date"]['working_day']=0;
                    $report["$date"]['total_min']=0;
                    $report["$date"]['total_absent_min']=0;
                    $report["$date"]['total_worked_min']=0;
                    //return "no shift today";
                }
            }
            else{
                $report["$date"]['deduction_amount']=0;
                //global $report;
                $report["$date"]['shifts']=0;$report["$date"]['absent_shifts']=0;$report["$date"]['late']=0;$report["$date"]['worked_day']=0;$report["$date"]['working_day']=0;
                $report["$date"]['total_min']=0;
                $report["$date"]['total_absent_min']=0;
                $report["$date"]['total_worked_min']=0;
                //return "no shift today";
            }




        }
        return $report;

    }
    protected function getTimeTableAttendance($user_id,$date,$timetable){
        $attendances=Attendance::where('USERID',$user_id)->whereDate('CHECKTIME',$date)->get();
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
            //if(Carbon::parse($attendance->CHECKTIME)->format('Y-m-d') ==$date){
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
            //}
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
            $clock_out_time=Carbon::parse($clock_out_time);
            //$time_table_report['total_min']=$total_time_table_min;
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
        return $time_table_report;
    }

    public function paySlip(Request $request){
        $phone=0;
        $user=UserInfo::find($request->input("id"));
        $default_year=AcademicYear::where('default',true)->get()->first()->id;
        $user_shift=UserShift::where('userinfo_id',$user->USERID)->where('clicklizeAcYear_id',$default_year)->get()->first();
        if(count($user_shift)){
            $salary=$user_shift->salary;
            $currency=$user_shift->currency;
            $phone=$user->PAGER;

            $name=$request->input("name");
            $total_worked_days=$request->input("total_worked_days");
            $late=$request->input("late");
            $deduction_amount=$request->input("deduction_amount");
            $advance=$request->input("advance");
            $accumulated_amount=$request->input("accumulated_rate");
            $absent_days=(integer)$request->input("working_days")-(integer)$request->input("worked_days");
            $absent_shifts=(integer)$request->input("absent_shifts");
            $from=$request->input("from");$to=$request->input("to");
        }else{
            $salary=0;
            $currency='';
            $phone=$user->PAGER;

            $name=$request->input("name");
            $total_worked_days=$request->input("total_worked_days");
            $late=$request->input("late");
            $deduction_amount=$request->input("deduction_amount");
            $advance=$request->input("advance");
            $accumulated_amount=$request->input("accumulated_rate");
            $absent_days=(integer)$request->input("working_days")-(integer)$request->input("worked_days");
            $absent_shifts=(integer)$request->input("absent_shifts");
            $from=$request->input("from");$to=$request->input("to");
        }

        //return $request->all();
        return view('report.payslip',compact('name','total_worked_days','late','deduction_amount',
            'absent_days','salary','currency','phone','from','to','advance','accumulated_amount','absent_shifts'));
    }
    public function schedule(){
        //return UserInfo::find(67)->OneUserShift->shift;
        $users=UserInfo::with('userShifts')->get();
        return view('print.userSchedule',compact('users'));
    }
    protected  function getEmailsByIds($email_ids){
        $emails=array();
        $emailss=Email::whereIn('id',$email_ids)->get();
        foreach($emailss as $email){
            $emails[]=$email->email;

        }
        return $emails;

    }
    protected  function getWorkingHours(){
        $week_days=array();
        $week_days[]="sat";$week_days[]="sun";$week_days[]="mon";$week_days[]="tue";$week_days[]="wed";$week_days[]="thu";$week_days[]="fri";
        $default_year=AcademicYear::where('default',true)->get()->first()->id;
        $users=UserInfo::all();
        $reports=array();
        foreach($users as $user){
            $reports["$user->USERID"]["name"]=$user->NAME;
            $reports["$user->USERID"]["total_mins"]=null;
            $user_shift=UserShift::where('userinfo_id',$user->USERID)->where('clicklizeAcYear_id',$default_year)->get()->first();
            if(count($user_shift)){
                foreach($week_days as $week_day){
                    $reports["$user->USERID"]["$week_day"]['mins']=0;
                    //$reports["$user->USERID"]["$week_day"]['hours']=null;
                    $shiftTimetables=$user_shift->shift->shiftTimetables()->where('day',$week_day)->get();
                    if($shiftTimetables->count()){
                        foreach($shiftTimetables as $shiftTimetable){
                            $timetable=$shiftTimetable->timeTable; //Carbon::parse($timetable->start_time)->format('H:i:s');
                            $reports["$user->USERID"]["$week_day"]['mins']+=Carbon::parse(Carbon::parse($timetable->start_time)->format('H:i:s'))->diffInMinutes(Carbon::parse($timetable->end_time));

                            //$diff_in_hours=Carbon::parse(Carbon::parse($timetable->start_time)->format('H:i:s'))->diffInSeconds(Carbon::parse($timetable->end_time));
                            //$diff_in_hours=gmdate('H:i', $diff_in_hours);
                            //if($reports["$user->USERID"]["$week_day"]['hours']!=null){
                            //$reports["$user->USERID"]["$week_day"]['hours']= Carbon::parse(Carbon::parse($reports["$user->USERID"]["$week_day"]['hours'])->format('H:i'))->addHours($diff_in_hours)->format('H:i');
                            //}else{
                            //$reports["$user->USERID"]["$week_day"]['hours']=$diff_in_hours;
                            //}
                            //+=$diff_in_hours;break;
                            if($reports["$user->USERID"]["total_mins"]!=null){
                                //$total_hours=$reports["$user->USERID"]["total_hours"];
                                $reports["$user->USERID"]["total_mins"]+= $reports["$user->USERID"]["$week_day"]['mins'];
                            }else{
                                $reports["$user->USERID"]['total_mins']=$reports["$user->USERID"]["$week_day"]['mins'];
                            }
                            //$reports["$user->USERID"]["total_hours"]+=$diff_in_hours;
                        }
                    }else{
                        $reports["$user->USERID"]["$week_day"]['mins']='-';
                        //$diff_in_hours=Carbon::parse(Carbon::parse($timetable->start_time)->format('H:i:s'))->diffInHours(Carbon::parse($timetable->end_time));
                        $reports["$user->USERID"]["$week_day"]['hours']='-';
                        $reports["$user->USERID"]["total_hours"]='-';
                    }

                }
            }else{
                foreach($week_days as $week_day){

                    $reports["$user->USERID"]["$week_day"]['mins']='-';
                    //$diff_in_hours=Carbon::parse(Carbon::parse($timetable->start_time)->format('H:i:s'))->diffInHours(Carbon::parse($timetable->end_time));
                    $reports["$user->USERID"]["$week_day"]['hours']='-';
                    $reports["$user->USERID"]["total_hours"]='-';
                }


            }

        }
        //return dd($reports);
        return view("print.workingHours",compact('reports'));

    }

    public function sendPrintDailyReport(Request $request){
        
        if($request->input("date")!=''){
            $daily_reports=Helper::DailyReport($request->input("date"));
            $date = $request->input("date");
        }else{
            $daily_reports=Helper::DailyReport();
            $date = Carbon::today()->format('Y-m-d');
        }
        if($request->input("print")!=''){
            return view('print.dailyReport',compact('daily_reports','date'));
        }
        elseif($request->input("email")!='')
        {
            if($request->input("emails")!=''){
                $emails=$this->getEmailsByIds($request->input("emails")) ;
                Mail::send('mail.dailyReport', ['daily_reports' => $daily_reports,'date'=>$date], function ($message)use($emails,$date)  {
                    $today=Carbon::now()->toDateString();
                    //$m->from('moe1047@gmail.com', 'Your Application');
                    //$message->embed(asset('img/Attendance_mail_header.png'));
                    $message->to($emails)->subject('Attendance Report For: '.$date);
                });
            }
            return redirect()->back()->withInput();
        }
        if($request->input("search")!='') {
            $this->data['title'] = trans('backpack::base.dashboard');
            $time = Carbon::now()->format('g:i a');
            $emails=\App\Models\Email::all()->pluck('email_name','id');
            if(count($holiday=\App\Models\Holiday::where('from','<=',$date)->where('to','>=',$date)->get()) > 0){
                $holiday=$holiday->first();
            }else{
                $holiday=false;
            };
            return view("Dashboard",compact('daily_reports',$this->data,'date','emails','holiday','time'));
        }
    }
}
