<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Validator;
use Hash;

class ApiCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        $customers = Customer::get(['id','email']);
        return [
            "status" => 1,
            "data" => $customers
        ];
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   /* public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);


    }*/

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    /*public function show(Customer $customer)
    {
        return [
            "status" => 1,
            "data" =>$customer
        ];
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    /*public function edit(Customer $customer)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

       /* $customer->update($request->all());

        return [
            "status" => 1,
            "data" => $customer,
            "msg" => "Blog updated successfully"
        ];
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        /*$customer->delete();
        return [
            "status" => 1,
            "data" => $customer,
            "msg" => "Blog deleted successfully"
        ];*/
    }

    public function login(Request $request)
    {



        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where(['email' => $request->email, 'password' => Hash::make( $request->password)]);
        $user_n = User::where(['user_name' => $request->email, 'password' => Hash::make( $request->password)]);
        // dd($user);
        if($user || $user_n)
        {
            return response([
                'message' => 'Login Success!'
            ]);
        }
        else
        {
            return response([
                'message' => 'Invalid credentials'
            ]);
        }


    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
    }
}
