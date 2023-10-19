<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\payment_history;
use App\Models\employee_load_histories;

use App\Http\Traits\LeadLogTrait;

use App\Models\employee_load;
use Illuminate\Support\Facades\Auth;

class EmployeeLoanController extends Controller
{
    use LeadLogTrait;
    public function index(Request $request)
    {   
       $employeelist=employee::get();
       $list = employee_load::select('employee_loads.*','users.first_name','users.email','users.mobile','employees.basic_salary')
       ->leftjoin('users','users.id','=','employee_loads.empID')
       ->leftjoin('employees','employees.user_id','=','employee_loads.empID')
       ->get();
    //    dd($list);
    if (Auth::user()->role_id == '3' || $this->role_check(42)) {
        return view('employeeloan.add',compact('employeelist','list'));
     } else {
        $msg = 'Cannot Access Page !';
        return redirect()->back()->with('msg', $msg);
     }
       
    
    }
    public function store(Request $request)
    {   
         $input = $request->all();
         unset($input['_token']);
         $input['user_id'] = Auth::user()->id;
         $input['created_by'] = Auth::user()->id;
         
        if($request->requestType =='Return'){
            $input['balance'] = $request->advanceAmount;
            $input['collected'] =0;
            unset($input['deduction_amount']);
        }else{
            unset($input['received_date']);

        }
        $employee_loan = employee_load::create($input);
          if($request->requestType =='Deduction'){
            for($i=1;$i<=$request->month_deduction;$i++){
                employee_load_histories::create([
                    'employee_load_id'=>$employee_loan->id,
                    'emp_id'=>$request->empID,
                    'no_month'=>$request->month_deduction,
                    'month_type'=>1,
                    'amount'=>$request->advanceAmount/$request->month_deduction,
                    'month_date'=>date('Y-m-d', strtotime($employee_loan->created_at.  '+'.$i.' month')),
                    'total_amount'=>$request->advanceAmount,
                ]
                );
            }
          }
       return redirect()->back()->with('msg','Employee Loan Successfully!');
    }
    public function return_pay($id)
    {   
        // dd($id);
        //  $input = $request->all();
        //  unset($input['_token']);
        //  $input['user_id'] = Auth::user()->id;
        //  $input['created_by'] = Auth::user()->id;
        // if($request->requestType =='return'){
        //     unset($input['deduction_amount']);
        // }
        // employee_load::updateOrInsert(
        //     ['id' => $request->id],
        //     $input
        //   );
       $data = employee_load::select('employee_loads.*','users.first_name','users.mobile','users.email')
       ->leftjoin('users','users.id','=','employee_loads.empID')
      ->where('employee_loads.id',$id)
       ->first();
       $payment_history = payment_history::where('invoiceID',$id)->where('status','5')->get();
        return view('employeeloan.payment',compact('data','payment_history'));

    }
    public function employee_update(Request $request)
    {   
        $check_advance =employee_load::where('id',$request->invoiceID)->first();
        if($check_advance->advanceAmount ==$request->collected){
            $id = payment_history::create([
                'user_id' => Auth::user()->id,
                'invoiceID' => $request->invoiceID,
                'amount' => $request->amount,
                'collected' => $request->collected,
                'balance' => 0,
                'paymentDate' => $request->paymentDate,
                'status'=>'5',  //employee loan status
            ]);
            if($id){
            $update =employee_load::where('id',$request->invoiceID)->first();
            $update->payment_status=1;
            $update->collected=$request->amoun;
            $update->balance=0;
            $update->save();
            return redirect()->back()->with('msg','Employee Payment Successfully!');
            }

        }
    }
    public function loan_histories($id){
        $histores = employee_load_histories::
        leftjoin('users','users.id','=','employee_load_histories.emp_id')
        ->where('employee_load_histories.employee_load_id',$id)
        ->get();

        return view('employeeloan.loan_histories',compact('histores'));

    }
    

}
