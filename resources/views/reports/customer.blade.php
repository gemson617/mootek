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
                    <h3 class="card-title">Customer	Report</h3>
                </div>

                <div class="card-body">
                    <form action=""  id='form_submit'>
                        <div class="row mb-2">
                            <?php
                    // echo $start_date;
                            // $now = date('Y-m-d');
                            // $start_date = date('Y-m-d', strtotime($now . ' -1 month'));
                            ?>
                            <form action="">
                                <div class="col-md-4">
                                       
                                    <label for=""> Select Customer<span class="error">*</span></label>

                                    <select id='customer' class="form-select txt-num  @error('customer') is-invalid @enderror" value="" name="customer" required>
                                        <option value="">--Select--</option>
                                        @foreach($customer as $val)

                                        <option value="{{$val->id}}">{{$val->name}}</option>

                                        @endforeach
                                    </select>
                                    @error('customer')
                                    <div class="error">*{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="">From Date</label>
                                    <div class="form-group">
                                        <input type="date" value="<?= $start_date; ?>" id='start' placeholder="Enter Serial Number" name='start' class="form-control  @error('price') is-invalid @enderror " required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">To Date</label>
    
                                    <div class="form-group">
                                        <input type="date" id='end' value="<?= $end_date; ?>" placeholder="Enter Serial Number" name='end' class="form-control  @error('price') is-invalid @enderror " required />
                                    </div>
                                </div>
                            </form>
                               
                            <div class="col-md-1 my-4 d-flex align-items-end">
                                <div class="form-group mr-2">
                                    <button type="button" class="btn btn-primary submit">Filter</button>

                                </div>
                                <div class="form-group">
                                    <a href="/report-customer-list">
                                        <button type="button" class="btn btn-warning submit">Reset</button>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </form>
                    <div class="row">
                        <table id="datatable" class="table table-striped">
                            <thead>
                                <tr>
                                    {{-- <th></th> --}}
                                    <th>S.No</th>
                                    <th>Service Method</th>
                                    <th>Invoice</th>
                                    <th>Tax</th>   
                                    <th>Amount</th>   
                                    <th>Collected</th>   
                                    <th>Balance</th>   
                                    <th>Date</th>   

                                </tr>
                            </thead>
                            <tbody>
                              
                              <?php  
                             $total=0;
                             $collected=0;
                             $balance=0;
                              ?>
                              @foreach($customer_sale as $key => $sale)
                              @php
                                   $total+=$sale->grand_total;
                                   $collected+=$sale->collected;
                                   $balance+=$sale->balance;

                              @endphp
                              <tr>
                                <td>{{$key+1}}</td>
                                <td>Sale</td>
                                <td>{{$sale->invoiceID}}</td>
                                <td>{{$sale->tax}}</td>
                                <td>{{$sale->grand_total}}</td>
                                <td>{{$sale->collected}}</td>
                                <td>{{$sale->balance}}</td>
                                <td>{{$sale->created_at}}</td>
                            </tr>
                              @endforeach
                              @foreach($customer_rental as $key => $rendel)
                              @php
                              $total+=$rendel->total_amount;
                              $collected+=$rendel->collected;
                              $balance+=$rendel->balance;

                              
                         @endphp
                              <tr>
                                <td>{{$key+1}}</td>
                                <td>Rental</td>
                                <td>{{$rendel->rentalID}}</td>
                                <td>{{$rendel->tax}}</td>
                                <td>{{$rendel->total_amount}}</td>
                                <td>{{$rendel->collected}}</td>
                                <td>{{$rendel->balance}}</td>
                                <td>{{$rendel->created_at}}</td>
                            </tr>
                              @endforeach
                              @foreach($customer_service as $key => $service)
                              @php
                              $total+=$service->grand_total;
                              $collected+=$service->collected;
                              $balance+=$service->balance;


                         @endphp
                              <tr>
                                <td>{{$key+1}}</td>
                                <td>Service</td>
                                <td>{{$service->invoiceID}}</td>
                                <td>{{$service->tax}}</td>
                                <td>{{$service->grand_total}}</td>
                                <td>{{$service->collected}}</td>
                                <td>{{$service->balance}}</td>
                                <td>{{$service->created_at}}</td>
                            </tr>
                              @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row pt-4">
                        <div class="card border-left-primary shadow h-100 bg-dark bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Amount</h6>
                                        <strong class='text-white'>{{$total}}</strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Collected</h6>
                                        <strong class='text-white'>{{$collected}}</strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Outstanding</h6>
                                        <strong class='text-white'>{{$balance}}</strong>
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