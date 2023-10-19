<style>
.nav > .dropdown:hover>.dropdown-menu {
  display: block;
  margin:0;
  position: absolute;
}
</style>
<div class="card bg-azure-lightest">
      <div class="card-body p-4">
         <ul class="nav navbar-nav admin-menus flex-row justify-content-start flex-column flex-sm-row justify-content-md-around">
            <!-- Admin Users -->
            <!-- <li class="dropdow">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> Users <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ route('user.list') }}"><i class="fa fa-users"></i> Manage Users</a></li>
                  <li><a href="#"><i class="fa fa-rocket"></i> Agents</a></li>
               </ul>
            </li> -->
            <!-- Admin Products -->
            <?php /*
            <li class="dropdown open">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tag"></i> Products <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ route('admin.list-category') }}"><i class="fa fa-list-ul"></i> Product Categories</a></li>
                  <li><a href="{{ route('admin.list-product-category') }}"><i class="fa fa-list-ul"></i> Product </a></li>
               </ul>
            </li>
            */?>
            <!-- Admin Delivery -->
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown active"><i class="fa fa-fire"></i> Office <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ route('admin.list-office') }}"><i class="fa fa-building"></i> Offices</a></li>
                  <li><a href="{{ route('admin.email-templates') }}"><i class="fa fa-building"></i> Email Templates</a></li>
               </ul>
            </li>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck"></i> Delivery <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ route('admin.list-delivery-regions') }}"><i class="fa fa-map-marker"></i> Delivery Regions</a></li>
                  <li><a href="{{ route('admin.list-truck-dispatch') }}"><i class="fa fa-truck"></i> Trucks &amp; Dispatch</a></li>
                  <li><a href="{{ route('admin.list-class-types') }}"><i class="fa fa-exclamation-triangle"></i> Class Types</a></li>
                  <li><a href="{{ route('admin.list-safety-items') }}"><i class="fa fa-check-square-o"></i> Safety Checklist Items</a></li>
                  <li><a href="{{ route('admin.list-no-delivery-reasons') }}"><i class="fa fa-times-circle"></i> No Delivery Reasons</a></li>
                  <!--li><a href="{{ route('admin.list-missing-docket-reasons')}}"><i class="fa fa-book"></i> Missing Docket Reasons</a></li-->
               </ul>
            </li>
            <!-- Admin Office -->
            <!-- Admin Misc -->
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tachometer"></i> Misc <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                    <!-- <li><a href="{{ route('admin.list-supplier') }}"><i class="fa fa-industry"></i> Supplier</a></li> -->
                  <li><a href="{{ route('admin.list-suburb') }}"><i class="fa fa-map-marker"></i> Suburbs</a></li>
                  <li><a href="#"><i class="fa fa-cc-visa"></i> Credit Cards</a></li>
               </ul>
            </li>
            <!-- Admin Tools -->
            <!-- <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> Tools <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="#"><i class="fa fa-cog"></i> Merge Customer</a></li>
               </ul>
            </li> -->
            <!-- Lost Customers -->
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-frown-o"></i> Lost Customers <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ route('admin.list-competitors') }}"><i class="fa fa-thumbs-o-down"></i> Competitors</a></li>
                  <li><a href="{{ route('admin.list-lostcustomer') }}"><i class="fa fa-frown-o"></i> Reasons</a></li>
               </ul>
            </li>
            <!-- Customer Marketing -->
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bullhorn"></i> Marketing <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="{{ route('admin.list-marketing-customer') }}"><i class="fa fa-line-chart"></i> Customer Marketing </a></li>
                  <li><a href="{{ route('admin.list-email') }}" target="_blank"><i class="fa fa-at"></i> Customer Email List </a></li>
               </ul>
            </li>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-calendar" aria-hidden="true"></i> Holiday Calender <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                @permission('create-holiday-calendar')
                  <li><a href="{{ route('admin.holiday') }}"><i class="fa fa-calender"></i> Create Holiday Calender</a></li>
                  @endpermission
                  <!-- <li><a href="#" target="_blank"><i class="fa fa-at"></i> Customer Email List </a></li> -->
               </ul>
            </li>
         </ul>
      </div>
   </div>
