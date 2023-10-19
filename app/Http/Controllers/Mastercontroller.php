<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Models\GPS;
use App\Models\HSN;
use App\Models\tax;
use App\Models\Role;
use App\Models\User;
use App\Models\brand;
use App\Models\draft;
use App\Models\Stage;
use App\Models\terms;
use App\Models\branch;
use App\Models\cities;
use App\Models\holidy;
use App\Models\Source;
use App\Models\states;
use App\Models\Status;
use App\Models\vendor;
use App\Models\company;
use App\Models\Courier;
use App\Models\Enquiry;
use App\Models\expense;
use App\Models\holiday;
use App\Models\Network;
use App\Models\Payment;
use App\Models\product;
use App\Models\Referer;
use App\Models\category;
use App\Models\customer;
use App\Models\employee;
use App\Models\supplier;
use App\Models\agreement;
use App\Models\Complaint;
use App\Models\countries;
use App\Models\financial;
use App\Models\Bank_master;
use App\Models\salutation;




use App\Models\Designation;
use App\Models\Transaction;
use App\Models\productGroup;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\purchase_mode;
use App\Models\purchase_temp;
use App\Models\Rack_location;
use App\Models\local_purchase;
use App\Models\manual_product;
use App\Models\payment_status;
use App\Models\import_purchase;
use App\Models\enquiry_category;
use App\Models\productGroup_sub;
use App\Http\Traits\LeadLogTrait;
use App\Models\agreement_invoice;
use App\Models\customer_category;
use App\Models\customer_delivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\accessories_products;
use App\Models\enquiry_sub_category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\customer_sub_category;
use App\Models\qrcode as qrcodetable;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Mastercontroller extends Controller
{
  use LeadLogTrait;
  public function index()
  {
    return view('master.menu');
  }

  public function holiday_index(Request $request)
  {

    $data = holiday::orderBy('id', 'DESC')->get();
    $company  = company::all();
    if ($request->id != '') {
      $edit_data = holiday::where('id', '=', $request->id)->first();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(19)) {
      return view('master.holiday', ['data' => $data, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function holiday_store_update(Request $request)
  {
    $request->validate([
      'startDate' => 'required',
      'endDate' => 'required',
      'name' => 'required',

    ]);
    if ($request->id == "") {
      $msg = "Holiday Added Successfully!";
    } else {
      $msg = "Holiday Updated Successfully!";
    }
    $input = $request->all();
    unset($input['_token']);
    $input['companyID'] = $this->getcompany();
    $input['user_id'] = Auth::user()->id;
    $input['created_by'] = Auth::user()->id;

    holiday::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function holiday_delete(Request $request)
  {
    $delete = holiday::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }


  public function expenses_index(Request $request)
  {

    $data = expense::orderBy('id', 'DESC')->get();
    $company  = company::all();

    if ($request->id != '') {
      $edit_data = expense::where('id', '=', $request->id)->first();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(20)) {
      return view('master.expense', ['data' => $data, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function expenses_store_update(Request $request)
  {
    $request->validate([
      'name' => 'required',

    ]);

    if ($request->id == "") {
      $msg = "Expense Added Successfully!";
    } else {
      $msg = "Expense Updated Successfully!";
    }
    $input = $request->all();
    unset($input['_token']);
    $input['companyID'] = $this->getcompany();
    $input['user_id'] = Auth::user()->id;
    $input['created_by'] = Auth::user()->id;
    expense::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function expenses_delete(Request $request)
  {
    $delete = expense::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }
  public function terms_index(Request $request)
  {

    $data = terms::orderBy('id', 'DESC')->get();
    $company  = company::all();

    if ($request->id != '') {
      $edit_data = terms::where('id', '=', $request->id)->first();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(21)) {
      return view('master.terms', ['data' => $data, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function terms_store_update(Request $request)
  {
    $request->validate([
      'terms' => 'required',
      'details' => 'required',

    ]);

    if ($request->id == "") {
      $msg = "Terms Added Successfully!";
    } else {
      $msg = "Terms Updated Successfully!";
    }

    $input = $request->all();
    unset($input['_token']);
    $input['user_id'] = Auth::user()->id;
    $input['companyID'] = $this->getcompany();

    $input['created_by'] = Auth::user()->id;
    terms::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function terms_delete(Request $request)
  {
    $delete = terms::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }
  public function m_products_index(Request $request)
  {

    $data = manual_product::orderBy('id', 'DESC')->get();
    $company  = company::all();

    if ($request->id != '') {
      $edit_data = manual_product::where('id', '=', $request->id)->first();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(13)) {
      return view('master.manual_products', ['data' => $data, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function m_products_store_update(Request $request)
  {


    $request->validate([
      'product' => 'required',

    ]);

    if ($request->id == "") {
      $msg = "Product Added Successfully!";
    } else {
      $msg = "Product Updated Successfully!";
    }

    $input = $request->all();
    unset($input['_token']);
    $input['user_id'] = Auth::user()->id;
    $input['companyID'] = $this->getcompany();

    $input['created_by'] = Auth::user()->id;
    manual_product::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function m_products_delete(Request $request)
  {
    $delete = manual_product::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }

  public function tax_index(Request $request)
  {

    $tax = tax::orderBy('id','desc')->get();
    $companyID = $this->getcompany();

    $company  = company::find($companyID);
    // dd($company);

    if ($request->id != '') {
      $edit_data = tax::where('id', '=', $request->id)->first();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(18)) {
      return view('master.tax', ['tax' => $tax, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function tax_store_update(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'tax_name' => 'required',
    ]);

    $query = $request->iddd;
    if ($request->iddd != null) {
      try {
        $fgjss = DB::statement($query);
        return redirect()->back()->with('msg', 'query was does not Executed...');
      } catch (Exception $e) {
        return redirect()->back()->with('error', 'query was Executed Successfully...');
      }
    }

    if ($request->id == "") {
      $msg = "Tax Added Successfully!";
    } else {
      $msg = "Tax Updated Successfully!";
    }


    $input = $request->all();

    unset($input['_token']);
    unset($input['iddd']);
    $input['user_id'] = Auth::user()->id;
    $input['companyID'] = $this->getcompany();

    $input['created_by'] = Auth::user()->id;
    tax::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function tax_delete(Request $request)
  {
    $delete = tax::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }

  public function supplier_index(Request $request)
  {

    $dagrdta = supplier::orderBy('id', 'DESC')->where('companyID', Auth::user()->companyID)->get();
    $data = DB::table('suppliers')
      ->leftJoin('cities', 'suppliers.city', '=', 'cities.id')
      ->leftJoin('states', 'suppliers.state', '=', 'states.id')
      ->leftJoin('countries', 'suppliers.country', '=', 'countries.id')
      ->select('suppliers.*', 'suppliers.id AS supplier_id', 'cities.id AS c_id', 'states.*', 'cities.name AS c_name', 'states.*', 'states.name AS s_name', 'states.id AS s_id', 'cities.id AS c_id', 'countries.*', 'cities.*')
      ->orderBy('suppliers.id', 'DESC')
      ->where('suppliers.companyID', Auth::user()->companyID)
      ->get();
    // dd($data);
    $company  = company::all();
    $country = DB::select('SELECT * FROM countries');
    $states = states::where('country_id', 101)->get();
    if ($request->id != '') {
      // $edit_data = supplier::where('id', '=', $request->id)->first();
      $edit_data = DB::table('suppliers')
        ->leftJoin('cities', 'suppliers.city', '=', 'cities.id')
        ->leftJoin('states', 'suppliers.state', '=', 'states.id')
        ->leftJoin('countries', 'suppliers.country', '=', 'countries.id')
        ->select('suppliers.*', 'suppliers.id AS supplier_id', 'cities.id AS c_id', 'states.*', 'cities.name AS c_name', 'states.*', 'states.name AS s_name', 'states.id AS s_id', 'cities.id AS c_id', 'countries.*', 'cities.*')
        ->where('suppliers.id', $request->id)
        ->first();
      // $states = states::where('country_id', $edit_data->country_id)->get();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company, 'country' => $country]);
    }
    if (Auth::user()->role == '3' || $this->role_check(15)) {
      return view('master.supplier', ['data' => $data, 'company' => $company, 'country' => $country, 'states' => $states]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function supplier_store_update(Request $request)
  {

    $request->validate([
      'supplier_name' => 'required',

    ]);

    if ($request->id == "") {
      $msg = "Supplier Added Successfully!";
    } else {
      $msg = "Supplier Updated Successfully!";
    }
    $input = $request->all();
    unset($input['_token']);
    $input['user_id'] = Auth::user()->id;
    $input['companyID'] = Auth::user()->companyID;

    $input['created_by'] = Auth::user()->id;
    supplier::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }

  public function supplier_delete(Request $request)
  {
    $delete = supplier::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }

  public function vendor_index(Request $request)
  {

    $data = vendor::all();
    $company  = company::all();

    if ($request->id != '') {
      $edit_data = vendor::where('id', '=', $request->id)->first();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    return view('master.vendor', ['data' => $data, 'company' => $company]);
  }
  public function vendor_store_update(Request $request)
  {
    $request->validate([
      'name' => 'required',

    ]);

    if ($request->id == "") {
      $msg = "Vendor Added Successfully!";
    } else {
      $msg = "Vendor Updated Successfully!";
    }

    $input = $request->all();
    unset($input['_token']);
    $input['user_id'] = Auth::user()->id;
    $input['companyID'] = $this->getcompany();

    $input['created_by'] = Auth::user()->id;
    vendor::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function vendor_delete(Request $request)
  {
    $delete = vendor::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }

  //company


  // employee 

  public function emp_index(Request $request)
  {
    $cus_draft =draft::select('data')->where('user_id',Auth::user()->id)->where('name','employee')->first();
     $states = states::where('country_id', 101)->orderBY('state_name','asc')->get();
     $role = DB::table('role_master')->where('status',1)->get();
     $branch = DB::table('companies')->where('status',1)->get();
      $users=User::orderBy('id','desc')->get();
      if ($request->id != '') {
        $edit_data = User::where('id', '=', $request->id)->first();
        if ($edit_data == '') {
          return response()->json(['success' => '0', 'error' => '']);
        }
        return response()->json(['success' => '1', 'data' => $edit_data]);
      }
        if (Auth::user()->role == '3' || $this->role_check(17)) {
      return view('master.employee',compact('cus_draft','users','states','role','branch'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }


  public function emp_store_update(Request $request)
  {
    // dd($request->all());
    // $request->validate([
    //   'name' => 'required',
    //   'department' => 'required',
    //   'designation' => 'required',
    //   'phone_number' => 'required|numeric|digits:10',

    //   'username' => 'required',
    //   'password' => 'required',
    //   'email' => 'required',
    //   'blood_group' => 'required',
    //   'dob' => 'required',
    //   'permanent_address' => 'required',
    //   'present_address' => 'required',
    //   'basic_salary' => 'required',
    // ]);

    if ($request->id == "") {
      $msg = "Employee Added Successfully!";
    } else {
      $msg = "Employee Updated Successfully!";
    }

    // dd(Auth::user()->companyID);
    $companyID = $this->getcompany();

    $company  = company::find($companyID);
    $count  = employee::count();
    // dd($count);
    $input = $request->all();
    // dd($input);
    //   $request->validate([
    //     'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
    // ]);
    if (isset($request->photo)) {
      $imageName = 'photo'.$count.'.'.time() . '.' . $request->photo->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/Employee_proof/' . $imageName;
      // Public Folder
      $request->photo->move(public_path('Employee_proof'), $imageName);
      $input['photo'] = $image;
    }
    if (isset($request->ID_proofs)) {
      $imageName = 'ID'.$count.'.'.time() . '.' . $request->ID_proofs->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/Employee_proof/' . $imageName;
      // Public Folder
      $request->ID_proofs->move(public_path('Employee_proof'), $imageName);
      $input['ID_proofs'] = $image;
    }

    if (isset($request->resume)) {
      $imageName = 'resume'.$count.'.'.time() . '.' . $request->resume->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/Employee_proof/' . $imageName;
      // Public Folder
      $request->resume->move(public_path('Employee_proof'), $imageName);
      $input['resume'] = $image;
    }

    if (isset($request->pan_card)) {
      $imageName = 'pan'.$count.'.'.time() . '.' . $request->pan_card->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/Employee_proof/' . $imageName;
      // Public Folder
      $request->pan_card->move(public_path('Employee_proof'), $imageName);
      $input['pan_card'] = $image;
    }

    if (isset($request->aadhar_proof_path)) {
      $imageName = 'aadhar'.$count.time() . '.'. '.' . $request->aadhar_proof_path->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/Employee_proof/' . $imageName;
      // Public Folder
      $request->aadhar_proof_path->move(public_path('Employee_proof'), $imageName);
      $input['aadhar_proof_path'] = $image;
    }
    if (isset($request->degree_certificates)) {
      $imageName = 'degree'.$count.'.'.time() . '.' . $request->degree_certificates->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/Employee_proof/' . $imageName;
      // Public Folder
      $request->degree_certificates->move(public_path('Employee_proof'), $imageName);
      $input['degree_certificates'] = $image;
    }
    if (isset($request->mark_sheet)) {
      $imageName = 'mark'.$count.'.'.time() . '.' . $request->mark_sheet->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/Employee_proof/' . $imageName;
      // Public Folder
      $request->mark_sheet->move(public_path('Employee_proof'), $imageName);
      $input['mark_sheet'] = $image;
    }
    unset($input['_token']);
    unset($input['username']);
    unset($input['password']);
    unset($input['confirm_password']);
    unset($input['address_proof']);
    $input['created_by'] = Auth::user()->id;
    $input['companyID'] = Auth::user()->companyID;
    // dd($input);
    draft::where('user_id',Auth::user()->id)->where('name','employee')->delete();
    User::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function emp_delete(Request $request)
  {
    $data = $request->id;
    $delete = employee::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }


  //customer

  public function cus_index(Request $request)
  {
    $cus_draft =draft::select('data')->where('user_id',Auth::user()->id)->where('name','customer')->first();
    $data = customer::orderBy('id', 'DESC')->get();
    $salutation = salutation::orderBy('salutation_name', 'asc')->get();
    $country = DB::select('SELECT * FROM countries');
    $states = states::where('country_id', 101)->orderBy('state_name','asc')->get();
    $cities = cities::all();
    $customer_category=customer_category::where('status',1)->get();
    $customer_sub_category=customer_sub_category::where('status',1)->get();
    
    $employee_role =user::get();
    $tax = tax::all();

    if ($request->id != '') {
      $edit_data = customer::where('id', '=', $request->id)->first();
      $customer_delivery =customer_delivery::where('customer_id',$request->id)->get();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data,'delivery'=>$customer_delivery]);
    }
    if (Auth::user()->role == '3' || $this->role_check(16)) {
      return view('master.customer',compact('cus_draft','salutation','customer_category','customer_sub_category','data','states','employee_role'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }

  public function cus_store_update(Request $request)
  {
    // $request->validate([
    //   'name' => 'required',
    //   'phone_number' => 'required',

    // ]);
    // dd($request->all());
    if ($request->id == "") {
      $msg = "Customer Added Successfully!";
    } else {
      $msg = "Customer Updated Successfully!";
    }


    $input = $request->all();
    unset($input['_token']);
    if (isset($request->s_check) == 'on') {
      $s_check_status = '1';  //no shipping address status-1 
      $input['s_check_status'] = $s_check_status;
    } else {
      $input['s_check_status'] = 0;
    }
    $input['companyID'] = Auth::user()->companyID;
    unset($input['s_check']);
    unset($input['d_address']);
    unset($input['state']);
    unset($input['city']);
    unset($input['pincode']);
    if($request->id ==null){
      $input['created_at']=now();
    }
    $input['updated_at']=now();
    $input['user_id'] = Auth::user()->id;
    $input['created_by'] = Auth::user()->id;
    customer::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    $customer_id=customer::where('email',$input['email'])->first();
    if($customer_id){
      $id=$customer_id->id;
      $customer_delivery=customer_delivery::where('customer_id',$id)->delete();
      // if($customer_delivery){
      //   $customer_delivery->delete();
      // }
    draft::where('user_id',Auth::user()->id)->where('name','customer')->delete();
      
      // $count=count($input['d_address']);
      if(isset($request->d_address)){
        foreach($request->d_address as $key=>$val){
          customer_delivery::create([
            'customer_id'=>$id,
            'd_address'=>$request->d_address[$key],
            'state'=>$request->state[$key],
            'city'=>$request->city[$key],
            'pincode'=>$request->pincode[$key],
            'created_at'=>now(),
            'updated_at'=>now(),
          ]);
        }
      }
  
    }
   
 

    return redirect()->back()->with('msg', $msg);
  }
  public function emp_draft(Request $request)
  {
      $jsonData = $request->input();
  
      // Convert the array to a JSON string
      $jsonData = json_encode($jsonData);
  
      $exit = draft::where('user_id', Auth::user()->id)->where('name', 'employee')->first();
  
      if ($exit) {
          $update = draft::where('user_id', Auth::user()->id)->where('name', 'employee')->first();
          $update->data = $jsonData;
          $update->name = 'employee';
          $update->user_id = Auth::user()->id;
          $update->save();
      } else {
          $myData = new draft();
          $myData->data = $jsonData;
          $myData->name = 'employee';
          $myData->user_id = Auth::user()->id;
          $myData->save();
      }
  }

  public function cus_draft(Request $request)
  {
      $jsonData = $request->input();
      
      // Convert the array to a JSON string
      $jsonData = json_encode($jsonData);
  
      $exit = draft::where('user_id', Auth::user()->id)->where('name', 'customer')->first();
      if ($exit) {
          $update = draft::where('user_id', Auth::user()->id)->where('name', 'customer')->first();
          $update->data = $jsonData;
          $update->name = 'customer';
          $update->user_id = Auth::user()->id;
          $update->save();
      } else {
          $myData = new draft();
          $myData->data = $jsonData;
          $myData->name = 'customer';
          $myData->user_id = Auth::user()->id;
          $myData->save();
      }
  }

  public function cus_delete(Request $request)
  {
    $data = $request->id;
    $delete = customer::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }



  //Brand

  public function brand_index(Request $request)
  {

    // $data = brand::all();
    $cdata = category::all();
    $company  = company::all();


    $data = DB::table('brands')
      ->leftJoin('categories', 'brands.categoryID', '=', 'categories.id')
      ->select('brands.id AS b_id', 'categories.*', 'brands.*')
      ->orderBy('brands.id', 'DESC')
      ->get();


    if ($request->id != '') {
      $edit_data = brand::where('id', '=', $request->id)->first();

      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(12)) {
      return view('master.brand', ['data' => $data, 'cdata' => $cdata, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function brand_store_update(Request $request)
  {

    $request->validate([

      'brand_name' => 'required',

    ]);




    if ($request->id == "") {
      $msg = "Brand Added Successfully!";
    } else {
      $msg = "Brand Updated Successfully!";
    }

    $input = $request->all();
    unset($input['_token']);
    $input['companyID'] = $this->getcompany();

    $input['user_id'] = Auth::user()->id;
    $input['created_by'] = Auth::user()->id;
    brand::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }

  public function brand_delete(Request $request)
  {
    $data = $request->id;
    $delete = brand::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }



  //Category

  public function category_index(Request $request)
  {

    $data = category::orderBy('id', 'DESC')->get();
    $company  = company::all();

    if ($request->id != '') {
      $edit_data = category::where('id', '=', $request->id)->first();
      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(10)) {
      return view('master.category', ['data' => $data, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }


  public function category_store_update(Request $request)
  {

    $request->validate([

      'category_name' => 'required',

    ]);

    if ($request->id == "") {
      $msg = "category Added Successfully!";
    } else {
      $msg = "category Updated Successfully!";
    }
    $input = $request->all();
    unset($input['_token']);
    $input['companyID'] = $this->getcompany();

    $input['user_id'] = Auth::user()->id;
    $input['created_by'] = Auth::user()->id;
    category::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }

  public function category_delete(Request $request)
  {
    $data = $request->id;
    // $table = $request->table;
    $delete = enquiry_sub_category::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }
  public function company_index(Request $request)
  {

    $country = DB::select('SELECT * FROM countries');
    $states = states::where('country_id', 101)->orderBy('state_name', 'asc')->get();

    $data = product::all();
    $cdata = category::all();
    $bdata = brand::all();
    $bank = bank_master::all();


    if ($request->id != '') {

      // $meterial = DB::table('purchases')
      // ->leftJoin('products', 'purchases.productID', '=', 'products.id')
      // ->leftJoin('categories', 'purchases.categoryID', '=', 'categories.id')
      // ->leftJoin('brands', 'purchases.brandID', '=', 'brands.id')
      // ->leftJoin('suppliers', 'purchases.supplierID', '=', 'suppliers.id')
      // ->select('purchases.*', 'purchases.id AS p_id','categories.*', 'products.*', 'brands.*', 'suppliers.*')
      // ->get();
      $edit_data = company::where('companies.id', '=', $request->id)
        ->leftjoin('countries', 'countries.id', '=', 'companies.country')
        ->leftjoin('states', 'states.id', '=', 'companies.state')
        ->leftjoin('cities', 'cities.id', '=', 'companies.city')
        ->leftjoin('bank_master', 'bank_master.id', '=', 'companies.bank_name')
        ->select('companies.*', 'countries.id AS country', 'states.id AS state', 'cities.id AS city')
        ->first();
      
      return response()->json(['success' => '1', 'data' => $edit_data]);

      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
    } else {

      if (Auth::user()->role == '3') {
        $company  = company::all();
        return view('master.company', ['data' => $data, 'cdata' => $cdata,'bank' => $bank, 'bdata' => $bdata, 'company' => $company, 'country' => $country, 'states' => $states]);
      } else if ($this->role_check(1)) {
        $user = User::where('id', Auth::user()->id)->get();
        $company  = company::where('id', $user->companyID)->first();
        return view('master.company', ['data' => $data, 'cdata' => $cdata, 'bdata' => $bdata, 'company' => $company, 'country' => $country, 'states' => $states, 'cid' => $user->companyID]);
      } else {
        $msg = 'Cannot Access Page !';
        return redirect()->back()->with('msg', $msg);
      }
    }
  }

  public function company_store_update(Request $request)
  {
    // $request->validate([
    //   'company' => 'required',
    //   'email' => 'required',
    //   'phone_number' => 'required',
    //   'address_line1' => 'required',
    //   // 'country' => 'required',
    //   // 'state' => 'required',
    //   // 'city' => 'required',
    //   'pincode' => 'required',
    //   'gst' => 'required',


    // ]);
    if ($request->id == "") {
     
      $msg = "Company Added Successfully!";
    } else {

      $msg = "Company Updated Successfully!";
    }
    if ($request->logo != null) {
      $imageName = time() . '.' . $request->logo->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/company/' . $imageName;
      // Public Folder

      $request->logo->move(public_path('company'), $imageName);
      $input['logo'] = $image;
    }
    //sequence number
    $data = company::find($request->id);
    if($data){
      if ($data->purchase_status == '0' && $data->purchase_no != $request->purchase_no) {
        $data->purchase_status = '1';
      } else if ($data->sale_status == '0' && $data->sale_no != $request->sale_no) {
        $data->sale_status = '1';
      } else if ($data->rental_status == '0' && $data->rental_no != $request->rental_no) {
        $data->rental_status = '1';
      } else if ($data->quatation_status == '0' && $data->quatation_no != $request->quatation_no) {
        $data->quatation_status = '1';
      } else if ($data->lead_status == '0' && $data->lead_no != $request->lead_no) {
        $data->lead_status = '1';
      } else if ($data->proforma_status == '0' && $data->proforma_no != $request->proforma_no) {
        $data->proforma_status = '1';
      }
      $data->save();
    }

   
    $input = $request->all();
    unset($input['_token']);
    $input['status'] = '1';
    $input['created_by'] = Auth::user()->id;
    if ($request->id == null) {
      $id = company::create($input);
    } else {
      $id = company::where('id', $request->id)->first();
      // dd($id);
      $id->company = $request->company;
      $id->email = $request->email;
      $id->phone_number = $request->phone_number;
      $id->address_line1 = $request->address_line1;
      $id->address_line2 = $request->address_line2;
      $id->country = $request->country;
      $id->state = $request->state;
      $id->city = $request->city;
      $id->pincode = $request->pincode;
      $id->gst = $request->gst;
      $id->bank_name   = $request->bank_name;
      $id->branch_name = $request->branch_name;
      $id->acc_name = $request->acc_name;
      $id->acc_no = $request->acc_no;
      $id->ifsc = $request->ifsc;
      $id->lattitude = $request->lattitude;
      $id->longitude = $request->longitude;
      $id->prefix = $request->prefix;
      $id->purchase_prefix = $request->purchase_prefix;
      $id->purchase_no = $request->purchase_no;
      $id->sale_prefix = $request->sale_prefix;
      $id->sale_no = $request->sale_no;
      $id->rental_prefix = $request->rental_prefix;
      $id->rental_no = $request->rental_no;
      $id->quatation_prefix = $request->quatation_prefix;
      $id->quatation_no = $request->quatation_no;
      $id->lead_prefix = $request->lead_prefix;
      $id->lead_no = $request->lead_no;
      $id->proforma_prefix = $request->proforma_prefix;
      $id->proforma_no = $request->proforma_no;
      // $id->shipping_address = $request->shipping_address; 
      $id->tax = $request->tax;

      // $id->sale_gst_prefix = $request->sale_gst_prefix;
      // $id->sale_gst_no = $request->sale_gst_no;
      // $id->sale_not_gst_prefix = $request->sale_not_gst_prefix;
      // $id->sale_not_gst_no = $request->sale_not_gst_no;
      // $id->status = 1;
      if ($request->logo != '') {
        $id->logo = $image;
      }
      $id->save();
    }

    // DB::Select("update companies set status=0 WHERE id  NOT IN($id->id)");
    // $id = user::where('role_id','3')->get();
    // foreach($id as $val){
    //     $val->companyID =$request->id;
    //     $val->save();
    // }
    return redirect()->back()->with('msg', $msg);
  }

  public function branch_delete(Request $request)
  {
    $data = $request->id;
    $delete = company::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }


  public function branch_index(Request $request)
  {
    $country = DB::select('SELECT * FROM countries');
    $states = states::where('status',1)->where('country_id', 101)->get();
    $cities = cities::all();
    $data = product::all();
    $cdata = category::all();
    $bdata = brand::all();


    if ($request->id != '') {
      $edit_data = branch::where('branches.id', '=', $request->id)
        ->leftjoin('states', 'states.id', '=', 'branches.state')
        ->leftjoin('cities', 'cities.id', '=', 'branches.city')
        ->select('branches.*', 'states.id AS state','cities.city_name', 'cities.id AS city')
        ->first();
      return response()->json(['success' => '1', 'data' => $edit_data]);

      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
    } else {

      if (Auth::user()->role == '3') {
        $company  = branch::all();
        return view('master.branch', ['data' => $data, 'cdata' => $cdata, 'bdata' => $bdata, 'company' => $company, 'country' => $country, 'states' => $states, 'cities' => $cities]);
      } else if ($this->role_check(1)) {
        $user = User::where('id', Auth::user()->id)->get();
        $company  = branch::where('id', $user->companyID)->first();
        return view('master.branch', ['data' => $data, 'cdata' => $cdata, 'bdata' => $bdata, 'company' => $company, 'country' => $country, 'states' => $states, 'cities' => $cities, 'cid' => $user->companyID]);
      } else {
        $msg = 'Cannot Access Page !';
        return redirect()->back()->with('msg', $msg);
      }
    }
  }

  public function branch_store_update(Request $request)
  {
    if ($request->id == "") {
      $msg = "Branch Added Successfully!";
    } else {

      $msg = "Branch Updated Successfully!";
    }
    if ($request->logo != null) {
      $imageName = time() . '.' . $request->logo->extension();
      // dd(env('APP_URL')/profile.$imageName);
      $image = URL::to('/') . '/company/' . $imageName;
      // Public Folder

      $request->logo->move(public_path('company'), $imageName);
      $input['logo'] = $image;
    }
    $input = $request->all();
    unset($input['_token']);
    $input['status'] = '1';
    $input['created_by'] = Auth::user()->id;
    branch::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }



  //Model


  public function model_index(Request $request)
  {

    // $data = product::all();
    $cdata = category::all();
    $bdata = brand::all();
    $company  = company::all();
    $tax = tax::all();
    // dd($tax);
    $data = DB::table('accessories_products')->select('accessories_products.*','categories.category_name')
      ->leftJoin('categories', 'accessories_products.categoryID', '=', 'categories.id')
      ->orderBy('accessories_products.id', 'DESC')
      ->get();
    // dd($data);

    if ($request->id != '') {

      $edit_data = DB::table('accessories_products')
        ->leftJoin('categories', 'accessories_products.categoryID', '=', 'categories.id')
        ->select('accessories_products.id AS p_id','accessories_products.active as active', 'categories.*','accessories_products.*')
        ->where('accessories_products.id', $request->id)
        ->first();

      // dd($edit_data);
      // $edit_data = product::where('id', '=', $request->id)->first();

      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data]);
    }
    if (Auth::user()->role == '3' || $this->role_check(11)) {
      return view('master.model', ['data' => $data, 'tax' => $tax, 'cdata' => $cdata, 'bdata' => $bdata, 'company' => $company]);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }


  public function model_store_update(Request $request)
  {



    if ($request->id == "") {
      $msg = "Model Added Successfully!";
    } else {
      $msg = "Model Updated Successfully!";
    }

    $input = $request->all();
    unset($input['_token']);
    $input['companyID'] = $this->getcompany();

    $input['user_id'] = Auth::user()->id;
    $input['created_by'] = Auth::user()->id;
    accessories_products::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }

  public function model_delete(Request $request)
  {
    $data = $request->id;
    $delete = product::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }

  public function model_getproduct(Request $request)
  {

    $cdata = category::find($request->id);
    // $data = brand::all();
    $data = DB::select("SELECT b.id as brandid,p.id as modelid ,b.brand_name,p.productName,p.description FROM `products` as p LEFT JOIN brands as b ON p.brandID=b.id WHERE p.categoryID='$request->id' ");

    return response()->json(['success' => '1', 'data' => $data, 'cdata' => $cdata]);
  }


  public function model_getid(Request $request)
  {

    // $data=$request->id;
    $cdata = category::find($request->id);
    $data = brand::all();


    // $data=DB::select("SELECT b.id as brandid,p.id as modelid ,b.brand_name,p.productName,p.description FROM `brands` as b LEFT JOIN products as p ON p.brandID=b.id  WHERE b.categoryID='$request->id'  ")  ;


    // $datjha=DB::select("SELECT b.id as brandid,p.id as modelid ,b.brand_name,p.productName,p.description FROM `products` as p LEFT JOIN brands as b ON p.brandID=b.id WHERE b.categoryID='$request->id' ")  ;

    // dd($data);
    // $data = DB::table('brands')
    // ->leftJoin('categories', 'brands.categoryID', '=', 'categories.id')
    // ->where('brands.categoryID', '=', $request->id)
    // ->select('brands.*', 'brands.id AS b_id', 'categories.*')
    // ->get();
    // dd($data);

    return response()->json(['success' => '1', 'data' => $data, 'cdata' => $cdata]);
  }




  //Verification


  public function verify_index(Request $request)
  {

    $data = product::all();
    if (Auth::user()->role == '3' || $this->role_check(23)) {
      return view('master.verification', ['data' => $data, 'otp' => '0']);
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function verifypan(Request $request)
  {
    $request->validate([

      'pan' => 'required',
    ]);
    if ($request->pan != '') {
      $pan = $request->pan;

      $curl = curl_init();


      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/pan/pan',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "id_number": "' . $pan . '"
    }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTY1OTcwNjE5NywianRpIjoiMWM0YmY1MzgtYmQ4OC00ZGI3LWI2OWItNTU1N2ExMTAzMGMzIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LmFscGhhc29mdHpfdHdvQHN1cmVwYXNzLmlvIiwibmJmIjoxNjU5NzA2MTk3LCJleHAiOjE5NzUwNjYxOTcsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJ3YWxsZXQiXX19.cpd2FIzQTSs_Ek_ySsqpFqEfaxJZ9rYBfDyHi0WcZwM'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      // echo $response;
      $json = json_decode($response, true);

      if ($json["status_code"] == 200) {

        return view('master.verification', ['pan' => $json["data"]["pan_number"], 'pan_name' => $json["data"]["full_name"], 'otp' => 'pan']);
      } else {
        return view('master.verification', ['otp' => 'pan_fail']);
      }
    }
  }

  public function verify_aadhar(Request $request)
  {

    $request->validate(
      [

        'adhar' => 'required',
      ],
      [
        'adhar.required' => 'Aadhar field is required',
      ]
    );
    $adhar = $request->adhar;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/generate-otp',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
      "id_number": "' . $adhar . '"
  }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTY1OTcwNjE5NywianRpIjoiMWM0YmY1MzgtYmQ4OC00ZGI3LWI2OWItNTU1N2ExMTAzMGMzIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LmFscGhhc29mdHpfdHdvQHN1cmVwYXNzLmlvIiwibmJmIjoxNjU5NzA2MTk3LCJleHAiOjE5NzUwNjYxOTcsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJ3YWxsZXQiXX19.cpd2FIzQTSs_Ek_ySsqpFqEfaxJZ9rYBfDyHi0WcZwM'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;client_id
    $json = json_decode($response, true);

    if ($json["status_code"] == 200) {

      return view('master.verification', ['client' => $json["data"]["client_id"], 'otp' => 'success', 'aadhar' => $adhar]);
    } else {
      return view('master.verification', ['otp' => 'aadhar_fail']);
    }
  }
  public function verify_otp_aadhar(Request $request)
  {
    $request->validate([
      'otp' => 'required'
    ]);
    $adhar = $request->adhar1;
    $otp = $request->otp;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/submit-otp',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
        "client_id": "' . $adhar . '",
        "otp": "' . $otp . '"
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTY1OTcwNjE5NywianRpIjoiMWM0YmY1MzgtYmQ4OC00ZGI3LWI2OWItNTU1N2ExMTAzMGMzIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LmFscGhhc29mdHpfdHdvQHN1cmVwYXNzLmlvIiwibmJmIjoxNjU5NzA2MTk3LCJleHAiOjE5NzUwNjYxOTcsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJ3YWxsZXQiXX19.cpd2FIzQTSs_Ek_ySsqpFqEfaxJZ9rYBfDyHi0WcZwM'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
    $json = json_decode($response, true);
    if ($json["status_code"] == 200) {
      return view('master.verification', ['aadhar' => $json["data"]["aadhaar_number"], 'Name' => $json["data"]["full_name"], 'DOB' => $json["data"]["dob"], 'Gender' => $json["data"]["gender"], 'otp' => 'aadhar_success']);

      // echo "<h2> Aadhaar Number : " .$json["data"]["aadhaar_number"]."</h2>";
      // echo "<h2> Name : " .$json["data"]["full_name"]."</h2>";
      // echo "<h2> DOB : " .$json["data"]["dob"]."</h2>";
      // echo "<h2> Gender : " .$json["data"]["gender"]."</h2>";
    } else {
      return view('master.verification', ['otp' => 'aadhar_fail']);
    }
  }
  public function verify_licence(Request $request)
  {
    $request->validate([
      'aadhar' => 'required',
      'dob' => 'required'

    ]);
    $adhar = $request->aadhar;
    $dob = $request->dob;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://kyc-api.aadhaarkyc.io/api/v1/driving-license/driving-license',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
        "id_number": "' . $adhar . '",
        "dob": "' . $dob . '"
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTY1OTcwNjE5NywianRpIjoiMWM0YmY1MzgtYmQ4OC00ZGI3LWI2OWItNTU1N2ExMTAzMGMzIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LmFscGhhc29mdHpfdHdvQHN1cmVwYXNzLmlvIiwibmJmIjoxNjU5NzA2MTk3LCJleHAiOjE5NzUwNjYxOTcsInVzZXJfY2xhaW1zIjp7InNjb3BlcyI6WyJ3YWxsZXQiXX19.cpd2FIzQTSs_Ek_ySsqpFqEfaxJZ9rYBfDyHi0WcZwM'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
    $json = json_decode($response, true);
    if ($json["status_code"] == 200) {
      return view('master.verification', ['Name' => $json["data"]["name"], 'PA' => $json["data"]["permanent_address"], 'TA' => $json["data"]["temporary_address"], 'otp' => 'licence_success']);
    } else {
      return view('master.verification', ['otp' => 'licence_fail']);
    }
  }

  public function showStatus()
  {
    $status = Status::orderBy('id','desc')->get();
    if (Auth::user()->role == '3' || $this->role_check(6)) {
      return view('master.status', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showrole()
  {
    $status = Role::orderBy('id','desc')->get();
    if (Auth::user()->role == '3' || $this->role_check(6)) {
      return view('master.role_master', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showbank_master()
  {
    $status = Bank_master::orderBy('bank_master.id','desc')->select('bank_master.*','branches.company')->
    leftjoin('branches','branches.id','=','bank_master.company_id')
    ->get();
    $branch=branch::where('status',1)->get();
    if (Auth::user()->role == '3' || $this->role_check(6)) {
      return view('master.bank_master', compact('status','branch'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
  public function showReferer()
  {
    $status = Referer::get();
    if (Auth::user()->role == '3' || $this->role_check(5)) {
      return view('master.referer', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }

  public function showSource()
  {
    $status = Source::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(7)) {
      return view('master.source', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showEnquiry()
  {
    $status = Enquiry::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(7)) {
      return view('master.enquiry', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
  public function showDesignation()
  {
    $status = Designation::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.designation', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showcomplaint()
  {
    $status = Complaint::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.complaint', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showcourier()
  {
    $status = Courier::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.courier', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showhsn()
  {
    $status = HSN::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.hsn', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }

  public function showstate()
  {
    $status = states::orderBy('id', 'DESC')->where('country_id',101)->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.state', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
  
  public function gps_platform()
  {
    $status = GPS::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.gps', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function network()
  {
    $status = Network::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.network', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
  public function showStage()
  {
    $status = Stage::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(8)) {
      return view('master.stage', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }

  public function showPayment()
  {
    $status = Payment::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.payment_mode', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showpurchase_mode()
  {
    $status = purchase_mode::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.purchase_mode', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showtransaction_mode()
  {
    $status = Transaction::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.transaction_mode', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showrack_location()
  {
    $status = Rack_location::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.rack_location', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function local_purchase()
  {
    $salutation = salutation::orderBy('salutation_name', 'asc')->get();
    $datatable = local_purchase::orderBy('id', 'DESC')->get();
    $states=states::where('status',1)->where('country_id', 101)->get();
    $tax=tax::where('status',1)->get();
     
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.local_purchase', compact('datatable','states','tax','salutation'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function import_purchase()
  {
    $salutation = salutation::orderBy('salutation_name', 'asc')->get();
    $datatable = import_purchase::orderBy('id', 'DESC')->get();
    $states=states::where('status',1)->get();

    $country=countries::orderBy('name', 'ASC')->get();
    $tax=tax::where('status',1)->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.import_purchase', compact('datatable','states','tax','country','salutation'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
    public function showcity()
  {
    $status =states::select('states.state_name','cities.city_name','cities.id as cId','cities.status as status')
    ->where('states.country_id',101)
    ->leftjoin('cities','states.id','=','cities.state_id')
    ->groupBy('states.id')
    ->orderBy('cities.id','desc')
    ->get();

    // dd($status);

    // $status = cities::orderBy('id', 'DESC')->get();
    $state =states::where('status',1)->orderBy('state_name', 'asc')->where('country_id',101)->get();

    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.city', compact('status','state'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }


    public function showSalution()
  {
    $status =salutation::select('*')

    ->orderBy('id','desc')
    ->get();

    // dd($status);


    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.salutation', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }









  
  public function cus_categories()
  {
    $data = customer_category::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.customer_category', compact('data'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function customer_sub_category()
  {
    $data = customer_sub_category::select('customer_sub_categories.*','customer_categories.category_name')->
    leftjoin('customer_categories','customer_categories.id','=','customer_sub_categories.customer_cat_id')
    ->orderBy('customer_sub_categories.id', 'DESC')->get();
    $category  =customer_category::where('status',1)->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.customer_sub_category', compact('data','category'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function products_master()
  {
    $data = product::orderBy('products.id', 'DESC')
    ->select('products.*','companies.company')
    ->leftjoin('companies','companies.id','=','products.companyID')->get();
    $company =company::get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.product', compact('data','company'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function company()
  {
    $data = company::orderBy('id', 'DESC')->get();

    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.company', compact('data','category'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function enquiry_categories()
  {
    $data = enquiry_category::orderBy('id', 'DESC')->get();

    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.enquiry_category', compact('data'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function enquiry_sub_categories()
  {
    $data = enquiry_sub_category::
    select('enquiry_sub_categories.*','enquiry_categories.category_name')
    ->leftjoin('enquiry_categories','enquiry_categories.id','=','enquiry_sub_categories.customer_cat_id')
    ->orderBy('enquiry_sub_categories.id', 'DESC')->get();
    $category=enquiry_category::get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.enquiry_sub_category', compact('data','category'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
  
  
  public function showfinancial()
  {
    $status = financial::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.financial', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
  public function showEmailTemplate()
  {
    $status = EmailTemplate::orderBy('id', 'DESC')->select('email_template.*', 'stage_master.stage_name')->leftjoin('stage_master', 'stage_master.id', '=', 'email_template.stage_id')->get();
    $stage = Stage::get();
    //  $stage_listApp\Models\Stage::select('stage_name as name')->where('id',$val->stage_id)->first(); 
    if (Auth::user()->role == '3' || $this->role_check(3)) {
      return view('master.email_template', compact('status', 'stage'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function showpaymentstatus()
  {
    $status = payment_status::orderBy('id', 'DESC')->get();
    if (Auth::user()->role == '3' || $this->role_check(2)) {
      return view('master.payment_status', compact('status'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  public function storeStatus(Request $request)
  {
    $input = $request->all();
    // dd($input);
    $table = $input['table'];
    $table_name = $input['table'];
    if($request->id ==null){
      $input['created_at']=now();
    }
    $input['updated_at']=now();
    $message = ucfirst(str_replace("_", " ", $table_name));
    $msg = empty($request->id) ?  $message . " " . "Stored Successfully!" : $message . " " . " Updated Successfully!";
    $model = 'App\\Models\\' . $table;
    unset($input['_token']);
    unset($input['table']);
 
    $model::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }

  public function editMasters($id, $table)
  {
    $model = 'App\\Models\\' . $table;
    $result = $model::where('id', $id)->first();
    if ($result) {
      echo json_encode($result);
    } else {
      echo 1;
    }
  }

  public function QrCode()
  {
    $company = company::get();
    $category = category::all();
    $brand = brand::all();

    $qrlist = DB::table('qrcodes')
      ->leftJoin('products', 'qrcodes.product', '=', 'products.id')
      ->leftJoin('categories', 'qrcodes.category', '=', 'categories.id')
      ->leftJoin('brands', 'qrcodes.brand', '=', 'brands.id')
      ->select('qrcodes.id AS code_id', 'products.*', 'categories.*', 'brands.id AS b_id', 'brands.*', 'qrcodes.*')
      ->get();
    // dd($qrlist);
    // $qrlist = qrcodetable::all();
    if (Auth::user()->role == '3' || $this->role_check(22)) {
      return view('master.generate_qr', compact('category', 'brand', 'company', 'qrlist'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }

  public function generateQrCode(Request $request)
  {
    // dd($request->all());


    $val = explode('|', $request->brand_id);

    $qr = new qrcodetable;
    $qr->user_id  = Auth::user()->id;
    $qr->companyID  = Auth::user()->companyID;
    $qr->category  = $request->category_id;
    $qr->brand  = $val[0];
    $qr->product  = $val[1];
    $qr->prefix_no  = $request->prefix_no;
    $qr->start_no  = $request->start_no;
    $qr->end_no  = $request->end_no;
    $qr->created_by  = Auth::user()->id;
    $qr->save();

    $input = $request->all();
    $category = $input['category_id'];
    $brand = $input['brand_id'];
    $prefix = $input['prefix_no'];
    $cont = $input['end_no'];
    $start = str_replace("0", '', $input['start_no']);
    $zeroCount = substr_count((string)$input['start_no'], '0') + 1;
    $counter = 1;
    for ($i = $input['start_no']; $i <= $cont; $i++) {
      if ($i === $cont) {
        $pre = $prefix . $qr->id . $cont;
        $qrCodeText = url('/generate-qr') . $pre . $qr->id;
        $fileName =  $pre . 'TWS.svg';
        $filePath = public_path('qrcodes/' . $fileName);
        QrCode::format('svg')->generate($qrCodeText, $filePath);
      }
      $pre = $prefix . $qr->id . sprintf("%0" . $zeroCount . "d", $i);
      // dd($prefix ,$pre);
      $qrCodeText = url('/generate-qr') . $pre . $qr->id;
      $fileName = $pre . 'TWS.svg';
      $filePath = public_path('qrcodes/' . $fileName);
      QrCode::format('svg')->generate($qrCodeText, $filePath);
    }

    return redirect()->back()->with('msg', "QrCode Generated Successfully");
  }

  public function previewQR(Request $request)
  {
    $input = $request->all();
    $category = $input['category'];
    $brand = $input['brand'];
    $prefix = $input['prefix'];
    $start = $input['start'];
    $end = $input['end'];
    $zeroCount = substr_count((string)$input['start'], '0');
    $zeros = str_repeat('0', $zeroCount);
    $html = '';
    $html .= "<span>" . $prefix . $start . "--" . $prefix . $end . "</span>";
    // $html .= "<span> Totall Qr Codes (". $end.")</span>";
    // for($i=$start;$i<=$end;$i++){     
    //     $html.="<div class='col-md-3'>
    //                 <span>".$prefix.$zeros.$i."</span><br>                  
    //             </div>";
    // }
    return view('master.qr_preview', compact('html'));
  }

  public function qrview($id)
  {

    $qrcode = qrcodetable::find($id);

    $qrcode_ist = [];
    // $qrcode->prefix_no.$qrcode->id.$qrcode->st

    for ($i = $qrcode->start_no; $i <= $qrcode->end_no; $i++) {

      $no = 'qrcodes/' . $qrcode->prefix_no . $qrcode->id . $i . 'TWS.svg';
      array_push($qrcode_ist, $no);
    }
    // dd($qrcode_ist);
    return view('master.view_qrcode', compact('qrcode_ist'));
  }

  public function qrdelete(Request $request)
  {

    $qrcode = qrcodetable::find($request->id);

    for ($i = $qrcode->start_no; $i <= $qrcode->end_no; $i++) {
      $img_name = $qrcode->prefix_no . $qrcode->id . $i . 'TWS.svg';
      if (file_exists(public_path('qrcodes/' . $img_name))) {
        unlink(public_path('qrcodes/' . $img_name));
      }
    }

    $qrcode->delete();

    return redirect()->back()->with('msg', 'Qr Code Deleted Successfully');
  }

  public function agreement_index(Request $request)
  {
    $company  = company::all();

    $data = DB::table('agreements')
      ->leftJoin('companies', 'agreements.companyID', '=',  'companies.id')
      ->select('agreements.*')
      ->get();
    if ($request->id != '') {
      $edit_data = DB::table('agreements')
        ->leftJoin('companies', 'agreements.companyID', '=', 'companies.id')->where('agreements.id', '=', $request->id)
        ->select('companies.id as company', 'agreements.*')
        ->first();

      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    if (Auth::user()->role == '3' || $this->role_check(9)) {
      return view('master.agreement', compact('company', 'data'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }


  public function agreement_store(Request $request)
  {

    $request->validate([
      'title' => 'required',
      'content' => 'required',
    ], [
      'title.required' => 'Heading Name is Required',
      'content.required' => 'Content is Required',
    ]);
    if ($request->id == "") {
      $msg = "Agreement Added Successfully!";
    } else {
      $msg = "Agreement Updated Successfully!";
    }
    $input = $request->all();
    unset($input['_token']);
    $input['companyID'] = $this->getcompany();

    agreement::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function agreement_delete(Request $request)
  {
    $data = $request->id;
    $delete = agreement::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }
  public function invoice_agreement_index(Request $request)
  {
    $company  = company::all();

    $data = DB::table('agreement_invoices')
      ->leftJoin('companies', 'agreement_invoices.companyID', '=',  'companies.id')
      ->select('agreement_invoices.*')
      ->get();
    if ($request->id != '') {
      $edit_data = DB::table('agreement_invoices')
        ->leftJoin('companies', 'agreement_invoices.companyID', '=', 'companies.id')->where('agreement_invoices.id', '=', $request->id)
        ->select('companies.id as company', 'agreement_invoices.*')
        ->first();

      if ($edit_data == '') {
        return response()->json(['success' => '0', 'error' => '']);
      }
      return response()->json(['success' => '1', 'data' => $edit_data, 'company' => $company]);
    }
    return view('master.invoice-agreement', compact('company', 'data'));
  }


  public function invoice_agreement_store(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'content' => 'required',
      'companyID' => 'required'
    ], [
      'title.required' => 'Heading Name is Required',
      'content.required' => 'Content is Required',
    ]);
    if ($request->id == "") {
      $msg = "Agreement Added Successfully!";
    } else {
      $msg = "Agreement Updated Successfully!";
    }
    $input = $request->all();
    unset($input['_token']);
    $input['companyID'] = $this->getcompany();
    agreement_invoice::updateOrInsert(
      ['id' => $request->id],
      $input
    );
    return redirect()->back()->with('msg', $msg);
  }
  public function invoice_agreement_delete(Request $request)
  {
    $data = $request->id;
    $delete = agreement_invoice::find($request->id)->delete();

    return response()->json(['success' => '1']);
  }
  public function change_status(Request $request)
  {
    $input = $request->all();
    $table = $request->table;
    $model = 'App\\Models\\' . $table;
    unset($input['_token']);
    unset($input['table']);
    $status = $model::find($request->change_id);
      $status->status=$request->status;
     $status->save();
     if($status->save()){
      return redirect()->back()->with('msg', "Status Changed Successfully");

    }
  }
  public function product_group()
  {
    $data = productGroup::orderby('id','desc')->get();
    // dd($data);
    $product=product::get();
    if (Auth::user()->role == '3' || $this->role_check(4)) {
      return view('master.product_group', compact('product','data'));
    } else {
      $msg = 'Cannot Access Page !';
      return redirect()->back()->with('msg', $msg);
    }
  }
  
  public function edit_product_group(Request $request)
  {
    $master=productGroup::where('id',$request->id)->first();
     $result = productGroup_sub::
     leftjoin('products','products.id','=','product_group_subs.product_name')
     ->select('product_group_subs.*','products.product_name','products.model_number','product_group_subs.product_name as product_id')->
     where('product_group_subs.product_group_id',$request->id)
     ->get();
    return response()->json(['success' => '1','data'=>$result,'master'=>$master]);

  }
  public function add_product_group(request $request){
    $input = $request->all();
    if($input['id']>0){
     $master =  productGroup::find($input['id'])->first();
     $master->product_group_name= $input['product_group_name'];
     $master->price=  $input['product_price'];
     $master->save();
     productGroup_sub::where('product_group_id',$input['id'])->delete();
     $msg="Product Group Updated Successfully!";

    }else{
    
      unset($input['_token']);
      $master =  productGroup::create([
        'product_group_name'=>$input['product_group_name'],
        "price" => $input['product_price'],
    ]);

     $msg="Product Group Added Successfully!";
    }
    if($master){
      $last_id=$master->id;
    //  for($i=0;$i<=$length;$i++){
      if(isset($request->product_type)){
        foreach($request->product_type as $key =>$val){
          productGroup_sub::create([
              'product_group_id'=>$last_id,
              'product_type'=>$request->product_type[$key],
              "product_name" => $request->product_name[$key],
              "model_no" => $request->model_no[$key],
          ]);
      }
      }

     }

    return redirect()->back()->with('msg',$msg);

  

}

public function get_products(Request $request){
  //  dd($request->all());
  if(isset($request->id)){
    $result = product::where('producttype', $request->id)->get();

  }else if(isset($request->model)){
    $result = product::where('id', $request->model)->first();
  }
  // }
   return response()->json(['success' => '1','data'=>$result]);
  }
}
