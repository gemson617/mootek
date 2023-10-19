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

                <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown active"><i class="fa fa-file-text-o"></i> Invoices <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li aria-haspopup="true"><a href="{{ route('customer.email-print-invoice') }}"><i class="fa fa-bar-chart"></i> Email/Print Invoices</a></li>
                </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-university"></i> Accounts <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        @permission('bank-statement')
                        <li aria-haspopup="true"><a href="{{ route('accounts.statement_bank') }}"><i class="fa fa-university"></i> Bank Statement Report</a></li>
                        @endpermission
                        @permission('bank-deposits')
                        <li aria-haspopup="true"><a href="{{ route('accounts.deposit_bank') }}"><i class="fa fa-money"></i> Bank Deposits</a></li>
                        @endpermission
                        @permission('make-deposit')
                        <li aria-haspopup="true"><a href="{{ route('accounts.deposit_make') }}"><i class="fa fa-arrow-circle-right"></i> Make A Deposit</a></li>
                        @endpermission
                    </ul>
                 </li>
                <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart"></i> Reports <span class="caret"></span></a>
                   <ul class="dropdown-menu" role="menu">
                        @permission('accounts-receivable-report')
                    <li aria-haspopup="true"><a href="{{ route('accounts.reports.account_recievable') }}"><i class="fa fa fa-times-circle"></i> Account Recievable</a></li>
                    @endpermission
                        @permission('cash-in-safe')
                    <li aria-haspopup="true"><a href="{{ route('accounts.reports.cash_in_safe') }}"><i class="fa fa-money"></i> Cash In Safe</a></li>
                    @endpermission
                        @permission('followup-notes')
                    <li aria-haspopup="true"><a href="{{ route('accounts.reports.followup_notes') }}"><i class="fa fa-pencil-square-o"></i> Follow Up Notes</a></li>
                    @endpermission
                        @permission('cash-verification-report')
                    <li aria-haspopup="true"><a href="{{ route('accounts.reports.cash_verification') }}"><i class="fa fa-exclamation-triangle"></i> Cash Verification Change</a></li>
                    @endpermission
                </ul>
                </li>
                <li class="dropdown">
                    @permission('promo-code')
                    <a href="{{ route('accounts.promo_code') }}" ><i class="fa fa-star"></i> Promo Code <span class="caret"></span></a>
                    @endpermission
                </li>



             </ul>
          </div>
       </div>
