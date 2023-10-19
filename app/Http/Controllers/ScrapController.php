<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\scrap;
use App\Models\company;
use App\Models\Payment;
use App\Models\employee;
use App\Models\purchase;
use App\Models\supplier;
use Illuminate\Http\Request;
use App\Models\manual_product;
use App\Models\scrap_products;
use App\Http\Traits\LeadLogTrait;
use Illuminate\Support\Facades\Auth;

class ScrapController extends Controller
{
    use LeadLogTrait;

    public function index(Request $request)
    {
        //company
        // $company  = company::->get();
        //product
        // $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price')->where('active', '1')->where('stock', '1')->where('type', '0')->get();
        $vendor = supplier::where('mgt_status', 2)->where('companyID',Auth::user()->companyID)->get();
        $payment = Payment::get();
        // dd(Auth::user()->companyID);
        // $manual_products = manual_product::all();
        if(Auth::user()->role_id =='3' || $this->role_check(47)){
            return view('scrap.index', compact('vendor','payment'));
          }else{
            $msg='Cannot Access Page !';
             return redirect()->back()->with('msg', $msg);
          }
    }

    public function final(Request $request)
    {
        $insert = scrap::create([
            'user_id' => Auth::user()->id,
            'companyID' => Auth::user()->companyID,
            'vendor' => $request->vendor,
            'date' => $request->date,
            'reference' => $request->reference,
            'price' => $request->price,
            'payment'=>$request->payment,
        ]);
        if ($insert) {
            foreach ($request->product as $key => $val) {
                scrap_products::create([
                    'scrap_id' => $insert->id,
                    'product' => $request->product[$key],
                    'qty' => $request->qty[$key]
                ]);
            }
            return redirect()->back()->with('msg', 'Scrap  Sent Successfully!');
        }
    }

    public function viewscrap(){
        $all = scrap::select('scraps.*','suppliers.supplier_name','payment_mode.payment_mode')
        ->where('scraps.companyID',Auth::user()->companyID)
        ->leftjoin('payment_mode','payment_mode.id','=','scraps.payment')
        ->leftjoin('suppliers','scraps.vendor','=','suppliers.id')
        ->orderBy('scraps.id', 'DESC')
        ->get();
         if(Auth::user()->role_id =='3' || $this->role_check(39)){
       
             return view('scrap.view', compact('all'));     
          }else{
            $msg='Cannot Access Page !';
             return redirect()->back()->with('msg', $msg);
          }

    }
    public function viewscraplist($id){
        $all = scrap_products::where('scrap_id',$id)->get();
        $vendor = scrap::where('scraps.id',$id)->leftjoin('suppliers','scraps.vendor','=','suppliers.id')->first();

      if (Auth::user()->role_id == '3' || $this->role_check(46)) {
                return view('scrap.viewlist', compact('all','vendor')); 
      } else {
         $msg = 'Cannot Access Page !';
         return redirect()->back()->with('msg', $msg);
      }
    }

    public function scrap_edit($id){
        $all = scrap_products::where('scrap_id',$id)->get();
        $vendor = scrap::where('scraps.id',$id)->leftjoin('suppliers','scraps.vendor','=','suppliers.id')
        ->first();
        $vendors = supplier::where('mgt_status', 2)->get();
        $payment = Payment::get();
        
        $sid=$id;
        return view('scrap.scrap_edit', compact('all','vendor','vendors','sid','payment'));
    }
    public function update(Request $request){
         
            $vendor = scrap::where('id',$request->master_id)->first();
            $vendor->date=$request->date;
            $vendor->reference=$request->reference;
            $vendor->price=$request->price;
            $vendor->payment=$request->payment;
            $vendor->save();
         $count = count($request->product_id);
         for ($i = 0; $i < $count; $i++) {
 
             if ($request->product_id[$i] != null) {
 
                 $product = scrap_products::find($request->product_id[$i]);
                 // dd($request->product_id[$i]);
                 $product->product  =$request->product[$i];
                 $product->qty  = $request->qty[$i];
                 $product->created_by  = Auth::user()->id;
                 $product->save();
             } else {
                 $product = new scrap_products;
                 $product->scrap_id = $request->master_id;
                 $product->product  =$request->product[$i];
                 $product->qty  = $request->qty[$i];
                 $product->created_by  = Auth::user()->id;
                 $product->save();
             }
          
         }
         if ($request->removeid != null) {
            $r_id = count($request->removeid);
            for ($i = 0; $i < $r_id; $i++) {
                $purchase = scrap_products::find($request->removeid[$i])->delete();
            }
        }
        return redirect()->back()->with('msg', 'Scrap  Update Successfully!');

    }
    public function delete(Request $request){
    //   dd($request->id); 
      scrap::where('id',$request->id)->delete();
      scrap_products::where('scrap_id',$request->id)->delete();
      return redirect()->back()->with('msg', 'Scrap  deleted Successfully!');

         
    } 
}
