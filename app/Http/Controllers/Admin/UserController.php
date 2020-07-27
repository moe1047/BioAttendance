<?php

namespace App\Http\Controllers\Admin;


use App\AcademicYear;
use App\Models\Shift;
use App\UserInfo;
use App\UserShift;
use Illuminate\Http\Request;

class UserController extends \App\Http\Controllers\Controller
{
    public function index(){
         $users=UserInfo::all();
        //$all_shifts=Shift::all();
        $default_year=AcademicYear::where('default',true)->get()->first()->id;
        $shifts=Shift::where('clicklizeAcYear_id',$default_year)->pluck('name','id');


        $all_shifts=Shift::where('clicklizeAcYear_id',$default_year)->get();


        return view('user.AssignShift',compact('users','shifts','all_shifts'));
    }
    public function postAssignShift(Request $request){
        $academic_year=AcademicYear::where('default',true)->get()->first();
        foreach($request->input('user') as $id=>$value){
            $user=UserInfo::find($id);
            $userShift=UserShift::where('userinfo_id',$id)
                ->where('clicklizeAcYear_id',$academic_year->id);

            if(count($userShift->get())){
                //return "there is";
                $userShift->update(['clicklizeshift_id'=>$value["shift"],'userinfo_id'=>$id,'clicklizeAcYear_id'=>$academic_year->id,'salary'=>$value["salary"],'payment_type'=>$value["payment_type"],'currency'=>$value["currency"]]);
            }else{
                //return "there is not";
                UserShift::create(['clicklizeshift_id'=>$value["shift"],'userinfo_id'=>$id,'clicklizeAcYear_id'=>$academic_year->id,'salary'=>$value["salary"],'payment_type'=>$value["payment_type"],'currency'=>$value["currency"]]);
            }
            //return $value["shift"];break;
        }
        return redirect()->back();
        //return $request->input('user');
    }

}
