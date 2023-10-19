@extends('layouts.app')

@section('content')
<style>
    .report-count {
        color: #e37b21;
        font-weight: bolder;
    }
</style>

<div class="app-content page-body">

    <div class="container">

        <div class="row">
            <div class="card border-left-primary shadow h-100 ">
                <div class="card-header">
                    <h3 class="card-title">Balance	Report</h3>
                </div>

                <div class="card-body">
                    <form action=""  id='form_submit'>
                        <div class="row mb-2">
                            <form action="" id='filter'>
                                <div class="row">
                                    <?php
                            // echo $start_date;
                                    // $now = date('Y-m-d');
                                    // $start_date = date('Y-m-d', strtotime($now . ' -1 month'));
                                    ?>
                                    <div class="col-md-4">
                                        <label for="">From Date</label>
                                        <div class="form-group">
                                            <input type="date" value="<?= $start_date; ?>" id='start' placeholder="Enter Serial Number" name='start' class="form-control  @error('price') is-invalid @enderror " required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">To Date</label>
        
                                        <div class="form-group">
                                            <input type="date" id='end' value="<?= $end_date; ?>" placeholder="Enter Serial Number" name='end' class="form-control  @error('price') is-invalid @enderror " required />
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <div class="form-group mr-1">
                                            <button type="submit" class="btn btn-primary submit">Filter</button>
                                        </div>
                                        <div class="form-group">
                                            <a href="/balance">
                                                <button type="button" class="btn btn-warning submit">Reset</button>
                                            </a>
        
                                        </div>
                                    </div>
        
        
                                </div>
                            </form>


                        </div>
                    </form>
                    <div class="row">
                        <table id="datatable" class="table table-striped">
                            <thead>
                                <tr>
                                    {{-- <th></th> --}}
                                    <th>S.No</th>
                                    <th>Total Sale</th>
                                    <th>Total Rental</th>
                                     <th>Total Services</th>
                                     <th>Total Purchases</th>
                                     <th>Total Expenses</th>
                                     <th>Overall Total</th>

                                </tr>
                            </thead>
                            <tbody>
                              @php
                              $begin = new DateTime( $start_date);
                              $end   = new DateTime($end_date);
                              $income =0;
                              $expense=0;
                          @endphp
                          @for ($i = $end; $i >= $begin; $i->modify('-1 day'))
                            <tr>
                            <td>
                            @php
                            
                                $date = date("d-m-Y", strtotime($i->format("Y-m-d")));
                            echo $date;
                                
                            @endphp
                           </td>  
                           <td>
                            @php
                              $total_sale_list = App\Models\purchase_order::leftjoin('payment_histories','payment_histories.id','purchase_orders.invoiceID')
                              ->select(DB::raw('SUM(payment_histories.amount) AS sale'))->where('purchase_orders.status','1')->where('purchase_orders.companyID', Auth::user()->companyID)
                               
                              ->where('payment_histories.created_by', $i->format("Y-m-d"))->get();
                               echo $total_sale_list[0]->sale ==null ?'0':$total_sale_list[0]->sale;
                            @endphp
                           </td> 
                           <td>
                            @php
                              $total_rental_list = App\Models\rent_invoice::leftjoin('payment_histories','payment_histories.rentID','rent_invoices.rentalID')
                              ->select(DB::raw('SUM(payment_histories.amount) AS rentel'))->where('payment_histories.companyID', Auth::user()->companyID)
                              ->where('payment_histories.paymentDate',$i->format("Y-m-d"))->get();
                              echo $total_rental_list[0]->rentel ==null ? '0':$total_rental_list[0]->rentel;
                            @endphp
                           </td> 
                           <td>
                            @php
                              $total_service_list = App\Models\purchase_order::select(DB::raw('SUM(collected) AS service'))->where('companyID', Auth::user()->companyID)
                              ->where('created_by',$i->format("Y-m-d"))->where('status','2')->get();
                              echo $total_service_list[0]->service ==null ? '0':$total_service_list[0]->rentel;
                            @endphp
                           </td>      
                           <td>
                            @php
                              $total_purchase_list = App\Models\purchase::select(DB::raw('SUM(purchase_price) AS p_price'))->where('companyID', Auth::user()->companyID)
                              ->where('purchaseDate',$i->format("Y-m-d"))->get();
                              echo $total_purchase_list[0]->p_price ==null ? '0':$total_purchase_list[0]->p_price;
                            @endphp
                           </td>   
                           <td>
                            @php
                              $total_expense_list = App\Models\expense_details::select(DB::raw('SUM(amount) AS amount'))->where('companyID', Auth::user()->companyID)
                              ->where('expdate',$i->format("Y-m-d"))->get();
                              echo $total_expense_list[0]->amount ==null ? '0':$total_expense_list[0]->amount;
                            @endphp
                           </td>   
                           <td>
                            @php
                              $income+=($total_sale_list[0]->sale+$total_rental_list[0]->rentel+$total_service_list[0]->service);
                              $expense+=($total_purchase_list[0]->p_price+$total_expense_list[0]->amount);
                               $overall =($total_sale_list[0]->sale+$total_rental_list[0]->rentel+$total_service_list[0]->service)-($total_purchase_list[0]->p_price+$total_expense_list[0]->amount);
                               echo $overall;
                            @endphp
                           </td> 
                                </tr>
                            @endfor
                             </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="row pt-4">
                        <div class="card border-left-primary shadow h-100 bg-dark bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Total Income</h6>
                                        <strong class='text-white'>{{$income}}</strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Total Expense</h6>
                                        <strong class='text-white'>{{$expense}}</strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Balance</h6>
                                        <strong class='text-white'>{{$income-$expense}}</strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Profit/loss</h6>
                                        <strong class='text-white'>{{$income-$expense >0 ?'Profit':'Loss'}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                </form>

            </div>
        </div>


    </div>

</div>
</div>
</div>
</div>
</div>
</div>
<script>
    $('.submit').on('click', function() {
        id = $(this).val();
        $("#form_submit").submit();

    })
    $('form[id="form_submit"]').validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        rules: {
            customer: 'required',
        },
        messages: {
            customer: 'This customer is required',
        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        },
        highlight: function(element, errorClass) {
            $(element).parent().addClass('has-danger')
            $(element).addClass('form-control-danger')
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('has-danger')
            $(element).parent().removeClass('form-control-danger')
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(document).ready(function() {

        $('#datatable').DataTable({
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
        'copy', 'excel', {
            extend: 'pdf',
            text: 'PDF',
            exportOptions: {
                columns: ':visible'
            }
        }
    ]
        });

    });
    // $('.submit').on('click', function() {
    // alert('hi');
    $('form[id="filter"]').validate({
        rules: {
            start: 'required',
            end: 'required',
        },
        messages: {
            start: 'This From Date is required',
            end: 'This To Date is required',

        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        },
        highlight: function(element, errorClass) {
            $(element).parent().addClass('has-danger')
            $(element).addClass('form-control-danger')
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('has-danger')
            $(element).parent().removeClass('form-control-danger')
        },
        submitHandler: function(form) {

            form.submit();
        }

    });
    // id = $(this).val();

    // });
</script>
@endsection