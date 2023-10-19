<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Exception;
use App\Models\Lead;
use App\Models\User;
use App\Models\Admin;
use App\Models\Office;
use App\Models\Suburb;
use App\Models\Meeting;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\ClassTypes;
use App\Models\LeadAssign;
use App\Models\LeadMaster;
use App\Models\LeadStatus;
use App\Models\Competitors;
use App\Models\SafetyItems;
use App\Models\LeadTimeline;
use App\Models\LostCustomer;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ProductPrices;
use App\Models\TruckDispatch;
use App\Models\RequiredSpares;
use App\Models\ServiceRecords;
use PhpParser\Node\Expr\List_;
use App\Models\CategoryProduct;
use App\Models\DeliveryRegions;
use App\Models\UserNotification;
use App\Models\CustomerMarketing;
use App\Models\NoDeliveryReasons;
use App\Models\EmailTemplateModel;
use App\Models\ProductRentalPrice;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\MissingDocketReasons;
use App\Http\Traits\PermissionsTrait;
use App\Http\Traits\SalesactivityTrait;

class AdminController extends Controller
{

  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.add-category');
    }

    public function add_product()
    {
        if (!$this->hasPermission('create-new-product')) {
			return view('admin.error');}

        $category = Admin::Where('is_deleted', 0)->get();


        return view('admin.add-product-category', compact('category'));
    }

    public function update_product_category(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            "name" => "required|string",
            "product_code" => "required|string|unique:category_product,product_code,".$input['id'],
            /*"category_id" => "required",
            "product_code" => "required|string",
            "rrp" => "required|regex:/^\d+(\.\d{1,2})?$/",
            "cost_price" => "required|regex:/^\d+(\.\d{1,2})?$/",
            "outright_price" => "required|regex:/^\d+(\.\d{1,2})?$/",*/
        ]);

        $product = CategoryProduct::find($input['id']);
        $product->name = $input['name'];
        $product->product_code = $input['product_code'];
        $product->description = $input['description'];
        /*$product->transaction_description = $input['transaction_description'];
        $product->category_id = $input['category_id'];
        $product->type = $input['type'];
        $product->rrp = $input['rrp'];
        $product->cost_price = $input['cost_price'];
        $product->outright_price = $input['outright_price'];*/
        if ($product->save()) {
            return redirect()->route('admin.list-product-category')->with('msg', 'Product Updated Successfully');
        }
    }
    public function edit_product($id)
    {
        if (!$this->hasPermission('edit-product-details')) {
			return view('admin.error');
        }
        $category = CategoryProduct::find($id);
        $product = Admin::Where('is_deleted', 0)->get();
        //dd($category );
        return view('admin.edit-product-category', compact('category', 'product'));
    }
    public function  list_product()
    {
        $data = CategoryProduct::leftJoin('category','category_product.category_id','=','category.id')
               // ->leftjoin('product_prices as pr','pr.product_id','=','category_product.id')
                ->where('category_product.is_deleted', 0)
               // ->groupBy('pr.product_id')
                ->get(['category_product.*','category.category_name']);
               // dd($data);
        $prodArr=array();
        foreach($data as $key=>$row){
            $price=ProductPrices::Where('product_id',$row['id'])
            ->where('applicable_from_date','<=',date('Y-m-d'))
            ->orderBy('created_at','DESC')->first();

            $prodArr[$key]['id']=$row['id'];
           // $prodArr[$key]['product_code']=$row['product_code'];
            $prodArr[$key]['name']=$row['name'];
            $prodArr[$key]['type']=$row['type'];
            $prodArr[$key]['category_name']=$row['category_name'];
            $prodArr[$key]['cost_price']=isset($price['cost_price']) ? $price['cost_price'] : Null;
            $prodArr[$key]['rrp']=isset($price['rrp']) ? $price['rrp'] : Null;

        }
      //  dd($prodArr);
        $category=Admin::Where('is_deleted', 0)->get();


        return view('admin.list-product-category', compact('prodArr','category'));
    }

    public function product_search(Request $request){
        $input=$request->all();
        $category=Admin::Where('is_deleted', 0)->get();
        if (empty($input['search'])) {
            $status=$input['status'];
            $code=$input['code'];
            $categoryid=$input['category'];
            $type=$input['type'];
            $desc=$input['desc'];
            $data = CategoryProduct::leftJoin('category','category_product.category_id','=','category.id')
        ->where('category_product.is_deleted', 0);
        if($status=='1'){
            $data=$data->Where('category_product.status', '=','1');
        }if($status=='0'){
            $data=$data->Where('category_product.status', '=','0');
        }if($status=='-1'){
            $data=$data->Wherein('category_product.status',[0,1]);
        }
        if($type){
            $data=$data->Where('category_product.type', '=',  $type);
        }
        if($code){
            $data=$data->Where('category_product.product_code', '=',  $code);
        }
        if($categoryid){
            $data=$data->Where('category_product.category_id', '=',  $categoryid);
        }
        $data=$data->get(['category_product.*','category.category_name']);
            $prodArr=array();
            foreach($data as $key=>$row){
                $price=ProductPrices::Where('product_id',$row['id'])->orderBy('created_at','DESC')->first();
                $prodArr[$key]['id']=$row['id'];
                $prodArr[$key]['product_code']=$row['product_code'];
                $prodArr[$key]['name']=$row['name'];
                $prodArr[$key]['type']=$row['type'];
                $prodArr[$key]['category_name']=$row['category_name'];
                $prodArr[$key]['cost_price']=isset($price['cost_price']) ? $price['cost_price'] : '';
                $prodArr[$key]['rrp']=isset($price['rrp']) ? $price['rrp'] : '';
            }
        return view('admin.search-products', compact('prodArr','category'));

        }else{
            $search=$input['search'];
            $data = CategoryProduct::leftJoin('category','category_product.category_id','=','category.id')
            ->orWhere('category_product.name', 'like', '%' . $search . '%')
            ->orWhere('category_product.product_code', 'like', '%' . $search . '%')
            ->orWhere('category_product.description', 'like', '%' . $search . '%')
            ->where('category_product.is_deleted', 0)
            ->get(['category_product.*','category.category_name']);

            $prodArr=array();
            foreach($data as $key=>$row){
                $price=ProductPrices::Where('product_id',$row['id'])->orderBy('created_at','DESC')->first();
                $prodArr[$key]['id']=$row['id'];
                $prodArr[$key]['product_code']=$row['product_code'];
                $prodArr[$key]['name']=$row['name'];
                $prodArr[$key]['type']=$row['type'];
                $prodArr[$key]['category_name']=$row['category_name'];
                $prodArr[$key]['cost_price']=$price['cost_price'];
                $prodArr[$key]['rrp']=$price['rrp'];
            }
        return view('admin.search-products', compact('prodArr','category'));



        }


    }

    public function product_delete_category(Request $request)
    {
        if (!$this->hasPermission('edit-product-details')) {
			return view('admin.error');
}
        $id = $request->id;
        $product = CategoryProduct::find($id);
        $product->is_deleted = 1;
        if ($product->save()) {
            return 1;
        }
    }

    public function store_product(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string",
            "category_id" => "required",
            "product_code" => "required|string|unique:category_product",
            "rrp" => "required|regex:/^\d+(\.\d{1,7})?$/",
            "cost_price" => "required|regex:/^\d+(\.\d{1,7})?$/",
            "outright_price" => "required|regex:/^\d+(\.\d{1,7})?$/",
            "status" => "required",
            ]
        );
        $input = $request->all();
        $product = new CategoryProduct;
        $product->name = $input['name'];
        $product->product_code = $input['product_code'];
        $product->description = $input['description'];
        $product->transaction_description = $input['transaction_description'];
        $product->category_id = $input['category_id'];
        $product->type = $input['type'];

        if ($product->save())
        {
            $productPrices = new ProductPrices;
            $productPrices->product_id = $product->id;
            $productPrices->cost_price = $input['cost_price'];
            $productPrices->outright_price = $input['outright_price'];
            $productPrices->rrp = $input['rrp'];
            $productPrices->applicable_from_date = date('Y-m-d');
            $productPrices->updated_by_user_id = Auth::user()->id;
            $productPrices->save();

            return redirect()->route('admin.list-product-category')->with('msg', 'Product added Successfully');
        }
    }

    public function list_category()
    {

        $records['data'] = Admin::Where('is_deleted', 0)->get();
        return view('admin.list-category', $records);
    }


    public function add_category(Request $request)
    {
        $this->validate($request, [
            "category" => "required|string|max:255"
        ]);
        $product = new Admin;
        $product->category_name = $request->category;
        if ($product->save()) {
            return redirect()->route('admin.list-category')->with('msg', 'Category added Successfully');
        }
    }

    public function edit_category($id)
    {
        $result['data'] = Admin::find($id);
        return view('admin.edit-category', $result);
    }


    public function update_record(Request $request)
    {
        $this->validate($request, [
            "category" => "required|string|max:255"
        ]);
        $product = Admin::find($request->id);
        $product->category_name = $request->category;

        if ($product->save()) {
            return redirect('list-category/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_category(Request $request)
    {
        $id = $request->id;

        $product = Admin::find($id);
        $product->is_deleted = 1;
        if ($product->save()) {
            return 1;
        }
    }
    public function loadpostcode(Request $request)
	{
        $output='';

        if($request->ajax()) {
            $post_code = Suburb::Where('post_code', 'LIKE', '%'.$request->postcode.'%')->Where('name', 'LIKE', '%'.$request->suburb_id.'%')->where('is_deleted',0)->get();

            if($post_code) {

                foreach($post_code as $key=> $code) {
                $output.='
                    <div class="postcodeResult" id="'.$code->id.'"  onclick="setPostCode(this.id,'.$code->post_code.',\''.$code->name.'\',\''.$code->state.'\')";>
                    <span>'.$code->name.'</span>, <span>'.$code->state.'</span>, <span>'.$code->post_code.'</span></div>';
                }
                return response()->json($output);
            }

        }

	}
    public function add_office()
    {
        $srch_suburb = '';
        $srch_post_code = '';
        $suburb = Suburb::get();
        // dd($suburb);
        return view('admin.add-office', compact('suburb', 'srch_suburb',
        'srch_post_code'));
    }

    public function list_office()
    {
        $records['data'] = Office::Where('is_deleted', 0)->get();
        // dd($records['data']);
        return view('admin.list-office', $records);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "address_name" => "required|string|max:255"
        ]);
        $office = new Office;
        $office->address_name = $request->address_name;
        $office->first_name = $request->first_name;
        $office->last_name = $request->last_name;
        $office->street_name = $request->street_name;
        $office->postcode = $request->srch_post_code;
        $office->suburb = $request->srch_suburb;

        if ($office->save()) {
            return redirect('list-office/')->with('msg', 'Office added Successfully');
        }
    }

    public function show_office($id)
    {
        $result = Office::find($id);
        //dd($result);
        return view('admin.edit-office', compact('result'));
    }

    public function update_office(Request $request)
    {
        $this->validate($request, [
            "address_name" => "required|string|max:255"
        ]);

        $office = Office::find($request->id);
        $office->address_name = $request->address_name;
        $office->first_name = $request->first_name;
        $office->last_name = $request->last_name;
        $office->street_name = $request->street_name;
        $office->postcode = $request->srch_post_code;
        $office->suburb = $request->suburb;
        if ($office->save()) {
            // dd($office);
            return redirect('list-office/')->with('msg', 'Updated Successfully');
        }

    }

    public function delete_office(Request $request)
    {
        $office = Office::find($request->id);

        $office->is_deleted = 1;
        if ($office->save()) {
            return 1;
        }
    }

    public function suburb_index()
    {
        return view('admin.add-suburb');
    }
    public function view_suburb($id){
        $suburb=Suburb::Where('is_deleted',0)->Where('id',$id)->first();
        return view('admin.view-suburb',compact('suburb'));
    }

    public function add_suburb(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255",
            "post_code" => "required|string",
            "state"=>"required|string"
        ]);
        $suburb = new Suburb;
        $suburb->name = $request->name;
        $suburb->post_code = $request->post_code;
        $suburb->state = $request->state;
        $suburb->long_num = $request->long_num;
        $suburb->lat_num = $request->lat_num;
        $suburb->surcharge_num = $request->surcharge_num;
        $suburb->iddeliveryregion = $request->iddeliveryregion;
        if ($suburb->save()) {
            return redirect('list-suburb/')->with('msg', 'Suburb added Successfully');
        }
    }

    public function list_suburb()
    {
        $result['data'] = Suburb::Where('is_deleted', 0)->get();
        return view('admin.list-suburb', $result);
    }
    public function edit_suburb($id)
    {
        $result['data'] = Suburb::find($id);
        return view('admin.edit-suburb', $result);
    }

    public function update_suburb(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255",
            "post_code" => "required|string",
            "state"=>"required|string"
        ]);
        $suburb = Suburb::find($request->id);
        $suburb->name = $request->name;
        $suburb->post_code = $request->post_code;
        $suburb->state = $request->state;
        $suburb->long_num = $request->long_num;
        $suburb->lat_num = $request->lat_num;
        $suburb->surcharge_num = $request->surcharge_num;
        $suburb->iddeliveryregion = $request->iddeliveryregion;
        if ($suburb->save()) {
            return redirect('list-suburb/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_suburb(Request $request)
    {
        $id = $request->id;
        $suburb = Suburb::find($id);
        $suburb->is_deleted = 1;
        if ($suburb->save()) {
            return 1;
        }
    }

    public function supplier_index()
    {
        return view('admin.add-supplier');
    }

    public function list_supplier()
    {
        $result['data'] = Supplier::Where('is_deleted', 0)->get();
        return view('admin.list-supplier', $result);
    }


    public function add_supplier(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255",
        ]);
        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->is_deleted = 0;
        if ($supplier->save()) {
            return redirect('list-supplier/')->with('msg', 'Supplier added Successfully');
        }
    }

    public function edit_supplier($id)
    {
        $result['data'] = Supplier::find($id);
        return view('admin.edit-supplier', $result);
    }

    public function update_supplier(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255",
        ]);
        $supplier = Supplier::find($request->id);
        $supplier->name = $request->name;
        if ($supplier->save()) {
            return redirect('list-supplier/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_supplier(Request $request)
    {
        $id = $request->id;
        $supplier = Supplier::find($id);
        $supplier->is_deleted = 1;
        if ($supplier->save()) {
            return 1;
        }
    }

    public function competitors_index()
    {
        //$records['user_data']=User::all();
        $records['user_data'] = Customer::orderBy('created_at', 'DESC')->get();
        return view('admin.add-competitors', $records);
    }

    public function add_competitors(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $competitors = new Competitors;

        $competitors->name = $request->name;
        $competitors->customer_id = $request->customer_id;
        if ($competitors->save()) {
            return redirect('list-competitors/')->with('msg', 'Competitors added Successfully');
        }
    }

    public function list_competitors()
    {
        $result['data'] = Competitors::Where('is_deleted', 0)->get();
        return view('admin.list-competitors', $result);
    }

    public function edit_competitors($id)
    {
        //$result['user_data']=User::all();
        $result['user_data'] = Customer::orderBy('created_at', 'DESC')->get();
        $result['data'] = Competitors::find($id);
        return view('admin.edit-competitors', $result);
    }
    public function update_competitors(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $competitors = Competitors::find($request->id);
        $competitors->name = $request->name;
        $competitors->customer_id = $request->customer_id;
        if ($competitors->save()) {
            return redirect('list-competitors/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_competitors(Request $request)
    {
        $id = $request->id;
        $competitors = Competitors::find($id);
        $competitors->is_deleted = 1;
        if ($competitors->save()) {
            return 1;
        }
    }

    public function marketing_customer_index()
    {
        return view('admin.add-customer-marketing');
    }

    public function list_marketing_customer()
    {
        $result['data'] = CustomerMarketing::Where('is_deleted', 0)->get();
        return view('admin.list-marketing-customer', $result);
    }
    public function add_marketing_customer(Request $request)
    {
        $this->validate($request, [
            "about_agas" => "required|string|max:255"
        ]);
        $lost = new CustomerMarketing;
        $lost->about_agas = $request->about_agas;
        if ($lost->save()) {
            return redirect('list-marketing-customer/')->with('msg', 'Marketing Customer added Successfully');
        }
    }
    public function show_marketing_customer($id)
    {
        $result['data'] = CustomerMarketing::find($id);
        return view('admin.edit-customer-marketing', $result);
    }
    public function update_marketing_customer(Request $request)
    {
        $this->validate($request, [
            "about_agas" => "required|string|max:255"
        ]);
        $lost = CustomerMarketing::find($request->id);
        $lost->about_agas = $request->about_agas;
        if ($lost->save()) {
            return redirect('list-marketing-customer/')->with('msg', 'Updated Successfully');
        }
    }
    public function delete_marketing_customer(Request $request)
    {
        $id = $request->id;
        $lost = CustomerMarketing::find($id);
        $lost->is_deleted = 1;
        if ($lost->save()) {
            return 1;
        }
    }

    public function lost_customer_index()
    {
        return view('admin.add-lost-customer');
    }

    public function list_lost_customer()
    {
        $result['data'] = LostCustomer::Where('is_deleted', 0)->get();
        return view('admin.list-lost-customer', $result);
    }

    public function add_lost_customer(Request $request)
    {
        $this->validate($request, [
            "reason" => "required|string|max:255"
        ]);
        $lost = new LostCustomer;
        $lost->reason = $request->reason;
        if ($lost->save()) {
            return redirect('list-lostcustomer')->with('msg', 'Lost Customer added Successfully');
        }
    }

    public function show_lost_customer($id)
    {
        $result['data'] = LostCustomer::find($id);
        return view('admin.edit-lost-customer', $result);
    }

    public function update_lost_customer(Request $request)
    {
        $this->validate($request, [
            "reason" => "required|string|max:255"
        ]);
        $lost = LostCustomer::find($request->id);
        $lost->reason = $request->reason;
        if ($lost->save()) {
            return redirect('list-lostcustomer/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_lost_customer(Request $request)
    {
        $id = $request->id;
        $lost = LostCustomer::find($id);
        $lost->is_deleted = 1;
        if ($lost->save()) {
            return 1;
        }
    }


    public function delivery_regions_index()
    {
        $office=Office::where('is_deleted',0)->get();
        return view('admin.add-delivery-regions',compact('office'));
    }

    public function list_delivery_regions()
    {
        $result['data'] = DeliveryRegions::leftJoin('hu_offices as ho','ho.id','=','delivery_regions.dispatch_from')
                                        ->Where('delivery_regions.is_deleted', 0)
                                        ->get(['delivery_regions.id as id','ho.address_name as dispatch_from','delivery_regions.name']);
        $result['office']=Office::Where('is_deleted', 0)->get(['address_name','id']);

        return view('admin.list-delivery-regions', $result);
    }

    public function add_delivery_regions(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $delivery = new DeliveryRegions;
        $delivery->name = $request->name;
        $delivery->delivery_days = $request->delivery_days;
        $delivery->dispatch_from = $request->dispatch_from;
        if ($delivery->save()) {
            return redirect('list-delivery-regions/')->with('msg', 'Delivery Regions added Successfully');
        }
    }

    public function show_delivery_regions($id)
    {   $result['office']=Office::where('is_deleted',0)->get();
        $result['data'] = DeliveryRegions::find($id);
        return view('admin.edit-delivery-regions', $result);
    }

    public function update_delivery_regions(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $delivery = DeliveryRegions::find($request->id);

        $delivery->name = $request->name;
        $delivery->delivery_days = $request->delivery_days;
        $delivery->dispatch_from = $request->dispatch_from;
        if ($delivery->save()) {
            return redirect('list-delivery-regions/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_delivery_regions(Request $request)
    {
        $id = $request->id;
        $delivery = DeliveryRegions::find($id);
        $delivery->is_deleted = 1;
        if ($delivery->save()) {
            return 1;
        }
    }


    public function truck_dispatch_index()
    {
        return view('admin.add-truck-dispatch');
    }

    public function list_truck_dispatch()
    {
        $result['data'] = TruckDispatch::where('is_deleted',0)->get();
        return view('admin.list-truck-dispatch', $result);
    }

    public function add_truck_dispatch(Request $request)
    {
        $input=$request->all();

        $this->validate($request, [
            "make" => "required|string|max:255",
            "rego" => "required|string|max:255"
        ]);
        $truck = new TruckDispatch;
        $truck->make = $input['make'];
        $truck->rego = $input['rego'];
        $truck->type = $input['type'];
        $truck->alias = $input['alias'];
        $truck->model = $input['model'];
        $truck->year = $input['year'];
        $truck->rego_expiry = $input['rego_expiry'];
        $truck->klms = $input['klms'];
        $truck->vin_number = $input['vin_number'];
        $truck->status = $input['status'];
        $truck->tank_capacity = $input['tank_capacity'];
        $truck->fuel_capacity = $input['fuel_capacity'];
        $truck->company = $input['company_name'];
        $truck->branch = $input['branch'];
        $truck->employee = $input['employee'];
        $truck->coc_expiry = $input['coc_expiry'];
        $truck->coi = $input['coi'];
        $truck->vehicle_status = $input['vehicle_status'];
        $truck->notes = isset($input['notes']) ? $input['notes']:'';
        if(isset( $input['images'])){
        $imageName = time().'.'.$input['images']->extension();
        $path = $request->file('images')->storeAs('/public/agas/truck_image', $imageName);
        $data['file_name'] = $imageName;
        $file_path = str_replace('public/','storage/',$path);
        }
        $truck->images = isset($file_path) ? $file_path:'';


        if ($truck->save()) {
            return redirect('list-truck-dispatch/')->with('msg', 'Truck & Dispatch added Successfully');
        }
    }

    public function show_truck_dispatch($id)
    {
        $result['data'] = TruckDispatch::find($id);

        return view('admin.edit-truck-dispatch', $result);
    }

    public function maintain_truck_dispatch($id)
    {
        $trucks = TruckDispatch::find($id);
        $users = User::where('is_deleted',0)->get();
        $services=ServiceRecords::where('truck_id','=',$id)->get();
        $services_det=array();
        foreach($services as $key=>$val){
            $services_det[$key]['id']=$val['id'];
            $services_det[$key]['truck_id']=$val['truck_id'];
            $service_truck = TruckDispatch::where('id','=',$val['truck_id'])->first();
            $services_det[$key]['truck_name']=$service_truck['name'];
            $services_det[$key]['make']=$service_truck['make'];
            $services_det[$key]['service_type']=$val['service_type'];
            $services_det[$key]['status']=$val['status'];
            $spares=RequiredSpares::where('service_id','=',$val['id'])->get();
            $spares_det=array();
            foreach($spares as $key1=>$vals){
                $spares_det[$key1]['spare_name']=$vals['spare_name'];
                $spares_det[$key1]['quantity']=$vals['quantity'];
                $spares_det[$key1]['unit_price']=$vals['unit_price'];
                $spares_det[$key1]['total_price']=$vals['total_price'];
            }
            $services_det[$key]['spares']=$spares_det;
        }
        return view('admin.maintain-truck-dispatch',compact('services_det','trucks','users'));
    }
    public function add_service_record($id)
    {
        $add='1';
        $trucks = TruckDispatch::find($id);
        $users = User::where('is_deleted',0)->get();
        return view('admin.add-service-record',compact('trucks','users','add'));
    }
    public function edit_service_record($id,$sid)
    {
        $edit='1';
        $trucks = TruckDispatch::find($id);
        $users = User::where('is_deleted',0)->get();
        $services=ServiceRecords::where('id','=',$sid)->first();
        $spares=RequiredSpares::where('service_id','=',$sid)->get();
        return view('admin.add-service-record',compact('spares','services','trucks','users','edit','id','sid'));
    }
    public function createServiceRecord(Request $request)
    {
        $input=$request->all();
        if(isset($input['report'])){
            $fileName = request()->report->getClientOriginalName();
            $path = $request->report->storeAs('/public/agas/serviceRecords', $fileName);
        }
        else{ $fileName = ''; $path = '';}
        //dd($input);
        $service = new ServiceRecords;
        $service->truck_id=$input['truck_id'];
        $service->start_date=$input['start_date'];
        $service->end_date=$input['end_date'];
        $service->phone=$input['end_time'];
        $service->email=$input['email'];
        $service->serviced_by=$input['serviced_by'];
        $service->quoted_price=$input['quoted_price'];
        $service->quote_accepted_by=$input['quote_acceptedby'];
        $service->checked_date=$input['checked_date'];
        $service->checked_by=$input['checked_by'];
        $service->service_type=$input['service_type'];
        $service->suppliers_name=$input['suppliers_name'];
        $service->suppliers_address=$input['Suppliers_address'];
        $service->invoice_no=$input['invoice_no'];
        $service->order_no=$input['order_no'];
        $service->invoice_price=$input['price'];
        $service->manager_name=$input['manager_name'];
        $service->authorised_by=$input['auth_by'];
        $service->invoice_checked=$input['invoice_checked'];
        $service->manager_accepted=$input['manager_accepted'];
        $service->ready_to_pay=$input['ready_to_pay'];
        $service->report_path=$path;
        $service->availability=$input['availability'];
        $service->created_by=Auth::user()->id;
        $service->updated_by=Auth::user()->id;
        $service->save();

        $id=$service->id;
        if(isset($request->spare_name)){
            $spare_name=$request->spare_name;
            $quantity=$request->quantity;
            $unit_price=$request->unit_price;
            $total_price=$request->total_price;

            foreach($spare_name as $key=>$name){

                $required_spares=new RequiredSpares;
                $required_spares->truck_id=$input['truck_id'];
                $required_spares->service_id=$id;
                $required_spares->spare_name=isset($spare_name[$key]) ? $spare_name[$key]:'';
                $required_spares->quantity=isset($quantity[$key]) ? $quantity[$key]:'';
                $required_spares->unit_price=isset($unit_price[$key]) ? $unit_price[$key]:'';
                $required_spares->total_price=isset($total_price[$key]) ? $total_price[$key]:'';
                $required_spares->created_by=Auth::user()->id;
                $required_spares->updated_by=Auth::user()->id;
                $required_spares->save();
            }
        }

        //dd($service);

        return redirect()->route('admin.edit-truck-dispatch',$input['truck_id'])->with('msg', 'Truck & Dispatch added Successfully');

    }

    public function updateServiceRecord(Request $request)
    {
        $input=$request->all();
        //dd($input);
        if(isset($input['report'])){
            $fileName = request()->report->getClientOriginalName();
            $path = $request->report->storeAs('/public/agas/serviceRecords', $fileName);
        }
        else{ $fileName = ''; $path = '';}
        //dd($input);
        $service =ServiceRecords::where('id','=',$input['service_id'])->first();
        $service->truck_id=$input['truck_id'];
        $service->start_date=$input['start_date'];
        $service->end_date=$input['end_date'];
        $service->phone=$input['end_time'];
        $service->email=$input['email'];
        $service->serviced_by=$input['serviced_by'];
        $service->quoted_price=$input['quoted_price'];
        $service->quote_accepted_by=$input['quote_acceptedby'];
        $service->checked_date=$input['checked_date'];
        $service->checked_by=$input['checked_by'];
        $service->service_type=$input['service_type'];
        $service->suppliers_name=$input['suppliers_name'];
        $service->suppliers_address=$input['Suppliers_address'];
        $service->invoice_no=$input['invoice_no'];
        $service->order_no=$input['order_no'];
        $service->invoice_price=$input['price'];
        $service->manager_name=$input['manager_name'];
        $service->authorised_by=$input['auth_by'];
        $service->invoice_checked=$input['invoice_checked'];
        $service->manager_accepted=$input['manager_accepted'];
        $service->ready_to_pay=$input['ready_to_pay'];
        $service->report_path=$path;
        $service->availability=$input['availability'];
        $service->created_by=Auth::user()->id;
        $service->updated_by=Auth::user()->id;
        $service->save();


        if(isset($request->spare_name)){
            $spare_id=$request->spare_id;
            $spare_name=$request->spare_name;
            $quantity=$request->quantity;
            $unit_price=$request->unit_price;
            $total_price=$request->total_price;

            foreach($spare_name as $key=>$name){

                $required_spares=RequiredSpares::where('id','=',$spare_id[$key])->first();

                $required_spares->spare_name=isset($spare_name[$key]) ? $spare_name[$key]:'';
                $required_spares->quantity=isset($quantity[$key]) ? $quantity[$key]:'';
                $required_spares->unit_price=isset($unit_price[$key]) ? $unit_price[$key]:'';
                $required_spares->total_price=isset($total_price[$key]) ? $total_price[$key]:'';
                $required_spares->created_by=Auth::user()->id;
                $required_spares->updated_by=Auth::user()->id;
                $required_spares->save();
            }
        }

        //dd($service);

        return redirect()->route('admin.edit-truck-dispatch',$input['truck_id'])->with('msg', 'Truck & Dispatch added Successfully');

    }


    public function update_truck_dispatch(Request $request)
    {
        $input=$request->all();
        $this->validate($request, [
            "make" => "required|string|max:255",
            "rego" => "required|string|max:255"
        ]);
        $truck = TruckDispatch::find($request->id);

        $truck->make = $input['make'];
        $truck->rego = $input['rego'];
        $truck->type = $input['type'];
        $truck->alias = $input['alias'];
        $truck->model = $input['model'];
        $truck->year = $input['year'];
        $truck->rego_expiry = $input['rego_expiry'];
        $truck->klms = $input['klms'];
        $truck->vin_number = $input['vin_number'];
        $truck->status = $input['status'];
        $truck->tank_capacity = $input['tank_capacity'];
        $truck->fuel_capacity = $input['fuel_capacity'];
        $truck->company = $input['company_name'];
        $truck->branch = $input['branch'];
        $truck->employee = $input['employee'];
        $truck->coc_expiry = $input['coc_expiry'];
        $truck->coi = $input['coi'];
        $truck->vehicle_status = $input['vehicle_status'];
        $truck->notes = isset($input['notes']) ? $input['notes']:'';

             if(isset($input['images'])){
                $imageName = time().'.'.$input['images']->extension();
                $path = $request->file('images')->storeAs('/public/agas/truck_image', $imageName);
                $data['file_name'] = $imageName;
                $file_path = str_replace('public/','storage/',$path);
               }

               $oldimg=empty($input['old_image']) ? '':$input['old_image'];




        $truck->images = isset($file_path) ? $file_path:$oldimg;

        if ($truck->save()) {
            return redirect('list-truck-dispatch/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_truck_dispatch(Request $request)
    {
        $id = $request->id;
        $truck = TruckDispatch::find($id);
        $truck->is_deleted = 1;
        if ($truck->save()) {
            return 1;
        }
    }


    public function class_types_index()
    {
        return view('admin.add-class-types');
    }

    public function list_class_types()
    {
        $result['data'] = ClassTypes::Where('is_deleted', 0)->get();
        return view('admin.list-class-types', $result);
    }

    public function add_class_types(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $classtype = new ClassTypes;
        $classtype->name = $request->name;
        if ($classtype->save()) {
            return redirect('list-class-types/')->with('msg', 'Class Types added Successfully');
        }
    }

    public function show_class_types($id)
    {
        $result['data'] = ClassTypes::find($id);
        return view('admin.edit-class-types', $result);
    }

    public function update_class_types(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $classtype = ClassTypes::find($request->id);
        $classtype->name = $request->name;
        if ($classtype->save()) {
            return redirect('list-class-types/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_class_types(Request $request)
    {
        $id = $request->id;
        $classtype = ClassTypes::find($id);
        $classtype->is_deleted = 1;
        if ($classtype->save()) {
            return 1;
        }
    }

    public function safety_items_index()
    {
        return view('admin.add-safety-items');
    }

    public function list_safety_items()
    {
        $result['data'] = SafetyItems::Where('is_deleted', 0)->get();
        return view('admin.list-safety-items', $result);
    }

    public function add_safety_items(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $items = new SafetyItems;
        $items->name = $request->name;
        if ($items->save()) {
            return redirect('list-safety-items/')->with('msg', 'Safety Items added Successfully');
        }
    }

    public function show_safety_items($id)
    {
        $result['data'] = SafetyItems::find($id);
        return view('admin.edit-safety-items', $result);
    }

    public function update_safety_items(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:255"
        ]);
        $items = SafetyItems::find($request->id);
        $items->name = $request->name;
        if ($items->save()) {
            return redirect('list-safety-items/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_safety_items(Request $request)
    {
        $id = $request->id;
        $items = SafetyItems::find($id);
        $items->is_deleted = 1;
        if ($items->save()) {
            return 1;
        }
    }


    public function no_delivery_reasons_index()
    {
        return view('admin.add-no-delivery-reasons');
    }

    public function list_no_delivery_reasons()
    {
        $result['data'] = NoDeliveryReasons::Where('is_deleted', 0)->get();
        return view('admin.list-no-delivery-reasons', $result);
    }

    public function add_no_delivery_reasons(Request $request)
    {
        $this->validate($request, [
            "reason" => "required|string|max:255"
        ]);
        $reason = new NoDeliveryReasons;
        $reason->reason = $request->reason;
        if ($reason->save()) {
            return redirect('list-no-delivery-reasons/')->with('msg', 'No Delivery Reason added Successfully');
        }
    }

    public function show_no_delivery_reasons($id)
    {
        $result['data'] = NoDeliveryReasons::find($id);
        return view('admin.edit-no-delivery-reasons', $result);
    }

    public function update_no_delivery_reasons(Request $request)
    {
        $this->validate($request, [
            "reason" => "required|string|max:255"
        ]);
        $reason = NoDeliveryReasons::find($request->id);
        $reason->reason = $request->reason;
        if ($reason->save()) {
            return redirect('list-no-delivery-reasons/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_no_delivery_reasons(Request $request)
    {
        $id = $request->id;
        $reason = NoDeliveryReasons::find($id);
        $reason->is_deleted = 1;
        if ($reason->save()) {
            return 1;
        }
    }


    public function missing_docket_reasons_index()
    {
        return view('admin.add-missing-docket-reasons');
    }

    public function list_missing_docket_reasons()
    {
        $result['data'] = MissingDocketReasons::Where('is_deleted', 0)->get();
        return view('admin.list-missing-docket-reasons', $result);
    }

    public function add_missing_docket_reasons(Request $request)
    {
        $this->validate($request, [
            "reason" => "required|string|max:255"
        ]);
        $reason = new MissingDocketReasons;
        $reason->reason = $request->reason;
        if ($reason->save()) {
            return redirect('list-missing-docket-reasons/')->with('msg', 'Missing Docket Reason added Successfully');
        }
    }

    public function show_missing_docket_reasons($id)
    {
        $result['data'] = MissingDocketReasons::find($id);
        return view('admin.edit-missing-docket-reasons', $result);
    }

    public function update_missing_docket_reasons(Request $request)
    {
        $this->validate($request, [
            "reason" => "required|string|max:255"
        ]);
        $reason = MissingDocketReasons::find($request->id);
        $reason->reason = $request->reason;
        if ($reason->save()) {
            return redirect('list-missing-docket-reasons/')->with('msg', 'Updated Successfully');
        }
    }

    public function delete_missing_docket_reasons(Request $request)
    {
        $id = $request->id;
        $reason = MissingDocketReasons::find($id);
        $reason->is_deleted = 1;
        if ($reason->save()) {
            return 1;
        }
    }
    public function lead_prospects(){
        $prospect = Lead::Where('is_deleted', 0)->Where('current_lead_status',5)->get();
        $prosp=array();
        foreach($prospect as $key=>$row){
            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
            $prosp[$key]['id']=$row['id'];
            $prosp[$key]['name']=$row['first_name'].' '.$row['last_name'];
            $prosp[$key]['phone_number']=$row['phone_number'];
            $prosp[$key]['email']=$row['email'];
            $prosp[$key]['product_id']=$row['product'];
            $prosp[$key]['product']=isset($categoryProduct['name']) ? $categoryProduct['name']:'';
            $prosp[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
            $prosp[$key]['company_name']=$row['company_name'];
            $prosp[$key]['address']=$row['address'];
            $prosp[$key]['enquiry_notes']=$row['enquiry_notes'];
            $prosp[$key]['industry']=$row['industry'];
            $prosp[$key]['customer_found_us']=isset($customermark['about_agas']) ? $customermark['about_agas']:'';
            $prosp[$key]['job_title']=$row['job_title'];
            $prosp[$key]['created_at']=$row['created_at'];
            $prosp[$key]['contactable_date']=$row['contactable_date'];
            $prosp[$key]['updated_at']=$row['updated_at'];
            $prosp[$key]['custid']=$row['customer_id'];
            $prosp[$key]['status']=$row['current_lead_status'];

        }
        return view('admin.list-prospects',compact('prosp'));
    }

    public function prospect_search(Request $request){
        $input=$request->all();
        $fname=$input['firstname'];
        $lname=$input['lastname'];
        $email=$input['email'];
        $phone=$input['phone'];
        $company=$input['companyname'];
        $product=$input['cust-convert'];
       // DB::enableQueryLog();
        $leadarrr = Lead::Where('is_deleted', 0)
                ->Where('current_lead_status',5)
				->Where('first_name', '=',  $fname)
				->orWhere('last_name', '=',  $lname)
				->orWhere('email', '=',  $email)
				->orWhere('phone_number', '=',  $phone)
				->orWhere('company_name', '=',  $company)
                ->orWhere('product', '=',  $product)
				->orderBy('created_at', 'DESC')->get();
            //    $queries = \DB::getQueryLog();
            //   dd($queries);
            $prosp=array();
            foreach($leadarrr as $key=>$row){
                $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
                $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
                $prosp[$key]['id']=$row['id'];
                $prosp[$key]['name']=$row['first_name'].' '.$row['last_name'];
                $prosp[$key]['phone_number']=$row['phone_number'];
                $prosp[$key]['email']=$row['email'];
                $prosp[$key]['product']=$categoryProduct['name'];
                $prosp[$key]['product_id']=$row['product'];
                $prosp[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
                $prosp[$key]['company_name']=$row['company_name'];
                $prosp[$key]['address']=$row['address'];
                $prosp[$key]['enquiry_notes']=$row['enquiry_notes'];
                $prosp[$key]['industry']=$row['industry'];
                $prosp[$key]['customer_found_us']=$customermark['about_agas'] ? $customermark['about_agas']:'';
                $prosp[$key]['job_title']=$row['job_title'];
                $prosp[$key]['created_at']=$row['created_at'];
                $prosp[$key]['updated_at']=$row['updated_at'];
                $prosp[$key]['contactable_date']=$row['contactable_date'];
                $prosp[$key]['status']=$row['current_lead_status'];
                $prosp[$key]['custid']=isset($row['customer_id']) ? $row['customer_id']:'';
            }
        return view('admin.list-prospects', compact('prosp'));

    }

    public function leads_index()
    {
        $data = Lead::Where('is_deleted', 0)->get();
        $yet=Lead::Where('is_deleted', 0)->Wherein('current_lead_status',[7,10])->get();
        $followup = Lead::Where('is_deleted', 0)->Wherein('current_lead_status',[2,3,4])->get();
        $prospect = Lead::Where('is_deleted', 0)->Where('current_lead_status',5)->get();
        $disq = Lead::Where('is_deleted', 0)->Where('current_lead_status',[6])->get();
        $not = Lead::Where('is_deleted', 0)->Where('current_lead_status',[1])->get();

        $leadarr=$followarr=$prosp=$disqarr=$yetfollow=$notint=array();
        foreach($data as $key=>$row){
            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
            $leadarr[$key]['id']=$row['id'];
            $leadarr[$key]['name']=$row['first_name'].' '.$row['last_name'];
            $leadarr[$key]['phone_number']=$row['phone_number'];
            $leadarr[$key]['email']=$row['email'];
            $leadarr[$key]['product_id']=$row['product'];
            $leadarr[$key]['product']=isset($categoryProduct['name']) ? $categoryProduct['name']:'';
            $leadarr[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
            $leadarr[$key]['company_name']=$row['company_name'];
            $leadarr[$key]['address']=$row['address'];
            $leadarr[$key]['enquiry_notes']=$row['enquiry_notes'];
            $leadarr[$key]['industry']=$row['industry'];
            $leadarr[$key]['customer_found_us']=isset($customermark['about_agas']) ? $customermark['about_agas']:'';
            $leadarr[$key]['job_title']=$row['job_title'];
            $leadarr[$key]['created_at']=$row['created_at'];
            $leadarr[$key]['contactable_date']=$row['contactable_date'];
            $leadarr[$key]['updated_at']=$row['updated_at'];
            $leadarr[$key]['custid']=isset($row['customer_id']) ? $row['customer_id']:'';
            $leadarr[$key]['status']=$row['current_lead_status'];
        }
        foreach($not as $key=>$row){
            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
            $notint[$key]['id']=$row['id'];
            $notint[$key]['name']=$row['first_name'].' '.$row['last_name'];
            $notint[$key]['phone_number']=$row['phone_number'];
            $notint[$key]['email']=$row['email'];
            $notint[$key]['product']=isset($categoryProduct['name']) ? $categoryProduct['name']:'';
            $notint[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
            $notint[$key]['company_name']=$row['company_name'];
            $notint[$key]['address']=$row['address'];
            $notint[$key]['enquiry_notes']=$row['enquiry_notes'];
            $notint[$key]['industry']=$row['industry'];
            $notint[$key]['customer_found_us']=isset($customermark['about_agas']) ? $customermark['about_agas']:'';
            $notint[$key]['job_title']=$row['job_title'];
            $notint[$key]['created_at']=$row['created_at'];
            $notint[$key]['contactable_date']=$row['contactable_date'];
            $notint[$key]['updated_at']=$row['updated_at'];
            $notint[$key]['status']=$row['current_lead_status'];
        }
        foreach($followup as $key=>$row){
            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
            $followarr[$key]['id']=$row['id'];
            $followarr[$key]['name']=$row['first_name'].' '.$row['last_name'];
            $followarr[$key]['phone_number']=$row['phone_number'];
            $followarr[$key]['email']=$row['email'];
            $followarr[$key]['product']=isset($categoryProduct['name']) ? $categoryProduct['name']:'';
            $followarr[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
            $followarr[$key]['company_name']=$row['company_name'];
            $followarr[$key]['address']=$row['address'];
            $followarr[$key]['enquiry_notes']=$row['enquiry_notes'];
            $followarr[$key]['industry']=$row['industry'];
            $followarr[$key]['customer_found_us']=isset($customermark['about_agas']) ? $customermark['about_agas']:'';
            $followarr[$key]['job_title']=$row['job_title'];
            $followarr[$key]['created_at']=$row['created_at'];
            $followarr[$key]['contactable_date']=$row['contactable_date'];
            $followarr[$key]['updated_at']=$row['updated_at'];
            $followarr[$key]['status']=$row['current_lead_status'];

        }

        foreach($prospect as $key=>$row){
            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
            $prosp[$key]['id']=$row['id'];
            $prosp[$key]['name']=$row['first_name'].' '.$row['last_name'];
            $prosp[$key]['phone_number']=$row['phone_number'];
            $prosp[$key]['email']=$row['email'];
            $prosp[$key]['product']=isset($categoryProduct['name']) ? $categoryProduct['name']:'';
            $prosp[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
            $prosp[$key]['company_name']=$row['company_name'];
            $prosp[$key]['address']=$row['address'];
            $prosp[$key]['enquiry_notes']=$row['enquiry_notes'];
            $prosp[$key]['industry']=$row['industry'];
            $prosp[$key]['customer_found_us']=isset($customermark['about_agas']) ? $customermark['about_agas']:'';
            $prosp[$key]['job_title']=$row['job_title'];
            $prosp[$key]['created_at']=$row['created_at'];
            $prosp[$key]['contactable_date']=$row['contactable_date'];
            $prosp[$key]['updated_at']=$row['updated_at'];
            $prosp[$key]['custid']=isset($row['customer_id']) ? $row['customer_id']:'';;
            $prosp[$key]['status']=$row['current_lead_status'];

        }
        foreach($disq as $key=>$row){
            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
            $disqarr[$key]['id']=$row['id'];
            $disqarr[$key]['name']=$row['first_name'].' '.$row['last_name'];
            $disqarr[$key]['phone_number']=$row['phone_number'];
            $disqarr[$key]['email']=$row['email'];
            $disqarr[$key]['product']=isset($categoryProduct['name']) ? $categoryProduct['name']:'';
            $disqarr[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
            $disqarr[$key]['company_name']=$row['company_name'];
            $disqarr[$key]['address']=$row['address'];
            $disqarr[$key]['enquiry_notes']=$row['enquiry_notes'];
            $disqarr[$key]['industry']=$row['industry'];
            $disqarr[$key]['customer_found_us']=isset($customermark['about_agas']) ? $customermark['about_agas']:'';
            $disqarr[$key]['job_title']=$row['job_title'];
            $disqarr[$key]['created_at']=$row['created_at'];
            $disqarr[$key]['contactable_date']=$row['contactable_date'];
            $disqarr[$key]['updated_at']=$row['updated_at'];
            $disqarr[$key]['status']=$row['current_lead_status'];

        }
        foreach($yet as $key=>$row){
            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
            $yetfollow[$key]['id']=$row['id'];
            $yetfollow[$key]['name']=$row['first_name'].' '.$row['last_name'];
            $yetfollow[$key]['phone_number']=$row['phone_number'];
            $yetfollow[$key]['email']=$row['email'];
            $yetfollow[$key]['product']=isset($categoryProduct['name']) ? $categoryProduct['name']:'';
            $yetfollow[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
            $yetfollow[$key]['company_name']=$row['company_name'];
            $yetfollow[$key]['address']=$row['address'];
            $yetfollow[$key]['enquiry_notes']=$row['enquiry_notes'];
            $yetfollow[$key]['industry']=$row['industry'];
            $yetfollow[$key]['customer_found_us']=isset($customermark['about_agas']) ? $customermark['about_agas']:'';
            $yetfollow[$key]['job_title']=$row['job_title'];
            $yetfollow[$key]['created_at']=$row['created_at'];
            $yetfollow[$key]['contactable_date']=$row['contactable_date'];
            $yetfollow[$key]['updated_at']=$row['updated_at'];
            $yetfollow[$key]['status']=$row['current_lead_status'];

        }
    //   dd($notint);
        return view('admin.list-leads',compact('leadarr','followarr','prosp','disqarr','yetfollow','notint'));
    }

    public function create_lead()
    {
        // if (!$this->hasPermission('create-leads')) {
        //     abort(403);
        // }
        $customerMarketings = CustomerMarketing::orderBy('created_at', 'DESC')->get();
        // dd($customerMarketings->toArray());
        $categoryProduct = CategoryProduct::where('is_deleted', 0)->get();
        // $supplier=Supplier::orderBy('created_at', 'DESC')->get();
        $supplier = Competitors::Where('is_deleted', 0)->get();
        return view("admin.add-leads", compact('customerMarketings', 'categoryProduct', 'supplier'));
    }

    public function store_lead(Request $request)
    {
        $input = $request->all();
        $lead = new lead;
        $lead->first_name = $input['first_name'];
        $lead->phone_number = $input['phone_number'];
        $lead->email = $input['email'];
        $lead->last_name = $input['last_name'];
        $lead->account_type = $input['account_type'];
        $lead->customer_found_us = $input['customer_found_us'];
        $lead->job_title = $input['job_title'];
        $lead->company_name = $input['company_name'];
        $lead->industry = $input['industry'];
        $lead->website = $input['website'];
        $lead->nature_of_enquiry = $input['nature_of_enquiry'];
        $lead->reason_for_call = $input['reason_for_call'];
        $lead->current_supplier_name = $input['current_supplier_name'];
        $lead->product = $input['products'];
        $lead->current_supplier_price = $input['current_supplier_price'];
        $lead->rental_price = $input['rental_price'];
        $lead->agas_price = $input['agas_price'];
        $lead->yearly_rental_price = $input['yearly_rental_price'];
        $lead->daily_rental_price = $input['daily_rental_price'];
        $lead->half_yearly_rental_price = $input['half_yearly_rental_price'];
        $lead->quarterly_rental_price = $input['quarterly_rental_price'];
        $lead->monthly_rental_price = $input['monthly_rental_price'];
        $lead->weekly_rental_price = $input['weekly_rental_price'];
        $lead->delivery_time = $input['delivery_time'];
        $lead->address = $input['address'];
        $lead->enquiry_notes = $input['enquiry_notes'];
        $lead->close_reason = $input['close_reason'];
        $lead->price_types = $input['price_types'];
        $lead->contactable_date=date('Y-m-d h:i',strtotime("+1 day"));
        $lead->created_by = Auth::user()->id;
        // lead status 7 --> Lead Created
        $lead->current_lead_status = 7;
        $lead->save();
        $lead_id=$lead->id;
        $leadstatus=new LeadStatus;
        $leadstatus->lead_id=$lead_id;
        $leadstatus->lead_status=7;
        $actionid=7;
        $leadstatus->created_by=Auth::user()->id;
        if ($leadstatus->save()) {
            $user = 'customer';
		$module = 'Sales-module';
		$timemsg = 'Lead Created';
		$today = date("Y-m-d");
        $cmnt='';
		if (!$this->hasSalesactivity($user, $lead_id ,$actionid,$module, $timemsg, $today, $input,$cmnt)) {
			$log = Log::info("Lead created successfully");
		}

            return redirect('leads')->with('msg', 'Lead added Successfully');
        }
    }

    public function edit_lead($id)
    {
        $customerMarketings = CustomerMarketing::orderBy('created_at', 'DESC')->get();
        $supplier = Competitors::Where('is_deleted', 0)->get();
        $categoryProduct = CategoryProduct::where('is_deleted', 0)->get();
        $lead = Lead::find($id);
        return view('admin.edit-leads', compact('lead','categoryProduct', 'customerMarketings', 'supplier'));
    }

    public function update_lead(Request $request)
    {
        $input = $request->all();
        $lead = Lead::find($input['id']);
        $lead->first_name = $input['first_name'];
        $lead->phone_number = $input['phone_number'];
        $lead->email = $input['email'];
        $lead->last_name = $input['last_name'];
        $lead->account_type = $input['account_type'];
        $lead->customer_found_us = $input['customer_found_us'];
        $lead->job_title = $input['job_title'];
        $lead->company_name = $input['company_name'];
        $lead->industry = $input['industry'];
        $lead->website = $input['website'];
        $lead->nature_of_enquiry = $input['nature_of_enquiry'];
        $lead->reason_for_call = $input['reason_for_call'];
        $lead->current_supplier_name = $input['current_supplier_name'];
        $lead->product = $input['products'];
        $lead->current_supplier_price = $input['current_supplier_price'];
        $lead->rental_price = $input['rental_price'];
        $lead->agas_price = $input['agas_price'];
        $lead->yearly_rental_price = $input['yearly_rental_price'];
        $lead->daily_rental_price = $input['daily_rental_price'];
        $lead->half_yearly_rental_price = $input['half_yearly_rental_price'];
        $lead->quarterly_rental_price = $input['quarterly_rental_price'];
        $lead->monthly_rental_price = $input['monthly_rental_price'];
        $lead->weekly_rental_price = $input['weekly_rental_price'];
        $lead->delivery_time = $input['delivery_time'];
        $lead->address = $input['address'];
        $lead->enquiry_notes = $input['enquiry_notes'];
        $lead->close_reason = $input['close_reason'];
        $lead->last_updated_by = Auth::user()->id;
        $lead->price_types = $input['price_types'];
        //$lead->contactable_date=date('Y-m-d h:i',strtotime($input['contactable_date']));
         // lead status 10 --> Lead Updated
         $lead->current_lead_status = 10;
         $lead->save();
        $lead_id=$lead->id;
        $leadstatus=new LeadStatus;
        $leadstatus->lead_id=$lead_id;
        $leadstatus->lead_status=10;
        $actionid=10;
        $leadstatus->created_by=Auth::user()->id;
        if ($leadstatus->save()) {
            $user = 'customer';
            $module = 'Sales-module';
            $timemsg = 'Lead Updated';
            $today = date("Y-m-d");
            $cmnt='';
            if (!$this->hasSalesactivity($user,$lead_id,$actionid, $module, $timemsg, $today, $input,$cmnt)) {
                $log = Log::info("Lead Updated successfully");
            }
            return redirect('leads')->with('msg', 'Lead Updated Successfully');
        }
    }

    public function delete_lead(Request $request)
    {
        $id = $request->id;
        $lead = Lead::find($id);
        $lead->is_deleted = 1;
        if ($lead->save()) {
            return 1;
        }
    }

    public function get_product_prices(Request $request){
        $proid=$request->product_id;
        $categoryProduct=ProductRentalPrice::find($proid);
        $product=CategoryProduct::find($proid);
        //$data=array();
       // dd($categoryProduct);
            $data=array(
                'rrp'=>$product->rrp,
                'daily_price'=>isset($categoryProduct->daily_price) ? $categoryProduct->daily_price :0,
                'weekly_price'=>isset($categoryProduct->weekly_price) ? $categoryProduct->weekly_price:0,
                'monthly_price'=>isset($categoryProduct->monthly_price) ? $categoryProduct->monthly_price:0,
                'quarterly_price'=>isset($categoryProduct->quarterly_price) ? $categoryProduct->quarterly_price:0,
                'half_yearly_price'=>isset($categoryProduct->half_yearly_price) ? $categoryProduct->half_yearly_price:0,
                'yearly_price'=>isset($categoryProduct->yearly_price) ? $categoryProduct->yearly_price:0,
            );

        echo json_encode($data);
    }

    public function leads_search(Request $request){
        $input=$request->all();
        $fname=$input['firstname'];
        $lname=$input['lastname'];
        $email=$input['email'];
        $phone=$input['phone'];
        $company=$input['companyname'];
        $product=$input['cust-convert'];
       // DB::enableQueryLog();
        $leadarrr = Lead::Where('is_deleted', 0)
				->Where('first_name', '=',  $fname)
				->orWhere('last_name', '=',  $lname)
				->orWhere('email', '=',  $email)
				->orWhere('phone_number', '=',  $phone)
				->orWhere('company_name', '=',  $company)
                ->orWhere('product', '=',  $product)
				->orderBy('created_at', 'DESC')->get();
            //    $queries = \DB::getQueryLog();
            //   dd($queries);
            $leadarr=array();
            foreach($leadarrr as $key=>$row){
                $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$row['product'])->first();
                $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$row['customer_found_us'])->first();
                $leadarr[$key]['id']=$row['id'];
                $leadarr[$key]['name']=$row['first_name'].' '.$row['last_name'];
                $leadarr[$key]['phone_number']=$row['phone_number'];
                $leadarr[$key]['email']=$row['email'];
                $leadarr[$key]['product']=$categoryProduct['name'];
                $leadarr[$key]['product_id']=$row['product'];
                $leadarr[$key]['nature_of_enquiry']=$row['nature_of_enquiry'];
                $leadarr[$key]['company_name']=$row['company_name'];
                $leadarr[$key]['address']=$row['address'];
                $leadarr[$key]['enquiry_notes']=$row['enquiry_notes'];
                $leadarr[$key]['industry']=$row['industry'];
                $leadarr[$key]['customer_found_us']=$customermark['about_agas'] ? $customermark['about_agas']:'';
                $leadarr[$key]['job_title']=$row['job_title'];
                $leadarr[$key]['created_at']=$row['created_at'];
                $leadarr[$key]['updated_at']=$row['updated_at'];
                $leadarr[$key]['contactable_date']=$row['contactable_date'];
                $leadarr[$key]['status']=$row['current_lead_status'];
                $leadarr[$key]['custid']=isset($row['customer_id']) ? $row['customer_id']:'';
            }
        return view('admin.list-leads', compact('leadarr'));
    }

    public function leads_details($id){
        $lead=Lead::where('id',$id)->first();
        $logs=LeadTimeline::where('lead_id',$id)->orderBy('created_at', 'DESC')->get();
        $status=LeadMaster::where('is_deleted',0)->whereNotIn('id',[7,8,9,10,11])->get();

            $leads=array();

            $categoryProduct = CategoryProduct::where('is_deleted', 0)->Where('id',$lead['product'])->first();
            $customermark=CustomerMarketing::where('is_deleted',0)->Where('id',$lead['customer_found_us'])->first();
            $leads['id']=$lead['id'];
            $leads['first_name']=$lead['first_name'];
            $leads['last_name']=$lead['last_name'];
            $leads['phone_number']=$lead['phone_number'];
            $leads['email']=$lead['email'];
            $leads['product']=$categoryProduct['name'];
            $leads['nature_of_enquiry']=$lead['nature_of_enquiry'];
            $leads['company_name']=$lead['company_name'];
            $leads['address']=$lead['address'];
            $leads['enquiry_notes']=$lead['enquiry_notes'];
            $leads['industry']=$lead['industry'];
            $leads['price_types']=$lead['price_types'];
            $leads['year']=$lead['yearly_rental_price'];
            $leads['daily']=$lead['daily_rental_price'];
            $leads['half']=$lead['half_yearly_rental_price'];
            $leads['quart']=$lead['quarterly_rental_price'];
            $leads['month']=$lead['monthly_rental_price'];
            $leads['week']=$lead['weekly_rental_price'];
            $leads['supplier_price']=$lead['current_supplier_price'];
            $leads['rental_price']=$lead['rental_price'];
            $leads['agas_price']=$lead['agas_price'];
            $leads['address']=$lead['address'];
            $leads['customer_found_us']=$customermark['about_agas'] ? $customermark['about_agas']:'';
            $leads['job_title']=$lead['job_title'];
            $leads['contactable_date']=date('Y-m-d h:i a',strtotime($lead['contactable_date']));
            $leads['created_at']=$lead['created_at'];
            $leads['updated_at']=$lead['updated_at'];


        $userid=Auth::user()->id;
        $users=User::where('is_deleted',0)->where('id','!=',$userid)->get();
        return view('admin.leads-details', compact('leads','logs','status','users'));
    }

    public function lead_followup(Request $request){
        $input=$request->all();
        $actionname=array('','Not Interested','Not Answered','Call Later','Need More Details','Converted as Prospect','Disqualified','Lead Created','Lead Imported','Assigned','Lead Updated','Yet to Follow');
        $user = 'customer';
        $module = 'Sales-module';
        $timemsg = $actionname[$input['status']];
        $today = $input['contactable_date'];
        if (!$this->hasSalesactivity($user,$input['lead_id'],$input['status'], $module, $timemsg, $today, $input,$input['comments'])) {
            $log = Log::info("Lead Followup successfully");
        }
        if(isset($input['selff_assign'])==1){
            $assign=new LeadAssign;

            $assign->lead_id=$input['lead_id'];
            $assign->user_id=Auth::user()->id;
            $assign->lead_status_id=$input['status'];
            $assign->assign_by=Auth::user()->id;
            $assign->contactable_date=date('Y-m-d h:i:s',strtotime($input['contactable_date']));
            $assign->comments=$input['comments'];
            $lead=Lead::find($input['lead_id']);
            $lead->current_lead_status=$input['status'];
            $lead->contactable_date=date('Y-m-d h:i:s',strtotime($input['contactable_date']));
            $lead->save();
            $assign->save();
            if($input['status']==5){
                $customer=new Customer;
                $customer->first_name=$lead['first_name'];
                $customer->last_name=$lead['last_name'];
                $customer->mobile=$lead['phone_number'];
                $customer->email=$lead['email'];
                $customer->account_type=$lead['account_type'];
                $customer->prospective=1;
                $customer->agas_price=$lead['agas_price'];
                $customer->current_supplier_price=$lead['current_supplier_price'];
                $customer->save();
                $cuid=$customer->id;
                $lead=Lead::find($input['lead_id']);
                $lead->customer_id=$cuid;
                $lead->save();

                //dd($lead);
            }



        }else{
            $assign=new LeadAssign;
            $assign->lead_id=$input['lead_id'];
            $assign->user_id=$input['assign_user'];
            $assign->lead_status_id=$input['status'];
            $assign->assign_by=Auth::user()->id;
            $assign->contactable_date=date('Y-m-d h:i:s',strtotime($input['contactable_date']));
            $assign->comments=$input['comments'];
            $assign->save();
            $lead=Lead::find($input['lead_id']);
            $lead->current_lead_status=$input['status'];
            $lead->contactable_date=date('Y-m-d h:i:s',strtotime($input['contactable_date']));
            $lead->save();

            if($input['status']==5){
                $customer=new Customer;
                $customer->first_name=$lead['first_name'];
                $customer->last_name=$lead['last_name'];
                $customer->mobile=$lead['phone_number'];
                $customer->email=$lead['email'];
                $customer->account_type=$lead['account_type'];
                $customer->prospective=1;
                $customer->agas_price=$lead['agas_price'];
                $customer->current_supplier_price=$lead['current_supplier_price'];
                $customer->save();
                $cuid=$customer->id;
                $lead=Lead::find($input['lead_id']);
                $lead->customer_id=$cuid;
                $lead->save();
            }
        }
        if(isset($input['is_active'])==1){
            // send email to user
        }
        return redirect('leads')->with('msg', 'Lead Followup Successfully');

    }


    public function assign_leads(){
        $assign_leads=LeadAssign::Where('is_deleted', 0)->get();
        $assign=User::where('is_deleted',0)->Where('id',Auth::user()->id)->first();
        $lead=array();
        $actionname=array('','Not Interested','Not Answered','Call Later','Need More Details','Converted as Prospect','Disqualified','Lead Created','Lead Imported','Assigned','Lead Updated','Yet to Follow');
        foreach($assign_leads as $key=>$val){
           $user=User::where('is_deleted',0)->Where('id',$val['user_id'])->first();
           $lead[$key]['id']=$val['id'];
           $lead[$key]['username']=$user['name'];
           $lead[$key]['lead_id']=$val['lead_id'];
           $lead[$key]['status']=$actionname[$val['lead_status_id']];
           $lead[$key]['assign_by']=$assign['name'];
           $lead[$key]['contactable_date']=date('Y-m-d h:i:s a',strtotime($val['contactable_date']));
           $lead[$key]['comments']=$val['comments'];
        }
       // dd($lead);
        return view('admin.list-assign-leads',compact('lead'));
    }

  public function listCustomerEmail(){
        $email=Customer::Where('is_deleted','0')->get('email');
        $email_cnt=count($email);
        $em='';
        foreach($email as $row){
            $em.=$row['email'].', ';
        }
        return view('admin.customer-email-list',compact('em','email_cnt'));
  }

  public function emailTemplates(){
    $templates=EmailTemplateModel::get();
    return view('admin.email_template',compact('templates'));
  }

  public function storeTemplate(Request $request){
        $input=$request->all();
        unset($input['_token']);
        $input['created_by']=Auth::user()->id;
        EmailTemplateModel::updateOrInsert(
			['id' => $request->id],
			$input
		);    
        return redirect()->back()->with('msg','Template Stored Successfully');  
  }

  public function getTemplates($id){
        $template=EmailTemplateModel::where('email_template_name',$id)->first();
        if($template){
            echo json_encode($template);
        }else{
            echo 1;
        }
  }
  public function meeting(){
        $meet=Meeting::get();
        $meetArr=array();
        foreach($meet as $key=>$row){
            $users=DB::select("select GROUP_CONCAT(u.name) as names from users u WHERE id IN($row->invite_list)");            
            $meetArr[$key]['meeting_date']=date('d-m-Y',strtotime($row->meeting_date));
            $meetArr[$key]['start']=$row->start_time;
            $meetArr[$key]['end']=$row->end_time;
            $meetArr[$key]['reminder']=$row->reminder.' Minutes';
            $meetArr[$key]['location']=$row->location;
            $meetArr[$key]['invite_list']=isset($users) ? $users:'N/A';
            $meetArr[$key]['desc']=$row->agenda;
            $meetArr[$key]['link']=$row->meeting_link;
        }
        return view('admin.list-meeting',compact('meetArr'));
  }
  public function addMeeting(){
    $users=User::get();
    return view('admin.add-meeting',compact('users'));
  }
  public function storeMeeting(Request $request){
        $input=$request->all();
        unset($input['_token']);         
        $input['invite_list']=implode(',',$input['users']);       
        $this->validate($request, [
            "meeting_date" => "required",
            "start_time" => "required",
            "end_time" => "required"                 
        ]);       
        $insert=Meeting::create($input);
        $rcash=Meeting::where('id',$insert->id)->first();
        $rcash->created_by=Auth::user()->id;
        $rcash->save();
        return redirect('/meeting')->with('msg','Meeting Created successfully');
  }

  public function getRemainder($date){
        $meet=Meeting::where('meeting_date',$date)->get();
        date_default_timezone_set('Asia/Kolkata');
        foreach($meet as $row){  
            $getDate=date('Y-m-d '.$row->start_time); 
            $minutes=$row->reminder;       
           $remainDate=date('Y-m-d h:i',strtotime("-".$minutes." minutes",strtotime($getDate)));
            if(date('Y-m-d h:i')==$remainDate){
                echo $row->id;
            }else{
                echo 0;
            }
        }
        //echo json_encode($meet);
  }

  public function pushRemainder(Request $request){
        $input=$request->all();
        $id=$input['id'];
        $meet=Meeting::where('id',$id)->first();
        if($meet){
            $meet['meeting_date'];
            $content="Meeting Scheduled on ".$meet['meeting_date']."\n
                      Start Time=".$meet['start_time']."\n End Time ".$meet['end_time'];
            $action="Meeting Scheduled";
            $done=Auth::user()->id;
            $notify=Notification::where('meet_id',$id)->first();
            $usr=$meet['invite_list'];
            $users=DB::select("select id,name from users WHERE id IN($usr)");                      
            if(!$notify){
                $not=new Notification;
                $not->meet_id=$id;
                $not->action=$action;
                $not->message=$content;
                $not->action_by=$done;
                $not->is_read=0;
                $not->save();
                foreach($users as $key=>$user){
                    $all_note=new UserNotification;
                    $all_note->notification_id=$not->id; 
                    $all_note->user_id=$user->id;
                    $all_note->is_read=0;
                    $all_note->save();
                }
            }
                      
        }
  }


}
