<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Commoncontroller extends Controller
{
    public function get_state(Request $request)
    {
        $country = $request->country_id;
        $result = DB::table('states')->where('country_id',$country )->where('flag',1)->orderBy('name','asc')->get();        
        echo json_encode($result);
    }
    public function get_city(Request $request)
    {
        $state =  $request->state_id;
        // print_r($state);
        $result = DB::table('cities')->where('state_id',$state )->where('flag',1)->orderBy('id','asc')->get();        
        echo json_encode($result);
    }
    // public function get_salution(Request $request)
    // {
    //     $state =  $request->state_id;
    //     // print_r($state);
    //     $result = DB::table('cities')->where('state_id',$state )->where('flag',1)->orderBy('id','asc')->get();        
    //     echo json_encode($result);
    // }
    public function privacy(){
        return view('privacy');
    }
    public function check_exit(Request $request){
        $model = 'App\\Models\\' . $request->table;
       $already  = $model::where($request->column,$request->name)->where('id',$request->id)->exists();
       if($already){
        return response()->json($already);
       }else{
        $exists= $model::where($request->column,$request->name)->exists();
        return response()->json(!$exists);
       }
        
    }

    public function get_products(Request $request){
        if($request->id =='1'){
            $products=purchase::where('status',$request->id)->select('purchases.*','products.product_name')
            ->leftjoin('products','products.id','=','purchases.product')
            ->get();
           return response()->json(['success' => '1','status'=>1,'data'=>$products]);

        }else if($request->id =='2'){
            $products=purchase::where('status',$request->id)->select('purchases.*','products.product_name')
            ->leftjoin('products','products.id','=','purchases.product')
            ->get();
           return response()->json(['success' => '1','status'=>2,'data'=>$products]);
        }

        }
    
}
