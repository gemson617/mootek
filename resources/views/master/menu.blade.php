@extends('layouts.app')

@section('content')
<style>
    strong {
        color: #ed6029;
        font-size: 18px;
    }

    li {
        padding-top: 5px;
    }

    a {
        text-decoration: none;
    }
</style>
<div class="app-content page-body">
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Master</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Master</li>
                </ol>
            </div>
        </div>
        <!--End Page header-->
        <!--Row-->
        <div class="row"> <?php
    if (Auth::user()->role == 3) { ?>
        <div class="row">

            <div class="col-xl-3 col-lg-6 col-md-12">
                <div class=" ">
                    <div class="card-body pb-0">
                        <div class="text-left mb-4">
                            <p class=" mb-1 ">
                                <strong>Master</strong>
                            <ul>
                                <li class=""><a class="" href="/company_master"><i class="fa fa-building mr-2"></i>Company</a></li>
                                {{-- <li class=""><a class="" href="/branch"><i class="fa fa-building-o mr-2" aria-hidden="true"></i> branch</a></li> --}}
                            <li class=""><a class="" href="/designation"><i class="fa fa-id-card mr-2" aria-hidden="true"></i> Designation Master</a></li>
                                <li class=""><a class="" href="/enquiry"><i class="fa fa-question-circle mr-2" aria-hidden="true"></i>Enquiry Master</a></li>
                                <li class=""><a class="" href="/source"><i class="fa fa-newspaper-o mr-2" aria-hidden="true"></i>Source Master</a></li>
                                <li class=""><a class="" href="/complaint"><i class="fa fa-comments mr-2" aria-hidden="true"></i>Complaint status</a></li>
                                {{-- <li class=""><a class="" href="/email_template"><i class="fa fa-envelope mr-1"></i> Email Template</a></li> --}}
                                <li class=""><a class="" href="/paymentmode"><i class="fa fa-credit-card mr-2"></i>Payment Mode</a></li>
                                <li class=""><a class="" href="/paymentstatus"><i class="fa fa-credit-card mr-2"></i>Payment Status</a></li>
                                <li class=""><a class="" href="/purchase_mode"><i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i>Purchase Mode</a></li>
                                <li class=""><a class="" href="/role_master"><i class="fa fa-tasks mr-2" aria-hidden="true"></i></i>Role Master</a></li>
                                {{-- <li class=""><a class="" href="/bank_master"><i class="fa fa-bank mr-2"></i>Bank Master</a></li> --}}
                                <li class=""><a class="" href="/network"><i class="fa fa-credit-card mr-2"></i>Network master</a></li>
                                <li class=""><a class="" href="/state"><i class="fa fa-home mr-2" aria-hidden="true"></i></i>State master</a></li>
                                <li class=""><a class="" href="/city"><i class="fa fa-home mr-2" aria-hidden="true"></i>City master</a></li>
                                <li class=""><a class="" href="/salution"><i class="fa fa-user-circle-o mr-2" aria-hidden="true"></i>Salution master</a></li>
                               
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12">
                <div class=" ">
                    <div class="card-body pb-0">
                        <div class="text-left mb-4">

                            <strong>Products</strong>
                            <ul>
                                <li class=""><a class="" href="/category"><i class="fa fa-laptop mr-2" aria-hidden="true"></i> Accessories</a></li>
                                <li class=""><a class="" href="/model"><i class="fa fa-product-hunt mr-2" aria-hidden="true"></i>Accessories Products</a></li>
                                <li class=""><a class="" href="/cus_categories"><i class="fa fa-desktop  mr-2" aria-hidden="true"></i>Customer Category</a></li>
                                <li class=""><a class="" href="/customer_sub_category"><i class="fa fa-bullhorn mr-2" aria-hidden="true"></i> Sub Category Master</a></li>
                                <li class=""><a class="" href="/products_master"><i class="fa fa-cubes mr-2" aria-hidden="true"></i>Products Master</a></li>
                                <li class=""><a class="" href="/enquiry_categories"><i class="fa fa-desktop mr-2" aria-hidden="true"></i>Enquiry Category Master</a></li>
                                <li class=""><a class="" href="/enquiry_sub_categories"><i class="fa fa-bullhorn mr-2" aria-hidden="true"></i>Enquiry Sub Category</a></li>
                                <li class=""><a class="" href="/product_group"><i class="fa fa-cubes mr-2" aria-hidden="true"></i>Product Group</a></li>
                                {{-- <li class=""><a class="" href="/m_products"><i class="fab fa-product-hunt" aria-hidden="true"></i> Manual Products</a></li> --}}
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-12">
                <div class="">
                    <div class="card-body pb-0">
                        <div class="text-left mb-4">
                            <p class=" mb-1 ">
                                <strong>Users</strong>
                            <ul>
                                <!-- <li class=""><a class="" href="/master/vendor"><i class="fa fa-user mr-1" aria-hidden="true"></i>Vendor - Service</a></li> -->
                                {{-- <li class=""><a class="" href="/supplier"><i class="fa fa-user-md mr-1" aria-hidden="true"></i>Supplier</a></li> --}}
                                <li class=""><a class="" href="/customer"><i class="fa fa-users mr-1" aria-hidden="true"></i>Customer</a></li>
                                <li class=""><a class="" href="/employee"><i class="fa fa-user mr-1" aria-hidden="true"></i>Employee</a></li>
                                <li class=""><a class="" href="/local_purchase"><i class="fa fa-user mr-1" aria-hidden="true"></i>Local Purchase</a></li>
                                <li class=""><a class="" href="/import_purchase"><i class="fa fa-user mr-1" aria-hidden="true"></i>Import Purchase</a></li>

                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-12">
                <div class=" ">
                    <div class="card-body pb-0">
                        <div class="text-left mb-4">
                            <p class=" mb-1 ">
                                <strong>Others</strong>
                            <ul>
                                <li class=""><a href="/expense" class=""><i class="fa fa-money mr-2" aria-hidden="true"></i> Expense Category</a></li>
                                <li class=""><a href="/tax" class=""><i class="fa fa-percent mr-2" aria-hidden="true"></i>Tax</a></li>
                                <li class=""><a href="/terms" class=""><i class="fa fa-file-text-o mr-2" aria-hidden="true"></i> Terms and condition</a></li>
                                <li class=""><a class="" href="/courier"><i class="fa fa-truck mr-2" aria-hidden="true"></i>Courier Management</a></li>
                                <li class=""><a class="" href="/hsn"><i class="fa fa-code mr-2" aria-hidden="true"></i>HSN code</a></li>

                                <li class=""><a class="" href="/gps_platform"><i class="fa fa-location-arrow mr-2" aria-hidden="true"></i>GPS Platform</a></li>
                                <li class=""><a class="" href="/transaction_mode"><i class="fa fa-paypal mr-2"></i>Transaction Mode</a></li>
                                <li class=""><a class="" href="/rack_location"><i class="fa fa-map-marker mr-2" aria-hidden="true"></i>Rack Location</a></li>
                                <li class=""><a class="" href="/financial"><i class="fa fa-money mr-2" aria-hidden="true"></i>Financial Year</a></li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--Row-->



    <!-- <div class="row">
            <div class="col-12">
                <div class="card card-bgimg">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="text-white ">
                                <h2 class="mb-1">24 days</h2>
                                <p class=" mb-0 op1">Avg Sales Cycle length</p>
                            </div>
                            <div class="text-white ml-auto">
                                <i class="fe fe-clock fs-50 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div> -->
    <!-- <div class="row">


            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <p class=" mb-0 ">Total earnings of this year</p>
                        <h2 class="mb-0">$5,69,265<span class="fs-12 text-muted"><span class="text-success mr-1"><i
                                        class="fe fe-arrow-up ml-1"></i>0.15%</span>last year</span></h2>
                        <div class="row mt-3">
                            <div class="col-4 border-right">
                                <p class="mb-0 text-muted">This month</p>
                                <h5 class="mb-0">34%</h5>
                            </div>
                            <div class="col-4 border-right ">
                                <p class="mb-0 text-muted">Last month</p>
                                <h5 class="mb-0">67%</h5>
                            </div>
                            <div class="col-4">
                                <p class="mb-0 text-muted">Total</p>
                                <h5 class="mb-0">$63,456</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <p class=" mb-0 ">Total Revenue of the Year</p>
                        <h2 class="mb-0">$68,245<span class="fs-12 text-muted"><span class="text-success mr-1"><i
                                        class="fe fe-arrow-up ml-1"></i>0.28%</span>last year</span></h2>
                        <div class="row mt-3 ">
                            <div class="col-4 border-right">
                                <p class="mb-0 text-muted">This month</p>
                                <h5 class="mb-0">12.6%</h5>
                            </div>
                            <div class="col-4 border-right ">
                                <p class="mb-0 text-muted">Last month</p>
                                <h5 class="mb-0">56%</h5>
                            </div>
                            <div class="col-4">
                                <p class="mb-0 text-muted">Total</p>
                                <h5 class="mb-0">90%</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> -->

<?php  } else { ?>
    <!--Row-->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-body pb-0">
                    <div class="text-left mb-4">
                        <p class=" mb-1 ">
                            <!-- <i class="fa fa-user mr-1"></i> -->
                            Total Run
                        </p>
                        <h2 class="mb-0">
                            <!--span class="fs-12 text-muted">
								<span class="text-success mr-1"><i class="fe fe-arrow-up ml-1 "></i> 0.12%</span> since last week
								</span-->
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-body pb-0">
                    <div class="text-left mb-4">
                        <p class=" mb-1 ">
                            <!-- <i class="fa fa-user mr-1"></i> -->
                            Today Ordered Delivered
                        </p>
                        <h2 class="mb-0">
                            <!--span class="fs-12 text-muted">
								<span class="text-success mr-1"><i class="fe fe-arrow-up ml-1 "></i> 0.12%</span> since last week
								</span-->
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-body pb-0">
                    <div class="text-left mb-4">
                        <p class=" mb-1 ">
                            <!-- <i class="fa fa-cart-arrow-down mr-1"></i> -->
                            Payment Collected
                        </p>
                        <h2 class="mb-0">$150
                            <!--span class="fs-12 text-muted">
								<span class="text-success mr-1"><i class="fe fe-arrow-up ml-1 "></i> 0.12%</span> since last week
								</span-->
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="text-left mb-4">
                        <p class=" mb-1">
                            <!-- <i class="fa fa-signal mr-1"></i> -->
                            Rescheduled
                        </p>
                        <h2 class="mb-0">0
                            <!--span class="fs-12 text-muted">
									<span class="text-success mr-1"><i class="fe fe-arrow-up ml-1"></i>0.82%</span> since last week
								</span-->
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End row-->
<?php } ?>



</div>
</div><!-- end app-content-->
<script>
        $(document).ready(function() {
                setTimeout(function() {
                    $(".alert-danger").slideUp(500);
                    $(".alert-success").slideUp(500);
                }, 2000);
            });
</script>
@endsection