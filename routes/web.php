<?php

use App\Models\Customer;
use App\Models\purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ScrapController;
use App\Http\Controllers\Commoncontroller;
use App\Http\Controllers\Mastercontroller;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\QuotationController;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\add_puchaseController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\exp_detailsController;
use App\Http\Controllers\EmployeeLoanController;
use App\Http\Controllers\CallManagementController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\add_purchasebillcontroller;
use App\Http\Controllers\add_importpurchasebillcontroller;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password.get');
Route::post('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitForgotPasswordForm'])->name('forgot.password.post');
Route::get('reset-passwords/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::get('reset-passwords', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('/');
//common controller

Route::post('/getstate', [App\Http\Controllers\Commoncontroller::class, 'get_state'])->name('get.state');
Route::post('/get_city', [App\Http\Controllers\Commoncontroller::class, 'get_city'])->name('get.city');

Route::get('/privacy', [App\Http\Controllers\Commoncontroller::class, 'privacy']);
Route::post('/check_exit', [App\Http\Controllers\Commoncontroller::class, 'check_exit'])->name('exit.index');


//Route::post('forgot-password', [ForgotPasswordController::class, 'submitForgotPasswordForm'])->name('forgot.password.post');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::post('/addcompany', [UserController::class, 'company'])->name('add.company');


    Route::get('/user', [UserController::class, 'index'])->name('user.user');
    Route::post('/user', [UserController::class, 'add'])->name('user.add');
    Route::post('/emp-draft', [Mastercontroller::class, 'emp_draft']);
    Route::post('/cus_draft', [Mastercontroller::class, 'cus_draft']);

    Route::post('/change_password', [UserController::class, 'change_password'])->name('password.confirm');
    Route::get('/user-profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/upload', [UserController::class, 'upload_image'])->name('user.upload');

    Route::post('/add_profile', [UserController::class, 'add_profile'])->name('profile.add');

    Route::get('/role', [RoleController::class, 'role'])->name('role.role');
    Route::post('/check_emp', [RoleController::class, 'check_emp'])->name('employee.check');


    Route::post('/permission', [RoleController::class, 'permission'])->name('role.permission');
   

    Route::post('/permission1', [RoleController::class, 'permission1'])->name('role.permission1');





    Route::get('/master-menus', [Mastercontroller::class, 'index'])->name('master.master_menus');
    Route::get('/holiday', [Mastercontroller::class, 'holiday_index'])->name('holiday.index');
    Route::post('/holiday', [Mastercontroller::class, 'holiday_store_update'])->name('holiday.store');
    Route::post('/holiday-delete', [Mastercontroller::class, 'holiday_delete'])->name('holiday.delete');

    Route::get('/expense', [Mastercontroller::class, 'expenses_index'])->name('expense.index');
    Route::post('/expense', [Mastercontroller::class, 'expenses_store_update'])->name('expense.store');
    Route::post('/expense-delete', [Mastercontroller::class, 'expenses_delete'])->name('expense.delete');

    Route::get('/terms', [Mastercontroller::class, 'terms_index'])->name('terms.index');
    Route::post('/terms', [Mastercontroller::class, 'terms_store_update'])->name('terms.store');
    Route::post('/terms-delete', [Mastercontroller::class, 'terms_delete'])->name('terms.delete');

    Route::get('/m_products', [Mastercontroller::class, 'm_products_index'])->name('m_products.index');
    Route::post('/m_products', [Mastercontroller::class, 'm_products_store_update'])->name('m_products.store');
    Route::post('/m_products-delete', [Mastercontroller::class, 'm_products_delete'])->name('m_products.delete');

    Route::get('/tax', [Mastercontroller::class, 'tax_index'])->name('tax.index');
    Route::post('/tax', [Mastercontroller::class, 'tax_store_update'])->name('tax.store');
    Route::post('/tax-delete', [Mastercontroller::class, 'tax_delete'])->name('tax.delete');


    Route::get('/supplier', [Mastercontroller::class, 'supplier_index'])->name('supplier.index');
    Route::post('/supplier', [Mastercontroller::class, 'supplier_store_update'])->name('supplier.store');
    Route::post('/supplier-delete', [Mastercontroller::class, 'supplier_delete'])->name('supplier.delete');

    Route::get('master/vendor', [Mastercontroller::class, 'vendor_index'])->name('vendor.index');
    Route::post('master/vendor', [Mastercontroller::class, 'vendor_store_update'])->name('vendor.store');
    Route::post('master/vendor-delete', [Mastercontroller::class, 'vendor_delete'])->name('vendor.delete');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/add-category', [AdminController::class, 'index'])->name('admin.product');
    Route::get('/add-product', [AdminController::class, 'add_product'])->name('admin.add-product');
    Route::get('/list-product', [AdminController::class, 'list_product'])->name('admin.list-product-category');
    Route::get('/edit-product/{id}', [AdminController::class, 'edit_product'])->name('admin.edit-product-category');



    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/add-category', [AdminController::class, 'index'])->name('admin.product');
    Route::get('/add-product', [AdminController::class, 'add_product'])->name('admin.add-product');
    Route::get('/list-product', [AdminController::class, 'list_product'])->name('admin.list-product-category');
    Route::get('/edit-product/{id}', [AdminController::class, 'edit_product'])->name('admin.edit-product-category');


    // employee

    Route::get('/employee', [Mastercontroller::class, 'emp_index'])->name('employee.emp_index');
    Route::post('/employee', [Mastercontroller::class, 'emp_store_update'])->name('employee.emp_store');
    Route::post('/employee-delete', [Mastercontroller::class, 'emp_delete'])->name('employee.emp_delete');

    // customer


    Route::get('/customer', [Mastercontroller::class, 'cus_index'])->name('customer.cus_index');
    Route::post('/customer', [Mastercontroller::class, 'cus_store_update'])->name('customer.cus_store');
    Route::post('/customer-delete', [Mastercontroller::class, 'cus_delete'])->name('customer.cus_delete');


    //brand

    Route::get('/brand', [Mastercontroller::class, 'brand_index'])->name('brand.brand_index');
    Route::post('/brand', [Mastercontroller::class, 'brand_store_update'])->name('brand.brand_store');
    Route::post('/brand-delete', [Mastercontroller::class, 'brand_delete'])->name('brand.brand_delete');


    //Category

    Route::get('/category', [Mastercontroller::class, 'category_index'])->name('category.category_index');
    Route::post('/category', [Mastercontroller::class, 'category_store_update'])->name('category.category_store');
    Route::post('/category-delete', [Mastercontroller::class, 'category_delete'])->name('category.category_delete');


    //Branch

    Route::get('/branch', [Mastercontroller::class, 'branch_index'])->name('branch.branch_index');
    Route::post('/branch', [Mastercontroller::class, 'branch_store_update'])->name('branch.branch_store');
    Route::post('/branch-delete', [Mastercontroller::class, 'branch_delete'])->name('branch.exp_delete');


        //company

        Route::get('/company_master', [Mastercontroller::class, 'company_index'])->name('company.company_index');
        Route::post('/company_master', [Mastercontroller::class, 'company_store_update'])->name('company.company_store');
        Route::post('/company-delete', [Mastercontroller::class, 'company_delete'])->name('company.exp_delete');
    
    //Model

    Route::get('/model', [Mastercontroller::class, 'model_index'])->name('model.model_index');
    Route::post('/model', [Mastercontroller::class, 'model_store_update'])->name('model.model_store');
    Route::post('/model-delete', [Mastercontroller::class, 'model_delete'])->name('model.model_delete');

    Route::post('/model_get', [Mastercontroller::class, 'model_getid'])->name('model.getid');

    // verification

    Route::get('/verification', [Mastercontroller::class, 'verify_index'])->name('verification.verify_index');
    Route::post('/verification', [Mastercontroller::class, 'verifypan'])->name('verification');
    Route::any('/verify_aadhar', [Mastercontroller::class, 'verify_aadhar'])->name('verify.aadhar');
    Route::post('/verify_otp_aadhar', [Mastercontroller::class, 'verify_otp_aadhar'])->name('verify.otp.aadhar');
    Route::post('/verify_licence', [Mastercontroller::class, 'verify_licence'])->name('verify.licence');
    Route::get('/verify_aadhar', [Mastercontroller::class, 'verify_index']);
    Route::get('/verify_otp_aadhar', [Mastercontroller::class, 'verify_index']);
    Route::get('/verify_licence', [Mastercontroller::class, 'verify_index']);


     //change_status
     Route::post('/change_status', [Mastercontroller::class, 'change_status'])->name('change.status');

     
    //Purchase Bill  Order
    
    Route::get('/localpurchase', [add_purchasebillcontroller::class, 'index'])->name('localpurchase.index');
    Route::post('/localpurchase', [add_purchasebillcontroller::class, 'store'])->name('add.purchase');
    Route::get('/purchase-view', [add_purchasebillcontroller::class, 'view'])->name('localpurchase.view');
    Route::get('/purchase-payment/{id}', [add_purchasebillcontroller::class, 'payment'])->name('purchase.payment');

    Route::get('/purchase-edit/{id}', [add_purchasebillcontroller::class, 'edit'])->name('purchase.edit');
    Route::post('/purchase-payment', [add_purchasebillcontroller::class, 'payment_update'])->name('purchase.payment.update');
    Route::post('/purchase-update', [add_purchasebillcontroller::class, 'update'])->name('purchase.update');
    Route::get('/purchase-stocks', [add_purchasebillcontroller::class, 'stocks'])->name('localpurchase.stocks');
    Route::post('/purchase-stocks', [add_purchasebillcontroller::class, 'get_branchAndRack'])->name('get.branchAndRack');
    Route::post('/purchase-addBranchAndLocation', [add_purchasebillcontroller::class, 'addBranchAndLocation'])->name('purchase.addBranchAndLocation');
    Route::get('/purchase-print/{id}', [add_purchasebillcontroller::class, 'print'])->name('purchase.print');

    
    
    //import purchase bill
    Route::get('/importpurchase', [add_importpurchasebillcontroller::class, 'index'])->name('importpurchase.index');
    Route::post('/importpurchase', [add_importpurchasebillcontroller::class, 'store'])->name('add.importpurchase');
    Route::get('/importpurchase-view', [add_importpurchasebillcontroller::class, 'view'])->name('importpurchase.view');
    Route::get('/importpurchase-payment/{id}', [add_importpurchasebillcontroller::class, 'payment'])->name('importpurchase.payment');
    Route::get('/importpurchase-edit/{id}', [add_importpurchasebillcontroller::class, 'edit'])->name('importpurchase.edit');
    Route::post('/importpurchase-payment', [add_importpurchasebillcontroller::class, 'payment_update'])->name('importpurchase.payment.update');
    Route::post('/importpurchase-update', [add_importpurchasebillcontroller::class, 'update'])->name('importpurchase.update');
    Route::get('/importpurchase-stocks', [add_importpurchasebillcontroller::class, 'stocks'])->name('importpurchase.stocks');

    

    Route::post('/purchase-update/{id}', [add_puchaseController::class, 'purchase_editupdate'])->name('purchase.purchase_editupdate');
    Route::post('/purchase-view_delete', [add_puchaseController::class, 'purchaseview_delete'])->name('purchase.view_delete');
    Route::post('/purchase-qtyproduct_delete', [add_puchaseController::class, 'qtyproduct_delete'])->name('purchase.qtyproduct_delete');


    Route::get('/purchase', [add_puchaseController::class, 'purchase_index'])->name('purchase.purchase_index');

    Route::post('/serialvalidation', [add_puchaseController::class, 'serialvalidation'])->name('serial.serialvalidation');

    Route::post('/getidpurchase', [add_puchaseController::class, 'puchasemodel_getid'])->name('purchase.model_getidpurchase');

    Route::post('/purchase', [add_puchaseController::class, 'purchase_store_update'])->name('purchase.purchase_store');
    Route::post('/purchase-delete', [add_puchaseController::class, 'purchase_delete'])->name('purchase.purchase_delete');
    Route::post('/product_get', [add_puchaseController::class, 'product_getid'])->name('product.getid');
    Route::post('/desc_get', [add_puchaseController::class, 'desc_getid'])->name('desc.getid');

    Route::post('/purchasesupplier', [add_puchaseController::class, 'purchasesup_store_update'])->name('purchasesupplier.purchase_store');

    //Expense

    Route::get('/exp_dtl', [exp_detailsController::class, 'index'])->name('exp_dtl.index');
    Route::post('/exp_dtl', [exp_detailsController::class, 'expenses_store_update'])->name('exp_dtl.exp_store');
    Route::post('/exp_dtl-delete', [exp_detailsController::class, 'expenses_delete'])->name('exp_dtl.exp_delete');


    //Attedance

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendanceedit/{id}', [AttendanceController::class, 'index'])->name('attendance.edit');
    Route::get('/attendance-view', [AttendanceController::class, 'view'])->name('attendance.view');
    Route::get('/attendance-view/{id}', [AttendanceController::class, 'view']);


    Route::post('/attendance', [AttendanceController::class, 'attendance_store_update'])->name('attendance.attendance_store');
    Route::post('/attendance-delete', [AttendanceController::class, 'attendance_delete'])->name('attendance.attendance_delete');
    
    // EmployeeLoan 
    Route::get('/employeeloan', [EmployeeLoanController::class, 'index'])->name('employeeloan.index');
    Route::post('/employeeloan', [EmployeeLoanController::class, 'store'])->name('employee_loan.store');
    Route::get('/return_pay/{id}', [EmployeeLoanController::class, 'return_pay'])->name('employee_loan.return_pay');
    Route::post('/return_pay', [EmployeeLoanController::class, 'employee_update'])->name('employee.loan.update');
    Route::get('/get_loan_histories/{id}', [EmployeeLoanController::class, 'loan_histories'])->name('view.loan.histories');
    //sale

    Route::get('/sale', [SaleController::class, 'index'])->name('sale.index');
    Route::post('/load_sale', [SaleController::class, 'load_data'])->name('load.product');
    Route::post('/load_tax', [SaleController::class, 'get_tax'])->name('get.tax');

    Route::post('/load_tax_grand', [SaleController::class, 'load_tax_grand'])->name('load.tax.grand');
    Route::post('/sale', [SaleController::class, 'add_purchase_order'])->name('sale.sale_store');
    Route::post('/sale-delete', [SaleController::class, 'sale_delete'])->name('sale.sale_delete');
    Route::post('/final_invoice', [SaleController::class, 'final_invoice'])->name('sale.final_invoice');
    Route::get('/viewinoice', [SaleController::class, 'invoicelist'])->name('sale.invoice');
    Route::get('/print/{id}', [SaleController::class, 'print'])->name('sale.print');
    Route::get('/payment/{id}', [SaleController::class, 'payment'])->name('sale.payment');
    Route::post('/payment', [SaleController::class, 'payment_store'])->name('sale.payment.update');
    Route::get('/invoice/{id}', [SaleController::class, 'invoice']);
    Route::get('/getmodal', [SaleController::class, 'getmodal'])->name('sale.getmodal');
    Route::get('/getmanual_products', [SaleController::class, 'getmanual_products'])->name('sale.getmanual_products');
    Route::post('/getstock', [SaleController::class, 'getstock'])->name('sale.getstock');
    Route::get('/getreceipt', [SaleController::class, 'getreceipt'])->name('sale.receipt');
    Route::get('/receipt', [SaleController::class, 'receipt'])->name('receipt');
    Route::post('/get_products', [SaleController::class, 'get_purchase'])->name('get.purchase');
    Route::post('/get_serial', [SaleController::class, 'get_serial'])->name('get.serial');


    

    /** QuotationController */
    Route::get('/quotation', [QuotationController::class, 'showQuotation']);
    /** ServiceController */
    // Route::gst('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/add-service', [ServiceController::class, 'add_service'])->name('add.service');

    
   
    /** CallMangementController */
    Route::get('/call', [CallManagementController::class, 'Call']);
    Route::get('/invoice-agreement', [Mastercontroller::class, 'invoice_agreement_index'])->name('invoice.agreement.index');
    Route::post('/invoice-agreement', [Mastercontroller::class, 'invoice_agreement_store'])->name('add.invoice.agreement');
    Route::post('/invoice-agreement_delete', [Mastercontroller::class, 'invoice_agreement_delete'])->name('delete.invoice.agreement');
    Route::get('/agreement', [Mastercontroller::class, 'agreement_index'])->name('agreement.index');
    Route::post('/agreement', [Mastercontroller::class, 'agreement_store'])->name('add.agreement');
    Route::post('/agreement_delete', [Mastercontroller::class, 'agreement_delete'])->name('delete.agreement');


    /** QuotationController */
    Route::get('/quotation', [QuotationController::class, 'showQuotation'])->name('quotation.add');
    Route::get('/quotation-view', [QuotationController::class, 'view'])->name('quotation.view');
    Route::post('/store-quotation', [QuotationController::class, 'store'])->name('quotation.store');
    Route::get('/quotation-list/{id}', [QuotationController::class, 'list'])->name('quotation.list');
    Route::get('/quotation-edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');
    Route::get('/quotation_print/{id}', [QuotationController::class, 'quotation_print'])->name('quotation.quotation_print');
    Route::POST('/get_tax', [QuotationController::class, 'get_tax'])->name('customer.get_tax');
    Route::get('/quotation-getmodal', [QuotationController::class, 'getmodal'])->name('quotation.getmodal');
    

    Route::post('/load_quotation', [QuotationController::class, 'get_data'])->name('load.quotation');


    Route::post('/quotation-product-delete', [QuotationController::class, 'prodct_delete'])->name('quotation.edit_delete');
    Route::post('/quotation-update', [QuotationController::class, 'update'])->name('quotation.update');
    Route::post('/quotation-delete', [QuotationController::class, 'quotation_delete'])->name('quotation.quotation_delete');
    Route::post('/quotation-delete', [QuotationController::class, 'quotation_delete'])->name('quotation.quotation_delete');
    Route::post('/quotation-invoice', [QuotationController::class, 'quotation_invoice'])->name('quotation.invoice');
    Route::post('/quotation-proforma', [QuotationController::class, 'quotation_proforma'])->name('quotation.proforma');
    Route::get('/quotation-proforma/{id}', [QuotationController::class, 'quotation_proforma_print'])->name('quotation.proforma.print');

    
    
    /** ServiceController */
    Route::get('/service', [ServiceController::class, 'Service']);
    /** CallMangementController */
    Route::get('/call', [CallManagementController::class, 'Call']);
    Route::get('/invoice-agreement', [Mastercontroller::class, 'agreement_index'])->name('invoice.agreement.index');
    Route::post('/invoice-agreement', [Mastercontroller::class, 'invoice_agreement_store'])->name('add.invoice.agreement');
    Route::post('/invoice-agreement_delete', [Mastercontroller::class, 'invoice_agreement_delete'])->name('delete.invoice.agreement');
    Route::get('/agreement', [Mastercontroller::class, 'agreement_index'])->name('agreement.index');
    Route::post('/agreement', [Mastercontroller::class, 'agreement_store'])->name('add.agreement');
    Route::post('/agreement_delete', [Mastercontroller::class, 'agreement_delete'])->name('delete.agreement');

    //scrap management

    Route::get('/scrap', [ScrapController::class, 'index'])->name('scrap.index');
    Route::post('/finalscrap', [ScrapController::class, 'final'])->name('final.scrap');
    Route::get('/view', [ScrapController::class, 'viewscrap'])->name('scrap.view');
    Route::get('/view/{id}', [ScrapController::class, 'viewscraplist'])->name('scrap.view.list');
    Route::get('/scrap/edit/{id}', [ScrapController::class, 'scrap_edit']);
    Route::post('/scrap/edit', [ScrapController::class, 'update'])->name('update.scrap');
    Route::post('/scrap/delete', [ScrapController::class, 'delete'])->name('scrap.delete');



    Route::get('/status', [Mastercontroller::class, 'showStatus'])->name('status.index');
    Route::get('/referer', [Mastercontroller::class, 'showReferer'])->name('referer.index');
    Route::get('/source', [Mastercontroller::class, 'showSource'])->name('source.index');
    Route::get('/enquiry', [Mastercontroller::class, 'showEnquiry'])->name('enquiry.index');
    Route::get('/complaint', [Mastercontroller::class, 'showcomplaint'])->name('complaint.index');
    Route::get('/courier', [Mastercontroller::class, 'showcourier'])->name('courier.index');
    Route::get('/hsn', [Mastercontroller::class, 'showhsn'])->name('hsn.index');
    Route::get('/state', [Mastercontroller::class, 'showstate'])->name('state.index');
    Route::get('/bank-master', [Mastercontroller::class, 'showbankmaster'])->name('bank.master.index');
    Route::get('/financial', [Mastercontroller::class, 'showfinancial'])->name('financial.index');
    Route::get('/city', [Mastercontroller::class, 'showcity'])->name('city.index');
    Route::get('/salution', [Mastercontroller::class, 'showSalution'])->name('Salution.index');
    Route::get('/purchase_mode', [Mastercontroller::class, 'showpurchase_mode'])->name('purchase_mode.index');
    Route::get('/transaction_mode', [Mastercontroller::class, 'showtransaction_mode'])->name('transaction_mode.index');
    Route::get('/rack_location', [Mastercontroller::class, 'showrack_location'])->name('rack_location.index');
    Route::get('/local_purchase', [Mastercontroller::class, 'local_purchase'])->name('local_purchase.index');
    Route::get('/import_purchase', [Mastercontroller::class, 'import_purchase'])->name('import_purchase.index');
    Route::get('/cus_categories', [Mastercontroller::class, 'cus_categories'])->name('cus_categories.index');
    Route::get('/enquiry_categories', [Mastercontroller::class, 'enquiry_categories'])->name('enquiry_categories.index');
    Route::get('/enquiry_sub_categories', [Mastercontroller::class, 'enquiry_sub_categories'])->name('enquiry_sub_categories.index');

    Route::get('/customer_sub_category', [Mastercontroller::class, 'customer_sub_category'])->name('customer_sub_category.index');
    Route::get('/products_master', [Mastercontroller::class, 'products_master'])->name('products_master.index');
    Route::get('/product_group', [Mastercontroller::class, 'product_group'])->name('enquiry_sub_categories.index');
    Route::post('/get_products', [Mastercontroller::class, 'get_products'])->name('get.products');
    Route::post('/add_product_group', [Mastercontroller::class, 'add_product_group'])->name('products.addProductGroup');
    Route::get('/add_product_group', [Mastercontroller::class, 'edit_product_group'])->name('edit.group_products');

    Route::get('/role_master', [Mastercontroller::class, 'showrole'])->name('role.index');
    
    Route::get('/bank_master', [Mastercontroller::class, 'showbank_master'])->name('bank.index');
    
    Route::get('/gps_platform', [Mastercontroller::class, 'gps_platform'])->name('gps.index');
    Route::get('/network', [Mastercontroller::class, 'network'])->name('network.index');

    Route::get('/stage', [Mastercontroller::class, 'showStage'])->name('stage.index');
    Route::get('/paymentmode', [Mastercontroller::class, 'showPayment'])->name('paymentmode.index');
    Route::get('/paymentstatus', [Mastercontroller::class, 'showpaymentstatus'])->name('paymentstatus.index');

    Route::get('/designation', [Mastercontroller::class, 'showDesignation'])->name('designation.index');
    Route::post('/designation_delete', [Mastercontroller::class, 'designation_delete'])->name('designation.delete');

    Route::get('/email_template', [Mastercontroller::class, 'showEmailTemplate'])->name('email_template.index');
    Route::post('/storeStatus', [Mastercontroller::class, 'storeStatus'])->name('status.storeStatus');
    Route::get('/editMasters/{id}/{table}', [Mastercontroller::class, 'editMasters'])->name('master.editmasters');
    Route::post('/assignLead', [LeadController::class, 'assignLead'])->name('assignLead');
    Route::get('getCategory', [add_puchaseController::class, 'getCategory'])->name('getCategory');

    
    Route::get('/add-lead', [LeadController::class, 'lead_index'])->name('add.lead');
    Route::post('/lead_delete', [LeadController::class, 'lead_delete'])->name('lead.lead_delete');

    Route::post('/lead_customer', [LeadController::class, 'getcustomer'])->name('lead.getcustomet');
    Route::post('/lead-reject', [LeadController::class, 'lead_reject'])->name('lead.reject');

    
    Route::post('/rq-model_get', [Mastercontroller::class, 'model_getproduct'])->name('model.getproduct');
    Route::post('/generateQRcode', [Mastercontroller::class, 'generateQrCode'])->name('generateCode');
    Route::post('/createLead', [LeadController::class, 'createLead'])->name('createLead');
    Route::post('/previewQR', [Mastercontroller::class, 'previewQR'])->name('previewQR');
    Route::get('/view-QR_Code/{id}', [Mastercontroller::class, 'qrview'])->name('qrcode.qrview');
    Route::post('/qrcode-delete', [Mastercontroller::class, 'qrdelete'])->name('qrcode.delete');
    
    //sub menu add
    Route::get('/menu', [RoleController::class, 'menu'])->name('menu');
    Route::get('/sub-menu', [RoleController::class, 'sub_menu'])->name('sub.menu');

    Route::get('/generate-qr', [Mastercontroller::class, 'QrCode'])->name('generate.qr');
    Route::post('/generateQRcode', [Mastercontroller::class, 'generateQrCode'])->name('generateCode');
    Route::post('/createLead', [LeadController::class, 'createLead'])->name('createLead');
    Route::post('/previewQR', [Mastercontroller::class, 'previewQR'])->name('previewQR');
    //sub menu add
    Route::get('/menu', [RoleController::class, 'menu'])->name('menu');
    Route::get('/sub-menu', [RoleController::class, 'sub_menu'])->name('sub.menu');
    Route::get('/permission', [RoleController::class, 'permission_menu'])->name('permission.menu');

    Route::get('/sendNotification/{id}/{title}/{msg}',[LeadController::class,'sendNotification']);


     //reports
     Route::get('/report-menus', [ReportsController::class, 'index'])->name('report.report_menus');

     Route::get('/gst-report', [ReportsController::class, 'gst'])->name('report.gst');
     Route::get('/non-gst-report', [ReportsController::class, 'non_gst'])->name('report.non.gst');
     Route::get('/completed', [ReportsController::class, 'completed'])->name('report.completed');
     Route::get('/pending', [ReportsController::class, 'pending'])->name('report.pending');
     Route::get('/total_purchase', [ReportsController::class, 'purchase'])->name('report.purchase');
     Route::get('/report-rental_all-list', [ReportsController::class, 'rental_alllist'])->name('report.rental_alllist');
     Route::get('/report-rental_return-list', [ReportsController::class, 'rental_returnlist'])->name('report.rental_returnlist');
     Route::get('/report-rental-list', [ReportsController::class, 'rental_list'])->name('report.rental_list');
     Route::get('/report-customer-list', [ReportsController::class, 'customer_report'])->name('report.customer');
     Route::get('/report-suplier-list', [ReportsController::class, 'suplier_report'])->name('report.suplier');
     Route::get('/report-quotation-list', [ReportsController::class, 'quotation_report'])->name('report.quotation');
     Route::get('/report-expense-list', [ReportsController::class, 'expense_report'])->name('report.expense');
     Route::get('/report-overallsale-list', [ReportsController::class, 'overallsale_report'])->name('report.overallsale');
     Route::get('/balance', [ReportsController::class, 'balance'])->name('report.balance');
     Route::get('/rental_agreement', [ReportsController::class, 'rental_agreement'])->name('report.rental_agreement');

     
     
     Route::get('/employee-salary-details', [ReportsController::class, 'employee_salary_details'])->name('employee.salary');
    
     
});
