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
                    <h3 class="card-title">Expense	Report</h3>
                </div>

                <div class="card-body">
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
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary submit">Filter</button>
                                </div>
                                <div class="form-group">
                                    <a href="/report-expense-list">
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
                                    <th>Expense</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                 $stock_in=0;
                                 $tot_price=0;
                                ?>
                              
                              @foreach($data as $key => $val)
                              <tr>
                                <?php 
                                $stock_in +=1;
                                $tot_price +=$val->amount;
                               ?>
                                  {{-- <td>{{$key+1}}</td> --}}
                                  <td>{{$val->expense}}</td>
                                  <?php
                                    $date = date("d-m-Y", strtotime($val->expdate));
                                    ?>
                                  <td>{{$date}}</td>
                                  <td>{{$val->expdesc}}</td>
                                  <td>{{$val->amount}}</td>
                                  
                            {{-- <td><button value='{{$val->id}}'  class='btn btn-primary edit_form'>Edit</button>
                            <button value='{{$val->id}}'  class='btn btn-danger delete_modall'>Delete</button></td>
                               --}}
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
                                        <h6 class='report-count'>No of Expense</h6>
                                        <strong class='text-white'><?= $stock_in; ?></strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Expense</h6>
                                        <strong class='text-white'><?= $tot_price; ?></strong>
                                    </div>
                                    {{-- <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Purchased Price</h6>
                                        <strong class='text-white'><?= number_format($pur_price,2); ?></strong>
                                    </div> --}}
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