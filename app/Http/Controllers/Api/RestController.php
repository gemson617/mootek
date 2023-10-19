<?php

namespace App\Http\Controllers\Api;

use PDF;
use App\Models\lead;
use App\Models\User;
use App\Models\cities;
use App\Models\states;
use App\Models\company;
use App\Models\category;
use App\Models\customer;
use App\Models\employee;
use App\Models\LeadLogs;
use App\Models\purchase;

use App\Models\AcceptJob;
use App\Models\attendance;
use App\Models\tax_purchase;
use App\Models\user_profile;
use Illuminate\Http\Request;
use App\Models\invoice_number;
use App\Models\manual_product;
use App\Models\purchase_order;
use App\Models\time_management;
use App\Http\Traits\LeadLogTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RestController extends Controller
{
    use LeadLogTrait;

    public function Login(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $password = $input['password'];

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            $response = [
                "status_code" => 200,
                "data" => $user,
                "message" => "Login Success"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "Email or Password Incorrect"
            ];
            return response()->json($response, 401);
        }
    }

    public function createLead(Request $request)
    {
        $input = $request->all();
        $mobile = isset($input['mobile_number']) ? $input['mobile_number'] : '';
        $checkMobile = customer::Where('phone_number', $mobile)->first();
        $company = user::where('id',$input['user_id'] )->first('companyID');
        $preferred_date = isset($input['preferred_date']) ? date('Y-m-d', strtotime($input['preferred_date'])) : '';
        $category=$input['categoryid'];
        if ($checkMobile) {
            // $response = [
            //     "status_code" => 401,
            //     "data" => null,
            //     "message" => "Mobile No Already Exists"
            // ];
            // return response()->json($response, 401);
            $cusid =$checkMobile->id;
        }else{
            $customer = array(
                'user_id' => isset($input['user_id']) ? $input['user_id'] : '',
                'companyID' => $company->companyID,
                'name' => isset($input['lead_name']) ? $input['lead_name'] : '',
                'phone_number' => isset($input['mobile_number']) ? $input['mobile_number'] : '',
                'country'=>101,//india
                'state' => isset($input['state']) ? $input['state'] : '',
                'city' => isset($input['city']) ? $input['city'] : '',
                'address_line1' => isset($input['address']) ? $input['address'] : '',
                'pincode' => isset($input['pincode']) ? $input['pincode'] : '',
                'created_by' => isset($input['user_id']) ? $input['user_id'] : '',
            );
            $customer_details = customer::create($customer);
            $cusid =$customer_details->id; 
        }
            // if ($customer_details) {
                $leadArr = array(
                    'user_id' => isset($input['user_id']) ? $input['user_id'] : '',
                    'companyID' => $company->companyID,
                    'employee_id' => isset($input['employee_id']) ? $input['employee_id'] : '',
                    // 'customer_id' => isset($input['customer_id']) ? $input['customer_id'] : $customer_details->id,
                    'customer_id' =>$cusid,
                    'lead_name' => isset($input['lead_name']) ? $input['lead_name'] : '',
                    'mobile_number' => isset($input['mobile_number']) ? $input['mobile_number'] : '',
                    'state' => isset($input['state']) ? $input['state'] : '',
                    'city' => isset($input['city']) ? $input['city'] : '',
                    'address' => isset($input['address']) ? $input['address'] : '',
                    'pincode' => isset($input['pincode']) ? $input['pincode'] : '',
                    'remark' => isset($input['remark']) ? $input['remark'] : '',
                    'date' => $preferred_date,
                    'category_id'=>$category,
                    'status' => '1',
                    'created_by' => isset($input['user_id']) ? $input['user_id'] : '',
                );
                $leads = lead::create($leadArr);
            $response = [
                "status_code" => 200,
                "data" => $leads->id,
                "message" => "Lead Created SuccessFully"
            ];
            return response()->json($response, 200);
        // }
    }
    public function state(){
       $state =  states::where('country_id',101)->get();
       if($state){
        $response = [
            "status_code" => 200,
            "data" =>$state,
            "message" => "Retrived SuccessFully"
        ];
        return response()->json($response, 200);
       }
    }
    public function city($id){
        $state =  cities::where('state_id',$id)->get();
        if($state){
         $response = [
             "status_code" => 200,
             "data" =>$state,
             "message" => "Retrived SuccessFully"
         ];
         return response()->json($response, 200);
        }
     }
    public function checkInOut(Request $request)
    {
        $input = $request->all();
        /**
         * Type==1 (In)
         * Type==2 (Out)
         */
        // dd($input);
        $userid = isset($input['user_id']) ? $input['user_id'] : '';
        $address = isset($input['address']) ? $input['address'] : '';
        // $status = isset($input['status']) ? $input['status'] : '';
        $lattitude = isset($input['lattitude']) ? $input['lattitude'] : '';
        $longitude = isset($input['longitude']) ? $input['longitude'] : '';
        $usertime = isset($input['time']) ? $input['time'] : '';
        $cur_date = isset($input['cur_date']) ? date('Y-m-d', strtotime($input['cur_date'])) : '';
        $type = isset($input['type']) ? $input['type'] : '';
        $loginType = isset($input['login_type']) ? $input['login_type'] : '';
        $location = isset($input['location']) ? $input['location'] : '';
        $company = User::where('id', $userid)->first('companyID');
        $branch = $company['companyID'];
        $company = company::where('id',$branch)->first();
        $inTime = date('h:i:s');
        $outTime = date('h:i:s');
        if ($type == 1) {
            $checkTime  = attendance::leftjoin('time_managements', 'time_managements.user_id', '=', 'attendances.empID')->where("attendances.empId", $userid)
                ->WhereDate("attendances.attdate", $cur_date)->where('attendances.approval', '1')
                ->first();
            // $checkTime = time_management::where('user_id', $userid)
            //     ->WhereDATE('date', $cur_date)
            //     ->first();
            if (!$checkTime) {
                if ($loginType == 1) { //office
                    $insertArr = array(
                        "user_id" => $userid,
                        'companyID' => $branch,
                        "empID" => $userid,
                        "attdate" => $cur_date,
                        "atttime" => $usertime,
                        "status" => 'Present',
                        'login_type' => $loginType,
                        'approval' => '1', //normal approval
                    );
                    //distance calculation
                    function haversineDistance($lat1, $lon1, $lat2, $lon2)
                    {

                        $earthRadius = 6371000; // Earth's radius in meters
                        $dLat = deg2rad($lat2 - $lat1);
                        $dLon = deg2rad($lon2 - $lon1);
                        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                        $distance = $earthRadius * $c;
                        return $distance;
                    }
                    // $targetLatitude = isset($input['lattitude']) ? $input['lattitude'] : '';
                    // $targetLongitude = isset($input['longitude']) ? $input['longitude'] : '';
                    // $coordinates = [
                    //     ['lat' => $company->lattitude, 'lon' => $company->longitude], // Coordinate 1
                    // ];
                    $nearestDistance = PHP_FLOAT_MAX;
                    $nearestCoordinate = null;
                    // foreach ($coordinates as $coord) {
                    $distance = haversineDistance($lattitude, $longitude, $company->lattitude, $company->longitude);
                    if ($distance < 50 && $distance < $nearestDistance) {
                        $nearestDistance = $distance;
                        $nearestCoordinate = $distance;
                        // }
                    }
                    if ($nearestCoordinate != null) {
                        $attendance = attendance::create($insertArr);
                        if ($attendance) {
                            $time = new time_management;
                            $time->login_time = $usertime;
                            $time->date = $cur_date;
                            $time->user_id = $userid;
                            $time->checkin_lattitude = $lattitude;
                            $time->checkin_longitude = $longitude;
                            $time->checkin_address = $address;
                            $time->status = 1; //CHECKIN
                            if ($time->save()) {
                                $response = [
                                    "status_code" => 200,
                                    "data" => $time,
                                    "message" => "CheckIn SuccessFully"
                                ];
                                return response()->json($response, 200);
                            }
                        }
                    } else {
                        $response = [
                            "status_code" => 400,
                            "data" => null,
                            "message" => "CheckIn Nearest Location"
                        ];
                        return response()->json($response, 400);
                    }
                } else { //Anywhere
                    $insertArr = array(
                        "user_id" => $userid,
                        'companyID' => $branch,
                        "empID" => $userid,
                        "attdate" => $cur_date,
                        "atttime" => $usertime,
                        "status" => 'Present', //present
                        'location' => $location,
                        'login_type' => $loginType,
                        'approval' => '0',
                    );
                    $check = attendance::where("empId", $userid)
                        ->WhereDate("attdate", $cur_date)->where('approval', '0')
                        ->first();
                    if ($check) {
                        $response = [
                            "status_code" => 401,
                            "data" => null,
                            "message" => "Waiting for Admin Approval!"
                        ];
                        return response()->json($response, 200);
                    } else {
                        $attendance = attendance::create($insertArr);
                        if ($attendance) {
                            $time = new time_management;
                            $time->login_time = $usertime;
                            $time->date = $cur_date;
                            $time->user_id = $userid;
                            $time->checkin_lattitude = $lattitude;
                            $time->checkin_longitude = $longitude;
                            $time->checkin_address = $address;
                            $time->status = 1;
                            if ($time->save()) {
                                $response = [
                                    "status_code" => 400,
                                    "data" => $time,
                                    "message" => "Waiting for Admin Approval!"
                                ];
                                return response()->json($response, 200);
                            }
                        }
                    }
                }
            } else {
                $time  = attendance::select('time_managements.*')->leftjoin('time_managements', 'time_managements.user_id', '=', 'attendances.empID')->where("attendances.empId", $userid)
                    ->WhereDate("attendances.attdate", $cur_date)->where('attendances.approval', '2')
                    ->first();
                if ($time) {
                    $response = [
                        "status_code" => 200,
                        "data" => $time,
                        "message" => "CheckIn SuccessFully"
                    ];
                    return response()->json($response, 200);
                } else {
                    $response = [
                        "status_code" => 401,
                        "data" => null,
                        "message" => "Already CheckIn"
                    ];
                    return response()->json($response, 401);
                }
            }
        }
        if ($type == 2) {
            // $time = time_management::where('user_id', $userid)
            //     ->where('status', '1')
            //     ->WhereDATE('date', $cur_date)
            //     ->first();
          
            $time  = time_management::where("user_id", $userid)
                ->Where("date", $cur_date)
                ->first();
                // dd($time);
            if ($time) {
                $time->logout_time = $usertime;
                $time->checkout_lattitude = $lattitude;
                $time->checkout_longitude = $longitude;
                $time->checkout_address = $address;
                $time->status = 2; //CHECKOUT
                if ($time->save()) {
                    $response = [
                        "status_code" => 200,
                        "data" => $time,
                        "message" => "CheckOut SuccessFully"
                    ];
                    return response()->json($response, 200);
                }
            }
        }
    }


    public function getProfile($id)
    {
        $user = User::leftjoin('user_profiles as up', 'up.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->get(['users.first_name', 'users.last_name', 'users.user_name', 'users.email', 'users.mobile', 'users.designation', 'up.image', 'up.address', 'up.city', 'up.pincode']);
        if ($user) {
            $response = [
                "status_code" => 200,
                "data" => $user,
                "message" => "Retrived SuccessFully"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "Data Not Found"
            ];
            return response()->json($response, 401);
        }
    }



    public function employeeList()
    {
        $employee = employee::get();
        $response = [
            "status_code" => 200,
            "data" => $employee,
            "message" => "Retrived SuccessFully"
        ];
        return response()->json($response, 200);
    }

    public function meterialList($id)
    {
        $user = user::where('id',$id )->first();
        //$meterial=manual_product::get();
        //   dd($user);
        $meterial = DB::table('purchases')
            ->leftJoin('products', 'purchases.productID', '=', 'products.id')
            ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
            ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id')
            ->leftJoin('suppliers', 'purchases.supplierID', '=', 'suppliers.id')
            ->select('purchases.*', 'purchases.id AS p_id', 'categories.*', 'products.*', 'brands.*', 'suppliers.*','categories.id as ')
            ->groupBy('purchases.categoryID', 'purchases.brandID', 'purchases.supplierID', 'purchases.selling_price')
            ->where('purchases.stock', 1)
            ->where('purchases.type', 0)
            ->where('purchases.companyID',$user->companyID)
            ->get();
        $response = [
            "status_code" => 200,
            "data" => $meterial,
            "message" => "Retrived SuccessFully"
        ];
        return response()->json($response, 200);
    }

    public function todayListJob()
    {
        $date = date('Y-m-d');
        $lead = employee::leftjoin('leads as l', 'l.employee_id', '=', 'employees.id')
            ->WhereDATE('l.created_at', $date)
            ->get(['l.id as lead_id', 'l.invoice_path', 'l.lead_name', 'employees.id as employee_id', 'employees.name as emp_name', 'l.mobile_number', 'l.state', 'l.city', 'l.address', 'l.pincode', 'l.remark', 'l.status']);
        $response = [
            "status_code" => 200,
            "data" => $lead,
            "message" => "Retrived SuccessFully"
        ];
        return response()->json($response, 200);
    }

    public function getJobDetails($id)
    {
        $lead = lead::leftjoin('accept_job as aj', 'aj.lead_id', '=', 'leads.id')
            ->Where('leads.id', $id)->first([
                'leads.id', 'leads.user_id', 'leads.companyID', 'leads.employee_id', 'leads.lead_name', 'leads.mobile_number', 'leads.state', 'leads.city',
                'leads.address', 'leads.pincode', 'leads.remark', 'leads.status', 'leads.is_accept', 'leads.created_at', 'leads.updated_at', 'aj.checkin_lattitude', 'aj.checkin_longitude'
            ]);
        if ($lead) {
            $response = [
                "status_code" => 200,
                "data" => $lead,
                "message" => "Retrived SuccessFully"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "Not Found"
            ];
            return response()->json($response, 401);
        }
    }




    public function acceptJobList($id)
    {
        // $lead=lead::leftjoin('employees as e','e.id','=','leads.employee_id')                        
        //             ->get(['leads.id as lead_id','leads.lead_name','e.id as employee_id','e.name as emp_name','leads.mobile_number','leads.state','leads.city','leads.address','leads.pincode','leads.remark']);
        $lead = lead::Where('employee_id', $id)->Where('employee_id', '!=', '')->get();
        $response = [
            "status_code" => 200,
            "data" => $lead,
            "message" => "Retrived SuccessFully"
        ];
        return response()->json($response, 200);
    }

    public function changePassword(Request $request)
    {
        $input = $request->all();
        $userid = $input['user_id'];
        $password = $input['password'];
        $confirm_password = $input['confirm_password'];
        if ($password == $confirm_password) {
            $user = User::where('id', $userid)->first();
            $user->password = Hash::make($password);
            if ($user->save()) {
                $response = [
                    "status_code" => 200,
                    "data" => $userid,
                    "message" => "Password Changed"
                ];
                return response()->json($response, 200);
            }
        } else {
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "Password Not Matched"
            ];
            return response()->json($response, 401);
        }
    }

    public function employeeAttendance(Request $request)
    {
        $input = $request->all();
        $userid = isset($input['user_id']) ? $input['user_id'] : '';
        $status = isset($input['status']) ? $input['status'] : '';
        $usertime = isset($input['time']) ? $input['time'] : '';
        $cur_date = isset($input['cur_date']) ? date('Y-m-d', strtotime($input['cur_date'])) : '';
        $employeeId = isset($input['employee_id']) ? $input['employee_id'] : '';
        $insertArr = array(
            "user_id" => $userid,
            "empID" => $employeeId,
            "attdate" => $cur_date,
            "atttime" => $usertime,
            "status" => $status
        );
        $check = attendance::where("empId", $employeeId)
            ->WhereDate("attdate", $cur_date)
            ->first();
        if ($check) {
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "Attendance Captured Already"
            ];
            return response()->json($response, 401);
        } else {
            $attendance = attendance::create($insertArr);
            if ($attendance) {
                $response = [
                    "status_code" => 200,
                    "data" => $attendance->id,
                    "message" => "Attendance Captured Success"
                ];
                return response()->json($response, 200);
            }
        }
    }


    public function acceptJob(Request $request)
    {
        $input = $request->all();
        $userid = isset($input['user_id']) ? $input['user_id'] : '';
        $lead_id = isset($input['lead_id']) ? $input['lead_id'] : '';
        $status = "Accept";
        $insertArr = array(
            "employee_id" => $userid,
            "lead_id" => $lead_id,
            "status" => $status
        );
        $lead = lead::where('id', $lead_id)->where('is_accept', '0')->first();
        if ($lead) {
            $lead->is_accept = '1';
            if ($lead->save()) {
                $accept = AcceptJob::create($insertArr);
                if ($accept) {
                    $response = [
                        "status_code" => 200,
                        "data" => $accept->id,
                        "message" => "Job Accepted Success"
                    ];
                    return response()->json($response, 200);
                }
            }
        } else {
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "Job is Accepted Already"
            ];
            return response()->json($response, 401);
        }
    }

    public function todayJob(Request $request)
    {
        $input = $request->all();
        $userid = isset($input['user_id']) ? $input['user_id'] : '';
        $cur_date = isset($input['cur_date']) ? date('Y-m-d', strtotime($input['cur_date'])) : '';
        $lead = lead::leftjoin('accept_job', 'accept_job.lead_id', '=', 'leads.id')
            ->WhereDate("accept_job.created_at", $cur_date)
            ->where('accept_job.employee_id', $userid)
            ->get(['accept_job.checkin_lattitude', 'accept_job.checkin_longitude', 'leads.id as lead_id', 'leads.lead_name', 'leads.mobile_number', 'leads.state', 'leads.city', 'leads.address', 'leads.pincode', 'leads.remark', 'accept_job.created_at', 'accept_job.status']);

        if (strlen($lead) > 2) {
            $response = [
                "status_code" => 200,
                "data" => $lead,
                "message" => "Retrived Success"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Data Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function getCustomer($mno)
    {
        $customer = customer::select('customers.*','states.name as state_name','cities.name as city_name','countries.name as country_name')
        ->leftjoin('countries','countries.id','=','customers.country')
        ->leftjoin('states','states.id','=','customers.state')
        ->leftjoin('cities','cities.id','=','customers.city')
        ->where('customers.phone_number', $mno)->first();
        if ($customer) {
            $response = [
                "status_code" => 200,
                "data" => $customer,
                "message" => "Retrived Success"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Data Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function forgetPassword(Request $request)
    {
        $input = $request->all();
        $email = isset($input['email']) ? $input['email'] : '';
        $user = User::where('email', $email)->first(['email', 'id']);

        if ($user) {
            $otp = rand(1000, 10000);
            $tomail = $email;
            $subject = "Your TWS One-Time Password (OTP)";
            $data = array('otp' => $otp);
            $mail = Mail::send('mail', $data, function ($message) use ($tomail, $subject) {
                $message->from('info@teamworksystem.com', 'TWS');
                $message->to($tomail, 'TWS');
                $message->subject($subject);
            });
            $res = array("otp" => $otp, "user_id" => $user['id']);
            $response = [
                "status_code" => 200,
                "data" => $res,
                "message" => "Otp sent Successfully"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Email Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function resendOtp(Request $request)
    {
        $input = $request->all();
        $user_id = isset($input['user_id']) ? $input['user_id'] : '';
        $user = User::where('id', $user_id)->first('email');
        if ($user) {
            $otp = rand(1000, 10000);
            $tomail = isset($user['email']) ? $user['email'] : '';
            $subject = "Your TWS One-Time Password (OTP)";
            $data = array('otp' => $otp);
            $mail = Mail::send('mail', $data, function ($message) use ($tomail, $subject) {
                $message->from('info@teamworksystem.com', 'TWS');
                $message->to($tomail, 'TWS');
                $message->subject($subject);
            });
            $response = [
                "status_code" => 200,
                "data" => $otp,
                "message" => "Otp sent Successfully"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Email Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function checkAttendance(Request $request)
    {
        $input = $request->all();
        $userid = $input['user_id'];
        $month = $input['month'];
        $year = $input['year'];
        $date = $year . '-' . $month . '-' . '01';
        $records = DB::select("SELECT COUNT( CASE WHEN MONTH(attdate)='$month' THEN attdate END) as month,
            COUNT(CASE WHEN status='Present' THEN attdate END) as Working,
            DAY(LAST_DAY('$date')) - COUNT(CASE WHEN status='Present' THEN attdate END) as Absent,
            DAY(LAST_DAY('$date')) as Total_no_days
            FROM `attendances` WHERE user_id='$userid' AND YEAR(attdate)='$year' AND MONTH(attdate)='$month'");
        if ($records) {
            $response = [
                "status_code" => 200,
                "data" => $records,
                "message" => "Retrived Successfully"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Records Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function leadCheckIn(Request $request)
    {
        $input = $request->all();
        $userid = $input['user_id'];
        $lead_id = $input['lead_id'];
        $lattitude = $input['lattitude'];
        $longitude = $input['longitude'];
        $leadData = lead::where('id', $lead_id)->first();
        if ($leadData) {
            $leadData->status = 2;
            $leadData->save();
            $job = AcceptJob::where('lead_id', $lead_id)
                ->Where('employee_id', $userid)->first();
            if ($job) {
                $job->checkin_lattitude = $lattitude;
                $job->checkin_longitude = $longitude;
                $job->status = "Pending";
                $job->save();
                $response = [
                    "status_code" => 200,
                    "data" => $job,
                    "message" => "CheckIn Successfully"
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    "status_code" => 400,
                    "data" => null,
                    "message" => "Records Not Found"
                ];
                return response()->json($response, 400);
            }
        }
    }

    public function generateInvoice(Request $request)
    {
        $input = $request->all();
        $userid = $input['user_id'];
        $lead_id = $input['lead_id'];
        $cust = lead::where('id', $lead_id)->first('customer_id');
        $status = $input['status'];
        $payment_status = $input['payment_status'];
        $labor_charge = $input['labor_charge'];
        $remark = $input['customer_remark'];
        $customer = isset($cust['customer_id']) ? $cust['customer_id'] : '';
        $product = explode(",", $input['product_id']);
        $tax_price = explode(",", $input['product_amount']);
        $category = explode(",", $input['category_id']);
        $brand = explode(",", $input['brand_id']);
        // $total=$labor_charge;
        $total = 0;
        foreach ($product as $key => $val) {
            $total += $tax_price[$key];
        }
        // dd('ok');
        $company = User::where('id', $userid)->first('companyID');
        $discount = 0;
        $branch = $company['companyID'];
        $tax = 18;
        $grand_total = ($total + $labor_charge) * 18 / 100;
        $delivery = 0;
        $others = $input['labor_charge'];
        $mop = $input['payment_status']; //mode of payment
        $terms = 1;
        $com = company::where('id', $branch)->first();
        $PO = purchase_order::orderBy('id','desc')->where('companyID',$com->id)->where('status','2')->first();
        if($PO){
        $lead_start_no= $PO->lead_start_no+1;
        }else{
            $lead_start_no=0;
        }
        // $reference = $input['reference'];
        // $balance = $grand_total - $collected_total;
        $purchase_order = purchase_order::create([
            'user_id' => $userid,
            'companyID' => $branch,
            'taxable_price' => $total,
            'discount' => $discount,
            'tax' => $tax,
            'tax_amount' => $grand_total,
            'grand_total' => $grand_total + $total+$labor_charge,
            'collected' => $grand_total + $total+$labor_charge,
            'delivery' => $delivery,
            'others' => $others,
            'balance' => 0,
            'mop' => $mop,
            'reference' => $remark,
            'terms' => $terms,
            'customerID' => $customer,
            'status' => '2', //services
            'lead_start_no'=>$lead_start_no
        ]);
        $lastIDsaleinvoice = $purchase_order->id;
        $update = purchase_order::where('id',$lastIDsaleinvoice)->where('status','2')->first();
        
        if($com->lead_status =='0'){
            // dd($com);
                $update->invoiceID=$com->lead_prefix.($com->lead_no+$update->lead_start_no);
            }else{    
                $update->sale_start_no=0;
                $update->invoiceID=$com->lead_prefix.$com->lead_no;
              $com->lead_status=0;
              $com->save();      
            }
        // $company = company::where('id', $branch)->first();
        // $prefix = $company->prefix;
        // $invoice = $prefix . '-' . 'L' . $lastIDsaleinvoice;
        // $update = purchase_order::where('id', $lastIDsaleinvoice)->first();
        // $update->invoiceID = $invoice;
        // $update->save();
        //  for ($i = 0; $i < count($request->purchase_id); $i++) {
        //  $stock_details = purchase::where('id', $request->purchase_id[$i])->first();
        //  dd($stock_details);
        foreach ($product as $key => $val) {
            tax_purchase::create([
                'companyID' => $branch,
                'user_id' => $userid,
                'seial_number' => null,
                'category' => $category[$key],
                'brand' => $brand[$key],
                'product' => $product[$key],
                'invoice_number' => $lastIDsaleinvoice,
                'price' => $tax_price[$key],
                'tax_per' => $tax,
                'tax_per_amount' =>$tax_price[$key]*$tax/100,
                'stock_status' => 1,
                'quantity' => '1',
            ]);

            $update = purchase::where('productID', $product[$key])
                ->where('brandID', $brand[$key])
                ->where('categoryID', $category[$key])
                ->first();
            $update->stock = 0;
            //$update->sale = '1';
            $update->type = 3;  //3-service
            $update->save();
        }

        // }
        $purchase_details = purchase_order::where('id', $lastIDsaleinvoice)->first();
        $customer = $purchase_details->customerID;
        $customer_list = customer::where('id', $customer)->first();
        $customer = str_replace(" ", '', $customer_list->name);
        $tax_details=tax_purchase::
        leftjoin('purchase_orders','purchase_orders.id','=','tax_purchases.invoice_number')
        ->select('tax_purchases.tax_per',DB::raw('sum(tax_purchases.price) as price'),DB::raw('sum(tax_purchases.tax_per_amount) as tax_per_amount'),'purchase_orders.taxable_price','purchase_orders.grand_total')
        ->where('tax_purchases.invoice_number',$request->invoiceID)
        ->groupBy('tax_purchases.tax_per')->get();
        $pdf = PDF::loadView('sale.invoice', compact('purchase_details','tax_details'));
        $pdf->setPaper('A4', 'portrait');
        $filePath = public_path('invoice/' . $customer . $purchase_details->invoice . '.pdf');
        $pdf->save($filePath);

        $purchase_details->invoice_path = URL::to('/') . '/invoice/' . $customer . $purchase_details->invoice . '.pdf';
        if ($purchase_details->save()) {
            /** update lead Status */
            $acceptJob = acceptJob::where('lead_id', $lead_id)->first();
            $acceptJob->status = "Completed";
            $acceptJob->save();
            $lead = lead::where('id', $lead_id)->first();
            $lead->status = 3;
            $lead->invoice_path = URL::to('/') . '/invoice/' . $customer . $purchase_details->invoice . '.pdf';
            $lead->purchase_id = $lastIDsaleinvoice;
            $lead->save();
            if (!$this->hasLeadLog($lead_id, $userid, "successful complete work", "Successful complete work Received payment", $userid)) {
            }
            $response = [
                "status_code" => 200,
                "data" => $lastIDsaleinvoice,
                "message" => "Generated  Successfully"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Not Generated"
            ];
            return response()->json($response, 400);
        }
    }

    public function getJobNotification($id)
    {
        $notification = LeadLogs::Where('employee_id', $id)
            // ->Where('is_read', '0')
            ->get();
        if ($notification) {
            $response = [
                "status_code" => 200,
                "data" => $notification,
                "message" => "Retrived Successfully"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Records Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function getCheckIn(Request $request)
    {
        $input = $request->all();
        $userid = isset($input['user_id']) ? $input['user_id'] : '';

        $cur_date = isset($input['cur_date']) ? date('Y-m-d', strtotime($input['cur_date'])) : '';
        $checkTime  = attendance::select('*')->leftjoin('time_managements as tm', 'tm.user_id', '=', 'attendances.empID')
            
            ->where("attendances.empId", $userid)
            ->where('tm.checkin_lattitude', '!=', null)
            ->where('tm.checkin_longitude', '!=', null)
            ->where('tm.checkout_lattitude', '=', null)
            ->where('tm.checkout_longitude', '=', null)
            ->WhereDate("attendances.attdate", $cur_date)
            ->first();
        // $checkTime = time_management::where('user_id', $userid)
        //     ->WhereDATE('date', $cur_date)
        //     ->WhereIn('status', ['1', '2'])
        //     ->first();

        if ($checkTime) {
            $user = User::leftjoin('user_profiles as up', 'up.user_id', '=', 'users.id')
                ->leftjoin('attendances as at', 'at.empId', '=', 'users.id')
                ->leftjoin('time_managements as tm', 'tm.user_id', '=', 'users.id')
                ->leftjoin('designation_master as ds', 'ds.id', 'users.designation')
                // ->leftjoin('employees as e','tm.user_id','=','users.id')     'e.emp_prefix as employee_prefix'
                ->where('users.id', $userid)
                ->WhereDATE('tm.date', $cur_date)
                ->select(['ds.designation_name as designation', 'tm.status', 'users.id as userid', 'tm.date as login_date', 'tm.login_time', 'tm.logout_time', 'users.first_name','users.pin_status', 'users.last_name', 'users.user_name', 'users.email', 'users.mobile', 'up.image', 'up.address', 'up.city', 'up.pincode', 'tm.checkin_lattitude', 'tm.checkin_longitude', 'tm.checkout_lattitude', 'tm.checkout_longitude'])
                ->first();
            $response = [
                "status_code" => 200,
                "data" => $user,
                "message" => "User CheckedIn"
            ];
            return response()->json($response, 200);
        } else {
            $checkTime  = attendance::select('*')->leftjoin('time_managements as tm', 'tm.user_id', '=', 'attendances.empID')
                ->where("attendances.empId", $userid)
                ->where('tm.checkin_lattitude', '!=', null)
                ->where('tm.checkin_longitude', '!=', null)
                ->where('tm.checkout_lattitude', '!=', null)
                ->where('tm.checkout_longitude', '!=', null)
                ->WhereDate("attendances.attdate", $cur_date)
                ->first();
            // $checkTime  = attendance::select('*')->leftjoin('time_managements', 'time_managements.user_id', '=', 'attendances.empID')->where("attendances.empId", $userid)
            // ->WhereDate("attendances.attdate", $cur_date)->where('attendances.approval','0')
            // ->first();
            // if($checkTime){
            if ($checkTime) {
                $user = User::leftjoin('user_profiles as up', 'up.user_id', '=', 'users.id')
                    ->leftjoin('attendances as at', 'at.empId', '=', 'users.id')
                    ->leftjoin('designation_master as ds', 'ds.id', 'users.designation')
                    ->leftjoin('time_managements as tm', 'tm.user_id', '=', 'users.id')
                    // ->leftjoin('employees as e','tm.user_id','=','users.id')     'e.emp_prefix as employee_prefix'
                    ->where('users.id', $userid)
                    ->WhereDATE('tm.date', $cur_date)
                    ->select(['ds.designation_name as designation', 'tm.status', 'users.id as userid', 'tm.date as login_date', 'tm.login_time','users.pin_status', 'tm.logout_time', 'users.first_name', 'users.last_name', 'users.user_name', 'users.email', 'users.mobile', 'up.image', 'up.address', 'up.city', 'up.pincode', 'tm.checkin_lattitude', 'tm.checkin_longitude', 'tm.checkout_lattitude', 'tm.checkout_longitude'])
                    ->first();
                $response = [
                    "status_code" => 200,
                    "data" => $user,
                    "message" => "UserCheckOut"
                ];
            } else {
                $user = User::leftjoin('user_profiles as up', 'up.user_id', '=', 'users.id')
                      ->leftjoin('designation_master as ds', 'ds.id', 'users.designation')

                    ->where('users.id', $userid)
                    ->first(['ds.designation_name as designation','users.first_name','users.pin_status', 'users.last_name', 'users.user_name', 'users.email', 'users.mobile','up.image', 'up.address', 'up.city', 'up.pincode','users.active as status']);
            //  $status=array('status'=>'0');
                    // dd($user_c);
                    $response = [
                    "status_code" => 200,
                    "data" => $user,
                    "message" => "User Not CheckIn Today"
                ];
            }

            //     $response = [
            //         "status_code" => 200,
            //         "data" => $user,
            //         "message" => "Waiting Admin Approval"
            //     ];
            // }else{

            // }

            return response()->json($response, 200);
        }
    }

    public function getCompany()
    {
        $company = company::get();
        if ($company) {
            $response = [
                "status_code" => 200,
                "data" => $company,
                "message" => "Retrived Success"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Records Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function profileUpload(Request $request)
    {
        $input = $request->all();
        $userid = isset($input['user_id']) ? $input['user_id'] : '';
        $profile = isset($input['profile_img']) ? $input['profile_img'] : '';
        $image = base64_decode($profile);
        $filename = time() . '.png';
        file_put_contents(public_path('profile/' . $filename), $image);
        $path = URL::to('/') . '/profile/' . $filename;
        $user = user_profile::where('user_id', $userid)->first();
        if ($user) {
            $user->image = $path;
            if ($user->save()) {
                $response = [
                    "status_code" => 200,
                    "data" => $path,
                    "message" => "Uploaded Success"
                ];
                return response()->json($response, 200);
            }
        } else {
            $profile = new user_profile;
            $profile->user_id = $userid;
            $profile->image = $path;
            if ($profile->save()) {
                $response = [
                    "status_code" => 200,
                    "data" => $path,
                    "message" => "Uploaded Success"
                ];
                return response()->json($response, 200);
            }
        }
    }

    public function saveDeviceId(Request $request)
    {
        $input = $request->all();
        $userid = isset($input['user_id']) ? $input['user_id'] : '';
        $deviceId = isset($input['device_id']) ? $input['device_id'] : '';
        $user = user::where('id', $userid)->first();
        if ($user) {
            $user->device_id = $deviceId;
            if ($user->save()) {
                $response = [
                    "status_code" => 200,
                    "data" => $deviceId,
                    "message" => "Token Stored Success"
                ];
                return response()->json($response, 200);
            }
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Records Not Found"
            ];
            return response()->json($response, 400);
        }
    }

    public function readNotification(Request $request)
    {
        $input = $request->all();
        $user_id = isset($input['user_id']) ? $input['user_id'] : '';
        $lead_id = isset($input['lead_id']) ? $input['lead_id'] : '';
        $notification_id = isset($input['notification_id']) ? $input['notification_id'] : '';
        $type = isset($input['type']) ? $input['type'] : '';
        if ($type == 1) {
            $Leadlog = LeadLogs::where('id', $notification_id)
                ->Where('lead_id', $lead_id)->first();
            if ($Leadlog) {
                $Leadlog->is_read = 1;
                if ($Leadlog->save()) {
                    $response = [
                        "status_code" => 200,
                        "data" => $notification_id,
                        "message" => "Notification Readed"
                    ];
                    return response()->json($response, 200);
                }
            } else {
                $response = [
                    "status_code" => 400,
                    "data" => null,
                    "message" => "Records Not Found"
                ];
                return response()->json($response, 400);
            }
        }
        if ($type == 2) {
            $notificationArray = explode(",", $notification_id);
            $leadArray = explode(",", $lead_id);
            foreach ($notificationArray as $key => $val) {
                $Leadlog = LeadLogs::where('id', $val)
                    ->Where('lead_id', $leadArray[$key])->first();
                if ($Leadlog) {
                    $Leadlog->is_read = 1;
                    $Leadlog->save();
                }
            }
            $response = [
                "status_code" => 200,
                "data" => $notification_id,
                "message" => "Notification Readed"
            ];
            return response()->json($response, 200);
        }
    }

    public function AdminEmployeeStatus()
    {
        $today = date('Y-m-d');
        $employeeStatus = DB::table('attendances')->select('attendances.*', 'users.first_name', 'users.last_name', 'designation_master.designation_name','time_managements.checkin_address as location')
            ->join('users', 'users.id', '=', 'attendances.empID')
            ->join('time_managements','time_managements.user_id','=','users.id')
            ->join('designation_master', 'designation_master.id', '=', 'users.designation')
            ->Where('attendances.attdate',$today)
            ->where('attendances.approval','0')
            ->groupBy('attendances.id')
            ->get();

        $response = [
            "status_code" => 200,
            "data" => $employeeStatus,
            "message" => "Retrived SuccessFully"
        ];
        return response()->json($response, 200);
    }

    public function adminApproval(Request $request)
    {
        $input = $request->all();
        $emp_id = isset($input['emp_id']) ? $input['emp_id'] : '';
        $attdate = isset($input['cur_date']) ? date('Y-m-d', strtotime($input['cur_date'])) : '';
        // $location = isset($input['location']) ? $input['location'] : '';

        $update = attendance::where('empID', $emp_id)->where('attdate', $attdate)->where('approval', 0)->first();
        $update->approval = '2';
        $update->save();
        if ($update) {
            // $time = time_management::where('user_id', $emp_id)->where('date', $attdate)->first();
            // $time->status = '1';
            // $time->save();
            // if ($time) {
                $response = [
                    "status_code" => 200,
                    "data" => $update,
                    "message" => "Admin Accepted Attendance"
                ];
                return response()->json($response, 200);
            // }
        }
    }
    public function listLead($id){
        $user =user::where('id',$id)
        ->first();
        // dd($user);
         $role =$user->role_id;
         if($role =='3'){
            $leads=lead::orderBy('leads.id', 'DESC')
            ->leftjoin('customers','customers.id','=','leads.customer_id')
            ->leftjoin('categories','categories.id','=','leads.category_id')
            ->leftjoin('leads.is_accept',1)
            ->get();
         }else{
            $leads=lead::orderBy('leads.id', 'DESC')
            ->leftjoin('customers','customers.id','=','leads.customer_id')
            ->leftjoin('categories','categories.id','=','leads.category_id')
            ->leftjoin('leads.is_accept',1)
            ->where('leads.companyID',$user->companyID)
            ->get();
         }
        //  dd(count($leads));
         if (count($leads)>0) {
            $response = [
                "status_code" => 200,
                "data" => $leads,
                "message" => "Retrived Success"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Records Not Found"
            ];
            return response()->json($response, 400);
        }
    }
    public function getCategory(){
        $category=category::get();
        if (count($category)>0) {
            $response = [
                "status_code" => 200,
                "data" => $category,
                "message" => "Retrived Success"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Records Not Found"
            ];
            return response()->json($response, 400);
        }
    }
    public function getEmployeelist(){
        $employee=employee::get();
        if (count($employee)>0) {
            $response = [
                "status_code" => 200,
                "data" => $employee,
                "message" => "Retrived Success"
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                "status_code" => 400,
                "data" => null,
                "message" => "Records Not Found"
            ];
            return response()->json($response, 400);
        }
    }
    public function storePin(Request $request){
        $input = $request->all();
        $user_id = isset($input['user_id']) ? $input['user_id'] : '';
        $mobile = isset($input['mobile']) ? $input['mobile'] : '';
        $pin_number = isset($input['pin_number']) ? $input['pin_number'] : '';
        $user =user::where('id',$user_id)->where('mobile',$mobile)->first();
        if($user->pin_status ==0){
            $otp_num=rand(1000,9000);
            $url = "http://reseller.alphasoftz.info/api/sendsms.php?user=jewelb&apikey=msMXhFsa1vmyvPHhRIUn&mobile=$mobile&message=Dear%20Sir%20/%20Madam,%20Your%20OTP%20for%20Jewel%20Bazar%20app%20is%20$otp_num%20-%20Jewel%20Bazar&senderid=JEWBZR&type=txt&tid=1507166072307133996";
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        $data = curl_exec($curl);
                        curl_close($curl);
                        $user->pin_number=$pin_number;
                        $user->pin_status=1;
                        $user->otp=$otp_num;
             if($user->save()){
            $response = [
                "status_code" => 200,
                "data" => $otp_num,
                "message" => "Pin number Stored SuccessFully!"
            ];
            return response()->json($response, 200);

        }else{
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "Not Stored Pin Number"
            ];
            return response()->json($response, 401);

        }
        }else{
            $response = [
                "status_code" => 401,
                "data" => null,
                "message" => "I already used Pin Number"
            ];
            return response()->json($response, 401);
        }



        
    }

    public function VerifyPin(Request $request){
        $input = $request->all();
        $user_id = isset($input['user_id']) ? $input['user_id'] : '';
        // $mobile = isset($input['mobile']) ? $input['mobile'] : '';
        $pin_number = isset($input['pin_number']) ? $input['pin_number'] : '';
        $user =user::where('id',$user_id)->first();
        $check_pin = $user->pin_number;
        
        if($pin_number == $check_pin){
            $response = [
                "status_code" => 200,
                "data" => true,
                "message" => "Pin number Verified SuccessFully!"
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                "status_code" => 401,
                "data" => false,
                "message" => "Pin Number Wrong"
            ];
            return response()->json($response, 401);
        }
        
    }
    public function changePin(Request $request){
        $input = $request->all();
        $user_id = isset($input['user_id']) ? $input['user_id'] : '';
        $mobile = isset($input['mobile']) ? $input['mobile'] : '';
        $pin_number = isset($input['pin_number']) ? $input['pin_number'] : '';
        $user =user::where('id',$user_id)->first();
        
        $check_pin = $user->pin_number;
        
        if($pin_number == $check_pin){
            $response = [
                "status_code" => 401,
                "data" => false,
                "message" => " Already Used Pin number!"
            ];
            return response()->json($response, 401);

        }else{
            
            $otp_num=rand(1000,9000);
            $url = "http://reseller.alphasoftz.info/api/sendsms.php?user=jewelb&apikey=msMXhFsa1vmyvPHhRIUn&mobile=$mobile&message=Dear%20Sir%20/%20Madam,%20Your%20OTP%20for%20Jewel%20Bazar%20app%20is%20$otp_num%20-%20Jewel%20Bazar&senderid=JEWBZR&type=txt&tid=1507166072307133996";
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        $data = curl_exec($curl);
                        curl_close($curl);
                        $user->pin_number=$pin_number;
                        $user->pin_status=1;
                        $user->otp=$otp_num;
             if($user->save()){
            $response = [
                "status_code" => 200,
                "data" => $otp_num,
                "message" => "Pin number Stored SuccessFully!"
            ];
            return response()->json($response, 200);

        }else{
            $response = [
                "status_code" => 401,
                "data" => false,
                "message" => "Not Stored Pin Number"
            ];
            return response()->json($response, 401);

        }
        }
        
    }
    
}
