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

            <!-- Admin Delivery -->
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown active"><i class="fa fa-tag"></i>  Products <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                @permission('kg-two-ten-Utilization')
                <li aria-haspopup="true"><a href="{{ route('reports.lpg_product') }}"><i class="fa fa-bar-chart"></i>  210 KG Product Utilization</a></li>
                @endpermission
                @permission('utilization-report')
                <li aria-haspopup="true"><a href="{{ route('reports.product_utilization') }}"> <i class="fa fa-bar-chart"></i>  Product Utilization</a></li>
                @endpermission
                @permission('sales-report')
                <li aria-haspopup="true"><a href="{{ route('reports.product_sales') }}"><i class="fa fa-line-chart"></i>  Product Sales</a></li>
                @endpermission
                @permission('sales-by-suburb-report')
                <li aria-haspopup="true"><a href="{{ route('reports.suburb_sales') }}"><i class="fa fa fa-map-marker"></i>  Sales By Suburb</a></li>
                @endpermission
                @permission('upcoming-rental-report')
                <li aria-haspopup="true"><a href="{{ route('reports.upcoming_rentals') }}"><i class="fa fa fa-binoculars"></i>  Upcoming Rentals</a></li>
                @endpermission
                @permission('product-price-change-report')
                <li class="divider"></li>
                <li aria-haspopup="true"><a href="{{ route('reports.generate_price') }}"><i class="fa fa-dollar"></i>  Product Price Change</a></li>
                @endpermission
                @permission('rental-price-change-report')
                <li aria-haspopup="true"><a href="{{ route('reports.generate_rental_price') }}"><i class="fa fa-dollar"></i>  Rental Price Change</a></li>
                <li class="divider"></li>
                @endpermission
                @permission('cylinder-stocktake-report')
                <li aria-haspopup="true"><a href="{{ route('reports.cylinder_stocktake') }}"><i class="fa fa-refresh"></i>  Cylinder Stocktake </a></li>
                @endpermission
            </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i>  Customers <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    @permission('customer-product-sales-report')
                    <li><a href="{{ route('reports.customer_product') }}"><i class="fa fa-bar-chart"></i>  Customer Product Sales</a></li>
                    @endpermission
                    @permission('prospective-report')
                    <li><a href="{{ route('reports.pros_customer') }}"><i class="fa fa-asterisk"></i>  Prospective Customers</a></li>
                    @endpermission
                    @permission('supply-agreement-report')
                    <li><a href="{{ route('reports.supply_agreement') }}"><i class="fa fa-file-text-o"></i>  Supply Agreements</a></li>
                    <li class="divider"></li>
                    @endpermission
                    @permission('lost-customer-report')
                    <li><a href="{{ route('reports.lost_customer') }}"><i class="fa fa-frown-o"></i>  Lost Customers</a></li>
                    @endpermission
                    @permission('x-month-report')
                    <li><a href="{{ route('reports.no_orders') }}"><i class="fa fa-calendar"></i>  No Order X Months</a></li>
                    @endpermission
                    @permission('overdue-report')
                    <li><a href="{{ route('reports.over_due') }}"><i class="fa fa-exclamation-triangle"></i>  Overdue</a></li>
                    @endpermission
                    @permission('bankrupt-report')
                    <li><a href="{{ route('reports.bankrupt') }}"><i class="fa fa-university"></i>  Bankrupt</a></li>
                    <li class="divider"></li>
                    @endpermission
                    @permission('customer-marketing-report')
                    <li><a href="{{ route('reports.customer_marketing') }}"><i class="fa fa-line-chart"></i> Customer Marketing</a></li>
                    @endpermission
                </ul>
             </li>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck"></i> Delivery <span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                    @permission('delivery-report')
                    <li><a href="{{ route('reports.delivery-reports') }}"><i class="fa fa-area-chart"></i> Deliveries</a></li>
                    @endpermission
                    @permission('daily-stop-supply-report')
                    <li><a href="{{ route('reports.daily-stop') }}"><i class="fa fa-times-circle"></i>  Daily Stop Supply</a></li>
                     {{--   <li><a href="#" class="fa fa-question-circle"></i>  Missing Dockets</a></li>  --}}
                     @endpermission
                    @permission('reschedule-report')
                     <li><a href="{{ route('reports.reschedule-reports') }}" ><i class="fa fa-refresh"></i>  Rescheduled Orders</a></li>
                     @endpermission
                    @permission('delivery-summary-report')
                     <li><a href="{{ route('reports.delivery-summary') }}"><i class="fa fa-bar-chart"></i>  Delivery Summary</a></li>
                     @endpermission
               </ul>
            </li>

            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fire"></i>  Office <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    @permission('office-report')
                  <li><a href="{{ route('reports.total-office') }}"><i class="fa fa-pie-chart"></i>  Office Day Total</a></li>
                  @endpermission
                    @permission('office-summary-report')
                  <li><a href="{{ route('reports.office-summary') }}"><i class="fa fa-bar-chart"></i>  Office Summary</a></li>
                  @endpermission
                    @permission('sales-rep-report')
                  <li><a href="{{ route('reports.sales-rep') }}"><i class="fa fa-male"></i>  Sales Rep</a></li>
                  @endpermission
                    @permission('thirty-day-report')
                  <li><a href="{{ route('reports.day-report') }}"><i class="fa fa-calendar"></i> 30 Day</a></li>
                  @endpermission
                </ul>
            </li>
            {{--     <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-eye"></i> Air Liquide<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                   <li><a href="{{ route('reports.air_liquide') }}"><i class="fa fa-bar-chart"></i> Air Liquide Summary</a></li>
                </ul>
             </li> --}}
             {{-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-rocket"></i> Agents <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                   <li><a href="#"><i class="fa fa-bar-chart"></i> Agent Report</a></li>
                </ul>
             </li> --}}

         </ul>
      </div>
   </div>
