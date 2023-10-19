<?php

namespace App\Http\Controllers;

use PDF;


use Mail;
use App\Models\tax;
use App\Models\brand;
use App\Models\terms;
use App\Models\company;
use App\Models\product;
use App\Models\category;
use App\Models\customer;
use App\Models\proforma;
use App\Models\purchase;
use App\Models\proforma_products;
use App\Models\rent_agreement;



use App\Models\quotation;


use App\Models\rent_invoice;

use App\Models\tax_purchase;
use Illuminate\Http\Request;

use App\Models\purchase_order;
use App\Models\rental_product;
use App\Http\Traits\LeadLogTrait;

use App\Models\quotation_product;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;

class QuotationController extends Controller
{
    use LeadLogTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showQuotation()
    {

        $companyID = $this->getcompany();
        $com = company::find($companyID);

        $product = DB::table('products')
            ->leftJoin('categories', 'products.categoryID', '=', 'products.id')
            ->leftJoin('brands', 'products.brandID', '=', 'products.id')
            ->select('products.*', 'products.id AS p_id', 'categories.*', 'brands.*')
            ->get();

        $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price', 'id')->where('active', '1')->where('stock', '1')->where('type', '0')->get();
        // dd($modal);
        $customer = customer::where('companyID', Auth::user()->companyID)->get();
        $tax = tax::all();
        if(Auth::user()->role_id =='3' || $this->role_check(37)){
           return view('quotation.add-quotaion', ['product' => $product, 'modal' => $modal, 'customer' => $customer,'tax'=>$tax]);

          }else{
            $msg='Cannot Access Page !';
             return redirect()->back()->with('msg', $msg);
          }
    }



    public function get_data(Request $request)
    {
        // $data['category'] = purchase::select('categories.category_name')->join("categories", "categories.id", "=", "purchases.categoryID")->where('categories.active', '1')->where('purchases.id', $request->id)->first();
        // $data['brand'] = purchase::select('brands.brand_name')->join("brands", "brands.id", "=", "purchases.brandID")->where('brands.active', '1')->where('purchases.id', $request->id)->first();
        // $data['product'] = purchase::select('products.productName', 'products.description', 'purchases.selling_price')->join("products", "products.id", "=", "purchases.productID")->where('products.active', '1')->where('purchases.id', $request->id)->first();
        $data = purchase::where('id', $request->id)->first();
        $product = product::find($data->productID);
        //    dd($product->description);
        return response()->json(['success' => '1', 'data' => $data, 'product' => $product]);
    }

    public function getmodal()
    {
        $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price', 'id')->where('active', '1')->where('stock', '1')->where('type', '0')->get();

        foreach ($modal as $val) {
            $category = category::where('id', $val->categoryID)->first();
            $product = product::where('id', $val->productID)->first();
            $brand = brand::where('id', $val->brandID)->first();
            $NumberOfStock = purchase::where('active', '1')->where('stock', '1')->where('type', '0')->where('categoryID', $val->categoryID)->where('brandID', $val->brandID)->where('productID', $val->productID)->where('selling_price', $val->selling_price)->where('companyID',Auth::user()->companyID)->get();

            $getNumberOfStock = $NumberOfStock->count();
            $array[] = array('id' => $val->id, 'cat' => $category->category_name, 'catid' => $category->id, 'brand' => $brand->brand_name, 'brandid' => $brand->id, 'product' => $product->productName, 'description' => $product->description, 'productid' => $product->id, 'count' => $getNumberOfStock);
        }
        // return $array;
        echo json_encode($array);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_tax(Request $request)
    {

        $data = customer::where('id', $request->id)->get();


        return response()->json(['success' => '1', 'data' => $data]);
    }
    public function store(Request $request)
    {
        // $request->validate([

        //     'tcmonth' => 'required',
        //     'customerID' => 'required',
        //     'categoryID.*' => 'required',
        //     'qty.*' => 'required',

        // ]);
        // dd($request->all());
        $companyID = $this->getcompany();
        $com = company::find($companyID);

        $q_i = quotation::all();
        $q_count = $q_i->count();
        $invoice = $q_count + 1000;

        $PO = quotation::orderBy('id', 'desc')->where('companyID', Auth::user()->companyID)->first();
        if ($PO) {
            $qt_start_no = $PO->qt_start_no + 1;
        } else {
            $qt_start_no = 0;
        }
        $quotation = new quotation;

        $quotation->user_id  =  Auth::user()->id;
        $quotation->companyID  =  $companyID;
        $quotation->branchID  =  $companyID;
        $quotation->taxable_price  =  $request->grandtotal;
        $quotation->grand_total  =  $request->taxable_amount;
        $quotation->gsttaxamount  =  $request->qm;
        $quotation->customerID  =  $request->customerID;
        $quotation->tcmonth  =  $request->tcmonth;
        $quotation->tax  =  $request->tottaltax;
        $quotation->tax_type  =  $request->taxtype;
        $quotation->created_by = Auth::user()->id;
        $quotation->qt_start_no = $qt_start_no;
        $quotation->save();
        // dd($request->customerID);
        $lastquotationID = $quotation->id;
        $update = quotation::where('id', $lastquotationID)->first();
        $com = company::find(Auth::user()->companyID);
        if ($com->quatation_status == '0') {
            // dd($com);
            $update->invoice = $com->quatation_prefix . ($com->quatation_no + $update->qt_start_no);
        } else {
            $update->qt_start_no = 0;
            $update->invoice = $com->quatation_prefix . $com->quatation_no;
            $com->quatation_status = 0;
            $com->save();
        }
        // $PO->invoice = $com->prefix . 'QT' . $lastquotationID;
        $update->save();
        $count = count($request->id);
        for ($i = 0; $i < $count; $i++) {

            // $cbp = $request->categoryID;

            $array = explode("|", $request->categoryID[$i]);
            // dd($array);
            $product = new quotation_product;
            $product->user_id  = Auth::user()->id;
            $product->companyID  = $companyID;
            $product->quotationID  = $lastquotationID;
            $product->category = $array[1];
            $product->brand =    $array[2];
            $product->product =  $array[3];
            $product->description  = $request->description[$i];
            $product->price  = $request->price[$i];
            $product->gstamount  = $request->gstamount[$i];
            $product->tax  = $request->taxtype;
            $product->gsttaxamount  = ($request->price[$i]*$request->qty[$i])*$request->taxtype/100;
            $product->qty  = $request->qty[$i];
            $product->created_by  = Auth::user()->id;
            $product->save();
            

        }
        // route('quotation.quotation_print', $val->q_id);
        return redirect()->route('quotation.view')->with('msg','Quotation Added Successfully');

        // return redirect()->route('quotation.quotation_print', $lastquotationID);
    }

    public function quotation_print($id)
    {

        $data = purchase::find($id);

        $datas = DB::table('quotations')

            ->leftJoin('customers', 'quotations.customerID', '=', 'customers.id')
            ->leftJoin('companies', 'quotations.companyID', '=', 'companies.id')
            ->where('quotations.id', $id)
            ->select(
                'quotations.*',
                'quotations.id AS q_id',
                'quotations.created_at AS q_created_at',

                'companies.address_line1 AS c_address_line1',
                'companies.address_line2 AS c_address_line2',
                'companies.city AS c_city',
                'companies.pincode AS c_pincode',
                'companies.gst AS c_gst',
                'companies.phone_number AS c_phone_number',
                'companies.email AS c_email',
                'customers.*',

                'customers.id AS cus_id',
                'customers.name AS cus_name',
                'customers.address_line1 AS cus_address_line1',
                'customers.address_line2 AS cus_address_line2',
                'customers.city AS cus_city',
                'customers.pincode AS cus_pincode',
                'customers.gst AS cus_gst',
                'customers.phone_number AS cus_phone_number',
                'customers.email AS cus_email',

                'quotations.tax as tax_per',

                'companies.*'
            )
            ->orderBy('quotations.id', 'DESC',)
            ->first();
        $terms = terms::find(7);
        $declaration = terms::find(8);

        $product = DB::table('quotations')
            ->leftJoin('quotation_products', 'quotations.id', '=', 'quotation_products.quotationID')
            ->leftJoin('categories', 'quotation_products.category', '=', 'categories.id')
            ->leftJoin('brands', 'quotation_products.brand', '=', 'brands.id')
            ->leftJoin('products', 'quotation_products.product', '=', 'products.id')
            ->where('quotations.id', $id)
            ->where('quotation_products.quotationID', $id)
            ->select('quotations.*', 'quotations.id AS q_id', 'quotation_products.*', 'categories.*', 'brands.*', 'products.*')
            ->get();

        //    dd($datas);
        $company =company::where('id',Auth::user()->companyID)->first();
        return view('quotation.quotation_print', ['product' => $product, 'datas' => $datas, 'terms' => $terms, 'declaration' => $declaration,'company'=>$company]);
    }
    public function quotation_proforma_print($id)
    {

        $data = purchase::find($id);

        $datas = DB::table('proforma')

            ->leftJoin('customers', 'proforma.customerID', '=', 'customers.id')
            ->leftJoin('companies', 'proforma.companyID', '=', 'companies.id')
            ->where('proforma.id', $id)
            ->select(
                'proforma.*',
                'proforma.id AS q_id',
                'proforma.created_at AS q_created_at',
                'companies.address_line1 AS c_address_line1',
                'companies.address_line2 AS c_address_line2',
                'companies.city AS c_city',
                'companies.pincode AS c_pincode',
                'companies.gst AS c_gst',
                'companies.phone_number AS c_phone_number',
                'companies.email AS c_email',
                'customers.*',

                'customers.id AS cus_id',
                'customers.name AS cus_name',
                'customers.address_line1 AS cus_address_line1',
                'customers.address_line2 AS cus_address_line2',
                'customers.city AS cus_city',
                'customers.pincode AS cus_pincode',
                'customers.gst AS cus_gst',
                'customers.phone_number AS cus_phone_number',
                'customers.email AS cus_email',
                'proforma.tax as tax_per',
                'companies.*'
            )
            ->orderBy('proforma.id', 'DESC',)
            ->first();
        $terms = terms::find(7);
        $declaration = terms::find(8);

        $product = DB::table('proforma')
            ->leftJoin('proforma_products', 'proforma.id', '=', 'proforma_products.proformaID')
            ->leftJoin('categories', 'proforma_products.category', '=', 'categories.id')
            ->leftJoin('brands', 'proforma_products.brand', '=', 'brands.id')
            ->leftJoin('products', 'proforma_products.product', '=', 'products.id')
            ->where('proforma.id', $id)
            ->where('proforma_products.proformaID', $id)
            ->select('proforma.*', 'proforma.id AS q_id', 'proforma_products.*', 'categories.*', 'brands.*', 'products.*')
            ->get();

        //    dd($datas);
        $company =company::where('id',Auth::user()->companyID)->first();
        return view('quotation.proforma', ['product' => $product, 'datas' => $datas, 'terms' => $terms, 'declaration' => $declaration,'company'=>$company]);
    }
    
    public function view()
    {

        $companyID = $this->getcompany();
        $data = DB::table('quotations')
            ->leftJoin('customers', 'quotations.customerID', '=', 'customers.id')
            ->select('quotations.*', 'quotations.id AS q_id', 'customers.*')
            ->where('quotations.companyID', $companyID)
            ->orderBy('quotations.id', 'DESC',)
            ->get();
        // dd($data);
        if(Auth::user()->role_id =='3' || $this->role_check(36)){
         return view('quotation.quotaion_view', ['data' => $data]);

          }else{
            $msg='Cannot Access Page !';
             return redirect()->back()->with('msg', $msg);
          }
    }

    public function quotation_delete(Request $request)
    {

        $q =  quotation::where('id', $request->id)->delete();
        $p = quotation_product::where('quotationID', $request->id)->delete();

        return redirect()->back()->with('msg', 'Product Deleted Successfully');
    }

    public function list($id)
    {

        $quotation = quotation_product::where('quotationID', $id)->get();

        $data = DB::table('quotation_products')
            // ->leftJoin('customers', 'quotations.customerID', '=', 'customers.id')
            ->leftJoin('categories', 'quotation_products.category', '=', 'categories.id')
            ->leftJoin('brands', 'quotation_products.brand', '=', 'brands.id')
            ->leftJoin('products', 'quotation_products.product', '=', 'products.id')
            ->select('quotation_products.*', 'quotation_products.id AS q_id', 'categories.*', 'brands.*', 'products.*')
            ->where('quotation_products.quotationID', $id)
            ->get();
        // dd($data);
        return view('quotation.quotation_list', ['data' => $data]);
    }



    public function edit($id)
    {
        $quotation = DB::table('quotation_products')
            // ->leftJoin('customers', 'quotations.customerID', '=', 'customers.id')
            ->leftJoin('categories', 'quotation_products.category', '=', 'categories.id')
            ->leftJoin('brands', 'quotation_products.brand', '=', 'brands.id')
            ->leftJoin('products', 'quotation_products.product', '=', 'products.id')
            ->select('quotation_products.*', 'quotation_products.id AS qp_id', 'categories.*', 'brands.*', 'products.*')
            ->where('quotation_products.quotationID', $id)
            ->get();

        // dd($quotation);
        $tax = tax::all();
        $product = DB::table('products')
            ->leftJoin('categories', 'products.categoryID', '=', 'products.id')
            ->leftJoin('brands', 'products.brandID', '=', 'products.id')
            ->select('products.*', 'products.id AS p_id', 'categories.*', 'brands.*')
            ->get();

        $data = DB::table('quotations')
            ->leftJoin('customers', 'quotations.customerID', '=', 'customers.id')
            ->where('quotations.id', $id)
            ->select('quotations.*', 'quotations.id AS q_id',
            'quotations.tax AS q_tax', 'customers.*')
            ->first();
        $customer = customer::where('companyID', Auth::user()->companyID)->get();
        return view('quotation.edit-quotaion', ['product' => $product, 'customer' => $customer, 'data' => $data, 'quotation' => $quotation, 'tax'=>$tax]);
    }

    public function prodct_delete(Request $request)
    {

        $p = quotation_product::where('id', $request->id)->delete();
        return redirect()->back()->with('msg', 'Product Deleted Successfully');
    }

    public function update(Request $request)
    {

        // $request->validate([

        //     'tcmonth' => 'required',
        //     'customerID' => 'required',
        //     'categoryID.*' => 'required',
        //     'qty.*' => 'required',

        // ]);
        
        $companyID = $this->getcompany();

        $id = $request->quotation_id;
        // dd($id);
        
        $quotation = quotation::find($id);
        
        $quotation->user_id  =  Auth::user()->id;
        $quotation->companyID  =  $companyID;
        $quotation->branchID  =  $companyID;
        // $quotation->invoice  =  $invoice;
        $quotation->taxable_price  =  $request->grandtotal;
        $quotation->grand_total  =  $request->taxable_amount;
        $quotation->gsttaxamount  =  $request->qm;
        $quotation->customerID  =  $request->customerID;
        $quotation->tcmonth  =  $request->tcmonth;
        $quotation->tax  =  $request->tottaltax;
        $quotation->tax_type  =  $request->taxtype;
        $quotation->created_by = Auth::user()->id;
        $quotation->save();
        // dd($request->all());
        $lastquotationID = $quotation->id;

        $count = count($request->product_id);
        for ($i = 0; $i < $count; $i++) {

            if ($request->product_id[$i] != null) {

                $product = quotation_product::find($request->product_id[$i]);
                // dd($request->product_id[$i]);
                $product->user_id  = Auth::user()->id;
                $product->companyID  = $companyID;
                $product->quotationID  = $lastquotationID;

                $product->description  = $request->description[$i];
                $product->price  = $request->price[$i];
                $product->gstamount  = $request->gstamount[$i];
                $product->tax  = $request->taxtype;
                $product->gsttaxamount  = ($request->price[$i]*$request->qty[$i])*$request->taxtype/100;
                $product->qty  = $request->qty[$i];
                $product->created_by  = Auth::user()->id;
                $product->save();
            } else {
                $array = explode("|", $request->categoryID[$i]);
                $product = new quotation_product;
                $product->user_id  = Auth::user()->id;
                $product->companyID  = $companyID;
                $product->quotationID  = $lastquotationID;
                $product->category = $array[1];
                $product->brand =    $array[2];
                $product->product =  $array[3];
                $product->description  = $request->description[$i];
                $product->price  = $request->price[$i];
                $product->gstamount  = $request->gstamount[$i];
                $product->tax  = $request->taxtype;
                $product->gsttaxamount  = $request->gsttaxamount[$i];
                $product->qty  = $request->qty[$i];
                $product->created_by  = Auth::user()->id;
                $product->save();
            }
        }
        if ($request->removeid != null) {
            $r_id = count($request->removeid);
            for ($i = 0; $i < $r_id; $i++) {
                $purchase = quotation_product::find($request->removeid[$i])->delete();
            }
        }
        // return redirect()->route('quotation.quotation_print', $lastquotationID);
        return redirect()->route('quotation.view')->with('msg','Quotation Updated Successfully');
    }

    public function attached_mail()
    {
        $info = array(
            'name' => "Manoj"
        );
        Mail::send('mail', $info, function ($message) {
            $message->to('mail08.mano@gmail.com', 'test')
                ->subject('Test eMail with an attachment from Team Work Project.');
            // $message->attach('D:\laravel_main\laravel\public\uploads\pic.jpg');
            // $message->attach('D:\laravel_main\laravel\public\uploads\message_mail.txt');
            $message->from('manoj@alphasoftz.in', 'Alex');
        });
        echo "Successfully sent the email";
    }

    public function quotation_invoice(Request $request)
    {
        $quotation = quotation::where('id',$request->invoice_id)->first();
        $q_product = quotation_product::where('quotationID', $quotation->id)->get();
        // sequence number start last number
        if ($quotation->gsttaxamount == 'Sales') {
            $PO = purchase_order::orderBy('id', 'desc')->where('companyID', Auth::user()->companyID)->first();
            if ($PO) {
                $sale_start_no = $PO->sale_start_no + 1;
            } else {
                $sale_start_no = 0;
            }
            $price = 0;
            $tax_amt = 0;
            // foreach ($q_product as $val) {
            //     $price += ($val->price*$val->qty);
            //     $tax_amt += $val->gsttaxamount;
            // }
            $purchase_order = purchase_order::create([
                'user_id' => Auth::user()->id,
                'companyID' => Auth::user()->companyID,
                'taxable_price' =>$quotation->taxable_price,
                'discount' => 0,
                'tax' =>$quotation->tax=='0'?0:'1',
                'tax_amount' => $quotation->tax,
                'grand_total' => $quotation->grand_total,
                'collected' => 0,
                'delivery' => 0,
                'others' => 0,
                'balance' => $quotation->grand_total,
                'terms' => 1,
                'customerID' => $quotation->customerID,
                'status' => '1', //sale
                'sale_start_no' => $sale_start_no,
            ]);
            $lastIDsaleinvoice = $purchase_order->id;
            // invoice number 
            $update = purchase_order::where('id', $lastIDsaleinvoice)->first();
            $com = company::find(Auth::user()->companyID);
            if ($com->sale_status == '0') {
                // dd($com);
                $update->invoiceID = $com->sale_prefix . ($com->sale_no + $update->sale_start_no);
            } else {
                $update->sale_start_no = 0;
                $update->invoiceID = $com->sale_prefix . $com->sale_no;
                $com->sale_status = 0;
                $com->save();
            }
            $update->save();

            for ($i = 0; $i < count($q_product); $i++) {
                for ($j = 0; $j < $q_product[$i]->qty; $j++) {
                    $stock_details = purchase::where('categoryID', $q_product[$i]->category)->where('brandID', $q_product[$i]->brand)->where('productID', $q_product[$i]->product)->where('stock', '1')->where('type', '0')->first();
                   
                        tax_purchase::create([
                            'companyID' => Auth::user()->companyID,
                            'user_id' => Auth::user()->id,
                            'category' => $stock_details->categoryID,
                            'brand' => $stock_details->brandID,
                            'product' => $stock_details->productID,
                            'invoice_number' => $lastIDsaleinvoice,
                            'price' => $q_product[$i]->price,
                            'tax_per' => $q_product[$i]->tax,
                            'tax_per_amount' =>$q_product[$i]->gsttaxamount,
                            'seial_number'=>isset($stock_details->serial)?$stock_details->serial:' ',
                            'quantity' => '1',
                            'stock_status' => '1'
                        ]);
                        $update = purchase::where('categoryID', $stock_details->categoryID)
                            ->where('brandID', $stock_details->brandID)
                            ->where('productID', $stock_details->productID)
                            ->where('selling_price', $stock_details->selling_price)
                            ->where('stock', '1')
                            ->where('type', '0')
                            ->where('serial',$stock_details->serial)
                            ->where('companyID', Auth::user()->companyID)->first();
                        if ($update) {
                            $update->stock = '0';
                            $update->type = '1';
                            $update->save();
                        } else {
                            $update = purchase::where('categoryID', $stock_details->categoryID)
                                ->where('brandID', $stock_details->brandID)
                                ->where('productID', $stock_details->productID)
                                ->where('selling_price', $stock_details->selling_price)
                                ->where('stock', '1')
                                ->where('type', '0')
                                ->where('companyID', Auth::user()->companyID)->first();
                            if ($update) {
                                $update->stock = '0';
                                $update->type = '1';
                                $update->save();
                            }
                        }

                    $quotation->qt_status=1;
                    $quotation->save();
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
                $filePath = public_path('invoice/' . $customer[0] .  $purchase_details->invoiceID . '.pdf');
                $pdf->save($filePath);
                $purchase_details->invoice_path = URL::to('/') . '/invoice/' . $customer[0] .  $purchase_details->invoiceID. '.pdf';
                $purchase_details->save();
            }
              return redirect()->route('sale.invoice')->with('msg', 'Invoice Generate  Successfully');
        }else{

            // dd(date("Y/m/d"));
            $rent_date = date("Y/m/d");
            $rentdate    = date('Y-m-d', strtotime($rent_date));
            $nosdwm    = '+'.intval($quotation->tcmonth-1).' month';
            $close_date = date('y-m-d', strtotime($rent_date. $nosdwm));
            $alert_date = date('y-m-d', strtotime($close_date. ' -1 month'));
            $renewal_date = date('Y-m-d', strtotime($rentdate . '+1 month'));
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
            $price = 0;
            $tax_amt = 0;
            foreach ($q_product as $val) {
                $price +=$val->price;
                $tax_amt += $val->gsttaxamount;
            }
            $agreement = new rent_agreement;
            $agreement->user_id = Auth::user()->id;
            $agreement->companyID = Auth::user()->companyID;
            $agreement->customerID =  $quotation->customerID;
            $agreement->rental_date =  $rentdate;
            $agreement->renewal_date =  $rent_date;
            $agreement->day_week_month =  'Month';
            $agreement->nos_day_week_month =  $quotation->tcmonth;
            $agreement->taxable_amount = $price;
            $agreement->tax = $quotation->tax_type;
            $agreement->tax_amt = $tax_amt;
            $agreement->total_amount = $price+$tax_amt;
            $agreement->collected =0;
            $agreement->receive_date = $close_date;
            $agreement->balance =$price+$tax_amt;
            $agreement->renewal_date = $renewal_date;
            $agreement->terms =  3;
            $agreement->created_by = Auth::user()->id;
            $agreement->rent_start_no = $rent_start_no;
            $agreement->complete_status = $complete;
            $agreement->save();
            $agreementID = $agreement->id;

      $input = new rent_invoice;
      $input->user_id = Auth::user()->id;
      $input->companyID = Auth::user()->companyID;
      $input->customerID =  $quotation->customerID;
      $input->rental_date =  $rentdate;
      $input->renewal_date =  $renewal_date;
      $input->day_week_month =  'Month';
      $input->nos_day_week_month =  $quotation->tcmonth;
      $input->taxable_amount = $price;
      $input->tax = $quotation->tax_type;
      $input->tax_amt = $tax_amt;
      $input->total_amount = $price+$tax_amt;
      $input->collected = 0;
      $input->receive_date = $close_date;
      $input->balance = $price+$tax_amt;
      $input->terms =  3;
      $input->created_by = Auth::user()->id;
      $input->rent_start_no = $rent_start_no;
      $input->complete_status = $complete;
      $input->agreementID = $agreementID;
      $input->save();
      $invoiceID = $input->id;
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

         $productlist = count($q_product);
         for($i=0; $i<$productlist; $i++){
            for ($j = 0; $j < $q_product[$i]->qty; $j++) {
                $stock_details = purchase::where('categoryID', $q_product[$i]->category)->where('brandID', $q_product[$i]->brand)->where('productID', $q_product[$i]->product)->where('stock', '1')->where('type', '0')->first();
                $RP = new rental_product;
   
                    // $val=explode("|",$request->categoryID[$i]);
           
                    $RP->user_id    = Auth::user()->id;
                    // $RP->invoiceID  = $lastRentID;
                    $RP->companyID = Auth::user()->companyID;
                    $RP->rentID    =  $rentalID;
                    $RP->agreementID    = $agreementID;
                    $RP->customerId  = $request->customerID;
                    $RP->serialID   = isset($stock_details[$i]->seial_number)?$stock_details[$i]->seial_number:' ';
                    // $RP->hsn    = $data->hsn;
                    $RP->categoryID   = $stock_details->categoryID;
                    $RP->brandID	   = $stock_details->brandID;
                    $RP->productID    = $stock_details->productID;
                    // $RP->description   = $data->description;
                    $RP->rent_month    = $quotation->tcmonth;
                    $RP->dayweekmonth  = 'Month';
                    $RP->rent_price    =$q_product[$i]->price ;
                    $RP->rent_date  = $rent_date;
                    // $RP->receive_date   =
                    // $RP->rentdescription  = $data->rentdescription;
                    $RP->created_by  = Auth::user()->id;
                    $RP->save();
                    $update = purchase::where('categoryID',  $stock_details->categoryID)->where('brandID', $stock_details->brandID)->where('productID', $stock_details->productID)->where('serial', $q_product[$i]->seial_number)->where('stock', '1')->where('type', '0')->first();
                    if($update) {
                        $update->stock = '0';
                        $update->type = '2';
                        $update->save();
                    }else{
                    $update = purchase::where('categoryID',  $stock_details->categoryID)->where('brandID', $stock_details->brandID)->where('productID', $stock_details->productID)->where('serial', null)->where('stock', '1')->where('type', '0')->first();
                    if($update) { 
                       $update->stock = '0';
                       $update->type = '2';
                       $update->save();
                    }else{
                       $update = purchase::where('categoryID',  $stock_details->categoryID)->where('brandID', $stock_details->brandID)->where('productID', $stock_details->productID)->where('stock', '1')->where('type', '0')->first();
                       $update->stock = '0';
                       $update->type = '2';
                       $update->save();
                    }               
                    }
            }
            $quotation->qt_status=1;
            $quotation->save();
            }
   
            return redirect()->route('rental.rental_view')->with('msg', 'Rendal Added  Successfully!');
            
      
        }
    }
    public function quotation_proforma(Request $request){

        $companyID = $this->getcompany();
        $com = company::find($companyID);
       
        $PO = proforma::orderBy('id', 'desc')->where('companyID', Auth::user()->companyID)->first();
        if ($PO) {
            $p_start_no = $PO->p_start_no + 1;
        } else {
            $p_start_no = 0;
        }
         $q_id  = quotation::where('id', $request->invoice_id)->first();
        $exit =  proforma::where('qt_id', $request->invoice_id)->first();
         if($exit){
            $exit->user_id  =  Auth::user()->id;
            $exit->companyID  =  $companyID;
            $exit->branchID  =  $companyID;
            $exit->taxable_price  =  $q_id->taxable_price;
            $exit->grand_total  =  $q_id->grand_total;
            $exit->gsttaxamount  =  $q_id->gsttaxamount;
            $exit->customerID  =  $q_id->customerID;
            $exit->tcmonth  =  $q_id->tcmonth;
            $exit->tax  =  $q_id->tax;
            $exit->created_by = Auth::user()->id;
            $exit->p_start_no = $p_start_no;
            $exit->qt_id = $request->invoice_id;
            $exit->save();
            proforma_products::where('proformaID', $exit->id)->delete();
            $lastproformaID=$exit->id;
         }else{
            $proforma = new proforma;
            $proforma->user_id  =  Auth::user()->id;
            $proforma->companyID  =  $companyID;
            $proforma->branchID  =  $companyID;
            $proforma->taxable_price  =  $q_id->taxable_price;
            $proforma->grand_total  =  $q_id->grand_total;
            $proforma->gsttaxamount  =  $q_id->gsttaxamount;
            $proforma->customerID  =  $q_id->customerID;
            $proforma->tcmonth  =  $q_id->tcmonth;
            $proforma->tax  =  $q_id->tax;
            $proforma->created_by = Auth::user()->id;
            $proforma->p_start_no = $p_start_no;
            $proforma->qt_id = $request->invoice_id;

            $proforma->save();
                    // dd($request->customerID);
        $lastproformaID = $proforma->id;
        $update = proforma::where('id', $lastproformaID)->first();
        $com = company::find(Auth::user()->companyID);
        if ($com->proforma_status == '0') {
            // dd($com);
            $update->invoice = $com->proforma_prefix . ($com->proforma_no + $update->p_start_no);
        } else {
            $update->p_start_no = 0;
            $update->invoice = $com->proforma_prefix . $com->proforma_no;
            $com->proforma_status = 0;
            $com->save();
        }
        // $PO->invoice = $com->prefix . 'QT' . $lastquotationID;
        $update->save();
      
         }
         $q_products =quotation_product::where('quotationID', $request->invoice_id)->get();
         // dd($q_products[0]->category);
         $count = count($q_products);
         // dd($count);
         for ($i = 0; $i < $count; $i++) {
             // $cbp = $request->categoryID;
     
             // $array = explode("|", $request->categoryID[$i]);
             // dd($array);
             $product = new proforma_products;
             $product->user_id  = Auth::user()->id;
             $product->companyID  = $companyID;
             $product->proformaID  = $lastproformaID;
             $product->category =$q_products[$i]->category;
             $product->brand =   $q_products[$i]->brand;
             $product->product = $q_products[$i]->product;
             $product->description  = $q_products[$i]->description;
             $product->price  = $q_products[$i]->price;
             $product->gstamount  = $q_products[$i]->gstamount;
             $product->tax  = $q_products[$i]->tax;
             $product->gsttaxamount  = ($q_products[$i]->price*$q_products[$i]->qty)*$q_products[$i]->tax/100;
             $product->qty  = $q_products[$i]->qty;
             $product->created_by  = Auth::user()->id;
             $product->save();
         }
         $update_status  = quotation::where('id', $request->invoice_id)->first();
         $update_status->proforma_status =1;
         $update_status->proforma_id =$lastproformaID;
         $update_status->save();
        // route('quotation.quotation_print', $val->q_id);
        return redirect()->route('quotation.proforma.print',$lastproformaID);
        // return redirect()->back()->with('msg', 'Quotation Added Successfully');
    }
}
