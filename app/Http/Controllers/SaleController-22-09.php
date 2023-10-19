<?php

namespace App\Http\Controllers;

use App\Models\tax;
use App\Models\brand;
use App\Models\terms;
use App\Models\branch;
use App\Models\company;
use App\Models\product;
use App\Models\category;
use App\Models\customer;
use App\Models\purchase;
use PDF;
use App\Models\sale_invoice;
use App\Models\sale_payment;

use App\Models\tax_purchase;
use Illuminate\Http\Request;



use App\Models\invoice_number;
use App\Models\manual_product;
use App\Models\purchase_order;
use App\Models\payment_history;
use App\Http\Traits\LeadLogTrait;
use App\Models\purchase_order_temp;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;


class SaleController extends Controller
{
    use LeadLogTrait;
    public function index()
    {
        $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price')->where('active', '1')->where('stock', '1')->where('type', '0')->where('companyID', Auth::user()->companyID)->get();
        $terms = terms::all();
        $branch = company::where('active', 1)->get();
        $customer = customer::where('active', 1)->where('companyID', Auth::user()->companyID)->get();
        // $tax = tax::first();
        $tax = company::select('tax')->where('id',Auth::user()->companyID)->first();
        // dd($tax);

        // dd($tax);
        // dd($datatable);
        $manual_products = manual_product::all();
        if (Auth::user()->role_id == '3' || $this->role_check(29)) {
            return view('sale.sale', ['modal' => $modal, 'manual_products' => $manual_products, 'terms' => $terms, 'branch' => $branch, 'customer' => $customer, 'tax' => $tax]);
        } else {
            $msg = 'Cannot Access Page !';
            return redirect()->back()->with('msg', $msg);
        }
    }

    public function load_data(Request $request)
    {
        $id = explode("-", $request->id);
        if ($id['1'] == 'stock') {
            $stock = explode("|", $id['0']);
            $data = purchase::where('categoryID', $stock[0])->where('brandID', $stock[1])->where('productID', $stock[2])->where('selling_price', $stock[3])->where('stock', '1')->where('type', '0')->get();

            $tax = product::where('id', $stock[2])->first();
            $gst = $tax->gst;
            $gst_calc = $data[0]->selling_price * $gst / 100;
            return response()->json(['success' => '1', 'status' => 1, 'data' => $data, 'gst' => $gst, 'gst_calc' => $gst_calc]);
        } else {
            $product = manual_product::where('id', $id['0'])->first();
            // dd($product);
            $gst = 18;
            $gst_calc = 0;
            return response()->json(['success' => '1', 'status' => 2, 'data' => $product, 'gst' => $gst, 'gst_calc' => $gst_calc]);
        }
    }
    public function get_tax(Request $request)
    {
        $data = customer::where('id', $request->id)->first();
        $tax =  tax::where('id', $data->tax)->first();
        //  $val =isset($tax->name)?$tax->name: '';
        return response()->json(['success' => '1', 'data' => $tax]);
    }
    public function getmodal()
    {
        $modal = purchase::groupBy('categoryID', 'brandID', 'productID', 'selling_price')->select('categoryID', 'brandID', 'productID', 'selling_price')->where('active', '1')->where('stock', '1')->where('type', '0')->where('companyID', Auth::user()->companyID)->get();
        $manual_products = manual_product::all();
        foreach ($modal as $val) {
            $id = $val->categoryID . '|' . $val->brandID . '|' . $val->productID . '|' . $val->selling_price;
            $category = category::where('id', $val->categoryID)->first();
            $product = product::where('id', $val->productID)->first();
            $brand = brand::where('id', $val->brandID)->first();
            $NumberOfStock = purchase::where('companyID', Auth::user()->companyID)->where('active', '1')->where('stock', '1')->where('type', '0')->where('categoryID', $val->categoryID)->where('brandID', $val->brandID)->where('productID', $val->productID)->where('selling_price', $val->selling_price)->get();
            $getNumberOfStock = $NumberOfStock->count();
            $array[] = array('check' => 'stock', 'id' => $id, 'cat' => $category->category_name, 'brand' => $brand->brand_name, 'product' => isset($product->productName) ? $product->productName : 'null', 'count' => $getNumberOfStock);
        }
        foreach ($manual_products as $pro) {
            $array[] = array('check' => 'others', 'id' => $pro->id, 'product' => $pro->product);
        }
        // dd($array);
        echo json_encode($array);
    }
    public function getstock(Request $request)
    {

        $stock = purchase::where('id', $request->id)->first();
        $stock->sale = 1;
        $stock->stock = 0;
        $stock->save();
        echo json_encode(1);
    }
    public function getmanual_products()
    {
        $products = manual_product::get();
        echo json_encode($products);
    }
    public function final_invoice(Request $request)
    {
        // dd($request->all());
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

        // $Sinvoice = $prefix . $no . $lastIDsaleinvoice;
        // dd($invoice);
        $update = purchase_order::where('id', $lastIDsaleinvoice)->where('status', '1')->first();
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
        // $update->invoiceID = $Sinvoice;
        $update->save();
        for ($i = 0; $i < count($request->order); $i++) {
            $check = explode('-', $request->order[$i]);
            // dd($check);
            if ($check[1] == 'stock') {

                $stock = explode('|', $check[0]);
                $stock_details = purchase::where('categoryID', $stock[0])->where('brandID', $stock[1])->where('productID', $stock[2])->where('selling_price', $stock[3])->where('stock', '1')->where('type', '0')->where('companyID', Auth::user()->companyID)->first();
                tax_purchase::create([
                    'companyID' => $branch,
                    'user_id' => Auth::user()->id,
                    'seial_number' => $request->serial[$i],
                    'category' => $stock_details->categoryID,
                    'brand' => $stock_details->brandID,
                    'product' => $stock_details->productID,
                    'invoice_number' => $lastIDsaleinvoice,
                    'price' => $request->price[$i],
                    // 'tax_per' => $request->tax_per[$i],
                    // 'tax_per_amount' => $request->tax_per_amount[$i],
                    'quantity' => '1',
                    'stock_status' => '1'
                ]);
                $update = purchase::where('categoryID', $stock[0])
                    ->where('brandID', $stock[1])
                    ->where('productID', $stock[2])
                    ->where('selling_price', $stock[3])
                    ->where('serial', $request->serial[$i])
                    ->where('stock', '1')
                    ->where('type', '0')
                    ->where('companyID', Auth::user()->companyID)
                    ->first();
                if ($update) {
                    $update->stock = '0';
                    $update->type = '1';
                    $update->save();
                } else {
                    $update = purchase::where('categoryID', $stock[0])
                        ->where('brandID', $stock[1])
                        ->where('productID', $stock[2])
                        ->where('selling_price', $stock[3])
                        ->Where('serial', null)
                        ->where('stock', '1')
                        ->where('type', '0')
                        ->where('companyID', Auth::user()->companyID)
                        ->first();
                    if ($update) {
                        $update->serial =  $request->serial[$i];
                        $update->stock = '0';
                        $update->type = '1';
                        $update->save();
                    } else {
                        $update = purchase::where('categoryID', $stock[0])
                            ->where('brandID', $stock[1])
                            ->where('productID', $stock[2])
                            ->where('selling_price', $stock[3])
                            ->where('stock', '1')
                            ->where('type', '0')
                            ->where('companyID', Auth::user()->companyID)
                            ->first();
                        $update->serial =  $request->serial[$i];
                        $update->stock = '0';
                        $update->type = '1';
                        $update->save();
                    }
                }
            } else {
                tax_purchase::create([
                    'companyID' => $branch,
                    'user_id' => Auth::user()->id,
                    'seial_number' => $request->serial[$i],
                    'product' => $check[0],
                    'invoice_number' => $lastIDsaleinvoice,
                    'price' => $request->price[$i],
                    // 'tax_per' => $request->tax_per[$i],
                    // 'tax_per_amount' => $request->tax_per_amount[$i],
                    'quantity' => '1',
                    'stock_status' => '0'

                ]);
            }
        }
        $purchase_details = purchase_order::where('id', $lastIDsaleinvoice)->first();
        $customer = $purchase_details->customerID;
        $customer_list = customer::where('id', $customer)->first();
        $customer = explode(" ", $customer_list->name);
        if ($purchase_details) {
        $pdf = PDF::loadView('sale.invoice', compact('purchase_details'));
        $pdf->setPaper('A4', 'portrait');
        $filePath = public_path('invoice/' . $customer[0] .  $purchase_details->invoiceID . '.pdf');
        $pdf->save($filePath);
        $purchase_details->invoice_path = URL::to('/') . '/invoice/' . $customer[0] .  $purchase_details->invoiceID. '.pdf';
        $purchase_details->save();
        return redirect()->back()->with('msg', 'Sales Added Successfully');
        }

        //dd($pdf);
    }

    public function payment($id)
    {
        // dd($id);
        $view_data['invoice'] = purchase_order::where('id', $id)->first();
        $view_data['payment_history'] = payment_history::where('invoiceID', $id)->orderby('id', 'desc')->get();

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
            'paymentDate' => $request->paymentDate
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
        if ($purchase_details->collected == $purchase_details->grand_total) {

            $pdf = PDF::loadView('sale.invoice', compact('purchase_details'));
            $pdf->setPaper('A4', 'portrait');
            $filePath = public_path('invoice/' . $customer[0] . $update_purchase_order->invoice . '.pdf');
            $pdf->save($filePath);
            $update_purchase_order->invoice_path = URL::to('/') . '/invoice/' . $customer[0] . $update_purchase_order->invoice . '.pdf';
            $update_purchase_order->save();
                    //receipt
            $history = payment_history::where('id', $payment)->first();
            $pdf = PDF::loadView('sale.ireceipt', compact('history', 'hand'));
            $pdf->setPaper('A4', 'portrait');
            $filePath = public_path('receipt/' . $customer[0] . $invoice  . '.pdf');
            $pdf->save($filePath);
            $history->invoice_path = URL::to('/') . '/receipt/' . $customer[0] . $invoice . '.pdf';
            $history->save();
        }

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
            ->where('payment_histories.balance','>',0)
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
            $purchase = purchase_order::where('active', '1')->where('tax', '!=', '0')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->get();
        } elseif ($id == '2') {
            $purchase = purchase_order::where('active', '1')->where('tax', '0')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->get();
        } else {
            $purchase = purchase_order::where('active', '1')->where('companyID', Auth::user()->companyID)->orderBy('id', 'DESC')->get();
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
