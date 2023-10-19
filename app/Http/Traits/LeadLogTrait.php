<?php
namespace App\Http\Traits;
use App\Models\company;
use App\Models\LeadLogs;
use App\Models\menu_permission;
use Illuminate\Support\Facades\Auth;


trait LeadLogTrait {
    public function hasLeadLog($lead_id,$employee_id,$title,$msg,$createdBy)
	{
        $insertArr=array(
            'lead_id'=>$lead_id,
            'employee_id'=>$employee_id,
            'title'=>$title,
            'message'=>$msg,
            'created_by'=>$createdBy           
        );
        LeadLogs::create($insertArr);
    }
    public function getcompany(){
        $company =company::where('status',1)->first();
          return $company->id; 
    }
    public function role_check($permission_id){
        $permission =menu_permission::where('user_id',Auth::user()->id)->where('menu_sub',$permission_id)->first();
        if($permission){
            return true; 
        }else{
            return false;
        }
         
    }
}
