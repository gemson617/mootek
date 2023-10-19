@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div class="app-content page-body">
    <div class="container">

    @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
        <!--End Page header-->
        <!--Row-->

        <?php if (Auth::user()->role_id != 6) { ?>
    
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card ">
                        <div class="card-body pb-0">
                            <div class="text-left mb-4">
                                <p class=" mb-1 ">
                                    <i class="fa fa-user mr-1"></i>
                                    Total Customers
                                </p>
                                <h2 class="mb-0">1
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
                                    <i class="fa fa-user mr-1"></i>
                                    Total Leads
                                </p>
                                <h2 class="mb-0">1
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
                                    <i class="fa fa-cart-arrow-down mr-1"></i>
                                    Total Purchase
                                </p>
                                <h2 class="mb-0">1
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
                                <p class=" mb-1 ">
                                    <i class="fa fa-line-chart mr-1"></i>
                                    Today Sales
                                </p>
                                <h2 class="mb-0">$1

                                </h2>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- 
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">New Customers <span class="last-15-day">in Last 15 days </span>
                                1</h3>
                            <div class="card-options ">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                                        class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                        class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-0 ">
                            <div class="list-group list-lg-group list-group-flush">

                                <div class="list-group-item list-group-item-action">
                                    <div class="media mt-0">
                                        <div class="media-body">
                                            <div class="d-md-flex align-items-center">
                                                <div class="mt-1">
                                                    <h5 class="mb-0 text-dark">1</h5>
                                                    <p class="mb-0  fs-13 text-muted">User ID: </p>
                                                </div>
                                                <small class="ml-md-auto fs-16 mt-2">
                                                    <a href="mailto:1">
                                                        <i class="si si-envelope mr-1" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Email"></i>
                                                    </a>
                                                    <a href="/view/customer/details/1/1/1"><i
                                                            class="fa fa-eye fa-sm"></i></a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">New Prospects <span class="last-15-day">in Last 15 days </span>
                                1</h3>
                            <div class="card-options ">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                                        class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                        class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-0 ">
                            <div class="list-group list-lg-group list-group-flush">

                                <div class="list-group-item list-group-item-action">
                                    <div class="media mt-0">
                                        <div class="media-body">
                                            <div class="d-md-flex align-items-center">
                                                <div class="mt-1">
                                                    <h5 class="mb-0 text-dark">1</h5>
                                                    <p class="mb-0  fs-13 text-muted">User ID: 1</p>
                                                </div>
                                                <small class="ml-md-auto fs-16 mt-2">
                                                    <a href="mailto:1">
                                                        <i class="si si-envelope mr-1" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Email"></i>
                                                    </a>
                                                    <a href="/view/customer/details/1/1/1"><i
                                                            class="fa fa-eye fa-sm"></i></a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Today Orders
                                1</h3>
                            <div class="card-options ">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                                        class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                        class="fe fe-x"></i></a>
                            </div>
                        </div>

                    </div>
                </div> -->

            <!---------------------------------------------------notes start--------------------------------------------------------->
            <!----------------------------------------------------notes end---------------------------------------------------------------------->
            <!---------------------------------------------------notes start--------------------------------------------------------->
            <!----------------------------------------------------notes end---------------------------------------------------------------------->
            <!-- </div> -->

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
       <div class="row">

             <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sold Out</h3>
                        <div class="card-options ">
                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-12 mb-5">
                                <p class=" mb-0 "> This Year Sales</p>
                                <h2 class="mb-0">35,789<span class="fs-12 text-muted"><span class="text-danger mr-1"><i class="fe fe-arrow-down ml-1"></i>0.9%</span>last year</span></h2>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 mb-5">
                                <p class=" mb-0 "> This Year Profits</p>
                                <h2 class="mb-0">$9,265<span class="fs-12 text-muted"><span class="text-success mr-1"><i class="fe fe-arrow-up ml-1"></i>0.15%</span>last year</span></h2>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 mb-5">
                                <p class=" mb-0 "> This Year Sales Revenue</p>
                                <h2 class="mb-0">$4,678<span class="fs-12 text-muted"><span class="text-danger mr-1"><i class="fe fe-arrow-down ml-1"></i>1.04%</span>last year</span></h2>
                            </div>
                        </div> --}}
                        <p class="text-center">Total Stock In  <span>0</span></p>
                        <div id="chart5" class="mb-0" style="min-height: 255px;">
                        </div>
                        {{-- <div id="chart1" class="mb-0" style="min-height: 255px;">
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category Stock In</h3>
                        <div class="card-options ">
                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart2" style="width:100%;max-width:600px"></canvas>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lead And Quotation</h3>
                        <div class="card-options ">
                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body d-flex">

                        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                        <canvas id="myChart9" style="width:100%;max-width:600px"></canvas>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end app-content-->


@endsection