<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
//use Illuminate\Support\Facades\Mail;
//use Illuminate\Support\Facades\Hash;
use Hash;
use Session;
use DB;
use Mail;
use Response;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function submitForgotPasswordForm(Request $request){

        $request->validate([
                'email'=>'required|email|exists:users,email'
        ]);

        $token = \Str::random(64);

        \DB::table('password_resets')->insert([
         'email'=>$request->input('email'),
         'token'=>$token,
         'created_at'=>Carbon::now()
        ]);

        $action_link = route('reset.password.get',['token'=>$token, 'email'=>$request->input('email')]);

        $body = "We are in receipt of your password reset request for Agas National application. You can reset your password by clicking the link below ";

        //\Mail::send('email.forgot.password', ['action_link'=>$action_link, 'body'=>$body], funtion($message) use($request) {

       // });

       \Mail::send('auth.passwords.forgotpasswordmail',['action_link'=>$action_link, 'body'=>$body], function($message) use($request){
        $message->from('noreply@example.com','Agas National');
        $message->to($request->input('email'));
        $message->subject('Reset Password');

    });

       return back()->with('message', 'we have sent you reset password link');



   }

   public function showResetPasswordForm(Request $request, $token=null){
    return view('auth.passwords.reset')->with(['token'=>$token, 'email'=>$request->input('email') ]);
}

public function submitResetPasswordForm(Request $request, $token=null ){
    $request->validate([
        'email'=>'required|email|exists:users,email',
        'password'=>'required|min:6|confirmed',
        'password_confirmation'=>'required',
    ]);

    //$check_token = \DB::table('password_resets')
    //->where('token', $token)
    //->where('email', $request->input('email'))->first();
    $email =$request->input('email');
    $tokenData = DB::table('password_resets')->select('token', 'token')
    ->where('email', $request->input('email'))->first();
    if(!$tokenData){
        return back()->withInput()->with('fail', 'Invalid token');
    }else{
    $user = User::where('email', $request->input('email'))->first();
    if(!$user){
        return back()->withInput()->with('fail', 'Invalid Email');
    }else {
        User::where('email', $request->input('email'))
        ->update([
            'password'=>\Hash::make($request->input('password'))
        ]);
        \DB::table('password_resets')->where([
            'email'=>$request->input('email')
        ])->delete();

        return redirect()->route('login')->with('message', ' Your password has been changed, You can Login here.');
    }
}
}
    //use SendsPasswordResetEmails;
}
