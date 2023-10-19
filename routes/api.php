<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiCustomerController;
use App\Http\Controllers\Api\RestController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::resource('customers', ApiCustomerController::class);

Route::controller(ApiCustomerController::class)->group(function()
{
  //  Route::post('login','login');
    Route::post('register','register');
});
/** API Controller */
Route::post('/login',[RestController::class,'Login']);
Route::post('/createLead',[RestController::class,'createLead']);
Route::post('/checkInOut',[RestController::class,'checkInOut']);
Route::get('/employeeList',[RestController::class,'employeeList']);
Route::get('/meterialList/{id}',[RestController::class,'meterialList']);
Route::get('/todayListJob',[RestController::class,'todayListJob']);
Route::post('/changePassword',[RestController::class,'changePassword']);
Route::post('/employeeAttendance',[RestController::class,'employeeAttendance']);
Route::get('/acceptJobList/{id}',[RestController::class,'acceptJobList']);
Route::get('/getProfile/{id}',[RestController::class,'getProfile']);
Route::get('/getJobDetails/{id}',[RestController::class,'getJobDetails']);
Route::post('/acceptJob',[RestController::class,'acceptJob']);
Route::post('/todayJob',[RestController::class,'todayJob']);
Route::get('/getCustomer/{id}',[RestController::class,'getCustomer']);
Route::post('/forgetPassword',[RestController::class,'forgetPassword']);
Route::post('/resendOtp',[RestController::class,'resendOtp']);
Route::post('/checkAttendance',[RestController::class,'checkAttendance']);
Route::post('/leadCheckIn',[RestController::class,'leadCheckIn']);
Route::get('/getJobNotification/{id}',[RestController::class,'getJobNotification']);
Route::post('/getCheckIn',[RestController::class,'getCheckIn']);
Route::post('/generateInvoice',[RestController::class,'generateInvoice']);
Route::get('/getCompany',[RestController::class,'getCompany']);
Route::post('/profileUpload',[RestController::class,'profileUpload']);
Route::post('/saveDeviceId',[RestController::class,'saveDeviceId']);
Route::post('/readNotification',[RestController::class,'readNotification']);
Route::post('/employeeCreateAttendance',[RestController::class,'employeeCreateAttendance']);
Route::post('/adminApproval',[RestController::class,'adminApproval']);
Route::get('/AdminEmployeeStatus',[RestController::class,'AdminEmployeeStatus']);
Route::get('/getState',[RestController::class,'state']);
Route::get('/getCity/{id}',[RestController::class,'city']);
Route::get('/listLead/{id}',[RestController::class,'listLead']);
Route::get('/getCategory',[RestController::class,'getCategory']);
Route::get('/getEmployeelist',[RestController::class,'getEmployeelist']);
Route::post('/storePin',[RestController::class,'storePin']);
Route::post('/VerifyPin',[RestController::class,'VerifyPin']);
Route::post('/changePin',[RestController::class,'changePin']);

