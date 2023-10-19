<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenusubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row=[
            [
                'menuID' => '1',
                'subName'=>'Company',
                'icon'=>'fa fa-building',
                'menulink'=>"branch.branch_index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>' Designation',
                'icon'=>'fa fa-id-card',
                'menulink'=>"designation.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>"Email Template",
                'icon'=>'fa fa-envelope',
                'menulink'=>"email_template.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>'Payment Mode',
                'icon'=>'fa fa-credit-card',
                'menulink'=>"paymentmode.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>'Referer',
                'icon'=>'fa fa-user-plus',
                'menulink'=>"referer.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>"Status",
                'icon'=>'fa fa-flag-o',
                'menulink'=>"status.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>'Source',
                'icon'=>'fa fa-newspaper-o',
                'menulink'=>"source.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>' Stage',
                'icon'=>'fa fa-th',
                'menulink'=>"stage.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>'Agreement',
                'icon'=>'fa fa-file-text',
                'menulink'=>"agreement.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>'Category',
                'icon'=>'fa fa-list-alt',
                'menulink'=>"category.category_index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>'Model',
                'icon'=>'fa fa-cubes',
                'menulink'=>"model.model_index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName'=>' Brand',
                'icon'=>'fa fa-bullhorn',
                'menulink'=>"brand.brand_index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Manual Products',
                'icon'=>'fa fa-product-hunt',
                'menulink'=>"m_products.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Vendor - Service',
                'icon'=>'fa fa-user',
                'menulink'=>"vendor.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Supplier',
                'icon'=>'fa fa-user-md',
                'menulink'=>"supplier.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Customer',
                'icon'=>'fa fa-users',
                'menulink'=>"customer.cus_index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Employee',
                'icon'=>'fa fa-user',
                'menulink'=>"employee.emp_index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Tax',
                'icon'=>'fa fa-percent',
                'menulink'=>"tax.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Holiday',
                'icon'=>'fa fa-smile-o',
                'menulink'=>"holiday.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => ' Expense',
                'icon'=>'fa fa-money',
                'menulink'=>"expense.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => ' Terms and condition',
                'icon'=>'fa fa-file-text-o',
                'menulink'=>"terms.index",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'GenerateQR',
                'icon'=>'fa fa-barcode',
                'menulink'=>"generate.qr",
                'active' => '1',
            ],
            [
                'menuID' => '1',
                'subName' => 'Verification',
                'icon'=>'fa fa-id-card',
                'menulink'=>"verification.verify_index",
                'active' => '1',
            ],
            [
                'menuID' => '2',
                'subName' => 'View Stocks',
                'icon'=>'',
                'menulink'=>"purchase.purchase_stock_view",
                'active' => '1',
            ],
            [
                'menuID' => '2',
                'subName' => 'View Purchase',
                'icon'=>'',
                'menulink'=>"purchase.purchase_view",
                'active' => '1',
            ],
            [
                'menuID' => '2',
                'subName' => 'Add Purchase',
                'icon'=>'',
                'menulink'=>"purchase.purchase_index",
                'active' => '1',
            ],
            [
                'menuID' => '3',
                'subName' => 'View Receipt list',
                'icon'=>'',
                'menulink'=>"sale.receipt",
                'active' => '1',
            ],
            [
                'menuID' => '3',
                'subName' => 'View Invoice list',
                'icon'=>'',
                'menulink'=>"sale.invoice",
                'active' => '1',
            ],
            [
                'menuID' => '3',
                'subName' => 'Add Sale',
                'icon'=>'',
                'menulink' => "sale.sale_store",
                'active' => '1',
            ],
            [
                'menuID' => '4',
                'subName' => 'Agreement & Bill ',
                'icon'=>'',
                'menulink'=>"rental.rental_agreement",
                'active' => '1',
            ],
            [
                'menuID' => '4',
                'subName' => 'Add Deposit',
                'icon'=>'',
                'menulink'=>"rental.deposit",
                'active' => '1',
            ],
            [
                'menuID' => '4',
                'subName' => 'View Renewal',
                'icon'=>'',
                'menulink'=>"rental.renewal",
                'active' => '1',
            ],
            [
                'menuID' => '4',
                'subName' => 'View Issue',
                'icon'=>'',
                'menulink'=>"rental.issue",
                'active' => '1',
            ],
            [
                'menuID' => '4',
                'subName' => 'View Rental',
                'icon'=>'',
                'menulink'=>"rental.rental_view",
                'active' => '1',
            ],
            [
                'menuID' => '4',
                'subName' => 'Add Rental',
                'icon'=>'',
                'menulink'=>"rental.rental_index",
                'active' => '1',
            ],
            [
                'menuID' => '5',
                'subName' => 'View Quotation',
                'icon'=>'',
                'menulink'=>"quotation.view",
                'active' => '1',
            ],
            [
                'menuID' => '5',
                'subName' => 'Add Quotation',
                'icon'=>'',
                'menulink'=>"quotation.add",
                'active' => '1',
            ],
            [
                'menuID' => '6',
                'subName' => 'Accept Job',
                'icon'=>'',
                'menulink'=>"joboreder.index",
                'active' => '1',
            ],
            [
                'menuID' => '6',
                'subName' => 'Services List',
                'icon'=>'',
                'menulink'=>"service.list",
                'active' => '1',
            ],
            [
                'menuID' => '6',
                'subName' => 'Add Services',
                'icon'=>'',
                'menulink'=>"add.service",
                'active' => '1',
            ],
            [
                'menuID' => '7',
                'subName' => 'Add Expense',
                'icon'=>'',
                'menulink'=>"exp_dtl",
                'active' => '1',
            ],
            [
                'menuID' => '8',
                'subName' => 'Add Employee Loan',
                'icon'=>'',
                'menulink'=>"employeeloan.index",
                'active' => '1',
            ],
            [
                'menuID' => '8',
                'subName' => 'View Attendance',
                'icon'=>'',
                'menulink'=>"attendance.view",
                'active' => '1',
            ],
            [
                'menuID' => '8',
                'subName' => 'Add Attendance',
                'icon'=>'',
                'menulink'=>"attendance.index",
                'active' => '1',
            ],
            [
                'menuID' => '9',
                'subName' => 'Create Lead',
                'icon'=>'',
                'menulink'=>"add.lead",
                'active' => '1',
            ],
            [
                'menuID' => '10',
                'subName' => 'View Scrap',
                'icon'=>'',
                'menulink'=>"scrap.view",
                'active' => '1',
            ],
            [
                'menuID' => '10',
                'subName' => 'Scrap List',
                'icon'=>'',
                'menulink'=>"scrap.index",
                'active' => '1',
            ]
            ];
            DB::table('menu_subs')->insert($row);
            
    }
}
