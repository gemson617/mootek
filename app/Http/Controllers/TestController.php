<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\ScheduledOrder;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetails;
use App\Models\CustomerOrderSchedule;
use Response;
use PDF;
use DB;
use DateTime;
use DateInterval;
use Mail;
use Carbon\Carbon;
use Auth;
use Carbon\CarbonPeriod;
use App\Models\Suburb;

class TestController extends Controller
{
  public function scheduled_order($id)
  {
    // dd("test");

    // $input = $request->all();
    // dd($input);
    return view('test.test', compact(
      'id'
		));
  }
  public function scheduled_order_insert(Request $request)
  {
    $input = $request->all();
    // dd($input);
    if(empty($input['mon_day']))
    {
      $mon_day=$input['mon_day1'];
      $mon_day1=$input['mon_day1'];
    }
    else
    {
      $mon_day=$input['mon_day'];
      $mon_day1=$input['mon_day'];
    }

    if(empty($input['tues_day']))
    {
      $tues_day=$input['tues_day1'];
      $tues_day1=$input['tues_day1'];
    }
    else
    {
      $tues_day=$input['tues_day'];
      $tues_day1=$input['tues_day'];
    }
    if(empty($input['wed_day']))
    {
      $wed_day=$input['wed_day1'];
      $wed_day1=$input['wed_day1'];
    }
    else{
      $wed_day=$input['wed_day'];
      $wed_day1=$input['wed_day'];
    }

    if(empty($input['thu_day']))
    {
      $thu_day=$input['thu_day1'];
      $thu_day1=$input['thu_day1'];
    }
    else{
      $thu_day=$input['thu_day'];
      $thu_day1=$input['thu_day'];
    }

    if(empty($input['fri_day']))
    {
      $fri_day=$input['fri_day1'];
      $fri_day1=$input['fri_day1'];
    }
    else{
      $fri_day=$input['fri_day'];
      $fri_day1=$input['fri_day'];
    }
    if(empty($input['sat_day']))
    {
      $sat_day=$input['sat_day1'];
      $sat_day1=$input['sat_day1'];
    }
    else{
      $sat_day=$input['sat_day'];
      $sat_day1=$input['sat_day'];
    }
    if(empty($input['sun_day']))
    {
      $sun_day=$input['sun_day1'];
      $sun_day1=$input['sun_day1'];
    }
    else{
      $sun_day=$input['sun_day'];
      $sun_day1=$input['sun_day'];
    }
    $order=CustomerOrder::where('customer_id','=',$input['customer_id'])->first();
    $order1=CustomerOrderDetails::where('order_id','=',$order['id'])->first();
    $delivery =new ScheduledOrder;
    $delivery->customer_id = $input['customer_id'];
    $delivery->order_id = $order['id'];
    $delivery->created_by = Auth::user()->id;
    $delivery->monday_dispatch = $mon_day;
    $delivery->tuesday_dispatch = $tues_day;
    $delivery->wednesday_dispatch = $wed_day;
    $delivery->thursday_dispatch = $thu_day;
    $delivery->friday_dispatch = $fri_day;
    $delivery->saturday_dispatch = $sat_day;
    $delivery->sunday_dispatch = $sun_day;
    $delivery->week_type = $input['week_no'];
    $delivery->week_type_days = $input['day_no'];
    $delivery->delivery_dispatch = $input['delEvery'];
    $delivery->start_date = $input['start_date'];
    $delivery->end_date = $input['end_date'];
    // dd($delivery);
    $delivery->save();
    // $delivery->id
    $lastid=$delivery->id;
    // dd($input['day_no']);
    $array=array();
    // if($input['week_no'] == '2')
    // {
        $no_week=$input['week_no'];
        $current_week_first_day=strtotime('Monday', strtotime($input['start_date']));

        $start_date=strtotime('+'.($no_week-1).' week', $current_week_first_day);
        // dd($start_date);
        $period = CarbonPeriod::create($input['start_date'], $input['end_date']);
        // Iterate over the period
        if($input['delEvery'] == 'on')
        {
           $endDate = strtotime($input['end_date']);
           $date=strtotime($input['day_no'], strtotime($input['start_date']));
           // dd(date("d/M/Y H:i:s", $date), "\n");
           // echo strtotime($input['end_date'])."<br/>";
           // echo strtotime($input['day_no'], $start_date);
           // exit();
           for($i = strtotime($input['day_no'], $start_date); $i <= strtotime($input['end_date']); $i = strtotime('+'.$no_week.' week', $i))
           {
            // echo date('Y-m-d', $i);
            $cu_or_schdule=new CustomerOrderSchedule;
            $cu_or_schdule->customer_id=$input['customer_id'];
            $cu_or_schdule->schedule_id=$lastid;
            $cu_or_schdule->repeatation_date=date('Y-m-d', $i);
            $cu_or_schdule->save();
          }
        }
      // echo date('M d, Y', $date);
      $period = CarbonPeriod::create($input['start_date'], $input['end_date']);
      foreach ($period as $date)
      {
      // echo $date->format('Y-m-d').'<br/>';
        $datee=date("l",strtotime($date->format('Y-m-d')));
        if($datee == $mon_day1)
        {
          $monn=$date->format('Y-m-d');
          $cu_or_schdule=new CustomerOrderSchedule;
          $cu_or_schdule->customer_id=$input['customer_id'];
          $cu_or_schdule->schedule_id=$lastid;
          $cu_or_schdule->repeatation_date=$monn;
          $cu_or_schdule->save();
        }
        if($datee == $tues_day1)
        {
          $tuess=$date->format('Y-m-d');
          $cu_or_schdule=new CustomerOrderSchedule;
          $cu_or_schdule->customer_id=$input['customer_id'];
          $cu_or_schdule->schedule_id=$lastid;
          $cu_or_schdule->repeatation_date=$tuess;
          $cu_or_schdule->save();
        }
        if($datee == $wed_day1)
        {
          $wed=$date->format('Y-m-d');
          $cu_or_schdule=new CustomerOrderSchedule;
          $cu_or_schdule->customer_id=$input['customer_id'];
          $cu_or_schdule->schedule_id=$lastid;
          $cu_or_schdule->repeatation_date=$wed;
          $cu_or_schdule->save();
        }
        if($datee == $thu_day1)
        {
          $thu=$date->format('Y-m-d');
          $cu_or_schdule=new CustomerOrderSchedule;
          $cu_or_schdule->customer_id=$input['customer_id'];
          $cu_or_schdule->schedule_id=$lastid;
          $cu_or_schdule->repeatation_date=$thu;
          $cu_or_schdule->save();
        }
        if($datee == $fri_day1)
        {
          $fri=$date->format('Y-m-d');
          $cu_or_schdule=new CustomerOrderSchedule;
          $cu_or_schdule->customer_id=$input['customer_id'];
          $cu_or_schdule->schedule_id=$lastid;
          $cu_or_schdule->repeatation_date=$fri;
          $cu_or_schdule->save();
        }
        if($datee == $sat_day1)
        {
          $sat=$date->format('Y-m-d');
          $cu_or_schdule=new CustomerOrderSchedule;
          $cu_or_schdule->customer_id=$input['customer_id'];
          $cu_or_schdule->schedule_id=$lastid;
          $cu_or_schdule->repeatation_date=$sat;
          $cu_or_schdule->save();
        }
        if($datee == $sun_day1)
        {
          $sun=$date->format('Y-m-d');
          $cu_or_schdule=new CustomerOrderSchedule;
          $cu_or_schdule->customer_id=$input['customer_id'];
          $cu_or_schdule->schedule_id=$lastid;
          $cu_or_schdule->repeatation_date=$sun;
          $cu_or_schdule->save();
        }
      }
      // Convert the period to an array of dates
      $dates = $period->toArray();
       // dd($dates);
    // for ($day = 1; $day <= $days; $day++)
    // {
    //     $dates["Week $week"] []= $date->format('d/m/Y');
    //     $dayOfWeek = $date->format('l');
    //     if ($dayOfWeek === 'Saturday')
    //     {
    //         $week++;
    //     }
    //     $date->add($oneDay);
    // }
    // dd($dates);
     // foreach ($dates as $key => $value) {
       // dd($value);
       // echo date("l",strtotime($value[0]));
       // $cu_or_schdule=new CustomerOrderSchedule;
       // $cu_or_schdule->customer_id=$input['customer_id'];
       // $cu_or_schdule->schedule_id=$lastid;
       // $cu_or_schdule->repeatation_date=$value;
       // $cu_or_schdule->save();
       // return 1;
     // }
     // dd($dates);
     return 1;

  }
}
