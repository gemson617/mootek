<?php

namespace App\Http\Controllers;

use DateTime;

use App\Models\lead;
use App\Models\User;
use App\Models\company;
use App\Models\holiday;

use App\Models\customer;
use App\Models\employee;
use App\Models\purchase;
use App\Models\supplier;


use App\Models\rent_invoice;
use Illuminate\Http\Request;
use App\Models\purchase_order;
use Illuminate\Support\Carbon;
use App\Models\expense_details;
use App\Models\master_purchase;
use App\Http\Traits\LeadLogTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;

class ReportsController extends Controller
{
    use LeadLogTrait;

    public function index()
    {

        return view('reports.report');
    }
    public function gst(Request $request)
    {
        $title = 'GST Report';
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        // dd($end_date);
        $datatable = purchase_order::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('active', '1')->where('tax', '!=', '0')->where('status', '1')->where('companyID', Auth::user()->companyID)->orderby('id', 'desc')->get();
        return view('reports.gst', compact('datatable', 'start_date', 'end_date', 'title'));
    }
    public function non_gst(Request $request)
    {
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        // dd($end_date);
        $datatable = purchase_order::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('active', '1')->where('tax', '0')->where('status', '1')->where('companyID', Auth::user()->companyID)->orderby('id', 'desc')->get();
        return view('reports.non_gst', compact('datatable', 'start_date', 'end_date'));
    }
    public function completed(Request $request)
    {
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        // dd($end_date);
        $datatable = lead::select('purchase_orders.*')->join('purchase_orders', 'purchase_orders.id', '=', 'leads.purchase_id')
            ->whereDate('leads.created_at', '>=', $start_date)
            ->whereDate('leads.created_at', '<=', $end_date)
            ->where('leads.status', '3')
            ->where('purchase_orders.status', '2')
            ->where('leads.companyID', Auth::user()->companyID)
            ->orderby('leads.id', 'desc')->get();
        // dd($datatable);
        return view('reports.completed', compact('datatable', 'start_date', 'end_date'));
    }
    public function pending(Request $request)
    {
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        // dd($end_date);
        $datatable = lead::select('purchase_orders.*')->join('purchase_orders', 'purchase_orders.id', '=', 'leads.purchase_id')
            ->whereDate('leads.created_at', '>=', $start_date)
            ->whereDate('leads.created_at', '<=', $end_date)
            ->where('leads.status', '2')
            ->where('purchase_orders.status', '2')
            ->where('leads.companyID', Auth::user()->companyID)
            ->orderby('leads.id', 'desc')->get();
        // dd($datatable);
        return view('reports.pending', compact('datatable', 'start_date', 'end_date'));
    }
    public function purchase(Request $request)
    {
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }

        $companyID = $this->getcompany();
        $company = company::find($companyID);

        // dd($companyID);
        $data = purchase::all();

        $datatable = DB::table('purchases')
            ->leftJoin('products', 'purchases.productID', '=', 'products.id')
            ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
            ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id')
            ->leftJoin('suppliers', 'purchases.supplierID', '=', 'suppliers.id')
            // ->where('purchases.stock',1)->where('purchases.type','0')
            ->where('purchases.companyID', $companyID)
            ->whereDate('purchases.created_at', '>=', $start_date)
            ->whereDate('purchases.created_at', '<=', $end_date)
            ->groupBy('purchases.categoryID', 'purchases.brandID', 'purchases.productID', 'purchases.po_no', 'purchases.purchase_price', 'purchases.selling_price',)
            ->select('suppliers.*', 'purchases.*', 'purchases.id as p_id', 'products.*', 'categories.*', 'brands.*', DB::raw("count(purchases.id) as count"))
            ->orderBy('purchases.id', 'DESC',)->get();

        // dd($datatable);
        return view('reports.purchase', compact('datatable', 'start_date', 'end_date', 'data'));
    }

    public function rental_alllist(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);

        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }

        $data = DB::table('rent_invoices')
            ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
            
            ->where('rent_invoices.companyID', $companyID)
            ->whereDate('rent_invoices.rental_date', '>=', $start_date)
            ->whereDate('rent_invoices.rental_date', '<=', $end_date)
            ->where('rent_invoices.payment_status',1)
            ->select('rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.tax AS taxpercentage', 'rent_invoices.created_at AS time', 'customers.*',)
            ->orderBy('rent_invoices.id', 'DESC')
            ->get(); // joining the rent_invoices tabe
        //  dd($data);
        return view('reports.rentalall_list', compact('data', 'start_date', 'end_date'));
    }
    public function rental_agreement(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);

        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }

        $data = DB::table('rent_agreement')
            ->leftJoin('customers', 'rent_agreement.customerID', '=', 'customers.id')
            ->where('rent_agreement.companyID', $companyID)
            ->whereDate('rent_agreement.receive_date', '>=', $start_date)
            ->whereDate('rent_agreement.receive_date', '<=', $end_date)
            // ->where('rent_agreement.payment_status',1)
            // ->where('rent_agreement.complete_status',1)
            ->where('rent_agreement.active',0)
            ->select('rent_agreement.*', 'rent_agreement.id AS r_id', 'rent_agreement.tax AS taxpercentage', 'rent_agreement.created_at AS time', 'customers.*',)
            ->orderBy('rent_agreement.id', 'DESC')
            ->get(); // joining the rent_invoices tabe
        
        return view('reports.agreement', compact('data', 'start_date', 'end_date'));
    }

    public function rental_returnlist(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);

        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }

        $data = DB::table('rent_invoices')
            ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
            ->where('rent_invoices.companyID', $companyID)
            ->where('rent_invoices.active', 0)
            ->whereDate('rent_invoices.renewal_date', '>=', $start_date)
            ->whereDate('rent_invoices.renewal_date', '<=', $end_date)
            ->select('rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.tax AS taxpercentage', 'rent_invoices.created_at AS time', 'customers.*',)
            ->orderBy('rent_invoices.id', 'DESC')
            ->get(); // joining the rent_invoices tabe
        //  dd($data);
        return view('reports.rentalall_list', compact('data', 'start_date', 'end_date'));
    }


    public function rental_list(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);

        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }

        $data = DB::table('rent_invoices')
            ->leftJoin('customers', 'rent_invoices.customerID', '=', 'customers.id')
            ->where('rent_invoices.companyID', $companyID)
            ->where('rent_invoices.active', 1)
            ->whereDate('rent_invoices.renewal_date', '>=', $start_date)
            ->whereDate('rent_invoices.renewal_date', '<=', $end_date)
            ->select('rent_invoices.*', 'rent_invoices.id AS r_id', 'rent_invoices.tax AS taxpercentage', 'rent_invoices.created_at AS time', 'customers.*',)
            ->orderBy('rent_invoices.id', 'DESC')
            ->get(); // joining the rent_invoices tabe
        //  dd($data);
        return view('reports.rentalall_list', compact('data', 'start_date', 'end_date'));
    }

    public function customer_report(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);
        $customer =  customer::where('companyID', Auth::user()->companyID)->get();
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));

            $cus =$request->customer;
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
            
            $cus =$request->customer;
        }

        $customer_sale = purchase_order::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('active', '1')->where('status', '1')->where('companyID', Auth::user()->companyID)->where('customerID',$cus)->orderby('id', 'desc')->get();
        $customer_rental = rent_invoice::where('companyID', Auth::user()->companyID)
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->whereColumn('total_amount', 'collected')->get();
        $customer_service = purchase_order::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('active', '1')->where('status', '2')->where('companyID', Auth::user()->companyID)->orderby('id', 'desc')->get();
        return view('reports.customer', compact('customer', 'customer_sale', 'customer_rental', 'customer_service', 'start_date', 'end_date'));
    }
    public function balance(Request $request)
    {
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        return view('reports.balance', compact('start_date', 'end_date'));
    }
    public function suplier_report(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);
        $suppliers = supplier::all();

        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
            $sup = supplier::find($request->supplierID);
            $data = purchase::where('supplierID', $request->supplierID)->get();
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
            $sup = '0';
            $data = '0';
        }
        // dd($suppliers);

        $datatable = DB::table('purchases')
            ->leftJoin('products', 'purchases.productID', '=', 'products.id')
            ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
            ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id')
            ->leftJoin('suppliers', 'purchases.supplierID', '=', 'suppliers.id')
            // ->where('purchases.stock',1)->where('purchases.type','0')
            ->where('purchases.supplierID', $request->supplierID)
            ->where('purchases.companyID', $companyID)
            ->whereDate('purchases.created_at', '>=', $start_date)
            ->whereDate('purchases.created_at', '<=', $end_date)
            ->groupBy('purchases.categoryID', 'purchases.brandID', 'purchases.productID', 'purchases.purchaseDate', 'purchases.po_no', 'purchases.purchase_price', 'purchases.selling_price')
            ->select('suppliers.*', 'purchases.*', 'purchases.id as p_id', 'products.*', 'categories.*', 'brands.*', DB::raw("count(purchases.id) as count"))
            ->orderBy('purchases.id', 'DESC',)->get();
        return view('reports.supplier', compact('suppliers', 'sup', 'data', 'datatable', 'start_date', 'end_date'));
    }

    public function quotation_report(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        $data = DB::table('quotations')
            ->leftJoin('customers', 'quotations.customerID', '=', 'customers.id')
            ->select('quotations.*', 'quotations.created_at as date', 'quotations.id AS q_id', 'customers.*')
            ->whereDate('quotations.created_at', '>=', $start_date)
            ->whereDate('quotations.created_at', '<=', $end_date)
            ->where('quotations.companyID', $companyID)
            ->orderBy('quotations.id', 'DESC',)
            ->get();
        // dd($data);
        return view('reports.quotation', compact('data', 'start_date', 'end_date'));
    }

    public function expense_report(Request $request)
    {


        $companyID = $this->getcompany();
        $company = company::find($companyID);
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        // $data = DB::table('quotations')
        // ->leftJoin('customers', 'quotations.customerID', '=', 'customers.id')
        // ->select('quotations.*','quotations.created_at as date', 'quotations.id AS q_id', 'customers.*')
        // ->whereDate('quotations.created_at','>=',$start_date)
        // ->whereDate('quotations.created_at','<=',$end_date)
        // ->where('quotations.companyID', $companyID)
        // ->orderBy('quotations.id', 'DESC',)
        // ->get();

        $data = expense_details::select('expense_details.*', 'expenses.name as expense')
            ->leftjoin('expenses', 'expense_details.expID', '=', 'expenses.id')
            ->whereYear('expense_details.expdate', '>=', $start_date)
            ->whereMonth('expense_details.expdate', '<=', $end_date)
            ->where('expense_details.companyID', Auth::user()->companyID)
            ->get();
        // dd($data);
        return view('reports.expense', compact('data', 'start_date', 'end_date'));
    }

    public function overallsale_report(Request $request)
    {

        $companyID = $this->getcompany();
        $company = company::find($companyID);
        $title = 'Overall Sale Report';
        if ($request->all()) {
            $start_date = date('Y-m-d', strtotime($request->start));
            $end_date = date('Y-m-d', strtotime($request->end));
        } else {
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime($end_date . ' -1 month'));
        }
        // dd($end_date);
        $datatable = purchase_order::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->where('companyID', Auth::user()->companyID)
            ->where('active', '1')->where('status', '1')->where('companyID', Auth::user()->companyID)->orderby('id', 'desc')->get();
        return view('reports.gst', compact('datatable', 'start_date', 'end_date', 'title'));
    }
    public function employee_salary_details(Request $request)
    {
        if ($request->all()) {
            $year = $request->year;
            $month = $request->month;
        } else {
            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;
        }
       
        // $datatable = employee::select('*')
        //     ->leftjoin('users', 'users.id', '=', 'employees.user_id')
        //     ->select([
        //         'users.*',
        //         DB::raw('(SELECT COUNT(*) FROM attendances WHERE attendances.empID = users.id) as present')
        //     ])->get();
        // dd($end_date);
        $datatable = User::select('*')
            ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->select(
                'employees.name','employees.basic_salary',
                DB::raw("(SELECT amount FROM employee_load_histories WHERE employee_load_histories.emp_id = users.id AND  MONTH(employee_load_histories.month_date) = $month) as Loan"),
                DB::raw("(SELECT COUNT(*) FROM attendances WHERE attendances.empID = users.id AND  MONTH(attendances.attdate) = $month) as working_days")
            )
       ->get();
       $holiday=0;
       $records = holiday::whereYear('created_at','>=',$year)->get();
       foreach($records as $val){
          $begin = new DateTime($val->startDate);
          $end   = new DateTime($val->endDate);
          $data='';
          $holiday=0;
          for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
        //   $data.=  $i->format("Y-m-d");
            if($month ==$i->format("m")){
                  $holiday+=1;
            }
              
         }
       }
       $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);      
        return view('reports.employee_sal', compact('datatable', 'year', 'month','holiday','daysInMonth'));
    }
}
