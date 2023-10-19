<?php

namespace App\Http\Controllers;

use App\Models\lead;
use App\Models\Source;
use App\Models\Status;
use App\Models\company;
use App\Models\Referer;
use App\Models\category;
use App\Models\employee;
use App\Models\LeadLogs;
use App\Models\customer;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\LeadLogTrait;
use DB;

class LeadController extends Controller
{
     use LeadLogTrait;
    public function lead_index(){
        $id=lead::max('id')+1;
        $source=Source::get();
        $referer=Referer::get();
        $status=Status::get();
        $category=category::get();
        $company  =company::all();
        $employee = employee::where('companyID',Auth::user()->companyID)->get();
        $leads=lead::orderBy('id', 'DESC')->where('companyID',Auth::user()->companyID)->get();
        if(Auth::user()->role_id =='3' || $this->role_check(45)){

          return view('lead.add-lead',compact('employee','source','referer','status','category','id','company','leads'));
        }else{
          $msg='Cannot Access Page !';
           return redirect()->back()->with('msg', $msg);
        }
    }

    public function getcustomer(Request $request){
      $customer =  customer::where('phone_number', $request->ph_no)->first();
      // return ($customer);
      return response()->json(['success' => '1', 'data' => $customer ]);
    }

    public function createLead(Request $request){
        $request->validate([
            'lead_name' => 'required',
            'lead_email' => 'required',
            'mobile_number' => 'required',
          ]);

        $customer =  customer::where('phone_number', $request->mobile_number)->first();
        $companyID = $this->getcompany();
        $company = company::find($companyID);

        if($customer == null){

          $new_cus = new customer;
          $new_cus->user_id  = Auth::user()->id;
          $new_cus->companyID  = $companyID;
          $new_cus->company  = $company->company;
          $new_cus->name  = $request->lead_name;
          $new_cus->email  = $request->lead_email;
          $new_cus->phone_number  = $request->mobile_number;
          $new_cus->created_by  = Auth::user()->id;
          $new_cus->save();
          $customerid = $new_cus->id;
        }else{
          $customerid = $customer->id;
          $cus = customer::where('id', $customer->id)->first();
          $cus->email = $request->lead_email;
          $cus->save();
        }
        $input=$request->all();
        $input['companyID'] = Auth::user()->companyID;
        unset($input['_token']);
        unset($input['table']);
        unset($input['tid']);
        unset($input['cus_id']);
        $input['user_id']=Auth::user()->id;
        $input['customer_id']= $customerid;
        $input['created_by']=Auth::user()->id;
        // dd($request->id);
        lead::updateOrInsert(
          ['id' => $request->id],
          $input
        );
        $msg=empty($request->id) ? "Lead Created SuccessFully":"Lead Updated Successfully";
        return redirect()->back()->with('msg',$msg);

    }
    public function assignLead(Request $request){

        $input = $request->all();
        $lead_id=$input['lead_id'];
        $employee_id=$input['employee_id'];
        $emp_user =employee::where('id', $employee_id)->first();
        $lead=lead::where('id',$lead_id)->first();
        $checkLead=DB::select("SELECT COUNT(*) AS total_tasks, SUM(CASE WHEN status = '3' THEN 1 ELSE 0 END) AS completed_tasks FROM leads WHERE employee_id ='$emp_user->user_id'");
        // dd($checkLead);
        if($checkLead){
            $totalTask = $checkLead[0]->total_tasks;
            $compTask = $checkLead[0]->completed_tasks;
            if($totalTask == $compTask){
              // dd('ok');
              if($lead){
                $logs=LeadLogs::where('lead_id',$lead_id)->first();
                       // ->Where('employee_id',$employee_id)
               if(!$logs){
                $lead->employee_id=$emp_user->user_id;
                $lead->save();
                  if(!$this->hasLeadLog($lead_id,$emp_user->user_id,"New work schedule","Lead Is Assigned to you",Auth::user()->id)){}
                  $this->sendNotification($emp_user->user_id,"New work schedule","Lead Is Assigned to you");
               }else{
                return redirect()->back()->with('error',"Lead is Already Assigned");
               }
                return redirect()->back()->with('msg',"Lead Assigned Successfully");
              }
            }else{
              return redirect()->back()->with('error',"Exist Lead Not Completed");
            }
        }

    }

    public function lead_delete(Request $request){

     $deletelead = lead::where('id',$request->id)->delete();
     return redirect()->back()->with('msg'," Lead Deleted ");
    }
    public function lead_reject(Request $request){
      $update = lead::where('id',$request->reject_id)->first();
        $update->status='4';
        $update->save();
      return redirect()->back()->with('msg'," Lead Reject! ");
     }
    
    public function sendNotification($userid,$title,$msg)
    {
        $firebaseToken = User::Where('id',$userid)->first('device_id');
            //dd($firebaseToken['device_id']);
        $SERVER_API_KEY = 'AAAAGZdphuY:APA91bG9ZcE0EukCW5DIzQzmOCpRU1GINvOxJt4iY52I0Ef3rB53szfNiJObaokadoTlwZu2d8gW7jP9u9KUutyjSPxYhlAY5Dzmap5sRPzVShsYQ6hCe90yEdX9oUVFQbjbbzS6hnUR';
      
        $data = [
            "registration_ids" => [$firebaseToken['device_id']],
            "notification" => [
                "title" => $title,
                "body" => $msg,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
       // dd($response);
    
}


}
