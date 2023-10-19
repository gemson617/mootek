<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;


use App\Models\time_management;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout(Request $request)
    {

        $last = time_management::where('user_id', Auth::user()->id)->latest('login_time')->first();
        $now = DB::raw('CURRENT_TIMESTAMP');

        if ($last) {
            time_management::find($last->id)->update([
                'logout_time' => $now,
            ]);
        }

        return redirect('login')->with(Auth::logout());
    }
    protected function credentials(Request $request)
    {
        $input = $request->all();
        // dd($input);
        // $this->validate($request, [
        //      'g-recaptcha-response' => ['required', new ReCaptcha]
        // ]);
        //dd(request()->email);
        $data = User::where('office_email', request()->email)->first();

        if ($data) {
            $now = DB::raw('CURRENT_TIMESTAMP');
            time_management::create([
                'login_time' => $now,
                'user_id' => $data->id,
            ]);
        }
        if ($data) {
            return [
                'office_email' => request()->email,
                'password' => request()->password,
                'status' => 1
                ];
        } else {
            return [
                'office_email' => request()->email,
                'password' => request()->password,
                'status' => 1
            ];
        }
    }
}
