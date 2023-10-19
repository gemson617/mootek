<?php

namespace App\Http\Controllers;

use PDF;
use DateTime;
use DatePeriod;
use DateIntercal;
use DateInterval;
use Carbon\Carbon;
use App\Models\tax;
use App\Models\brand;
use App\Models\terms;
use App\Models\company;
use App\Models\deposit;
use App\Models\Payment;
use App\Models\product;
use App\Models\category;
use App\Models\customer;
use App\Models\purchase;
use App\Models\supplier;
use App\Models\rental_sub;
use App\Models\rental_temp;
use App\Models\rent_invoice;
use App\Models\rent_agreement;



use Illuminate\Http\Request;


use App\Models\invoice_number;
use App\Models\rental_product;
use App\Models\payment_history;
use App\Models\edit_rental_temp;

use App\Http\Traits\LeadLogTrait;
use Illuminate\Support\Facades\DB;
use App\Models\rent_day_month_week;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Validation\Validator;

class RentalController extends Controller
{
   use LeadLogTrait;

   public function rental_index(Request $request)
   {


      // $u_id = Auth::user()->id;
      // $rent_temp1 = rental_temp::all();
      // $rent_temp2 = rent_invoice::where('user_id','=',$u_id)->get();
      // $rent_temp3 = rental_sub::where('user_id','=',$u_id)->get();
      // $rent_temp4 = rental_product::where('user_id','=',$u_id)->get();
      // $rent_temp5 = payment_history::where('user_id','=',$u_id)->get();
      // $rent_temp6 = invoice_number::where('user_id','=',$u_id)->get();

      // $rent_temp1->each->delete();
      // $rent_temp2->each->delete();
      // $rent_temp3->each->delete();
      // $rent_temp4->each->delete();
      // $rent_temp5->each->delete();
      // $rent_temp6->each->delete();


      $p_data = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID',  'selling_price', 'id')->where('active', '1')->where('stock', '1')->where('type', '0')->get();
      $data = product::all();
      $cdata = category::all();
      $bdata = brand::all();
      $cdata = customer::where('companyID', Auth::user()->companyID)->get();
      $tax = tax::all();

      $list_data = DB::table('rental_temps')
         ->leftJoin('products', 'rental_temps.productID', '=', 'products.id')
         ->leftJoin('categories', 'rental_temps.categoryID', '=', 'categories.id')
         ->leftJoin('brands', 'rental_temps.brandID', '=', 'brands.id')
         ->select('rental_temps.*', 'rental_temps.id AS r_id', 'categories.*', 'products.*', 'brands.*')
         ->get(); // joining the rental_temps tabe

      // dd($p_data);
      $rental_temp =  rental_temp::get();
      $total_amt = $rental_temp->sum('rent_price');
      if (Auth::user()->role_id == '3' || $this->role_check(35)) {
         return view('rental.addrental', ['list_data' => $list_data, 'cdata' => $cdata, 'p_data' => $p_data, 'total_amt' => $total_amt, 'tax' => $tax]);
      } else {
         $msg = 'Cannot Access Page !';
         return redirect()->back()->with('msg', $msg);
      }
   }

   public function getmodal()
   {
      $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price', 'id')->where('active', '1')->where('stock', '1')->where('type', '0')->get();
      foreach ($modal as $val) {
         $category = category::where('id', $val->categoryID)->first();
         $product = product::where('id', $val->productID)->first();
         $brand = brand::where('id', $val->brandID)->first();
         $NumberOfStock = purchase::where('active', '1')->where('stock', '1')->where('type', '0')->where('categoryID', $val->categoryID)->where('brandID', $val->brandID)->where('productID', $val->productID)->where('selling_price', $val->selling_price)->get();
         $getNumberOfStock = $NumberOfStock->count();
         $array[] = array('id' => $val->id, 'cat' => $category->category_name, 'catid' => $category->id, 'brand' => $brand->brand_name, 'brandid' => $brand->id, 'product' => $product->productName, 'description' => $product->description, 'productid' => $product->id, 'count' => $getNumberOfStock);
      }
      //   return $array;
      echo json_encode($array);
   }

   public function getserial(Request $request)
   {
      $id = $request->id;
      //  dd($id);
      $stock = explode("|", $id);
      $data = purchase::where('categoryID', $stock[1])->where('brandID', $stock[2])->where('productID', $stock[3])->where('stock', '1')->where('type', '0')->where('companyID', Auth::user()->companyID)->get();
      // dd($data);
      return response()->json(['success' => '1', 'status' => 1, 'data' => $data,]);
   }

   public function serialvalidation(Request $request)
   {

      $data = purchase::where([['serial', $request->checkserial], ['stock', 0]])->where('companyID', Auth::user()->companyID)->first();
      if ($data != null) {
         return response()->json(['msg' => 'false']);
      } else {
         return response()->json(['msg' => 'true']);
      }
   }


   public function rentaltemp_store(Request $request)
   {

      $request->validate([

         'productID' => 'required',
         'rentdescription' => 'required',
         'rent_date' => 'required',
         'hsn' => 'required',
         'dayweekmonth' => 'required',
         'rent_price' => 'required',
         'rent_month' => 'required',
         'serialID' => 'required|unique:rental_temps'

      ]);


      $rent_price = $request->rent_price;
      $rent_month = $request->rent_month;
      $rent_amt  = ($rent_price * $rent_month);



      $productID = $request->productID;
      //   $descript = product::where('productID', $productID)->get();
      $data = purchase::find($productID);

      // dd($descript);
      $input = new rental_temp;

      $input->user_id = Auth::user()->id;
      $input->categoryID = $data->categoryID;
      $input->brandID = $data->brandID;
      $input->description = $data->description;


      $input->productID = $request->productID;
      $input->serialID = $request->serialID;
      $input->rentdescription = $request->rentdescription;
      $input->rent_date = $request->rent_date;
      $input->hsn = $request->hsn;
      $input->dayweekmonth = $request->dayweekmonth;
      $input->rent_price = $rent_amt;
      $input->rent_month = $request->rent_month;
      $input->created_by = Auth::user()->id;

      $input->save();


      $purchase_update = purchase::where('serial', '=', $request->serialID)
         ->orWhere('id', $request->productID)->where('companyID', Auth::user()->companyID)->first();
      // ->update([['stock'=>0], ['rental'=>1], ['rent_price'=>$data->rent_price]]);

      // $update =purchase::where('id',$request->productID)->first();
      // dd($purchase_update);
      $purchase_update->update([
         'serial' => $request->serialID,
         'stock' => '0',
         'rental' => '1',
      ]);
      $purchase_update->update();
      return redirect()->back()->with('msg', ' Rental Added Successfully');

      // return redirect()->back()->with('msg','Serial ID Does not Match Product');
   }

   public function rentaltemp_delete(Request $request)
   {

      $data = $request->id;
      $delete = rental_temp::find($data);
      //   $up_temp = $delete->productID;
      // dd($delete->productID);
      $up_temp = purchase::find($delete->productID);


      $up_temp->update([
         'stock' => '1',
         'rental' => '0',
      ]);
      $up_temp->update();

      $delete->delete();

      return response()->json(['success' => '1']);
   }

   public function rental_store(Request $request)
   {
      //   dd($request->all());
      $companyID = $this->getcompany();
      $dwm = $request->dayweekmonth;
      if ($dwm == 'Day') {

         $rentdate    = date('Y-m-d', strtotime($request->rent_date)); //start date
         $nosdwm    = '+' . ($request->rent_month-1) . ' day';

         $close_date = date('Y-m-d', strtotime($request->rent_date . $nosdwm));
         $renewal_date = date('Y-m-d', strtotime($rentdate . ' +1 day'));
      } elseif ($dwm == 'Week') {
         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . ($request->rent_month-1) . ' week';
         $close_date = date('Y-m-d', strtotime($request->rent_date . $nosdwm));
         $renewal_date = date('Y-m-d', strtotime($rentdate . ' +1 week'));
      } else {
         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . ($request->rent_month-1) . ' month';
         $close_date = date('Y-m-d', strtotime($request->rent_date . $nosdwm));
         $renewal_date = date('Y-m-d', strtotime($rentdate . '+1 month'));
      }
      $PO = rent_agreement::orderBy('id', 'desc')->where('companyID', Auth::user()->companyID)->first();
      if ($PO) {
         $rent_start_no = $PO->rent_start_no + 1;
      } else {
         $rent_start_no = 0;
      }
      if ($renewal_date == $close_date) {
         $complete = 1;
      } else {
         $complete = 0;
      }
      $agreement = new rent_agreement;
      $agreement->user_id = Auth::user()->id;
      $agreement->companyID = $companyID;
      $agreement->customerID =  $request->customerID;
      $agreement->rental_date =  $request->rent_date;
      $agreement->renewal_date =  $request->rent_date;
      $agreement->day_week_month =  $request->dayweekmonth;
      $agreement->nos_day_week_month =  $request->rent_month;
      $agreement->taxable_amount = $request->taxable_amount;
      $agreement->deposit = $request->deposit;
      $agreement->discount = $request->discount == null ? '0' : $request->discount;
      $agreement->delivery = $request->delivery == null ? '0' : $request->delivery;
      $agreement->others = $request->others == null ? '0' : $request->others;
      $agreement->tax = $request->taxtype;
      $agreement->tax_amt = $request->tax;
      $agreement->total_amount = $request->total_amount;
      $agreement->collected = $request->collected;
      $agreement->receive_date = $close_date;
      $agreement->balance = $request->balance;
      $agreement->renewal_date = $renewal_date;
      $agreement->terms =  $request->terms;
      $agreement->created_by = Auth::user()->id;
      $agreement->rent_start_no = $rent_start_no;
      $agreement->complete_status = $complete;
      $agreement->save();
      $agreementID = $agreement->id;

      $input = new rent_invoice;
      $input->user_id = Auth::user()->id;
      $input->companyID = $companyID;
      $input->customerID =  $request->customerID;
      $input->rental_date =  $request->rent_date;
      $input->renewal_date =  $renewal_date;
      $input->day_week_month =  $request->dayweekmonth;
      $input->nos_day_week_month =  $request->rent_month;
      $input->taxable_amount = $request->taxable_amount;
      $input->deposit = $request->deposit;
      $input->discount = $request->discount == null ? '0' : $request->discount;
      $input->delivery = $request->delivery == null ? '0' : $request->delivery;
      $input->others = $request->others == null ? '0' : $request->others;
      $input->tax = $request->taxtype;
      $input->tax_amt = $request->tax;
      $input->total_amount = $request->total_amount;
      $input->collected = $request->collected;
      $input->receive_date = $close_date;
      $input->balance = $request->balance;
      $input->terms =  $request->terms;
      $input->created_by = Auth::user()->id;
      $input->rent_start_no = $rent_start_no;
      $input->complete_status = $complete;
      $input->agreementID = $agreementID;
      $input->save();
      $invoiceID = $input->id;


      // $rentidupdate = rent_invoice::where('id', $input->id)->update(['rentalID'=>$company->prefix.$rentcount_id.$input->id]);
      $update = rent_invoice::where('id', $invoiceID)->first();
      $com = company::find(Auth::user()->companyID);
      if ($com->rental_status == '0') {
         // dd($com);
         $rentalID = $com->rental_prefix . ($com->rental_no + $update->rent_start_no);
      } else {
         $update->rent_start_no = 0;
         $rentalID = $com->rental_prefix . $com->rental_no;
         $com->rental_status = 0;
         $com->save();
      }
      $update->agreementID = $agreementID;
      $update->rentalID = $rentalID;
      $update->save();
      $agree = rent_agreement::where('id', $agreement->id)->first();
      $agree->rentalID = $rentalID;
      $agree->save();

      //customer deposit
      $alreay_exist = deposit::where('customer_id', $request->customerID)->first();

      if ($alreay_exist) {
         $amount = deposit::where('customer_id', $request->customerID)->first();
         $customeramount = $amount->amount;
         $alreay_exist->amount = $customeramount + $request->deposit;
         $alreay_exist->save();
      } else {
         deposit::create([
            'customer_id' => $request->customerID,
            'amount' => $request->deposit,
         ]);
      }
      $productlist = count($request->id);
      //deposit

      for ($i = 0; $i < $productlist; $i++) {

         $RP = new rental_product;

         $val = explode("|", $request->categoryID[$i]);

         $RP->user_id    = Auth::user()->id;
         $RP->invoiceID  = $rentalID;
         $RP->companyID = $companyID;
         $RP->invoiceID  = $invoiceID;
         $RP->agreementID    = $agreementID;
         $RP->customerId  = $request->customerID;
         $RP->serialID   = $request->serial[$i];
         // $RP->hsn    = $data->hsn;
         $RP->categoryID   = $val[1];
         $RP->brandID      = $val[2];
         $RP->productID    = $val[3];
         // $RP->description   = $data->description;
         $RP->rent_month    = $request->rent_month;
         $RP->dayweekmonth  = $request->dayweekmonth;
         $RP->rent_price    = $request->rent_price[$i] * $request->rent_month;
         $RP->rent_date  = $request->rent_date;
         // $RP->receive_date   =
         // $RP->rentdescription  = $data->rentdescription;
         $RP->created_by  = Auth::user()->id;
         $RP->save();

         $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('serial', $request->serial[$i])->where('stock', '1')->where('type', '0')->first();
         if ($update) {
            $update->stock = '0';
            $update->type = '2';
            $update->save();
         } else {
            $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('serial', null)->where('stock', '1')->where('type', '0')->first();
            if ($update) {
               $update->serial =  $request->serial[$i];
               $update->stock = '0';
               $update->type = '2';
               $update->save();
            } else {
               $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('stock', '1')->where('type', '0')->first();
               $update->serial =  $request->serial[$i];
               $update->stock = '0';
               $update->type = '2';
               $update->save();
            }
         }
      }



      // $purchase_update = purchase::where([
      //    ['serial', $request->serialID],
      //    ['categoryID', $request->categoryID],
      //    ['brandID', $request->brandID],
      //    ['productID', $request->productID]
      //    ])
      // ->first();



      return redirect()->route('rental.rental_view')->with('msg', 'Rental Added Successfully');

      // Carbon::parse($timestamp)->format('Y-m-d');

      //    $time =  strtotime($RP->created_at);
      //    $effectiveDate = date("Y-m-d", strtotime("-1 day", $time));

      //    $month = $RP->rent_month+1;

      //    for($i=0;$i<$month;$i++){

      //       $alert_date= date('Y-m-d', strtotime("+{$i} months", strtotime($effectiveDate)));
      //       $sub_R = new rental_sub;

      //       $sub_R->user_id = Auth::user()->id;
      //       $sub_R->invoiceID = $lastRentID;
      //       $sub_R->rentID = $rent_id;
      //       $sub_R->customerId = $request->customerID;
      //       $sub_R->serialID = $data->serialID;
      //       $sub_R->hsn = $data->hsn;
      //       $sub_R->categoryID = $data->categoryID;
      //       $sub_R->brandID = $data->brandID;
      //       $sub_R->productID = $data->productID;
      //       $sub_R->description = $data->description;
      //       $sub_R->rent_month =  $data->rent_month;
      //       $sub_R->dayweekmonth = $data->dayweekmonth;
      //       $sub_R->rent_price = $data->rent_price;
      //       $sub_R->rent_date = $data->rent_date;
      //       $sub_R->alert_date = $alert_date;
      //       $sub_R->rentdescription = $data->rentdescription;
      //       $sub_R->created_by =  Auth::user()->id;
      //       $sub_R->save();
      //    }


      // $today = date('Y-m-d');
      //    $pay_hist = new payment_history;

      //    $pay_hist->user_id  = Auth::user()->id;
      //    $pay_hist->invoiceID  = $lastRentID;
      //    $pay_hist->rentID  = $rent_id;
      //    $pay_hist->amount  = $request->total_amount;
      //    $pay_hist->collected  = $request->collected;
      //    $pay_hist->balance  = $request->balance;
      //    $pay_hist->mop  = $request->mop;
      //    $pay_hist->paymentDate  = $today;
      //    $pay_hist->created_by  = Auth::user()->id;

      //    $pay_hist->save();

      //    $u_id = Auth::user()->id;
      //    $rent_temp = rental_temp::where('user_id','=',$u_id);
      //    $rent_temp->truncate();
      //    return redirect()->back()->with('msg','Rental Added Successfully');
   }

   public function rental_view()
   {

      if (isset($_GET['id'])) {
         $date = $_GET['id'];
      } else {
         $date = date('Y-m-d');
      }
      $dataa = rent_invoice::where([['user_id', '=', Auth::user()->id], ['active', 1]]);


      $companyID = $this->getcompany();
      $company = company::find($companyID);

      // dd($dataa);
      $data = DB::table('rent_invoices')
         ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
         ->leftjoin('deposit', 'deposit.customer_id', '=', 'rent_invoices.customerID')
         ->where('rent_invoices.companyID', $companyID)
         ->where('rent_invoices.rental_date', $date)
         ->select('deposit.amount as d_amt', 'rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.tax AS taxpercentage', 'rent_invoices.created_at AS time', 'customers.*',)
         ->orderBy('rent_invoices.id', 'DESC')
         ->get(); // joining the rent_invoices tabe
      // dd($data);
      if (Auth::user()->role_id == '3' || $this->role_check(34)) {
         return view('rental.viewrental', ['data' => $data]);
      } else {
         $msg = 'Cannot Access Page !';
         return redirect()->back()->with('msg', $msg);
      }
   }
   public function get_rent($id)
   {
      $data = DB::table('rent_invoices')
         ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
         ->leftjoin('deposit', 'deposit.customer_id', '=', 'rent_invoices.customerID')
         ->where('rent_invoices.companyID', Auth::user()->companyID)
         ->where('rent_invoices.id', $id)
         ->select('rent_invoices.*', 'deposit.amount as deposit_amount', 'rent_invoices.id AS r_id', 'rent_invoices.tax AS taxpercentage', 'rent_invoices.created_at AS time', 'customers.*',)
         ->orderBy('rent_invoices.id', 'DESC')
         ->first(); // joining the rent_invoices tabe
      $payment = Payment::where('status', '0')->get();
      // dd($payment);
      return response()->json(['success' => '1', 'status' => 1, 'data' => $data, 'payment' => $payment]);
   }
   public function rent_payment(Request $request)
   {
      $deposit = $request->deposit;
      $balance  = $request->balance;
      $data = rent_invoice::where('id', $request->id)->first();
      //   dd($data);
      $data->collected = $request->collected;
      $data->balance = 0;
      $data->payment_status = 1;
      if ($request->deposit_satus == '0') {
         $data->payment_mode = $request->payment_mode_status;
      }
      $data->rental_amount = ($request->taxable_amount - $request->discount) + (($request->taxable_amount - $request->discount) * $request->taxpercentage / 100);
      $data->save();
      if ($request->deposit_satus == '1') {
         $cus_id = DB::table('rent_invoices')->where('id', $request->id)->first();
         if ($deposit <= $balance) {
            $bal = 0;
         } else {
            $bal = $deposit - $balance;
         }
         $deposit  = deposit::where('customer_id', $cus_id->customerID)->first();
         $deposit->amount = $bal;
         $deposit->save();
      }
      return redirect()->route('rental.rental_view')->with('msg', 'Payment Update Successfully');
   }
   public function renewal_payment(Request $request)
   {
      if ($request->deposit_satus == '0' || $request->deposit_satus == '1') {

         $renewal = rent_invoice::where('companyID', Auth::user()->companyID)->where('id', $request->id)->first();
         $dwm = $renewal->day_week_month;
         $rent_month = $renewal->nos_day_week_month;
         if ($dwm == 'Day') {
            $rentdate    = date('Y-m-d', strtotime($renewal->renewal_date));
            $nosdwm    = '+' . $rent_month . ' day';
            $close_date = $renewal->receive_date;
            $renewal_date = date('Y-m-d', strtotime($rentdate . ' +1 day'));
         } elseif ($dwm == 'Week') {
            $rentdate    = date('Y-m-d', strtotime($renewal->renewal_date));
            $nosdwm    = '+' . $rent_month . ' week';
            $close_date = $renewal->receive_date;
            $renewal_date = date('Y-m-d', strtotime($rentdate . ' +1 week'));
         } else {
            $rentdate    = date('Y-m-d', strtotime($renewal->renewal_date));
            $nosdwm    = '+' . $rent_month . ' month';
            $close_date = $renewal->receive_date;
            $renewal_date = date('Y-m-d', strtotime($rentdate . '+1 month'));
         }
         if ($renewal_date == $close_date) {
            $complete = 1;
         } else {
            $complete = 0;
         }
         $tax_amount = $renewal->taxable_amount;
         $disc = $renewal->discount;
         $tax_type = $renewal->tax;
         $tax_amt = $renewal->tax_amt;
         $t_amount = ($renewal->taxable_amount - $renewal->discount) + (($renewal->taxable_amount - $renewal->discount) * $tax_type / 100);
         $input = new rent_invoice;
         $input->rentalID = $renewal->rentalID;
         $input->user_id = Auth::user()->id;
         $input->agreementID = $renewal->agreementID;
         $input->companyID = Auth::user()->companyID;
         $input->customerID =  $renewal->customerID;
         $input->rental_date =  $renewal->renewal_date;
         $input->renewal_date = $renewal_date;
         $input->day_week_month = $dwm;
         $input->nos_day_week_month = $rent_month;
         $input->taxable_amount = $tax_amount;
         $input->discount = $disc;
         $input->tax = $tax_type;
         $input->tax_amt = $tax_amt;
         $input->total_amount = $t_amount;
         $input->collected = $t_amount;
         $input->receive_date = $close_date;
         $input->balance = 0;
         $input->terms =  $renewal->terms;
         $input->created_by = Auth::user()->id;
         $input->complete_status = $complete;
         $input->rental_amount = $t_amount;
         $input->payment_status = '1';
         $input->renewal_status = 0;
         $input->payment_mode = $request->payment_mode_status;
         $input->save();
         $rental_id = $input->id;
         $deposit = $request->deposit;
         if ($request->deposit_satus == 1) {
            if ($t_amount >= $deposit) {
               $bal = 0;
            } else {
               $bal = $deposit - $t_amount;
            }
            $deposit  = deposit::where('customer_id', $renewal->customerID)->first();
            $deposit->amount = $bal;
            $deposit->save();
         }
         $upadte = rent_invoice::where('companyID', Auth::user()->companyID)->where('id', $request->id)->first();
         $upadte->renewal_status = 1;
         $upadte->save();

         return redirect()->route('rental.rental_view')->with('msg', 'Payment Update Successfully');
      } else {
         $id = $request->id;
         $last_agreement = rent_agreement::where('id', $id)->first();
         // dd($last_agreement);
         // $invoiceID = $last_invoice->rentalID;
         //  dd('ok');
         $rp = rental_product::where('agreementID', $id)->get();
         // dd($rp);
         $count = count($rp);
         for ($i = 0; $i < $count; $i++) {
            $remove_ietm = rental_product::find($rp[$i]->id);
            // dd($remove_ietm);
            $update = purchase::where('categoryID', $remove_ietm->categoryID)->where('brandID', $remove_ietm->brandID)->where('productID', $remove_ietm->productID)->where('serial', $remove_ietm->serialID)->where('stock', '0')->where('type', '2')->first();
            if ($update) {
               $update->stock = '1';
               $update->type = '0';
               $update->save();
            }
         }
         rent_agreement::where('id', $id)->update(['active' => '0']);
         rental_product::where('rentID', $id)->update(['active' => '0']);
         // return redirect()->back()->with('msg','Meterial Recived');
         if ($request->deposit > 0) {

            $update = rent_agreement::where('rent_agreement.id', $id)
               ->leftjoin('customers', 'customers.id', '=', 'rent_invoices.customerID')
               ->leftjoin('deposit', 'deposit.customer_id', '=', 'rent_invoices.customerID')
               ->first();
            $deposit = deposit::where('customer_id', $last_agreement->customerID)->first();
            $deposit->amount = '0';
            $deposit->save();
            $pdf = PDF::loadView('rental.voucher', compact('update'));
            $pdf->setPaper('A4', 'portrait');
            $name = $update->name . '.pdf';
            return $pdf->download($name, compact('update'));
         }
         return redirect()->route('rental.rental_view')->with('msg', 'Material Received Successfully');
      }
   }


   public function rentdeposit()
   {
      $deposit = deposit::leftjoin('customers', 'customers.id', '=', 'deposit.customer_id')->get();
      if (Auth::user()->role_id == '3' || $this->role_check(31)) {
         return view('rental.deposit', ['data' => $deposit]);
      } else {
         $msg = 'Cannot Access Page !';
         return redirect()->back()->with('msg', $msg);
      }
      
   }
   public function rent_view($id)
   {
      // $dataa =rental_product::where([
      //     ['user_id','=',Auth::user()->id],
      //     ['active', 1],
      //     ['rentID',$id],
      // ])->get();

      $data = DB::table('rental_products')
         ->leftJoin('rent_agreement', 'rental_products.agreementID', '=', 'rent_agreement.id')
         ->leftJoin('products', 'rental_products.productID', '=', 'products.id')
         ->leftJoin('categories', 'rental_products.categoryID', '=', 'categories.id')
         ->leftJoin('brands', 'rental_products.brandID', '=', 'brands.id')
         ->where('rental_products.companyID', Auth::user()->companyID)
         ->where('rental_products.user_id', Auth::user()->id)
         //  ->where('rental_products.rentID',$id)
         ->where('rent_agreement.id', $id)
         ->select('rental_products.*', 'rent_agreement.*', 'rental_products.id AS r_id', 'categories.*', 'products.*', 'brands.*')
         ->get();  // joining the rental_products tabe


      // dd($data);
      return view('rental.invoice_details', ['data' => $data]);
   }

   public function edit_rental($id, $customer)
   {


      $p_data = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price', 'id')->where('active', '1')->where('stock', '1')->where('type', '0')->where('companyID', Auth::user()->companyID)->get();
      // $p_data =product::all();
      $cdata = category::all();
      $bdata = brand::all();
      // $bdata =company::all();
      $cdata = customer::where('companyID', Auth::user()->companyID)->get();
      $tax = tax::all();
      // dd($id);
      $data = DB::table('rent_invoices')
         ->leftJoin('companies', 'rent_invoices.companyID', '=', 'companies.id')
         ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
         ->where('rent_invoices.rentalID', $id)
         ->select('rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.created_at AS time', 'customers.*', 'companies.*')
         ->first(); // joining the rent_invoices tabe

      $products = DB::table('rental_products')
         ->leftJoin('products', 'rental_products.productID', '=', 'products.id')
         ->leftJoin('categories', 'rental_products.categoryID', '=', 'categories.id')
         ->leftJoin('brands', 'rental_products.brandID', '=', 'brands.id')
         ->where('rental_products.rentID', $id)
         ->select('rental_products.id as rp_id', 'rental_products.*', 'products.*', 'categories.*', 'brands.*')
         ->get();

      //  dd($products);

      return view('rental.edit_rental', ['id' => $id, 'customer' => $customer, 'data' => $data, 'products' => $products, 'bdata' => $bdata, 'cdata' => $cdata, 'p_data' => $p_data,  'tax' => $tax]);
   }

   public function edit_rentaltemp_store(Request $request)
   {

      $request->validate([

         'productID' => 'required',
         'rentdescription' => 'required',
         'rent_date' => 'required',
         'hsn' => 'required',
         'dayweekmonth' => 'required',
         'rent_price' => 'required',
         'rent_month' => 'required',
         'serialID' => 'required|unique:rental_temps'

      ]);


      $rent_price = $request->rent_price;
      $rent_month = $request->rent_month;
      $rent_amt  = ($rent_price * $rent_month);



      $productID = $request->productID;
      //   $descript = product::where('productID', $productID)->get();
      $data = purchase::find($productID);

      // dd($descript);
      $input = new edit_rental_temp;

      $input->user_id = Auth::user()->id;
      $input->categoryID = $data->categoryID;
      $input->brandID = $data->brandID;
      $input->description = $data->description;


      $input->customerId = $request->customerId;
      $input->rentID = $request->rentID;
      $input->productID = $request->productID;
      $input->serialID = $request->serialID;
      $input->rentdescription = $request->rentdescription;
      $input->rent_date = $request->rent_date;
      $input->hsn = $request->hsn;
      $input->dayweekmonth = $request->dayweekmonth;
      $input->rent_price = $rent_amt;
      $input->rent_month = $request->rent_month;
      $input->created_by = Auth::user()->id;
      $input->save();


      $purchase_update = purchase::where('serial', '=', $request->serialID)
         ->orWhere('id', $request->productID)->first();
      // ->update([['stock'=>0], ['rental'=>1], ['rent_price'=>$data->rent_price]]);

      // $update =purchase::where('id',$request->productID)->first();
      // dd($purchase_update);
      $purchase_update->update([
         'serial' => $request->serialID,
         'stock' => '0',
         'rental' => '1',
      ]);
      $purchase_update->update();
      return redirect()->back()->with('msg', ' Rental Added Successfully');
   }



   public function edit_rental_store(Request $request)
   {
      $companyID = $this->getcompany();
      $company = company::find($companyID);

      $rent_i = rent_invoice::all();
      $rent_count = $rent_i->count();
      $rentcount_id = $rent_count + 1000;

      $nextid = DB::select("SHOW TABLE STATUS LIKE 'rent_invoices'");


      $dwm    = $request->dayweekmonth;

      if ($dwm == 'Day') {

         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . $request->rent_month . ' day';
         $close_date = date('y-m-d', strtotime($request->rent_date . $nosdwm));
         $alert_date = date('y-m-d', strtotime($close_date . ' -1 day'));
      } elseif ($dwm == 'Weeek') {

         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . $request->rent_month . ' week';
         $close_date = date('y-m-d', strtotime($request->rent_date . $nosdwm));
         $alert_date = date('y-m-d', strtotime($close_date . ' -1 day'));
      } else {

         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . $request->rent_month . ' month';
         $close_date = date('y-m-d', strtotime($request->rent_date . $nosdwm));
         $alert_date = date('y-m-d', strtotime($close_date . ' -1 day'));
      }

      // dd($request->all());

      $input =  rent_invoice::where('rentalID', $request->rent_id)->first();
      $input->user_id = Auth::user()->id;
      $input->companyID = $companyID;

      $input->customerID =  $request->customerID;
      $input->rental_date =  $request->rent_date;
      $input->day_week_month =  $request->dayweekmonth;
      $input->nos_day_week_month =  $request->rent_month;

      $input->taxable_amount = $request->taxable_amount;
      $input->discount = $request->discount;
      $input->delivery = $request->delivery;
      $input->others = $request->others;
      $input->tax = $request->taxtype;
      $input->tax_amt = $request->tax;
      $input->total_amount = $request->total_amount;
      $input->collected = $request->collected;
      $input->balance = $request->balance;
      $input->alert_date = $alert_date;
      $input->terms =  $request->terms;
      $input->created_by = Auth::user()->id;
      $input->save();

      $productlist = count($request->id);


      // dd($request->all());
      for ($i = 0; $i < $productlist; $i++) {

         if ($request->id[$i] != null) {

            $RP = rental_product::where([['id', $request->id[$i]], ['rentID', $request->rent_id]])->first();

            $RP->customerId  = $request->customerID;
            $RP->rent_month    = $request->rent_month;
            $RP->dayweekmonth  = $request->dayweekmonth;
            $RP->rent_price    = $request->rent_price[$i] * $request->rent_month;
            $RP->rent_date  = $request->rent_date;
            $RP->save();
         } else {
            $RP = new rental_product;
            $val = explode("|", $request->categoryID[$i]);

            $RP->user_id    = Auth::user()->id;
            // $RP->invoiceID  = $lastRentID;
            $RP->companyID = $companyID;
            $RP->rentID    = $request->rent_id;
            $RP->customerId  = $request->customerID;
            $RP->serialID   = $request->serial[$i];
            // $RP->hsn    = $data->hsn;
            $RP->categoryID   = $val[1];
            $RP->brandID      = $val[2];
            $RP->productID    = $val[3];
            // $RP->description   = $data->description;
            $RP->rent_month    = $request->rent_month;
            $RP->dayweekmonth  = $request->dayweekmonth;
            $RP->rent_price    = $request->rent_price[$i] * $request->rent_month;
            $RP->rent_date  = $request->rent_date;
            // $RP->receive_date   =
            // $RP->rentdescription  = $data->rentdescription;
            $RP->created_by  = Auth::user()->id;
            $RP->save();

            $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('serial', $request->serial[$i])->where('stock', '1')->where('type', '0')->first();
            if ($update) {
               $update->stock = '0';
               $update->type = '2';
               $update->save();
            } else {
               $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('serial', null)->where('stock', '1')->where('type', '0')->first();
               if ($update) {
                  $update->serial =  $request->serial[$i];
                  $update->stock = '0';
                  $update->type = '2';
                  $update->save();
               } else {
                  $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('stock', '1')->where('type', '0')->first();
                  $update->serial =  $request->serial[$i];
                  $update->stock = '0';
                  $update->type = '2';
                  $update->save();
               }
            }
         }
      }

      if ($request->removeid != null) {
         // dd($request->removeid);
         $delete_id =  count($request->removeid);
         //  dd($request->removeid);
         for ($i = 0; $i < $delete_id; $i++) {

            $remove_ietm = rental_product::find($request->removeid[$i]);

            $update = purchase::where('categoryID', $remove_ietm->categoryID)->where('brandID', $remove_ietm->brandID)->where('productID', $remove_ietm->productID)->where('serial', $remove_ietm->serialID)->where('stock', '0')->where('type', '2')->first();
            if ($update) {
               $update->stock = '1';
               $update->type = '0';
               $update->save();
            }
            rental_product::find($request->removeid[$i])->delete();
         }
      }


      return redirect()->back()->with('msg', 'Rental Updated Successfully');
   }


   public function edit_payment($id)
   {
      // ['user_id', Auth::user()->id], [

      $data = rent_invoice::where([['user_id', Auth::user()->id], ['rentalID', $id]])->first();
      $pay_data = payment_history::where('rentID', $id)->get();
      // dd($pay_data);
      $customer = customer::find($data->customerID);
      // dd($data);

      $ii = payment_history::all();


      return view('rental.payment', ['data' => $data, 'pay_data' => $pay_data, 'customer' => $customer]);
   }

   public function update_payment(Request $request)
   {

      $companyID = $this->getcompany();
      $company = company::find($companyID);

      // $rental_pay =  payment_history::where([['user_id', Auth::user()->id], ['rentID', $request->id]])->get();
      $advance = $request->advance - $request->collected;
      $balance = $request->amount - $request->balance;
      $rental_pay = new payment_history;
      $rental_pay->user_id  = Auth::user()->id;
      $rental_pay->companyID  = $companyID;
      $rental_pay->rentID  = $request->rentID;
      $rental_pay->amount  = $request->amount;
      $rental_pay->collected  = $request->collected;
      $rental_pay->balance  = $balance;
      $rental_pay->paymentDate  = $request->paymentDate;
      $rental_pay->created_by  = Auth::user()->id;
      $rental_pay->save();
      $id = $rental_pay->rentID;

      if ($request->balance == 0) {
         $rentidupdate = rent_invoice::where('rentalID', $request->rentID)->update([
            'collected' => $request->collected,
            'balance' => $balance,
            'complete_status' => 1
         ]);
      } else {
         $rentidupdate = rent_invoice::where('rentalID', $request->rentID)->update([
            'collected' => $request->collected,
            'balance' => $balance,
            'advamt' => $advance,

         ]);
      }
      return redirect()->route('rental.rental_agreement')->with('msg', 'Payment Updated Successfully');
   }

   public function rental_delete(Request $request)
   {

      $rp = rental_product::where('rentID', $request->id)->get();
      $count = count($rp);
      for ($i = 0; $i < $count; $i++) {

         $remove_ietm = rental_product::find($rp[$i]->id);

         $update = purchase::where('categoryID', $remove_ietm->categoryID)->where('brandID', $remove_ietm->brandID)->where('productID', $remove_ietm->productID)->where('serial', $remove_ietm->serial)->where('stock', '0')->where('type', '2')->first();
         if ($update) {
            $update->stock = '1';
            $update->type = '0';
            $update->save();
         }
      }

      $ri = rent_invoice::where('rentalID', $request->id)->delete();
      $r_p = rental_product::where('rentID', $request->id)->delete();
      return redirect()->back()->with('msg', 'Record Deleted Successfully');
   }

   public function rental_agreement()
   {


      $companyID = $this->getcompany();
      $company = company::find($companyID);


      $data = DB::table('rent_agreement')
         ->leftJoin('companies', 'rent_agreement.companyID', '=', 'companies.id')
         ->leftJoin('customers', 'rent_agreement.customerID', '=', 'customers.id')
         // ->where('rent_agreement.complete_status', '1')
         ->where('rent_agreement.companyID', $companyID)
         ->where('rent_agreement.active', '1')
         ->select('rent_agreement.*', 'rent_agreement.id AS r_id', 'rent_agreement.tax AS taxpercentage', 'rent_agreement.created_at AS time', 'customers.*', 'companies.*')
         ->groupBy('rent_agreement.rentalID')
         ->orderBy('rent_agreement.id', 'DESC')
         ->get(); // joining the rent_agreement tabe
      return view('rental.rentalagreement', ['data' => $data]);
   }

   public function agreement($id)
   {
      $data = DB::table('rent_agreement')
         ->leftJoin('companies', 'rent_agreement.companyID', '=', 'companies.id')
         ->leftJoin('customers', 'rent_agreement.customerID', '=', 'customers.id')
         ->leftJoin('deposit','deposit.customer_id','=','rent_agreement.customerID')
         ->where('rent_agreement.id', $id)
         // ->where('rent_agreement.active', 1)
         ->select('deposit.amount as deposit_amount','rent_agreement.*', 'rent_agreement.id AS r_id', 'rent_agreement.created_at AS time', 'customers.*', 'companies.*')
         ->first(); // joining the rent_invoices tabe
      $products = DB::table('rental_products')
         ->leftJoin('products', 'rental_products.productID', '=', 'products.id')
         ->leftJoin('categories', 'rental_products.categoryID', '=', 'categories.id')
         ->leftJoin('brands', 'rental_products.brandID', '=', 'brands.id')
         ->where('rental_products.agreementID', $id)
         //  ->where('rent_invoices.active',1)
         ->select('rental_products.id as rp_id','rental_products.*', 'products.*', 'categories.*', 'brands.*')
         ->get();
      $terms = terms::find(5);

      // dd($products); 
      if (Auth::user()->role_id == '3' || $this->role_check(30)) {
         return view('rental.agreement', ['data' => $data, 'products' => $products, 'terms' => $terms]);
      } else {
         $msg = 'Cannot Access Page !';
         return redirect()->back()->with('msg', $msg);
      }
   }

   public function bill($id)
   {
      $data = DB::table('rent_invoices')
         ->leftJoin('companies as cp', 'rent_invoices.companyID', '=', 'cp.id')
         ->leftJoin('customers as c', 'rent_invoices.customerID', '=', 'c.id')
         ->where('rent_invoices.id', $id)
         ->select(
            'rent_invoices.*',
            'rent_invoices.tax AS taxpercentage',
            'rent_invoices.id AS r_id',
            'rent_invoices.created_at AS time',
            'c.*',
            'cp.*',
            'c.id AS c_id',
            'c.name AS c_name',
            'c.address_line1 AS c_address_line1',
            'c.address_line2 AS c_address_line2',
            'c.city AS c_city',
            'c.pincode AS c_pincode',
            'c.gst AS c_gst',
            'c.phone_number AS c_phone_number',
            'c.email AS c_email',

            'cp.id AS cp_id',
            'cp.address_line1 AS cp_address_line1',
            'cp.address_line2 AS cp_address_line2',
            'cp.city AS cp_city',
            'cp.pincode AS cp_pincode',
            'cp.gst AS cp_gst',
            'cp.phone_number AS cp_phone_number',
            'cp.email AS cp_email',
         )
         ->first(); // joining the rent_invoices tabe
      $products = DB::table('rental_products')
         ->leftJoin('products', 'rental_products.productID', '=', 'products.id')
         ->leftJoin('categories', 'rental_products.categoryID', '=', 'categories.id')
         ->leftJoin('brands', 'rental_products.brandID', '=', 'brands.id')
         ->leftJoin('rent_agreement', 'rental_products.agreementID', '=', 'rent_agreement.id')
         ->leftJoin('rent_invoices', 'rental_products.agreementID', '=', 'rent_invoices.agreementID')
         ->where('rent_invoices.id', $id)
         ->select('rental_products.id as rp_id', 'rental_products.*', 'products.*', 'categories.*', 'brands.*',  'rent_invoices.*')
         ->get();
      $terms = terms::find(6);
      return view('rental.bill', ['datas' => $data, 'product' => $products, 'terms' => $terms]);
   }

   public function meterial_recived($id)
   {

      $rp = rental_product::where('rentID', $id)->get();
      $count = count($rp);
      for ($i = 0; $i < $count; $i++) {

         $remove_ietm = rental_product::find($rp[$i]->id);

         $update = purchase::where('categoryID', $remove_ietm->categoryID)->where('brandID', $remove_ietm->brandID)->where('productID', $remove_ietm->productID)->where('serial', $remove_ietm->serial)->where('stock', '0')->where('type', '2')->first();
         if ($update) {
            $update->stock = '1';
            $update->type = '0';
            $update->save();
         }
      }

      rent_invoice::where('rentalID', $id)->update(['active' => '0']);
      rental_product::where('rentID', $id)->update(['active' => '0']);
      return redirect()->back()->with('msg', 'Meterial Recived');
   }

   public function edit_renuwal($id, $rentalid)
   {

      $p_data = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price', 'id')->where('active', '1')->where('sale', '0')->where('rental', '0')->get();
      // $p_data =product::all();
      $cdata = category::all();
      $bdata = brand::all();
      $bdata = company::all();
      $cdata = customer::all();
      $tax = tax::all();

      $data = DB::table('rent_invoices')
         ->leftJoin('companies', 'rent_invoices.companyID', '=', 'companies.id')
         ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
         ->where('rent_invoices.rentalID', $rentalid)
         ->select('rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.created_at AS time', 'customers.*', 'companies.*')
         ->first(); // joining the rent_invoices tabe

      $products = DB::table('rental_products')
         ->leftJoin('products', 'rental_products.productID', '=', 'products.id')
         ->leftJoin('categories', 'rental_products.categoryID', '=', 'categories.id')
         ->leftJoin('brands', 'rental_products.brandID', '=', 'brands.id')
         ->where('rental_products.rentID', $rentalid)
         ->select('rental_products.id as rp_id', 'rental_products.*', 'products.*', 'categories.*', 'brands.*')
         ->get();

      //  dd($products);

      return view('rental.renuwal', ['id' => $id, 'data' => $data, 'products' => $products, 'bdata' => $bdata, 'cdata' => $cdata, 'p_data' => $p_data,  'tax' => $tax]);
   }

   public function renuwal(Request $request)
   {
      $companyID = $this->getcompany();
      $company = company::find($companyID);

      $rent_i = rent_invoice::all();
      $rent_count = $rent_i->count();
      $rentcount_id = $rent_count + 1000;

      $nextid = DB::select("SHOW TABLE STATUS LIKE 'rent_invoices'");


      $dwm    = $request->dayweekmonth;

      if ($dwm == 'Day') {

         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . $request->rent_month . ' day';
         $close_date = date('y-m-d', strtotime($request->rent_date . $nosdwm));
         $alert_date = date('y-m-d', strtotime($close_date . ' -1 day'));
      } elseif ($dwm == 'Week') {

         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . $request->rent_month . ' week';
         $close_date = date('y-m-d', strtotime($request->rent_date . $nosdwm));
         $alert_date = date('y-m-d', strtotime($close_date . ' -1 day'));
      } else {

         $rentdate    = date('Y-m-d', strtotime($request->rent_date));
         $nosdwm    = '+' . $request->rent_month . ' month';
         $close_date = date('y-m-d', strtotime($request->rent_date . $nosdwm));
         $alert_date = date('y-m-d', strtotime($close_date . ' -1 day'));
      }

      // dd($request->all());

      $input =  rent_invoice::where('rentalID', $request->rent_id)->first();
      // dd($input);
      $old_total = $input->total_amount;
      $old_coll = $input->collected;
      $old_bal = $input->balance;
      $new_total = $input->total_amount + $request->total_amount;
      $new_balance = $old_bal + $request->balance;
      $input->user_id = Auth::user()->id;
      $input->companyID = $companyID;

      $input->customerID =  $request->customerID;
      $input->renewal_date =  $request->rent_date;
      $input->day_week_month =  $request->dayweekmonth;
      $input->nos_day_week_month =  $request->rent_month;

      $input->taxable_amount = $request->taxable_amount;
      $input->discount = $request->discount;
      $input->delivery = $request->delivery;
      $input->others = $request->others;
      $input->tax = $request->taxtype;
      $input->tax_amt = $request->tax;
      $input->total_amount = $new_total;
      $input->collected = $request->total_amount;
      $input->balance = $old_bal;
      $input->alert_date = $alert_date;
      $input->terms =  $request->terms;
      $input->created_by = Auth::user()->id;
      $input->save();

      $productlist = count($request->id);

      for ($i = 0; $i < $productlist; $i++) {

         if ($request->id[$i] != null) {

            $RP = rental_product::where([['id', $request->id[$i]], ['rentID', $request->rent_id]])->first();

            $RP->customerId  = $request->customerID;
            $RP->rent_month    = $request->rent_month;
            $RP->dayweekmonth  = $request->dayweekmonth;
            $RP->rent_price    = $request->rent_price[$i] * $request->rent_month;
            $RP->rent_date  = $request->rent_date;
            $RP->save();
         } else {
            $RP = new rental_product;
            $val = explode("|", $request->categoryID[$i]);

            $RP->user_id    = Auth::user()->id;
            // $RP->invoiceID  = $lastRentID;
            $RP->companyID = $companyID;
            $RP->rentID    = $request->rent_id;
            $RP->customerId  = $request->customerID;
            $RP->serialID   = $request->serial[$i];
            // $RP->hsn    = $data->hsn;
            $RP->categoryID   = $val[1];
            $RP->brandID      = $val[2];
            $RP->productID    = $val[3];
            // $RP->description   = $data->description;
            $RP->rent_month    = $request->rent_month;
            $RP->dayweekmonth  = $request->dayweekmonth;
            $RP->rent_price    = $request->rent_price[$i] * $request->rent_month;
            $RP->rent_date  = $request->rent_date;
            // $RP->receive_date   =
            // $RP->rentdescription  = $data->rentdescription;
            $RP->created_by  = Auth::user()->id;
            $RP->save();

            $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('serial', $request->serial[$i])->where('stock', '1')->where('type', '0')->first();
            if ($update) {
               $update->stock = '0';
               $update->type = '2';
               $update->save();
            } else {
               $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('serial', null)->where('stock', '1')->where('type', '0')->first();
               if ($update) {
                  $update->serial =  $request->serial[$i];
                  $update->stock = '0';
                  $update->type = '2';
                  $update->save();
               } else {
                  $update = purchase::where('categoryID', $val[1])->where('brandID', $val[2])->where('productID', $val[3])->where('stock', '1')->where('type', '0')->first();
                  $update->serial =  $request->serial[$i];
                  $update->stock = '0';
                  $update->type = '2';
                  $update->save();
               }
            }
         }
      }

      if ($request->removeid != null) {
         // dd($request->removeid);
         $delete_id =  count($request->removeid);
         //  dd($request->removeid);
         for ($i = 0; $i < $delete_id; $i++) {

            $remove_ietm = rental_product::find($request->removeid[$i]);

            $update = purchase::where('categoryID', $remove_ietm->categoryID)->where('brandID', $remove_ietm->brandID)->where('productID', $remove_ietm->productID)->where('serial', $remove_ietm->serialID)->where('stock', '0')->where('type', '2')->first();
            if ($update) {
               $update->stock = '1';
               $update->type = '0';
               $update->save();
            }
            rental_product::find($request->removeid[$i])->delete();
         }
      }

      $today = date('Y-m-d');

      $rental_pay = new payment_history;
      $rental_pay->user_id  = Auth::user()->id;
      $rental_pay->companyID  = $companyID;
      $rental_pay->rentID  = $request->rent_id;
      $rental_pay->amount  = $request->total_amount;
      $rental_pay->collected  = $request->total_amount;
      $rental_pay->balance  = 0;
      $rental_pay->paymentDate  = $today;
      $rental_pay->created_by  = Auth::user()->id;
      $rental_pay->save();

      return redirect()->back()->with('msg', 'Renuwal Updated Successfully');






      // $companyID = $this->getcompany();
      // $company = company::find($companyID);


      // $dwm    = $request->dayweekmonth;

      //       if($dwm == 'Day'){

      //          $renewal_date    = date('Y-m-d', strtotime($request->renewal_date));
      //          $nosdwm    = '+'.$request->rent_month.' day';
      //          $close_date = date('y-m-d', strtotime($request->renewal_date. $nosdwm));
      //          $alert_date = date('y-m-d', strtotime($close_date. ' -1 day'));
      //       }elseif($dwm == 'Weeek'){

      //          $renewal_date    = date('Y-m-d', strtotime($request->renewal_date));
      //          $nosdwm    = '+'.$request->rent_month.' week';
      //          $close_date = date('y-m-d', strtotime($request->renewal_date. $nosdwm));
      //          $alert_date = date('y-m-d', strtotime($close_date. ' -1 day'));

      //       }else{

      //          $renewal_date    = date('Y-m-d', strtotime($request->renewal_date));
      //          $nosdwm    = '+'.$request->rent_month.' month';
      //          $close_date = date('y-m-d', strtotime($request->renewal_date. $nosdwm));
      //          $alert_date = date('y-m-d', strtotime($close_date. ' -1 day'));
      //       }

      //    $ri = rent_invoice::where('rentalID', $request->invoice_id)->first();
      //       $ri->renewal_date= $request->renewal_date;
      //       $ri->nos_day_week_month =  $request->rent_month;
      //       $ri->alert_date = $alert_date;
      //       $ri->save();

      //       $today = date('Y-m-d');

      //    $rental_pay = new payment_history;
      //    $rental_pay->user_id  = Auth::user()->id;
      //    $rental_pay->companyID  = $companyID;
      //    $rental_pay->rentID  = $request->invoice_id;
      //    $rental_pay->amount  = $ri->total_amount;
      //    $rental_pay->collected  = $ri->total_amount;
      //    $rental_pay->balance  = 0;
      //    $rental_pay->paymentDate  = $today;
      //    $rental_pay->created_by  = Auth::user()->id;
      //    $rental_pay->save();

      // return redirect()->back()->with('msg', 'Renuwal Successfully');

   }

   public function attached_mail($id)
   {


      $companyID = $this->getcompany();

      $company = company::find($companyID);
      // dd($company->email);
      $data = DB::table('rent_invoices')
         ->leftJoin('companies', 'rent_invoices.companyID', '=', 'companies.id')
         ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
         ->where('rent_invoices.rentalID', $id)
         ->select('rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.created_at AS time', 'customers.*', 'companies.*')
         ->first(); // joining the rent_invoices tabe



      $products = DB::table('rental_products')
         ->leftJoin('products', 'rental_products.productID', '=', 'products.id')
         ->leftJoin('categories', 'rental_products.categoryID', '=', 'categories.id')
         ->leftJoin('brands', 'rental_products.brandID', '=', 'brands.id')
         ->where('rental_products.rentID', $id)
         ->select('rental_products.id as rp_id', 'products.*', 'categories.*', 'brands.*')
         ->get();
      $terms = terms::find(5);

      $ri = rent_invoice::where('rentalID', $id)->get();
      $r_p = rental_product::where('rentID', $id)->get();

      // $pdf = PDF::loadView('rental.agreement', compact('data', 'products', 'terms'));
      // $pdf->setPaper('A4', 'portrait');
      // $agreement = public_path('invoice/'.$id.'_agreement.pdf');
      // $pdf->save($agreement);

      $info = array(
         'name' => $company->company
      );

      Mail::send('mail', $info, function ($message) {
         $message->to('manoj@alphasoftz.in', 'test')
            ->subject('Rental Agreement & Bill');
         $message->attach('file:///home/aztry007/Documents/invoice.pdf');
         //  $message->attach();
         $message->from('info@teamworksystem.com', 'Alex');
      });
      return redirect()->back()->with('msg', 'Mail Send Successfully');
   }

   public function rent_renewal()
   {
      //   if(isset($_GET['id'])){
      //    $date =$_GET['id'];
      //   }else{
      //    $date=date('Y-m-d');
      //   }
      $data = DB::table('rent_invoices')
         ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
         ->where('rent_invoices.payment_status', 1)
         ->where('rent_invoices.active', 1)
         ->where('rent_invoices.complete_status', 0)
         ->where('rent_invoices.renewal_status', 0)
         // ->where('rent_invoices.renewal_date',)
         ->where('rent_invoices.companyID', Auth::user()->companyID)
         ->select('rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.tax AS taxpercentage', 'rent_invoices.created_at AS time', 'customers.*',)
         ->orderBy('rent_invoices.id', 'DESC')
         ->get(); // joining the rent_invoices tabe
      // dd($data);
      if (Auth::user()->role_id == '3' || $this->role_check(32)) {
         return view('rental.viewrenewal', compact('data'));
      } else {
         $msg = 'Cannot Access Page !';
         return redirect()->back()->with('msg', $msg);
      }
      
   }

   public function renewal_issue()
   {
      // if(isset($_GET['id'])){
      //    $date =$_GET['id'];
      //   }else{
      //    $date=date('Y-m-d');
      //   }
      $data = DB::table('rent_agreement')
         ->leftJoin('customers', 'rent_agreement.customerID', '=', 'customers.id')
         ->where('rent_agreement.active', 1)
         ->where('rent_agreement.renewal_status', 0)
         // ->where('rent_agreement.complete_status',0)
         ->where('rent_agreement.companyID', Auth::user()->companyID)
         ->select('rent_agreement.*', 'rent_agreement.id AS r_id', 'rent_agreement.tax AS taxpercentage', 'rent_agreement.created_at AS time', 'customers.*',)
         ->orderBy('rent_agreement.id', 'DESC')
         ->get(); // joining the rent_agreement tabe
         if (Auth::user()->role_id == '3' || $this->role_check(33)) {
            return view('rental.issue', compact('data'));
         } else {
            $msg = 'Cannot Access Page !';
            return redirect()->back()->with('msg', $msg);
         }
     
   }
   public function issue(Request $request)
   {
      // dd($request->all());
      $id = $request->id;
      // dd($request->all());

      if ($request->deposit_satus == null) {
         // dd('no');
         $id = $request->id;
         $last_agreement = rent_agreement::where('id', $id)->first();
         // dd($last_agreement);
         // $invoiceID = $last_invoice->rentalID;
         //  dd('ok');
         $rp = rental_product::where('agreementID', $id)->get();
         // dd($rp);
         $count = count($rp);
         for ($i = 0; $i < $count; $i++) {
            $remove_ietm = rental_product::find($rp[$i]->id);
            // dd($remove_ietm);
            $update = purchase::where('categoryID', $remove_ietm->categoryID)->where('brandID', $remove_ietm->brandID)->where('productID', $remove_ietm->productID)->where('serial', $remove_ietm->serialID)->where('stock', '0')->where('type', '2')->first();
            if ($update) {
               $update->stock = '1';
               $update->type = '0';
               $update->save();
            }
         }
         rent_agreement::where('id', $id)->update(['active' => '0']);
         rental_product::where('rentID', $id)->update(['active' => '0']);
         // return redirect()->back()->with('msg','Meterial Recived');
         if ($request->deposit > 0) {

            $update = rent_agreement::where('rent_agreement.id', $id)
               ->leftjoin('customers', 'customers.id', '=', 'rent_invoices.customerID')
               ->leftjoin('deposit', 'deposit.customer_id', '=', 'rent_invoices.customerID')
               ->first();
            $deposit = deposit::where('customer_id', $last_agreement->customerID)->first();
            $deposit->amount = '0';
            $deposit->save();
            $pdf = PDF::loadView('rental.voucher', compact('update'));
            $pdf->setPaper('A4', 'portrait');
            $name = $update->name . '.pdf';
            return $pdf->download($name, compact('update'));
         }
         return redirect()->route('rental.rental_view')->with('msg', 'Material Received Successfully');
      } else {
         $close_agreement = rent_agreement::where('id', $request->id)->first();
         $close__agree_date = $close_agreement->receive_date;
         //   $close_agreement->active  =0;
         //   $close_agreement->save();
         $companyID = $this->getcompany();
         $dwm = $request->day_month_week;

         if ($dwm == 'Day') {

            $rentdate    = date('Y-m-d', strtotime($close__agree_date)); //start date
            $nosdwm    = '+' . ($request->nos_day_month_week-1) . ' day';

            $close_date = date('Y-m-d', strtotime($close__agree_date . $nosdwm));
            $renewal_date = date('Y-m-d', strtotime($rentdate . ' +1 day'));
         } elseif ($dwm == 'Week') {
            $rentdate    = date('Y-m-d', strtotime($close__agree_date));
            $nosdwm    = '+' . ($request->nos_day_month_week-1) . ' week';
            $close_date = date('Y-m-d', strtotime($close__agree_date . $nosdwm));
            $renewal_date = date('Y-m-d', strtotime($rentdate . ' +1 week'));
         } else {
            $rentdate    = date('Y-m-d', strtotime($close__agree_date));
            $nosdwm    = '+' . ($request->nos_day_month_week-1) . ' month';
            $close_date = date('Y-m-d', strtotime($close__agree_date . $nosdwm));
            $renewal_date = date('Y-m-d', strtotime($rentdate . '+1 month'));
         }
         $PO = rent_agreement::orderBy('id', 'desc')->where('companyID', Auth::user()->companyID)->first();
         if ($PO) {
            $rent_start_no = $PO->rent_start_no + 1;
         } else {
            $rent_start_no = 0;
         }
         if ($renewal_date == $close_date) {
            $complete = 1;
         } else {
            $complete = 0;
         }
         $agreement = new rent_agreement;
         $agreement->user_id = Auth::user()->id;
         $agreement->companyID = $companyID;
         $agreement->customerID =  $close_agreement->customerID;
         $agreement->rental_date =  $close__agree_date;
         $agreement->renewal_date =  $close__agree_date;
         $agreement->day_week_month =  $dwm;
         $agreement->nos_day_week_month =  $request->nos_day_month_week;
         $agreement->taxable_amount = $close_agreement->taxable_amount;
         $agreement->deposit = $close_agreement->deposit;
         $agreement->discount = $close_agreement->discount == null ? '0' : $close_agreement->discount;
         $agreement->delivery = $close_agreement->delivery == null ? '0' : $close_agreement->delivery;
         $agreement->others = $close_agreement->others == null ? '0' : $close_agreement->others;
         $agreement->tax = $close_agreement->taxtype;
         $agreement->tax_amt = $close_agreement->tax;
         $agreement->total_amount = $close_agreement->total_amount;
         $agreement->collected = $close_agreement->collected;
         $agreement->receive_date = $close_date;
         $agreement->balance = $close_agreement->balance;
         $agreement->renewal_date = $renewal_date;
         $agreement->terms =  $close_agreement->terms;
         $agreement->created_by = Auth::user()->id;
         $agreement->rent_start_no = $rent_start_no;
         $agreement->complete_status = $complete;
         $agreement->save();
         $agreementID = $agreement->id;

         $input = new rent_invoice;
         $input->user_id = Auth::user()->id;
         $input->companyID = $companyID;
         $input->customerID =  $request->customerID;
         $input->rental_date =  $close__agree_date;
         $input->renewal_date =  $renewal_date;
         $input->day_week_month =  $dwm;
         $input->nos_day_week_month =  $request->nos_day_month_week;
         $input->taxable_amount = $close_agreement->taxable_amount;
         $input->deposit = $close_agreement->deposit;
         $input->discount = $close_agreement->discount == null ? '0' : $close_agreement->discount;
         $input->delivery = $close_agreement->delivery == null ? '0' : $close_agreement->delivery;
         $input->others = $close_agreement->others == null ? '0' : $close_agreement->others;
         $input->tax = $close_agreement->taxtype;
         $input->tax_amt = $close_agreement->tax;
         $input->total_amount = $close_agreement->total_amount;
         $input->collected = $close_agreement->collected;
         $input->receive_date = $close_date;
         $input->balance = $close_agreement->balance;
         $input->terms =  $close_agreement->terms;
         $input->created_by = Auth::user()->id;
         $input->rent_start_no = $rent_start_no;
         $input->complete_status = $complete;
         $input->agreementID = $agreementID;
         $input->save();
         $invoiceID = $input->id;


         // $rentidupdate = rent_invoice::where('id', $input->id)->update(['rentalID'=>$company->prefix.$rentcount_id.$input->id]);
         $update = rent_invoice::where('id', $invoiceID)->first();
         $com = company::find(Auth::user()->companyID);
         if ($com->rental_status == '0') {
            // dd($com);
            $rentalID = $com->rental_prefix . ($com->rental_no + $update->rent_start_no);
         } else {
            $update->rent_start_no = 0;
            $rentalID = $com->rental_prefix . $com->rental_no;
            $com->rental_status = 0;
            $com->save();
         }
         $update->agreementID = $agreementID;
         $update->rentalID = $rentalID;
         $update->save();
         $agree = rent_agreement::where('id', $agreement->id)->first();
         $agree->rentalID = $rentalID;
         $agree->save();

         //customer deposit
         $alreay_exist = deposit::where('customer_id', $close_agreement->customerID)->first();

         if ($alreay_exist) {
            $amount = deposit::where('customer_id', $close_agreement->customerID)->first();
            $customeramount = $amount->amount;
            $alreay_exist->amount = $customeramount + $close_agreement->deposit;
            $alreay_exist->save();
         } else {
            deposit::create([
               'customer_id' => $close_agreement->customerID,
               'amount' => $close_agreement->deposit,
            ]);
         }
         $rental_product = rental_product::where('agreementID', $close_agreement->id)->get();
         $productlist = count($rental_product);
         //deposit

         for ($i = 0; $i < $productlist; $i++) {

            $RP = new rental_product;

            $RP->user_id    = Auth::user()->id;
            $RP->invoiceID  = $rentalID;
            $RP->companyID = $companyID;
            $RP->agreementID    = $agreementID;
            $RP->customerId  = $request->customerID;
            $RP->serialID   = $rental_product[$i]->serialID;
            // $RP->hsn    = $data->hsn;
            $RP->categoryID   = $rental_product[$i]->categoryID;
            $RP->brandID      = $rental_product[$i]->brandID;
            $RP->productID    = $rental_product[$i]->productID;
            // $RP->description   = $data->description;
            $RP->rent_month    = $rental_product[$i]->rent_month;
            $RP->dayweekmonth  = $rental_product[$i]->dayweekmonth;
            $RP->rent_price    = $rental_product[$i]->rent_price;
            $RP->rent_date  = $rental_product[$i]->rent_date;
            // $RP->receive_date   =
            // $RP->rentdescription  = $data->rentdescription;
            $RP->created_by  = Auth::user()->id;
            $RP->save();
         }
         $update  =  rental_product::where('agreementID', $close_agreement->id)->update(['active' => 0]);
         $old_agreement = rent_agreement::where('id', $close_agreement->id)->update(['active' => 0]);
         if ($old_agreement) {
            return redirect()->route('rental.rental_view')->with('msg', 'Rental Added Successfully');
         }
      }
   }
}
