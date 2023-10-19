<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\brand;
use App\Models\terms;
use App\Models\company;
use App\Models\Payment;
use App\Models\product;
use App\Models\category;
use App\Models\purchase;

use App\Models\supplier;


use Illuminate\Http\Request;

use App\Models\manual_product;
use App\Models\master_purchase;
use App\Models\payment_history;
use App\Http\Traits\LeadLogTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;



class add_puchaseController extends Controller
{

  use LeadLogTrait;
    public function purchase_view(){
      $companyID = $this->getcompany();
      $dataa =purchase::all();

      $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'purchaseDate')->select('categoryID', 'brandID', 'productID', 'purchaseDate', 'id')->where('active', '1')->where('sale', '0')->where('rental', '0')->get();

      $data = DB::table('purchases')
            ->leftJoin('products', 'purchases.productID', '=', 'products.id')
            ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
            ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id')
            ->leftJoin('suppliers', 'purchases.supplierID', '=', 'suppliers.id')
            ->groupBy('purchases.categoryID', 'purchases.brandID', 'purchases.productID', 'purchases.purchaseDate', 'purchases.supplierID', 'purchases.purchase_price', 'purchases.selling_price')
            ->where('suppliers.mgt_status', '1')
            // ->where('purchases.companyID', $companyID)
            ->where('purchases.active', '1')
            ->where('purchases.stock','1')->where('purchases.type','0')
            ->select('purchases.*', 'purchases.id AS p_id','categories.*', 'products.*', 'brands.*', 'suppliers.*', DB::raw('count(*) as total'))
            ->orderBy('purchases.id', 'DESC', )->get();// joining the purchases tabe
         

            $datsss = DB::table('master_purchase')
            ->leftJoin('suppliers', 'master_purchase.supplierID', '=', 'suppliers.id')
            ->leftJoin('purchases', 'master_purchase.po_no', '=', 'purchases.po_no')
            // ->where('master_purchase.companyID', $companyID)
            ->groupBy('master_purchase.po_no','master_purchase.companyID')
            ->select('master_purchase.*', 'master_purchase.id AS mp_id', 'suppliers.*',  DB::raw("count(purchases.po_no) as count"),DB::raw("SUM(purchases.purchase_price) as purchase_price"))
            ->orderBy('master_purchase.id', 'DESC', )->get();
           
            // dd($datsss);
            if(Auth::user()->role_id =='3' || $this->role_check(25)){
            return view('purchase.viewpurchase', ['data'=>$datsss]);
             }else{
               $msg='Cannot Access Page !';
                return redirect()->back()->with('msg', $msg);
             }
    }

    public function purchase_payment($id){
      // dd($id);
      $datsss = DB::table('master_purchase')
      ->leftJoin('suppliers', 'master_purchase.supplierID', '=', 'suppliers.id')
      ->where('master_purchase.po_no',$id)
      ->select('*')
      ->first();
      $payment_history =payment_history::select('payment_histories.*','payment_mode.payment_mode')->
      leftjoin('payment_mode','payment_mode.id','=','payment_histories.mop')
      ->where('payment_histories.invoiceID',$id)
      ->where('payment_histories.status',1)
      ->get();
      $payment  =Payment::get();
      // dd($payment_history);
      return view('purchase.payment', ['data'=>$datsss,'payment_history'=>$payment_history,'payment'=>$payment]);
    }

    public function purchase_payment_update(Request $request){
      $datsss = DB::table('master_purchase')->where('po_no',$request->invoiceID)->first();
      // dd($request->all());
      $id = payment_history::create([
        'companyID' => Auth::user()->companyID,
        'user_id' => Auth::user()->id,
        'invoiceID' => $request->invoiceID,
        'amount' => $request->amount,
        'collected' => $request->collected,
        'paymentDate' => $request->paymentDate,
        'mop'=>$request->mop,
        'status'=>1 //purchase
    ]);
     if($datsss->total_price ==$request->collected) {
      $datsss= master_purchase::where('po_no',$request->invoiceID)->first();
      // dd($datsss);
      $datsss->payment_status='1';
      $datsss->save();
      $hand = $request->collected;
      $history = payment_history::
      select('payment_histories.*','payment_mode.payment_mode')->
      leftjoin('payment_mode','payment_mode.id','=','payment_histories.mop')->
      where('payment_histories.invoiceID', $request->invoiceID)
      ->first();
      $details = company::where('id', Auth::user()->companyID)->first();
      $supplier= master_purchase::where('po_no',$request->invoiceID)
      ->leftjoin('suppliers','suppliers.id','=','master_purchase.supplierID')
      ->first();
      $pdf = PDF::loadView('purchase.receipt', compact('history', 'hand','details','supplier'));
      $pdf->setPaper('A4', 'portrait');
      $filePath = public_path('receipt/' .$request->invoiceID . '.pdf');
      $pdf->save($filePath);
      $history->invoice_path = URL::to('/') . '/receipt/' .$request->invoiceID. '.pdf';
      $history->save();
      return redirect()->back()->with('msg', 'Payment Updated Successfully!');
     
     }else{
      return redirect()->back()->with('msg', 'Complete Full Payment');
     }

    }
    
    public function serialvalidation(Request $request){
      $data = purchase::where('serial', $request->checkserial)->first();
      if($data != null){
        return response()->json(['msg' => 'false']);
      }else{
        return response()->json(['msg' => 'true']);
      }
    }

    public function purchase_edit(Request $request, $id){

      $data =master_purchase::where('po_no', $id)->first();

      $datas = DB::table('purchases')
      ->leftJoin('products','products.id','=','purchases.productID')
      ->leftJoin('categories', 'categories.id','=','purchases.categoryID' )
      ->leftJoin('brands','brands.id','=', 'purchases.brandID');
      // ->leftJoin('purchases', 'master_purchase.po_no', '=', 'purchases.po_no')
      if($data->type==2){

        $datas=$datas
        ->groupBy('purchases.categoryID', 'purchases.brandID', 'purchases.productID','purchases.purchase_price', 'purchases.selling_price' )
        ->where('purchases.po_no', $id)
        ->where('purchases.active', '1')
       
        ->select('purchases.*','purchases.categoryID AS categoryid', 'purchases.id AS p_id','categories.*', 'products.*',
        'products.gst AS p_gst', 'brands.*', 'categories.*', DB::raw("count(purchases.id) as count") )
        ->get();
      }else{

        $datas=$datas
        ->where('purchases.po_no', $id)
        ->where('purchases.active', '1')
       
        ->select('purchases.*', 'purchases.id AS p_id','categories.*','categories.id as cat_id', 'products.*',
        'products.gst AS p_gst', 'brands.*' )
        ->get();
        
      }
      // dd($datas);
      // $datas = DB::table('purchases')
      //       ->leftJoin('products', 'purchases.productID', '=', 'products.id')
      //       ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
      //       ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id')
      //       ->where('purchases.po_no', $id)
      //       ->select('purchases.*', 'purchases.id AS p_id','categories.*', 'products.*', 'brands.*')
      //       ->get();

      $cdata =category::all();
      $bdata =brand::all();
      $pdata =product::all();
      $company  =company::all();
     $sdata =supplier::where('suppliers.mgt_status', '1')->where('companyID',Auth::user()->companyID)->get();

      //  dd($datas, $id);
      // dd($cdata);
      return view('purchase.editpurchase', ['data'=>$data, 'sdata'=>$sdata, 'datas'=>$datas, 'cdata'=>$cdata, 'bdata'=>$bdata, 'pdata'=>$pdata,'company'=>$company]);
    }

    public function purchase_print(Request $request, $id){

      $companyID = $this->getcompany();

      // dd($companyID);

      $data = DB::table('master_purchase')

      ->leftJoin('suppliers', 'master_purchase.supplierID', '=', 'suppliers.id')
      ->leftJoin('companies', 'master_purchase.companyID', '=', 'companies.id')
      ->where('master_purchase.po_no', $id)
      ->select('master_purchase.*', 'master_purchase.id AS p_id',
      'suppliers.*', 'companies.*',

      'suppliers.id AS s_id',
      'suppliers.address_line1 AS s_address_line1',
      'suppliers.address_line2 AS s_address_line2',
      'suppliers.city AS s_city',
      'suppliers.pincode AS s_pincode',
      'suppliers.gst AS s_gst',
      'suppliers.phone_number AS s_phone_number',
      'suppliers.email AS s_email',

      'companies.id AS c_id',
      'companies.address_line1 AS c_address_line1',
      'companies.address_line2 AS c_address_line2',
      'companies.city AS c_city',
      'companies.pincode AS c_pincode',
      'companies.gst AS c_gst',
      'companies.phone_number AS c_phone_number',
      'companies.email AS c_email',
       )
      ->first();



   $master_p =  master_purchase::where('po_no', $id)->first();

  //  dd($master_p->type);
      $datas = DB::table('purchases')
      ->leftJoin('products', 'purchases.productID', '=', 'products.id')
      ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
      ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id');
      // ->leftJoin('purchases', 'master_purchase.po_no', '=', 'purchases.po_no')
      if($master_p->type==2){
        $datas=$datas->groupBy('purchases.categoryID', 'purchases.brandID', 'purchases.productID','purchases.purchase_price', 'purchases.selling_price')
        ->where('purchases.po_no', $id)
        ->where('purchases.active', '1')
        
        ->select('purchases.*', 'purchases.id AS p_id','categories.*', 'products.*',
        'products.gst AS p_gst', 'brands.*', 'categories.*', DB::raw("count(purchases.id) as count") )
        ->get();
      }else{
        $datas=$datas
        ->where('purchases.po_no', $id)
        ->where('purchases.active', '1')
        
        ->select('purchases.*', 'purchases.id AS p_id','categories.*', 'products.*',
        'products.gst AS p_gst', 'brands.*', 'categories.*' )
        ->get();
      }
      // joining the purchases tabe   DB::raw("count(purchases.serial) as count")


      $terms = terms::find(1);
      $company =company::where('id',Auth::user()->companyID)->first();

    //  $company =
      return view('purchase.print',['data'=>$data, 'datas'=>$datas, 'terms'=> $terms,'company'=>$company]);

    }

    public function purchase_editupdate(Request $request, $id){
      //  dd($id);


//   $request->validate([

//     'supplierID' => 'required',
//     'referenceID' => 'required',
//     'purchaseDate' => 'required',
//     'notes' => 'required',



//     // 'purchase_price' => 'required',
//     // 'selling_price' => 'required|gt:purchase_price',

// ],

// [

// // 'purchase_price.required' => 'The purchase_price field is required.',
// // 'selling_price.required' => 'The selling_price field is required.',
// // 'selling_price.gt' => 'Greater than purchase price',
// ]);

$today = Date('Y-m-d');
$companyID = $this->getcompany();

$p_price=0;
foreach($request->purchase_price as $val){
  $p_price+=$val;
}

      // dd($request->all());



        $purchase_m =master_purchase::where('po_no', $id)->first();

        // dd($purchase_m);
        $purchase_m->supplierID = $request->supplierID;
        $purchase_m->referenceID = $request->referenceID;
        $purchase_m->purchaseDate = $request->purchaseDate;
        $purchase_m->notes = $request->notes;
        $purchase_m->total_price=$p_price;


        // $purchase->serial = $request->serial;
        // $purchase->purchase_price = $request->purchase_price;
        // $purchase->selling_price = $request->selling_price;


        $purchase_m->update();


        if($purchase_m->type==1){

          $f_id = $request->id;
          $cid = count($f_id);
              // dd($request->all());
          for($i=0; $i<$cid; $i++){
                if($request->id[$i] != null){
                  $purchase =purchase::find($request->id[$i]);
                  $purchase->supplierID = $request->supplierID;
                  $purchase->referenceID = $request->referenceID;
                  $purchase->purchaseDate = $request->purchaseDate;
                  $purchase->notes = $request->notes;
                  $purchase->serial = $request->serial[$i];
                  $purchase->purchase_price = $request->purchase_price[$i];
                  $purchase->selling_price = $request->selling_price[$i];
                  $purchase->save();
                }else{
                  $values=explode("|",$request->brandID[$i]);
                  // dd($values);
                  $purchase = new purchase;

                  $purchase->user_id = Auth::user()->id;
                $purchase->companyID = $companyID;
                $purchase->categoryID = $request->categoryID[$i];
                $purchase->brandID = $values[0];
                $purchase->productID = $values[1];
                $purchase->po_no   =   $id;
                $purchase->supplierID = $request->supplierID;
                $purchase->referenceID = $request->referenceID;
                $purchase->purchaseDate = $request->purchaseDate;
                $purchase->notes = $request->notes;
                $purchase->serial = $request->serial[$i];
                $purchase->stock = '1';
                $purchase->purchase_price = $request->purchase_price[$i];
                $purchase->selling_price = $request->selling_price[$i];
                $purchase->created_by = $today;
                  $purchase->save();
                }
            }
            if($request->removeid != null){
              $r_id = count($request->removeid);
              for($i=0; $i<$r_id; $i++){
                $purchase =purchase::find($request->removeid[$i])->delete();
              }
            }


        }else{

          $loop_id = $request->id;
          // $cid = count($f_id);
          $count = count($request->id);

          //  dd($request->field_id);
          // dd($request->all());
          for($i=0; $i<$count; $i++){
            if($loop_id[$i] != null){

              $stac = $request->stock[$i];
              $f_id = count($request->field_id[$i]);
              // dd($request->field_id);
              if($stac == $f_id){
                for($j=0; $j<$f_id; $j++){

                  $purchase =purchase::find($request->field_id[$i][$j]);

                  $purchase->supplierID = $request->supplierID;
                  $purchase->referenceID = $request->referenceID;
                  $purchase->purchaseDate = $request->purchaseDate;
                  $purchase->notes = $request->notes;

                  $purchase->purchase_price = $request->purchase_price[$i];
                  $purchase->selling_price = $request->selling_price[$i];
                  $purchase->save();
                }
              }elseif($stac > $f_id){
                $valid = $stac - $f_id;
                // dd($request->field_id);
                // dd(count($request->field_id));
                for($j=0; $j<$f_id; $j++){

                    $purchase =purchase::find($request->field_id[$i][$j]);

                    $purchase->supplierID = $request->supplierID;
                    $purchase->referenceID = $request->referenceID;
                    $purchase->purchaseDate = $request->purchaseDate;
                    $purchase->notes = $request->notes;

                    $purchase->purchase_price = $request->purchase_price[$i];
                    $purchase->selling_price = $request->selling_price[$i];
                    $purchase->save();

                }
                for($j=0; $j<$valid; $j++){
                  $purchase = new purchase;

                    $purchase->user_id = Auth::user()->id;
                    $purchase->companyID = $companyID;
                    $purchase->supplierID = $request->supplierID;
                    $purchase->referenceID = $request->referenceID;
                    $purchase->purchaseDate = $request->purchaseDate;
                    $purchase->notes = $request->notes;

                    $purchase->categoryID = $request->categoryID[$i];
                    $purchase->brandID = $request->brandID[$i];
                    $purchase->productID = $request->productID[$i];
                    $purchase->po_no   =   $id;
                    $purchase->stock = '1';
                    $purchase->purchase_price = $request->purchase_price[$i];
                    $purchase->selling_price = $request->selling_price[$i];
                    $purchase->created_by = $today;
                    $purchase->save();
                }
              }elseif($stac < $f_id){
                $remov = $f_id - $stac;

                for($j=0; $j<$remov; $j++){
                  $purchase =purchase::find($request->field_id[$i][$j])->delete();
                }
              }

            }else{

              $stacadd = $request->stock[$i];
              // dd($stacadd);
              for($j=0; $j<$stacadd; $j++){
                $values=explode("|",$request->brandID[$i]);
                $purchase = new purchase;

                $purchase->user_id = Auth::user()->id;
                $purchase->companyID = $companyID;
                $purchase->supplierID = $request->supplierID;
                $purchase->referenceID = $request->referenceID;
                $purchase->purchaseDate = $request->purchaseDate;
                $purchase->notes = $request->notes;

                $purchase->categoryID = $request->categoryID[$i];
                $purchase->brandID = $values[0];
                $purchase->productID = $values[1];
                $purchase->po_no   =   $id;
                $purchase->stock = '1';
                $purchase->purchase_price = $request->purchase_price[$i];
                $purchase->selling_price = $request->selling_price[$i];
                $purchase->created_by = $today;
                $purchase->save();
              }

            }
          }


          if($request->removeid != null){
            $r_id = count($request->removeid);
            for($i=0; $i<$r_id; $i++){
              $purchase =purchase::find($request->removeid[$i]);
              if($purchase->stock == 1){
                $purchase->delete();
              }
            }
          }
        }
        // return redirect()->route('purchase.purchase_print', $id);
      return redirect()->route('purchase.purchase_view')->with('msg',' Purchase Updated Successfully');

    }

    public function purchaseview_delete(Request $request){

      $data=$request->id;

      $m_purchase = master_purchase::where('po_no', $data)->delete();

      $purchase = purchase::where('po_no', $data)->delete();


      return response()->json(['success' => '1']);
      // return redirect()->route('purchase.purchase_view')->with('msg',' Purchase Deleted Successfully');
    }


public function purchase_index(Request $request){

    // $p_data =purchase_temp::all();
    $data =product::all();
    $cdata =category::all();
    $bdata =brand::all();
    $sdata =supplier::where('suppliers.mgt_status', '1')->where('companyID',Auth::user()->companyID)->get();
    $company  =company::all();
    if(Auth::user()->role =='3' || $this->role_check(26)){
     return view('purchase.addpurchase', ['data'=>$data,'cdata'=>$cdata,'bdata'=>$bdata, 'sdata'=>$sdata, 'company'=>$company]);
    }else{
      $msg='Cannot Access Page !';
       return redirect()->back()->with('msg', $msg);
    }
  }


  public function purchase_store_update(Request $request){

//   $request->validate([

//                   'supplierID' => 'required',
//                   'referenceID' => 'required',
//                   'purchaseDate' => 'required',
//                   'notes' => 'required',

//                   'categoryID.*' => 'required',
//                   'brandID.*' => 'required',
//                   'productID.*' => 'required',
//                   'purchase_price.*' => 'required',
//                   'selling_price.*' => 'required|gt:purchase_price.*',
//   ],

//   [
//     'categoryID.*.required' => 'The categoryID field is required.',
//     'brandID.*.required' => 'The Product field is required.',
//     'purchase_price.*.required' => 'The purchase_price field is required.',
//     'selling_price.*.required' => 'The selling_price field is required.',
//     'selling_price.*.gt' => 'Greater than purchase price',

//   ]

// );



  // dd($request->all());
  // if($request->serial[0] != null){

  //   $request->validate([
  //     'serial' => 'required|unique:purchases'
  //     ]);
  // }

  $companyID = $this->getcompany();
  $PO = master_purchase::orderBy('id','desc')->where('companyID',Auth::user()->companyID)->first();
  if($PO){
    $po_start_no = $PO->po_start_no+1;
  }else{
    $po_start_no=0;
  }
  $today = Date('Y-m-d');
  $master_p = master_purchase::all();
  $mp_count = $master_p->count();
  $p_price=0;
  foreach($request->purchase_price as $val){
    $p_price+=$val;
  }
        $mp = new master_purchase;
        $mp->user_id = Auth::user()->id;
        $mp->companyID = $companyID;
        $mp->supplierID = $request->supplierID;
        $mp->referenceID = $request->referenceID;
        $mp->purchaseDate = $request->purchaseDate;
        $mp->notes = $request->notes;
        $mp->type = $request->purchasetype;
        $mp->total_price=$p_price;
        $mp->created_by = $today;
        $mp->po_start_no=$po_start_no;
        $mp->save();

        $last_inser_id = $mp->id;
        $PO = master_purchase::find($last_inser_id);
        $com = company::find($companyID);
        if($com->purchase_status =='0'){
          $PO->po_no=$com->purchase_prefix.($com->purchase_no+$PO->po_start_no);
        }else{
          $PO->po_start_no=0;      
          $PO->po_no=$com->purchase_prefix.($com->purchase_no+$PO->po_start_no);
          $com->purchase_status=0;
          $com->save();      
        }
        // if($companyID == 1){
        //   $PO->po_no = $com->prefix.'PO'.$last_inser_id;
        // }elseif($companyID == 2){
        //   $po_id = $mp_count + 1011;
        //   $PO->po_no = $com->prefix.'PO'.$po_id;

        // }elseif($companyID == 3){
        //   $po_id = $mp_count + 400;
        //   $PO->po_no = $com->prefix.'PO'.$po_id;
        // }else{
        //   $po_id = $mp_count + 100;
        //   $PO->po_no = $com->prefix.'PO'.$po_id;
        // }
        $PO->save();

  $rowcount = count($request->purchase_price);
  for($i=0; $i<$rowcount; $i++){
    // for($i=0; $i<$row['qty']; $i++){

      // if($request->serial[0] != null){
      //   //return($data);

      // }else{
        if(isset($request->qty[$i]) != null){
          for($j=0; $j<$request->qty[$i]; $j++){

            $values=explode("|",$request->brandID[$i]);
            $s_purchase = new purchase;
         $s_purchase->user_id = Auth::user()->id;
         $s_purchase->companyID = $companyID;
         $s_purchase->categoryID = $request->categoryID[$i];
         $s_purchase->brandID = $values[0];
         $s_purchase->productID = $values[1];
         $s_purchase->supplierID = $request->supplierID;
         $s_purchase->referenceID = $request->referenceID;
         $s_purchase->po_no = $s_purchase->id;
         $s_purchase->purchaseDate = $request->purchaseDate;
         $s_purchase->notes = $request->notes;
  
         $s_purchase->po_no = $PO->po_no;
  
        //  $s_purchase->serial = $request->serial;
        //  $s_purchase->hsn = $request->hsn[$i];
         $s_purchase->purchase_price = $request->purchase_price[$i];
         $s_purchase->selling_price = $request->selling_price[$i];
         $s_purchase->stock = 1;
         $s_purchase->created_by = $today;
         $s_purchase->save();
          }
        }else{
          $values=explode("|",$request->brandID[$i]);
          $s_purchase = new purchase;
   
   
          $s_purchase->id = $s_purchase->AUTO_INCREMENT;
   
   
          $s_purchase->user_id = Auth::user()->id;
          $s_purchase->companyID = $companyID;
          $s_purchase->categoryID = $request->categoryID[$i];
          $s_purchase->brandID = $values[0];
          $s_purchase->productID = $values[1];
          $s_purchase->supplierID = $request->supplierID;
          $s_purchase->referenceID = $request->referenceID;
   
          $s_purchase->po_no = $PO->po_no;
   
          $s_purchase->purchaseDate = $request->purchaseDate;
          $s_purchase->notes = $request->notes;
          $s_purchase->serial = $request->serial[$i];
         //  $s_purchase->hsn = $request->hsn[$i];
          $s_purchase->purchase_price = $request->purchase_price[$i];
          $s_purchase->selling_price = $request->selling_price[$i];
          $s_purchase->stock = '1';
          $s_purchase->created_by = $today;
          $s_purchase->save();
        }

      // }
  }
  // return redirect()->route('purchase.purchase_view', $PO->po_no);
    return redirect()->route('purchase.purchase_view')->with('msg',' Purchase Add Successfully');
  }

  public function purchase_delete(Request $request){
  $request->id;


  $data = purchase::where('po_no', $request->id)->get();
  // dd($data);
  // $delete = purchase_temp::find($request->id)->delete();

         return response()->json(['success' => '1']);

  }

  public function qtyproduct_delete(Request $request){

    $string = $request->id;

    if (str_contains($string, '|')) {
      $values=explode("|",$request->id);
    $data = purchase::where([['po_no', $values[0]], ['categoryID', $values[1]], ['brandID', $values[2]], ['productID', $values[3]] ])->delete();

    }else{
      // $data = purchase::find($request->id)->delete();
      $data = purchase::where('id', $request->id)->update(['temp'=> 1]);

      // ->delete();
    }

    return response()->json(['success' => '1']);
  }

  public function product_getid(Request $request){


    $data = product::where('brandID','=',$request->id)->get();


      // $data = product::where(['brandID','=',$request->id],['categoryID','=',$cid]);
    return response()->json(['success' => '1', 'data'=>$data]);

  }

  public function desc_getid(Request $request){

    $data = product::find($request->id);
  // dd($data);
      return response()->json(['success' => '1', 'data'=>$data]);

  }

  //purchase menu select splier

  public function getCategory(){
     $category=category::get();
     echo json_encode($category);
  }

  public function puchasemodel_getid(Request $request)
  {

    // $data=$request->id;

    $cdata = category::find($request->id);
    // $data = brand::all();


    // $data=DB::select("SELECT b.id as brandid,p.id as modelid ,b.brand_name,p.productName,p.description FROM `brands` as b LEFT JOIN products as p ON p.brandID=b.id  WHERE b.categoryID='$request->id'  ")  ;


    $data=DB::select("SELECT b.id as brandid,p.id as modelid ,b.brand_name,p.productName,p.description FROM `products` as p LEFT JOIN brands as b ON p.brandID=b.id WHERE p.categoryID='$request->id' ")  ;


    // dd($data);

    return response()->json(['success' => '1', 'data' => $data, 'cdata' => $cdata]);
  }

  public function viewpurchasestock(Request $request){

    $companyID = $this->getcompany();

    $datas = DB::table('purchases')
    ->leftJoin('products', 'purchases.productID', '=', 'products.id')
    ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
    ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id')
    ->leftJoin('suppliers', 'purchases.supplierID', '=', 'suppliers.id')
    ->where('purchases.stock',1)->where('purchases.type','0')
    // ->where('purchases.companyID', $companyID)
    ->groupBy('purchases.categoryID', 'purchases.brandID', 'purchases.productID', 'purchases.purchaseDate', 'purchases.po_no','purchases.purchase_price', 'purchases.selling_price' )
    ->select('suppliers.*','purchases.*', 'purchases.id as p_id', 'products.*', 'categories.*', 'brands.*',DB::raw("count(purchases.id) as count") )
    ->orderBy('purchases.id', 'DESC', )->get();

    // dd($datas);
    if(Auth::user()->role_id =='3' || $this->role_check(24)){
    return view('purchase.stock_list', ['data'=>$datas]);
       }else{
         $msg='Cannot Access Page !';
          return redirect()->back()->with('msg', $msg);
       }
  }
}
