<?php

namespace App\Http\Controllers;

use App\Models\tax;
use App\Models\Role;


use App\Models\User;
use App\Models\company;
use App\Models\product;
use App\Models\purchase;
use App\Models\Bank_master;
use App\Models\branch;
use Illuminate\Http\Request;
use App\Models\purchase_mode;

use App\Models\local_purchase;
use App\Models\payment_status;
use App\Models\master_purchase;
use App\Models\payment_history;
use App\Models\Rack_location;
use Illuminate\Support\Facades\Auth;



class add_purchasebillcontroller extends Controller
{
    public function index(Request $request){
    
        // $p_data =purchase_temp::all();
        $product =product::all();
        $local_purchase=local_purchase::orderBy('purchase_company','asc')->get();
        $purchase_executive =User::get();
        $purchase_role =Role::get();
        $tax=tax::get();
         return view('purchase.addpurchase',compact('tax','purchase_executive','purchase_role','product','local_purchase'));
      }
      
      public function store(Request $request){
          $master =  master_purchase::create([
            "companyID"=>Auth::user()->companyID,
            "local_purchase" =>$request->local_purchase,
            "invoice_no" => $request->invoice_no,
            "purchaseDate" => $request->purchaseDate,
            "purchase_executive" =>$request->purchase_executive,
            "purchase_role" => $request->purchase_role,
            "tax_amount_value" => $request->tax_amount_value,
            "tax_price" => $request->tax_price,
            "others" =>$request->others,
            "cess" => $request->cess,
            "tax_percent" => $request->tax_percent,
            "grand_total" => $request->grand_total,
            "balance" => $request->grand_total,
            "paid" =>0,
            "created_by"=>Auth::user()->id,
          ]);
          $lastID=$master->id;
            $company=company::find(Auth::user()->companyID)->first();
            $purchase_prefix=$company->purchase_prefix;
          if($master){
            foreach($request->product as $key =>$val){
                purchase::create([
                    'purchase_id'=>$lastID,
                    "product" => $val,
                    "model" => $request->model[$key],
                    "serial" => $request->serial[$key],
                    "qty" => $request->qty[$key],
                    "rate" => $request->rate[$key],
                    "amount" => $request->amount[$key],
                    'status'=>'1'//local
                ]);
            }
            $update=master_purchase::find($lastID)->first();
            $update->invoiceID=$purchase_prefix.$lastID;
            $update->save();
          return redirect()->route('localpurchase.view')->with('msg',' Purchase Added Successfully');
          }

      }
      
      public function view(){
        $datatable=master_purchase::select('master_purchase.*','local_purchase.purchase_company')
        ->leftjoin('local_purchase','local_purchase.id','=','master_purchase.local_purchase')
        ->get();
        // dd($datatable);
        return view('purchase.viewpurchase',compact('datatable'));
      }
    //   add.purchase
    public function payment($id){
      // dd($id);
      $data=master_purchase::select('master_purchase.*','local_purchase.purchase_company')
      ->leftjoin('local_purchase','local_purchase.id','=','master_purchase.local_purchase')
      ->where('master_purchase.id',$id)
      ->first();
      $payment_status =payment_status::where('status',1)->get();
      $bank =Bank_master::where('status',1)->get();
      $purchase_mode =purchase_mode::where('status',1)->get();
    $payment_histories =payment_history::where('payment_histories.invoiceID',$id)->where('payment_histories.status',1)
    ->select('payment_histories.*','payment_status.payment_status','purchase_mode.purchase_mode')
    ->leftjoin('payment_status','payment_status.id','payment_histories.purchase_status')
    ->leftjoin('purchase_mode','purchase_mode.id','payment_histories.purchase_type')
    ->get();
      return view('purchase.payment',compact('data','payment_status','bank','purchase_mode','payment_histories'));
    }
    public function payment_update(Request $request){
      $input = $request->all();
      unset($input['_token']);
      $input['status']=1;
      $status =  master_purchase::where('id',$input['invoiceID'])->first();
      
      $input['balance']  =$status->balance-$input['collected'];
       
      $payment = payment_history::create($input);
      if($input['balance'] ==0){
        $payment_status=1;
       }else{
        $payment_status=0;
       }
      if($payment){
        $update =  master_purchase::where('id',$input['invoiceID'])->first();
        $update->balance=$input['balance'];
        $update->paid=$input['collected'];
        $update->payment_status=$payment_status;
        $update->save();
      }
       
      // dd($data);
      return redirect()->back()->with('msg', 'Purchase Added Successfully!');

    }
    
    public function edit($id){
      $product =product::all();
      $local_purchase=local_purchase::get();
      $purchase_executive =User::get();
      $purchase_role =Role::get();
      $tax=tax::get();
      $local=master_purchase::select('master_purchase.*','local_purchase.purchase_company')
      ->leftjoin('local_purchase','local_purchase.id','=','master_purchase.local_purchase')
      ->first();
    $products =purchase::select('purchases.*','purchases.id as p_id','products.product_name','master_purchase.*')
   ->leftjoin('master_purchase','master_purchase.id','purchases.purchase_id')
   ->leftjoin('products','products.id','=','purchases.product')
   ->where('master_purchase.id',$id)
   ->where('purchases.status',1)
   ->get();
     
      return view('purchase.editpurchase',compact('local','products','tax','purchase_executive','purchase_role','product','local_purchase'));
    }
    public function update(Request $request){
        $master = master_purchase::find($request->master_id)->first();
        $master->local_purchase =$request->local_purchase;
        $master->purchaseDate=$request->purchaseDate;
        $master->purchase_executive=$request->purchase_executive;
        $master->purchase_role=$request->purchase_role;
        $master->tax_amount_value=$request->tax_amount_value;
        $master->tax_price=$request->tax_price;
        $master->others=$request->others;
        $master->cess=$request->cess;
        $master->tax_percent=$request->tax_percent;
        $master->grand_total=$request->grand_total;
      $master->balance= $request->grand_total;
      $master->paid=0;
        if($master->save()){
          if(isset($request->product)){
            foreach($request->product as $key=>$val){
              if(isset($request->id[$key])){
               $update = purchase::find($request->id[$key])->where('status',1)->first();
              $update->product= $request->product[$key];
              $update->model= $request->model[$key];
              $update->serial= $request->serial[$key];
              $update->qty= $request->qty[$key];
              $update->rate= $request->rate[$key];
              $update->amount= $request->amount[$key];
              $update->save();
              }else{
               purchase::create([
                 'purchase_id'=>$request->master_id,
                 "product" => $val,
                 "model" => $request->model[$key],
                 "serial" => $request->serial[$key],
                 "qty" => $request->qty[$key],
                 "rate" => $request->rate[$key],
                 "amount" => $request->amount[$key],
                 'status'=>1,
               ]);
              }
             }
          }
        }
        if(isset($request->removeid)){
          foreach($request->removeid as $val){
          purchase::find($val)->delete();
          }
        }
        return redirect()->route('localpurchase.view')->with('msg', 'Purchase Updated Successfully!');

    }
    public function stocks(){
      $products =purchase::select('purchases.*','purchases.id as p_id','products.product_name','master_purchase.*','local_purchase.purchase_company','companies.company as bCompany','rack_location.rack_location')
      ->leftjoin('master_purchase','master_purchase.id','=','purchases.purchase_id')
      ->leftjoin('local_purchase','local_purchase.id','=','master_purchase.local_purchase')
      ->leftjoin('products','products.id','=','purchases.product')
      ->leftjoin('companies','companies.id','=','purchases.company_id')
      ->leftjoin('rack_location','rack_location.id','=','purchases.rack_location')
      ->where('purchases.status',1)
      ->get();
      return view('purchase.stocks',compact('products'));
        
    }

    public function get_branchAndRack(request $request){
      $company = company::orderBy('id', 'DESC')->get();
      $rack = Rack_location::orderBy('id', 'DESC')->get();
      // dd($rack);

      $result = [
        'company' => $company,
        'rack' => $rack,
    ];

    return response()->json(['msg' => 'false','data'=>$result]);
    
      // echo json_encode($result);
    }


    public function addBranchAndLocation(request $request){
      $input = $request->all();
     
      $check = purchase::where('id',$input['id'])->select('status')->first();
      purchase::where('id',$input['id'])->update(['company_id'=>$input['company'],'rack_location'=>$input['rack'],'locationStatus'=>1]);

      if($check->status == 1)
      {
            return redirect()->route('localpurchase.stocks')->with('msg', 'Purchase Updated Successfully!');
      }
        else
      {
        return redirect()->route('importpurchase.stocks')->with('msg', 'Purchase Updated Successfully!');      
      }
        }

    
    public function print($id){
     
      $local=master_purchase::select('master_purchase.*','local_purchase.*','states.state_name','cities.city_name')
      ->leftjoin('local_purchase','local_purchase.id','=','master_purchase.local_purchase')
      ->leftjoin('states','states.id','=','local_purchase.state')
      ->leftjoin('cities','cities.id','=','local_purchase.city')
      ->first();
      $products =purchase::select('purchases.*','purchases.id as p_id','products.product_name','master_purchase.*')
      ->leftjoin('master_purchase','master_purchase.id','=','purchases.purchase_id')
      ->leftjoin('products','products.id','=','purchases.product')
      ->where('purchases.status',1)
      ->where('purchases.purchase_id',$id)

      ->get();
      $company=company::first();
// dd($local);
      return view('purchase.print',compact('products','local','company'));
        
    }
    
}
