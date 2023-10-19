<?php

namespace App\Http\Controllers;

use PDF;
use DateTime;
use App\Models\tax;
use App\Models\lead;
use App\Models\terms;
use App\Models\company;
use App\Models\customer;
use App\Models\employee;
use App\Models\purchase;
use App\Models\AcceptJob;
use App\Models\tax_purchase;
use Illuminate\Http\Request;

use App\Models\manual_product;
use App\Models\purchase_order;

use App\Http\Traits\LeadLogTrait;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;


class ServiceController extends Controller
{
   use LeadLogTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Service()
    {
        return view('service.add-service');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Servicelist(){
        // $leads=lead::orderBy('id', 'DESC')->where('companyID',Auth::user()->companyID)->get();
        // // dd($leads);
        // $employee = employee::get();
//   $purchase = purchase_order::where('active', '1')->where('tax', '!=', '0')->where('companyID', '!=', 3)->orderBy('id', 'DESC')->get();
        $id = isset($_GET['companyID']) ? $_GET['companyID'] : '';
        // dd($id);
        // dd($this->getcompany());
        if ($id == '1') {
            $purchase = purchase_order::where('active', '1')->where('tax', '1')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->where('status','2')->get();
        } elseif ($id == '2') {
            $purchase = purchase_order::where('active', '1')->where('tax', '0')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->where('status','2')->get();
        } else {
            $purchase = purchase_order::where('active', '1')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->where('status','2')->get();
        }
        if(Auth::user()->role_id =='3' || $this->role_check(39)){
            return view('service.serice_list',compact('purchase','id'));
            }else{
              $msg='Cannot Access Page !';
               return redirect()->back()->with('msg', $msg);
            }
                  
    }
    public function index(){
          
    }
    public function products($id){
        $leads=lead::select('customers.name','leads.*','source_master.source_name','referer_master.referrer_name','categories.category_name')
        ->leftjoin('customers','customers.id','=','leads.customer_id')
        ->leftjoin('source_master','source_master.id','=','leads.source_id')
        ->leftjoin('referer_master','referer_master.id','=','leads.referer_id')
        ->leftjoin('categories','categories.id','=','leads.category_id')
        ->where('leads.id',$id)
        
        ->orderBy('leads.id', 'DESC')->where('leads.companyID',Auth::user()->companyID)->get();
        // dd($leads);

        return view('service.product',compact('leads'));

    }

    public function joboreder(){
        $now = new DateTime();
        $leads=lead::select('customers.name','leads.*','source_master.source_name','referer_master.referrer_name','categories.category_name')
        ->leftjoin('customers','customers.id','=','leads.customer_id')
        ->leftjoin('source_master','source_master.id','=','leads.source_id')
        ->leftjoin('referer_master','referer_master.id','=','leads.referer_id')
        ->leftjoin('categories','categories.id','=','leads.category_id')
        ->where('leads.employee_id',Auth::user()->id)
        ->where('leads.status','!=',3)
        ->orderBy('leads.id', 'DESC')->where('leads.companyID',Auth::user()->companyID)->get();
        if(Auth::user()->role_id =='3' || $this->role_check(38)){
            return view('service.job',compact('leads'));
            }else{
              $msg='Cannot Access Page !';
               return redirect()->back()->with('msg', $msg);
            }
      

    }
    public function jobaccept(Request $request){
        
        $insertArr = array(
            "employee_id" => Auth::user()->id,
            "lead_id" => $request->id,
            "status" => 'Accept'
        );
        
        $lead = lead::where('id', $request->id)->where('is_accept', '0')->first();
        $lead->is_accept = '1';
        $lead->status=2;
        if ($lead->save()) {
            $accept = AcceptJob::create($insertArr);
            if ($accept) {
             return response()->json(['success' => '1', 'date' => $accept->id]);
            }else{
             return response()->json(['success' => '0', 'date' => $accept->id]);

            }
        }
    }
    public function jobproduct($id){
        $lead=lead::where('id',$id)->first('customer_id');
        $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price')->where('active', '1')->where('stock', '1')->where('type', '0')->where('companyID',Auth::user()->companyID)->get();
        $terms = terms::all();
        $branch = company::where('active', 1)->get();
        $customer = customer::select('name')->where('id',$lead->customer_id)->first();
        
        $tax = tax::first();
        // dd($tax);
        // dd($datatable);
        // $manual_products = manual_product::all();
        if(Auth::user()->role_id =='3' || $this->role_check(29)){
            return view('service.jobservice', ['modal' => $modal, 'terms' => $terms, 'branch' => $branch, 'customer' => $customer, 'tax' => $tax]);
               }else{
                 $msg='Cannot Access Page !';
                  return redirect()->back()->with('msg', $msg);
               }
        // return view('jobservice');
    }
    public function add_service(){
        // $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price')->where('active', '1')->where('stock', '1')->where('type', '0')->get();
        // $terms = terms::all();
        // $branch = company::where('active', 1)->get();
        $customer = customer::get();
        // $company_tax = company::where('id', Auth::user()->companyID)->first();

        // $tax = tax::first();

       if(Auth::user()->role =='3' || $this->role_check(40)){
         return view('service.add-services',compact('customer'));
        }else{
       $msg='Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
        }
    }
    public function final_invoice(Request $request)
    {
        // dd($request->all());
        // $request->validate(
        //     [
        //         'customer' => 'required',
        //     ]
        // );
        // dd($request->all());
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
        // $tax_amount = $request->tax_amount;
        $today = date('Y-m-d');
        $balance = $grand_total - $collected_total;
        // dd($request->all());
        $PO = purchase_order::orderBy('id','desc')->where('companyID',Auth::user()->companyID)->where('status','2')->first();
        if($PO){
        $lead_start_no= $PO->lead_start_no+1;
        }else{
            $lead_start_no=0;
        }
        $tax_amount=0;
        if($tax =='1'){
            foreach($request->price as $val){
                 $tax_amount+=($val*18/100);
            }
            
        }
// dd($tax_amount);
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
            'delivery' => 0,
            'others' => 0,
            'balance' => $balance,
            'mop' => $mop,
            'reference' => $reference,
            'terms' => $terms,
            'customerID' => $customer,
            'status'=>'2',//Service
            'lead_start_no'=>$lead_start_no,
        ]);
        $lastIDsaleinvoice = $purchase_order->id;

        // $Sinvoice = $prefix . $no . $lastIDsaleinvoice;
        // dd($invoice);
        $update = purchase_order::where('id', $lastIDsaleinvoice)->where('status','2')->first();
        $com = company::find(Auth::user()->companyID);
        
        if($com->lead_status =='0'){
           
            $update->invoiceID=$com->lead_prefix.($com->lead_no+$update->lead_start_no);
        }else{    
            $update->lead_start_no=0;
            $update->invoiceID=$com->lead_prefix.$com->lead_no;
          $com->lead_status=0;
          $com->save();      
        }
        // $update->invoiceID = $Sinvoice;
        $update->save();
        for ($i = 0; $i < count($request->order); $i++) {
            $check = explode('-', $request->order[$i]);
            // dd($check);
            if ($check[1] == 'stock') {

                $stock = explode('|', $check[0]);
                // dd($stock);
                $stock_details = purchase::where('categoryID', $stock[0])->where('brandID', $stock[1])->where('productID', $stock[2])->where('selling_price', $stock[3])->where('stock', '1')->where('type', '0')->first();
                // dd($stock_details);
                $tax_per=0;
                $tax_per_amount=0;
                if($tax  =='1'){
                 $tax_per=18;
                 $tax_per_amount=$request->price[$i]*$tax_per/100;
                }
                tax_purchase::create([
                    'companyID' => $branch,
                    'user_id' => Auth::user()->id,
                    'category' => $stock_details->categoryID,
                    'brand' => $stock_details->brandID,
                    'product' => $stock_details->productID,
                    'invoice_number' => $lastIDsaleinvoice,
                    'price' => $request->price[$i],
                    'tax_per' => $tax_per,
                    'tax_per_amount' => $tax_per_amount,
                    'quantity' => '1',
                    'stock_status' => '1'
                ]);
                $update = purchase::where('categoryID', $stock[0])
                ->where('brandID', $stock[1])
                ->where('productID', $stock[2])
                ->where('selling_price', $stock[3])
                ->where('stock', '1')
                ->where('type', '0')
                ->first();
                if ($update) {
                    $update->stock = '0';
                    $update->type = '1';
                    $update->save();
                }
            } else {
                tax_purchase::create([
                    'companyID' => $branch,
                    'user_id' => Auth::user()->id,
                    'product' => $check[0],
                    'invoice_number' => $lastIDsaleinvoice,
                    'price' => $request->price[$i],
                    'tax_per' => $request->tax_per[$i],
                    'tax_per_amount' => $request->tax_per_amount[$i],
                    'quantity' => '1',
                    'stock_status' => '0'

                ]);
            }
        }
        $purchase_details = purchase_order::where('id', $lastIDsaleinvoice)->first();
        // dd($purchase_details);
        $tax_details=tax_purchase::
        leftjoin('purchase_orders','purchase_orders.id','=','tax_purchases.invoice_number')
        ->select('tax_purchases.tax_per',DB::raw('sum(tax_purchases.price) as price'),DB::raw('sum(tax_purchases.tax_per_amount) as tax_per_amount'),'purchase_orders.taxable_price','purchase_orders.grand_total')
        ->where('tax_purchases.invoice_number',$lastIDsaleinvoice)
        ->groupBy('tax_purchases.tax_per')->get();
        $customer = $purchase_details->customerID;
        $customer_list = customer::where('id', $customer)->first();
        $customer = explode(" ", $customer_list->name);
        if ($purchase_details) {
            $pdf = PDF::loadView('sale.invoice', compact('purchase_details','tax_details'));
            $pdf->setPaper('A4', 'portrait');
            $filePath = public_path('invoice/' .  $purchase_details->invoiceID . '.pdf');
            $pdf->save($filePath);
            $purchase_details->invoice_path = URL::to('/') . '/invoice/' . $purchase_details->invoiceID. '.pdf';
            $purchase_details->save();
            return redirect()->route('sale.invoice')->with('msg', 'Services Added Successfully');
        }

        //dd($pdf);
    }

    
}
