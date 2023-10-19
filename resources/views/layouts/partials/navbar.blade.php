<style>
    .dropdown:hover>.dropdown-menu {
        display: block;
        margin: 0;
        position: absolute;
        left: none;
    }
</style>

<?php

use Illuminate\Support\Facades\Auth;

$permission = App\Models\menu_permission::where('user_id', Auth::user()->id)->get();

?>
<div class="header bg-white top-header">
    <div class="container">
        <div class="d-flex">
            <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a><!-- sidebar-toggle-->
            <a class="header-brand" href="{{ route('home') }}">
                <img src="{{ asset('mootek/images/home.jpg') }}" class="header-brand-img desktop-lgo" alt="Clont logo">
            </a>
            <div class="dropdown  header-option">

                <a class="nav-link icon" href="{{route('master.master_menus')}}">
                    <span class="nav-span">Master<i class="fa fa-angle-down ml-1 fs-18"></i></span>
                </a>
            </div>
            <div class="dropdown  header-setting">
                <a class="nav-link icon" href="{{route('report.report_menus')}}">
                    <span class="nav-span">Reports<i class="fa fa-angle-down ml-1 fs-18"></i></span>
                </a>
            </div>
            <div class="dropdown">
                <a class="nav-link icon"><?php $status = App\Models\user::leftjoin('companies','companies.id','=','users.companyID')->where('users.companyID', Auth::user()->companyID)->first();  ?>
                    <span class="nav-span <?php $role = App\Models\user::where('id',Auth::user()->id)->first();  echo $role->role =='3'? 'status' :' ';?>">
                                         <?php   echo $status->company ; ?></span>
                </a>
            </div>
           
            <div class="d-flex order-lg-2 ml-auto">
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch"><i class="fa fa-search"></i></a>
                <div class="dropdown   header-fullscreen">
                    <a class="nav-link icon full-screen-link" id="fullscreen-button">
                        <i class="fe fe-minimize"></i>
                    </a>
                </div>
                <div class="dropdown ">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span>
                            <img src="{{ asset('mootek/images/home.jpg') }}" alt="img" class="avatar avatar-md brround">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <div class="text-center">
                            <a href="#" class="dropdown-item text-center user pb-0"><?= Auth::user()->user_name ?></a>
                            <div class="dropdown-divider"></div>
                        </div>
                        <a class="dropdown-item" href="{{route('user.profile')}}">
                            <i class="dropdown-icon mdi mdi-account-outline "></i> Profile
                        </a>
                        <?php if (Auth::user()->role == '3') { ?>
                            <a class="dropdown-item" href="{{route('user.user')}}">
                                <i class="dropdown-icon mdi mdi-account-outline "></i> User Management
                            </a>
                            <a class="dropdown-item" href="{{route('role.role')}}">
                                <i class="dropdown-icon mdi mdi-account-outline "></i>Role And permission
                            </a>
                        <?php } ?>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="horizontal-main logo hor-menu clearfix">
    <div class="horizontal-mainwrapper container clearfix">
        <nav class="horizontalMenu clearfix">
            <div class="overlapblackbg"></div>
            <ul class="horizontalMenu-list">

                <?php $permission = App\Models\menu_permission::select('menu')->where('user_id', Auth::user()->id)->groupBy('menu')->get();
                if ($permission->count() > 0) { //1,2-permission

                    foreach ($permission as $val) {
                        $menu = App\Models\menu::where('id', $val->menu)->first();
                       
                        $sub_menu = App\Models\menu_sub::where('menuID', $menu->id)->get();
                        // dd($sub_menu);
                        if ($menu->id != 1) {
                ?>
                            <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon">{{$menu->menu}} <i class="fa fa-angle-down horizontal-icon"></i></a>
                                <ul class="sub-menu">
                                    <?php
                                    $permission = App\Models\menu_permission::where('user_id', Auth::user()->id)->get();
                                    foreach ($sub_menu as $sub) {
                                        foreach ($permission as $per) {
                                            if ($per->menu_sub == $sub->id) { 
                                                $link = route($sub->menulink);
                                                ?>
                                                <li aria-haspopup="true"><a href="{{$link}}">{{$sub->subName}}
                                                    </a></li>
                                    <?php  }
                                        }
                                    } ?>
                                </ul>
                            </li>

                    <?php }
                    }
                } else if (Auth::user()->role == '3') { ?>
                    <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon">Purchase  <i class="fa fa-angle-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            {{-- <li aria-haspopup="true"><a href="#">View Stocks
                                </a></li> --}}
                                <li aria-haspopup="true"><a href="{{route('importpurchase.view')}}">import Bill
                                </a></li>
                       
                            <li aria-haspopup="true"><a href="{{route('localpurchase.view')}}">local Bill
                                    </a></li>
                        
                        </ul>
                    </li>
                    <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon">Stocks  <i class="fa fa-angle-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            {{-- <li aria-haspopup="true"><a href="#">View Stocks
                                </a></li> --}}
                                <li aria-haspopup="true"><a href="{{route('importpurchase.stocks')}}">import Stocks
                                </a></li>
                            <li aria-haspopup="true"><a href="{{route('localpurchase.stocks')}}">local Stocks
                                     </a></li>
                        </ul>
                    </li>
                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon">Sales <i class="fa fa-angle-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="{{route('sale.receipt')}}">View Receipt list</a></li>
                            <li aria-haspopup="true"><a href="{{route('sale.invoice')}}">View Invoice list</a></li>
                            <li aria-haspopup="true"><a href="{{route('sale.index')}}">Add Sale </a></li>
                        </ul>
                    </li> --}}
                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon"> Rental <i class="fa fa-angle-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="{{route('rental.rental_agreement')}}">Agreement & Bill </a>
                            </li>
                            <li aria-haspopup="true"><a href="{{route('rental.deposit')}}">View Deposit</a></li>
                            <li aria-haspopup="true"><a href="{{route('rental.renewal')}}">View Renewal</a></li>
                            <li aria-haspopup="true"><a href="{{route('rental.issue')}}">View issue</a></li>
                            <li aria-haspopup="true"><a href="{{route('rental.rental_view')}}">View Rental</a></li>
                            <li aria-haspopup="true"><a href="{{route('rental.rental_index')}}">Add Rental</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon">Quotation </a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="{{route('quotation.view')}}">View Quotation</a>
                            </li>
                            <li aria-haspopup="true"><a href="{{route('quotation.add')}}">Add Quotation</a></li>
                        </ul>
                    </li> --}}


                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon"> Service </a>
                        <ul class="sub-menu"> --}}
                            {{-- <li aria-haspopup="true"><a href="">Accept Job</a></li>
                            <li aria-haspopup="true"><a href="">Services List</a></li> --}}
                            {{-- <li aria-haspopup="true"><a href="{{route('add.service')}}">Add Services</a></li>
                        </ul>
                    </li> --}}

                    
                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon"> Expense </a>
                        <ul class="sub-menu"> --}}
                            <!-- <li aria-haspopup="true"><a href="#">Manage Expense</a></li> -->
                            {{-- <li aria-haspopup="true"><a href="{{route('exp_dtl.index')}}">Add Expense</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon"> Attendance </a>
                        <ul class="sub-menu">
                            <!-- <li aria-haspopup="true"><a href="#">Attendance Report </a></li> -->
                            
                            <li aria-haspopup="true"><a href="{{route('employeeloan.index')}}">Add Employee Loan </a>
                            <li aria-haspopup="true"><a href="{{route('attendance.view')}}">View Attendance </a>
                            <li aria-haspopup="true"><a href="{{route('attendance.index')}}">Add Attendance </a>
                            </li>
                        </ul>
                    </li> --}}


                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon">Lead Management </a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="/add-lead">Create Lead</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-angle-down"></i></span><a href="#" class="sub-icon"> Scrap Management </a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="{{route('scrap.view')}}">View Scrap</a></li>
                            <li aria-haspopup="true"><a href="{{route('scrap.index')}}">Create Scrap</a></li>

                        </ul>
                    </li> --}}

                <?php } ?>
            </ul>
        </nav>
        <!--Nav end -->
    </div>
</div>



<div class="d-flex order-lg-2 ml-auto">

    <div class="dropdown">
        <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
            <span>
                <img src="#" alt="{{Auth::user()->name}}" class="avatar avatar-md brround">
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
            <div class="text-center">
                <a href="#" class="dropdown-item text-center user pb-0"></a>
                <span class="text-center user-semi-title text-dark"></span>
                <div class="dropdown-divider"></div>
            </div>
            <a class="dropdown-item" href="">
                <i class="dropdown-icon mdi mdi-account-outline "></i> Profile
            </a>

            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="dropdown-icon mdi  mdi-logout-variant"></i> {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>