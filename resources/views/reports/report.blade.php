@extends('layouts.app')

@section('content')
<style>
    strong{
        color: #ed6029;
        font-size: 18px;
    }
    li{
        padding-top: 5px;
    }
    
</style>
<div class="app-content page-body">
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Reports</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </div>
        </div>
        <!--End Page header-->
        <!--Row-->
		<?php  if(Auth::user()->role_id != 6){ ?>
        <div class="row">
            
            <div class="col-xl-3 col-lg-6 col-md-12">
                <div class=" ">
                    <div class="card-body pb-0">
                        <div class="text-left mb-4">
                            <p class=" mb-1 "> 
                                <ul>
                                <li><a class="" href="{{route('report.gst')}}">Gst Report</a></li>
                                <li><a class="" href="{{route('report.non.gst')}}">Non-Gst Report</a></li>
                                {{-- <li><a  class="" href="#">Collection Report</a></li> --}}
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
                            <strong>Services</strong>
                            <ul >
                                <li class=""><a class="" href="{{route('report.completed')}}">Completed Report</a></li>
                                <li class=""><a class="" href="{{route('report.pending')}}">Pending Report</a></li>
                            </ul>
                            <strong>Rental</strong>
                            <ul >
                                <li class=""><a class="" href="{{route('report.rental_alllist')}}">All Rental Invoice Report</a></li>
                                <li class=""><a class="" href="{{route('report.rental_agreement')}}">Agreement Report</a></li>
                                {{-- <li class=""><a class="" href="{{route('report.rental_list')}}">Rental Report</a></li> --}}
                            </ul>
                            {{-- <strong>Stock</strong>
                            <ul>
                                <li class=""><a class="" href="#">Inward Stock Report</a></li>
                                <li class=""><a class="" href="#">Outward Stock Report</a></li>
                            </ul> --}}
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
                            <strong>Sales</strong>
                            <ul>
                                <li class=""><a class="" href="{{route('report.purchase')}}">Purchase Report</a></li>
                                <li class=""><a class="" href="{{route('report.customer')}}">Customer Report</a></li>
                                {{-- <li class=""><a class="" href="#">Vendor Report</a></li>
                                <li class=""><a class="" href="#">Vendor Payment Report</a></li> --}}
                                <li class=""><a class="" href="{{route('report.suplier')}}">Supplier Report</a></li>
                            </ul>   </p>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-12">
                <div class=" ">
                    <div class="card-body pb-0">
                        <div class="text-left mb-4">
                        <p class=" mb-1 ">
                        <strong >Others</strong>
                            <ul>
                                <li class=""><a class="" href="{{route('report.quotation')}}">Quotation Report</a></li>
                                {{-- <li class=""><a class="" href="#">Call Management Report</a></li> --}}
                                <li class=""><a class="" href="{{route('report.expense')}}">Expense Report</a></li>
                                <li class=""><a class="" href="{{route('report.balance')}}">Balance Report</a></li>
                                <li class=""><a class="" href="{{route('report.overallsale')}}">Overall Sales Report</a></li>
                                <li class=""><a class="" href="{{route('employee.salary')}}">Employees Salary Report</a></li>
                            
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

<?php  }else{ ?>
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
@endsection
