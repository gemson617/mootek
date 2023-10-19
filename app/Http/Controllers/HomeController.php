<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\lead;
use App\Models\company;
use App\Models\category;
use App\Models\Customer;
use App\Models\purchase;
use App\Models\RunModel;
use App\Models\quotation;
use App\Models\CustomerLog;
use App\Models\CustomerCard;
use App\Models\rental_product;
use Illuminate\Http\Request;
use App\Models\CustomerOrder;
use Illuminate\Support\Facades\Auth;


use App\Models\tax_purchase;


use App\Models\CustomerPayment;
use App\Models\CustomerProduct;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerOrderDelivery;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

      
        return view('home');

    }
    
}
