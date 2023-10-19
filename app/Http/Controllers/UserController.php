<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\company;


use App\Models\employee;
use App\Models\Designation;
use App\Models\user_profile;
use Illuminate\Http\Request;
use App\Http\Traits\LeadLogTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use LeadLogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    { 
        if(Auth::user()->role =='3'){
            $viewdata['datatable'] = User::leftjoin('designation_master','designation_master.id','=','users.designation')->whereIn('role',[1,3])->orderBy('users.id','desc')->where('companyID',Auth::user()->companyID)->get();
            $viewdata['company'] = Company::all();
            $viewdata['designation']= Designation::where('status','0')->get();
            
            return view('user.user', $viewdata);
        }else{
                //  return redirect('home')->back()->with('msg', 'Cannot Access page!');
                 return redirect()->route('home')->with('msg', 'Cannot Access page!');
        }

    }
    public function company(Request $request)
    {

        $update = company::where('id',$request->id)->first();
        if($update){
            $update->status=1;
            $update->save();
            DB::Select("update companies set status=0 WHERE id  NOT IN($request->id)");
            $id = user::where('role','3')->get();
            foreach($id as $val){
                $val->companyID =$request->id;
                $val->save();
            }
        }  
        return redirect()->back()->with('msg', 'Company Updated Successfully!');


    }

    public function add(Request $request)
    {
        // dd($request->role);
        $request->validate([
            'username' => 'required|unique:users,user_name',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'designation' => 'required',
            // 'company'=>'required',

        ]);
        //  dd($request->all());
        //  dd(Auth::user()->companyID);
        $company=Auth::user()->companyID;
        $data =  User::create(
            [
                'first_name' =>$request->username,
                'user_name' => $request->username,
                'companyID'=>$company,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'designation' => $request->designation,
                'role' => $request->role == 3 ? $request->role: '1',
                'status' => 1,
            ]
        );
        if ($data) {
            return redirect()->back()->with('msg', ' User Added Successfully!');
        }
    }
    public function change_password(Request $request)
    {


        $data =  User::find($request->id)->update(
            [
                'password' => Hash::make($request->new_password),
            ]
        );
        if ($data) {
            return redirect()->back()->with('msg', ' User password updated Successfully!');
        }
    }
    public function profile()
    {

        $viewdata['user'] = user_profile::where('user_id', Auth::user()->id)->first();
        return view('profile.index', $viewdata);
    }
    public function upload_image(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $imageName = time() . '.' . $request->image->extension();
        // dd(env('APP_URL')/profile.$imageName);
        $image = URL::to('/') . '/profile/' . $imageName;
        // Public Folder
        $request->image->move(public_path('profile'), $imageName);
        $user_profile = user_profile::where('user_id', Auth::user()->id)->first();
        if ($user_profile) {
            $user_profile->image = $image;
            $user_profile->save();
        } else {
            $profile = new user_profile;
            $profile->image = $image;
            $profile->user_id = Auth::user()->id;
            $profile->save();
        }
        return response()->json(['success' => '1', 'image' => $image]);
    }



    public function add_profile(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'city' => 'required',
            'postal' => 'required',
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        if ($user != '') {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->user_name = $request->username;
            $user->mobile = $request->mobile;
            $user->save();

            $profile = user_profile::where('user_id', Auth::user()->id)->first();

            if ($profile == null) {
                user_profile::create([
                    'user_id' => Auth::user()->id,
                    'address' => $request->address,
                    'city' => $request->city,
                    'pincode' => $request->postal
                ]);
            } else {
                $profile->address = $request->address;
                $profile->city = $request->city;
                $profile->pincode = $request->postal;
                $profile->save();
            }
            if(Auth::user()->role ==2){
               $emp =  employee::where('user_id',Auth::user()->id)->first();
               $emp->name = $request->first_name;
            //    $emp->username = $request->username;
               $emp->phone_number =  $request->mobile;
               $emp->present_address=$request->address;
               $emp->save();
            }
            return redirect()->back()->with('msg', ' User Profile updated Successfully!');
        }
    }
}
