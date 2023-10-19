<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\employee;
use App\Models\attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\LeadLogTrait;

class AttendanceController extends Controller
{
  use LeadLogTrait;
  

public function index(Request $request){
        
    $employee = employee::get();

    if($request->id !=''){
         $edit_data= attendance::where('id',$request->id)->first();
         if (Auth::user()->role_id == '3' || $this->role_check(44)) {
          return view('attendance.attendance',['employee'=>$employee,'attendance'=>$edit_data]);
       } else {
          $msg = 'Cannot Access Page !';
          return redirect()->back()->with('msg', $msg);
       }
        
         
        //  if($edit_data ==''){
        //   return response()->json(['success' => '0', 'error' => '']);
  
        //  }
        //  return response()->json(['success' => '1', 'data' => $edit_data]);
          
    }
    if(Auth::user()->role_id =='3' || $this->role_check(37)){
  
      $attendance =attendance::orderby('id', 'desc')->where('empID',Auth::user()->id)
      ->where('companyID',Auth::user()->companyID)
      ->get();
     return view('attendance.attendance',['employee'=>$employee,'attendance'=>$attendance]);
    }else{
      $msg='Cannot Access Page !';
       return redirect()->back()->with('msg', $msg);
    }
  }
  public function view(Request $request){
        

    if($request->id){
    $employee = employee::get();
    $attendance =attendance::where('id',$request->id)->orderby('id', 'desc')->first();
    }
        // $employee = employee::get();
        if($request->all()){
          $year = $request->year;
          $month = $request->month;
      }else{
          $now = Carbon::now();
          $year = $now->year;
          $month = $now->month;
      }
      // dd(Auth::user()->companyID);
    $attendance =attendance::select('users.first_name as name','attendances.*')->leftjoin('users','users.id','=','attendances.empID')->orderby('attendances.id', 'desc')->whereYear('attendances.attdate',$year)->whereMonth('attendances.attdate',$month)
    ->where('attendances.companyID',Auth::user()->companyID)
    ->get();
    
    if(Auth::user()->role_id =='3' || $this->role_check(42)){
     return view('attendance.view',['all'=>$attendance,'year'=>$year,'month'=>$month]);
    }else{
      $msg='Cannot Access Page !';
       return redirect()->back()->with('msg', $msg);
    }
  }
  
  
  public function attendance_store_update(Request $request){
  
  $request->validate([
                  'attdate'=>'required',
                  'empID' => 'required',                
                  
  ]);
  // dd($request->all());
    $input=$request->all();
    unset($input['_token']);
    $input['created_by']=Auth::user()->id;
    $input['user_id']=Auth::user()->id;
    $input['companyID']=Auth::user()->companyID;

    attendance::updateOrInsert(
        ['id' => $request->id],
        $input
    );

    if ($request->id == "") {
      $msg = "Attendance Added Successfully!";
    } else {
      $msg = "Attendance Updated Successfully!";
    }
    return redirect()->route('attendance.view')->with('msg',  $msg);
  }
  
  public function attendance_delete(Request $request){
  $data=$request->id;
  $delete = attendance::find($request->id)->delete();
  
         return response()->json(['success' => '1']);
  
  }
}
