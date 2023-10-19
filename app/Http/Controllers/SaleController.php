<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\tax;
use App\Models\brand;
use App\Models\terms;
use App\Models\branch;
use App\Models\company;
use App\Models\Payment;
use App\Models\product;
use App\Models\category;
use App\Models\customer;
use App\Models\purchase;
use App\Models\sale_invoice;

use App\Models\sale_payment;
use App\Models\tax_purchase;



use Illuminate\Http\Request;
use App\Models\invoice_number;
use App\Models\manual_product;
use App\Models\purchase_order;
use App\Models\payment_history;
use App\Http\Traits\LeadLogTrait;
use Illuminate\Support\Facades\DB;
use App\Models\purchase_order_temp;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;


class SaleController extends Controller
{
    use LeadLogTrait;
    public function index()
    {
        $customer=customer::get();
        $tax=tax::get();
        if (Auth::user()->role == '3' || $this->role_check(29)) {
            return view('sale.sale',compact('customer','tax'));
        } else {
            $msg = 'Cannot Access Page !';
            return redirect()->back()->with('msg', $msg);
        }
    }
    public function get_serial(Request $request){
       if($request->id =='1'){
      $serial = purchase::select('serial')->where('id',$request->id)->first();
      return response()->json(['success' => '1','data'=>$serial]);

       }
    }
    public function final_invoice(Request $request)
    {
        dd($request->all());
        $request->validate(
            [
                'customer' => 'required',
            ]
        );
        $branch = Auth::user()->companyID;
        $customer = $request->customer;
        $tax_price = $request->tax_price;
        $discount = $request->discount;
        $tax = $request->tax;
        $grand_total = $request->grand_total;
        $collected_total = 0;
        $delivery = $request->delivery;
        $others = $request->others;
        $mop = $request->mop;
        $reference = $request->reference;
        $terms = $request->terms;
        $tax_amount = $request->tax_amount;
        $today = date('Y-m-d');
        $balance = $grand_total - $collected_total;
        // dd($request->all());
        $PO = purchase_order::orderBy('id', 'desc')->where('companyID', Auth::user()->companyID)->where('status', '1')->first();
        if ($PO) {
            $sale_start_no = $PO->sale_start_no + 1;
        } else {
            $sale_start_no = 0;
        }
        $tax_amount=0;
        if(isset($request->cgst)){
            foreach($request->cgst as $val){
                $tax_amount+=$val;
            }
            foreach($request->sgst as $val){
                $tax_amount+=$val;
            }
        }

        // $prefix =$company->invoice_prefix;
        // $no=$company->invoice_no;
        // if ($tax == 1) {
        //     $prefix = $company->sale_gst_prefix;
        //     $no = $company->sale_gst_no;
        // } else {
        //     $prefix = $company->sale_not_gst_prefix;
        //     $no = $company->sale_not_gst_no;
        // }
        $purchase_order = purchase_order::create([
            'user_id' => Auth::user()->id,
            'companyID' => $branch,
            'taxable_price' => $tax_price,
            'discount' => $discount,
            'tax' => $tax,
            'tax_amount' => $tax_amount,
            'grand_total' => $grand_total,
            'collected' => $collected_total,
            'delivery' => $delivery,
            'others' => $others,
            'balance' => $balance,
            'mop' => $mop,
            'reference' => $reference,
            'terms' => $terms,
            'customerID' => $customer,
            'status' => '1', //sale
            'sale_start_no' => $sale_start_no,
        ]);
        $lastIDsaleinvoice = $purchase_order->id;

        $purchase_details = purchase_order::where('id', $lastIDsaleinvoice)->first();
        $tax_details=tax_purchase::
        leftjoin('purchase_orders','purchase_orders.id','=','tax_purchases.invoice_number')
        ->select('tax_purchases.tax_per',DB::raw('sum(tax_purchases.price) as price'),DB::raw('sum(tax_purchases.tax_per_amount) as tax_per_amount'),'purchase_orders.taxable_price','purchase_orders.grand_total')
        ->where('tax_purchases.invoice_number',$lastIDsaleinvoice)
        ->groupBy('tax_purchases.tax_per')->get();
        //   dd($tax_details);
        $customer = $purchase_details->customerID;
        $customer_list = customer::where('id', $customer)->first();
        $customer = explode(" ", $customer_list->name);
        if ($purchase_details) {
        $pdf = PDF::loadView('sale.invoice', compact('purchase_details','tax_details'));
        $pdf->setPaper('A4', 'portrait');
        $filePath = public_path('invoice/' .  $purchase_details->invoiceID . '.pdf');
        $pdf->save($filePath);
        $purchase_details->invoice_path = URL::to('/') . '/invoice/' .  $purchase_details->invoiceID. '.pdf';
        $purchase_details->save();
        return redirect()->route('sale.invoice')->with('msg', 'Sales Added Successfully');
        }

        //dd($pdf);
    }

    public function payment($id)
    {
        
        $view_data['invoice'] = purchase_order::where('id', $id)->first();
        $view_data['payment_history'] = payment_history::where('invoiceID', $id)->orderby('id', 'desc')->get();
        $view_data['payment']  =Payment::get();
        return view('sale.payment', $view_data);
    }
    public function payment_store(Request $request)
    {
       
        $request->validate([
            'balance' => 'required',
            'paymentDate' => 'required',
            'collected' => 'required',
        ]);
        $hand = $request->collected;
        $total = $request->advance + $request->collected;
        $balance = $request->amount - $total;
        $today = date('Y-m-d');
        $branch = $this->getcompany();

        $id = payment_history::create([
            'companyID' => $branch,
            'user_id' => Auth::user()->id,
            'invoiceID' => $request->invoiceID,
            'rentID' => $request->rentID,
            'amount' => $request->amount,
            'collected' => $request->collected,
            'balance' => $balance,
            'paymentDate' => $request->paymentDate,
            'mop'=>$request->mop,
            'remarks'=>$request->remarks,
            'status' => 2,  //sale

        ]);
        $company = company::where('id', $branch)->first();
        $prefix = 'R';
        $payment = $id->id;
        $invoice = $prefix . '-' . (100+$payment);
        // dd($invoice);
        $update = payment_history::where('id', $payment)->first();
        $update->invoiceNo = $invoice;
        $update->save();

        $update_purchase_order = purchase_order::where('id', $request->invoiceID)->first();
        $update_purchase_order->collected = $total;
        $update_purchase_order->balance = $balance;
        $update_purchase_order->save();
        $purchase_details = purchase_order::where('id', $request->invoiceID)->first();
        $customer = $purchase_details->customerID;
        $customer_list = customer::where('id', $customer)->first();
        $customer = explode(" ", $customer_list->name);
        $tax_details=tax_purchase::
        leftjoin('purchase_orders','purchase_orders.id','=','tax_purchases.invoice_number')
        ->select('tax_purchases.tax_per',DB::raw('sum(tax_purchases.price) as price'),DB::raw('sum(tax_purchases.tax_per_amount) as tax_per_amount'),'purchase_orders.taxable_price','purchase_orders.grand_total')
        ->where('tax_purchases.invoice_number',$request->invoiceID)
        ->groupBy('tax_purchases.tax_per')->get();

            $pdf = PDF::loadView('sale.invoice', compact('purchase_details','tax_details'));
            $pdf->setPaper('A4', 'portrait');
            $filePath = public_path('invoice/' . $update_purchase_order->invoice . '.pdf');
            $pdf->save($filePath);
            $update_purchase_order->invoice_path = URL::to('/') . '/invoice/' . $update_purchase_order->invoice . '.pdf';
            $update_purchase_order->save();
                    //receipt
                   
            $history = payment_history::
            select('payment_histories.*','payment_mode.payment_mode')->
            leftjoin('payment_mode','payment_mode.id','=','payment_histories.mop')->
             where('payment_histories.id', $payment)
             ->where('payment_histories.status',2)
            ->first();
            $pdf = PDF::loadView('sale.ireceipt', compact('history', 'hand'));
            $pdf->setPaper('A4', 'portrait');
            $filePath = public_path('receipt/' . $invoice  . '.pdf');
            $pdf->save($filePath);
            $history->invoice_path = URL::to('/') . '/receipt/' . $invoice . '.pdf';
            $history->save();

        // if ($update_purchase_order) {
        if ($balance == 0) {
            return redirect()->route('sale.invoice')->with('msg', ' Update payment and Invoice Generate  Successfully');
        } else {
            return redirect()->route('sale.receipt')->with('msg', ' Update payment and Invoice Generate  Successfully');
        }
        // }
    }
    public function receipt()
    {
        $payment = payment_history::where('companyID', Auth::user()->companyID)
        ->get();
        return view('sale.ireceipt', compact('payment'));
    }
    public function getreceipt(Request $request)
    {
        $payment = payment_history::select('payment_histories.*', 'purchase_orders.invoiceID', 'purchase_orders.created_at as purchased_date', 'customers.name')->where('payment_histories.companyID', Auth::user()->companyID)
            ->leftjoin('purchase_orders', 'payment_histories.invoiceID', '=', 'purchase_orders.id')
            ->leftjoin('customers', 'purchase_orders.customerID', '=', 'customers.id')
            ->orderBy('payment_histories.id', 'desc')
            ->where('payment_histories.status',2)
            ->where('purchase_orders.companyID', Auth::user()->companyID)
            ->get();
        if (Auth::user()->role_id == '3' || $this->role_check(27)) {
            return view('sale.receipt', compact('payment'));
        } else {
            $msg = 'Cannot Access Page !';
            return redirect()->back()->with('msg', $msg);
        }
    }
    public function invoicelist()
    {
        //   $purchase = purchase_order::where('active', '1')->where('tax', '!=', '0')->where('companyID', '!=', 3)->orderBy('id', 'DESC')->get();
        $id = isset($_GET['companyID']) ? $_GET['companyID'] : '';
        // dd($id);
        // dd($this->getcompany());
        if ($id == '1') {
            $purchase = purchase_order::where('active', '1')->where('tax', '!=', '0')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->where('status','1')->get();
        } elseif ($id == '2') {
            $purchase = purchase_order::where('active', '1')->where('tax', '0')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->where('status','1')->get();
        } else {
            $purchase = purchase_order::where('active', '1')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->where('status','1')->get();
        }
        // dd($purchase);
        if (Auth::user()->role_id == '3' || $this->role_check(28)) {
            return view('sale.invoicelist', ['datatable' => $purchase, 'id' => $id]);
        } else {
            $msg = 'Cannot Access Page !';
            return redirect()->back()->with('msg', $msg);
        }
    }
    public function invoice($id)
    {
        // dd('ok');
        $purchase_details = purchase_order::where('id', $id)->first();
        if ($purchase_details) {
            $number = $purchase_details->grand_total;
            $no = floor($number);
            $point = round($number - $no, 2) * 100;
            $hundred = null;
            $digits_1 = strlen($no);
            $i = 0;
            $str = array();
            $words = array(
                '0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety'
            );
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str[] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                } else $str[] = null;
            }
            $str = array_reverse($str);
            $result = implode('', $str);
            $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
            $words_data  = $result . "Rupees  ";
            return view('sale.invoice', ['id' => $id, 'purchase_details' => $purchase_details, 'words' => $words_data]);
        }
    }
    public function print(Request $request, $id)
    {

        $purchase_details = sale_invoice::where('purchase_id', $id)->first();
        if ($purchase_details) {
            $number = $purchase_details->grand_total;
            $no = floor($number);



            $point = round($number - $no, 2) * 100;



            $hundred = null;



            $digits_1 = strlen($no);

            $i = 0;
            $str = array();
            $words = array(
                '0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety'
            );



            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');



            while ($i < $digits_1) {



                $divider = ($i == 2) ? 10 : 100;



                $number = floor($no % $divider);



                $no = floor($no / $divider);



                $i += ($divider == 10) ? 1 : 2;



                if ($number) {



                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;



                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;



                    $str[] = ($number < 21) ? $words[$number] .



                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                } else $str[] = null;
            }
            $str = array_reverse($str);
            $result = implode('', $str);
            $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
            $words_data  = $result . "Rupees  ";
            return view('sale.print_sale', ['id' => $id, 'purchase_details' => $purchase_details, 'words' => $words_data]);
        }
    }
    public function sale_delete(Request $request)
    {
        $data = $request->id;
        $delete = purchase_order_temp::find($request->id)->first();
        $update = purchase::where('serial', $delete->serial)->first();
        $update->stock = '1';
        $update->sale = '0';
        $update->save();
        $delete->delete();

        return response()->json(['success' => '1']);
    }
}
