<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\expense;
use Illuminate\Http\Request;
use App\Models\expense_details;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Traits\LeadLogTrait;

class exp_detailsController extends Controller
{
   use LeadLogTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cdata =expense::all();
      
        if($request->all()){
            $year = $request->year;
            $month = $request->month;
        }else{
            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;
        }
        $data =expense_details::select('expense_details.*','expenses.name as expense')->leftjoin('expenses','expense_details.expID','=','expenses.id')->whereYear('expense_details.expdate',$year)->whereMonth('expense_details.expdate',$month)
        ->where('expense_details.companyID',Auth::user()->companyID)
        ->get();
        if($request->id !=''){
             $edit_data= expense_details::where('id','=',$request->id)->first();
             
             if($edit_data ==''){
              return response()->json(['success' => '0', 'error' => '']);
      
             }
             return response()->json(['success' => '1', 'data' => $edit_data]);
              
        }
        if(Auth::user()->role_id =='3' || $this->role_check(41)){
            
        return view('expense.add_expense', ['data'=>$data,'cdata'=>$cdata,'year'=>$year,'month'=>$month]);
          }else{
            $msg='Cannot Access Page !';
             return redirect()->back()->with('msg', $msg);
          }
      
    }

    public function expenses_store_update(Request $request)
    {
       $request->validate([
        // 'name' => 'required',
        ]);

        $input = $request->all();
        unset($input['_token']);
        $input['created_by'] = Auth::user()->id;
        $input['companyID'] = Auth::user()->companyID;

        expense_details::updateOrInsert(
          ['id' => $request->id],
          $input
        );

        if ($request->id == "") {
            $msg = "Expense Added Successfully!";
          } else {
            $msg = "Expense Updated Successfully!";
          }

        return redirect()->back()->with('msg', $msg);
    }


    public function expenses_delete(Request $request){
    $data=$request->id;
    $delete = expense_details::find($request->id)->delete();
    
           return response()->json(['success' => '1']);
    
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
}
