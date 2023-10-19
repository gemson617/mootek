<?php

namespace App\Http\Controllers;

use App\Models\tax;
use App\Models\Role;
use App\Models\User;


use App\Models\company;
use App\Models\product;
use App\Models\purchase;
use App\Models\Bank_master;
use Illuminate\Http\Request;
use App\Models\purchase_mode;

use App\Models\payment_status;
use App\Models\import_purchase;
use App\Models\master_purchase;
use App\Models\payment_history;
use Illuminate\Support\Facades\Auth;
use App\Models\master_import_purchase;


class add_importpurchasebillcontroller extends Controller
{
    public function index(Request $request){
    
        // $p_data =purchase_temp::all();
        $product =product::all();
        $import_purchase=import_purchase::get();
        $purchase_executive =User::get();
        $purchase_role =Role::get();
        $tax=tax::get();
         return view('importpurchase.addpurchase',compact('tax','purchase_executive','purchase_role','product','import_purchase'));
      }
      
      public function store(Request $request){
        $input = $request->all();
        // dd($input);
        unset($input['_token']);
        unset($input['product']);
        unset($input['model']);
        // unset($input['serial']);
        unset($input['qty']);
        $input['created_at']=now();
        $input['updated_at']=now();
       
      $master =  master_import_purchase::create($input);
      $lastID =$master->id;
      $company=company::find(Auth::user()->companyID)->first();
      $purchase_prefix=$company->purchase_prefix;
       if($master){
        foreach($request->product as $key =>$val){
            purchase::create([
                'purchase_id'=>$lastID,
                "product" => $val,
                "model" => $request->model[$key],
                // "serial" => $request->serial[$key],
                "qty" => $request->qty[$key],
                'status'=>'2'//import
            ]);
        }
        $update=master_import_purchase::find($lastID)->first();
        $update->invoiceID=$purchase_prefix.$lastID;
        $update->save();
        return redirect()->route('importpurchase.view')->with('msg', 'Import Purchase Added Successfully!');

       }
      
      }
      

      public function view(){
        $datatable=master_import_purchase::select('master_import_purchase.*','import_purchase.purchase_company','import_purchase.created_at as purchaseDate')
        ->leftjoin('import_purchase','import_purchase.id','=','master_import_purchase.import_purchase')
        ->get();
        // dd($datatable);
        return view('importpurchase.viewpurchase',compact('datatable'));
      }


    //   add.purchase
    // public function payment($id){
    //   // dd($id);
    //   $data=master_import_purchase::select('master_import_purchase.*','import_purchase.purchase_company')
    //   ->leftjoin('import_purchase','import_purchase.id','=','master_import_purchase.import_purchase')
    //   ->where('master_import_purchase.id',$id)
    //   ->first();
    //   $payment_status =payment_status::where('status',1)->get();
    //   $bank =Bank_master::where('status',1)->get();
    //   $purchase_mode =purchase_mode::where('status',1)->get();
    // $payment_histories =payment_history::where('payment_histories.invoiceID',$id)->where('payment_histories.status',2)
    // ->select('payment_histories.*','payment_status.payment_status','purchase_mode.purchase_mode')
    // ->leftjoin('payment_status','payment_status.id','payment_histories.purchase_status')
    // ->leftjoin('purchase_mode','purchase_mode.id','payment_histories.purchase_type')
    // ->get();
    //   return view('importpurchase.payment',compact('data','payment_status','bank','purchase_mode','payment_histories'));
    // }
    // public function payment_update(Request $request){
    //   $input = $request->all();
    //   unset($input['_token']);
    //   $input['status']=2;
    //   $status =  master_purchase::where('id',$input['invoiceID'])->first();
      
    //   $input['balance']  =$status->balance-$input['collected'];
       
    //   $payment = payment_history::create($input);
    //   if($input['balance'] ==0){
    //     $payment_status=1;
    //    }else{
    //     $payment_status=0;
    //    }
    //   if($payment){
    //     $update =  master_purchase::where('id',$input['invoiceID'])->first();
    //     $update->balance=$input['balance'];
    //     $update->paid=$input['collected'];
    //     $update->payment_status=$payment_status;
    //     $update->save();
    //   }
       
    //   // dd($data);
    //   return redirect()->back()->with('msg', 'Purchase Added Successfully!');

    // }
    
    public function edit($id){
      $product =product::all();
      $import_purchase=import_purchase::get();
      $purchase_executive =User::get();
      $purchase_role =Role::get();
      $tax=tax::get();
      $import=master_import_purchase::select('master_import_purchase.*','import_purchase.purchase_company')
      ->leftjoin('import_purchase','import_purchase.id','=','master_import_purchase.import_purchase')
      ->where('master_import_purchase.id',$id)
      ->first();
    $products =purchase::select('purchases.*','purchases.id as p_id','products.product_name','master_import_purchase.*')
   ->leftjoin('master_import_purchase','master_import_purchase.id','purchases.purchase_id')
   ->leftjoin('products','products.id','=','purchases.product')
   ->where('master_import_purchase.id',$id)
    ->where('purchases.status',2)
   ->get();
     
      return view('importpurchase.editpurchase',compact('import','products','tax','purchase_executive','purchase_role','product','import_purchase'));
    }
    public function update(Request $request){
        $master = master_import_purchase::find($request->master_id)->first();
       
      $master->import_purchase=$request->import_purchase;
      $master->reference_no=$request->reference_no;
      $master->usd=$request->usd;
      $master->inr=$request-> inr;
      $master->amount=$request->amount;
      $master->bank_fees=$request->bank_fees;
      $master->awb_no=$request-> awb_no;
      $master->igst_amount=$request->igst_amount;
      $master->bob_number=$request->bob_number;
      $master->slip_no=$request-> slip_no;
      $master->mode=$request->mode;
      $master->do_charges_bill=$request->do_charges_bill;
      $master->do_charges_weight=$request->do_charges_weight;
      $master->do_charges_amount=$request->do_charges_amount;
      $master->custom_com_bill=$request->custom_com_bill;
      $master->custom_com_weight=$request-> custom_com_weight;
      $master->custom_com_amount=$request->custom_com_amount;
      $master->cfs_charges_bill=$request->cfs_charges_bill;
      $master->cfs_charges_weight=$request-> cfs_charges_weight;
      $master->cfs_charges_amount=$request-> cfs_charges_amount;
      $master->transport_c_bill=$request->transport_c_bill;
      $master->transport_c_weight=$request->transport_c_weight;
      $master->transport_c_amount=$request->transport_c_amount;
      $master->others_charges=$request->others_charges;
      $master->agent_charges=$request->agent_charges;
      $master->claim_details=$request->claim_details;
      $master->supplier_name=$request->supplier_name;
      $master->hawb_number=$request->hawb_number;
      $master->pickup_date=$request->pickup_date;
      $master->delivery_date=$request-> delivery_date;
      $master->no_of_days=$request->no_of_days;
      $master->date=$request->date;
      $master->purchase_executive=$request-> purchase_executive;
      $master->purchase_role=$request->purchase_role;
        if($master->save()){
          if(isset($request->product)){
            foreach($request->product as $key=>$val){
              if(isset($request->id[$key])){
               $update = purchase::find($request->id[$key])->where('status',2)->first();
              $update->product= $request->product[$key];
              $update->model= $request->model[$key];
              // $update->serial= $request->serial[$key];
              $update->qty= $request->qty[$key];
             //  $update->rate= $request->rate[$key];
             //  $update->amount= $request->amount[$key];
              $update->save();
              }else{
               purchase::create([
                 'purchase_id'=>$request->master_id,
                 "product" => $val,
                 "model" => $request->model[$key],
                //  "serial" => $request->serial[$key],
                 "qty" => $request->qty[$key],
                 // "rate" => $request->rate[$key],
                 // "amount" => $request->amount[$key],
                 'status'=>2
               ]);
              }
             }
          }
         
        }
        if(isset($request->removeid)){
          foreach($request->removeid as $val){
          purchase::find($val)->where('status',2)->delete();
          }
        }
        return redirect()->route('importpurchase.view')->with('msg', 'Import Purchase Updated Successfully!');;

    }
    public function stocks(){
      $products =purchase::select('purchases.*','purchases.id as p_id','products.product_name','master_import_purchase.*','companies.company as bCompany','rack_location.rack_location','import_purchase.purchase_company')
      ->leftjoin('master_import_purchase','master_import_purchase.id','purchases.purchase_id')
      ->leftjoin('products','products.id','=','purchases.product')
      ->leftjoin('import_purchase','import_purchase.id','=','master_import_purchase.import_purchase')
      ->leftjoin('companies','companies.id','=','purchases.company_id')
      ->leftjoin('rack_location','rack_location.id','=','purchases.rack_location')
       ->where('purchases.status',2)
      ->get();

      // dd($products);

      return view('importpurchase.stocks',compact('products'));

    }
}
