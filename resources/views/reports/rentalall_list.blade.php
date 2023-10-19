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
                    <h3 class="card-title"> Rental Report</h3>
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
                                    <a href="/report-rental_all-list">
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
                                    <th>In.No</th>
                                    <th>Rental Date</th>
                                    <th>Cus. Name</th>
                                    <th>Taxable Price</th>
                                    <th>Discount</th>
                                    <th>Tax(%)</th>
                                    <th>Grand Total</th>
                                    <th>Collected</th>
                                    <th>Balance</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                 $bill=0;
                                 $tottal = 0;
                                 $collected = 0;
                                ?>
                                @foreach($data as $key=>$val)
                                <?php
                                 $bill=$key+1;
                                ?>
                                <tr>
                                    <!-- <td>{{$val->r_id}}</td>                                                    -->
                                    <td>{{$val->rentalID}}</td>
                                   <?php
                                    $time =  date('d-m-Y', strtotime($val->rental_date));
                                    ?>
                                    <td>{{$time}}</td>
                                    <td>{{$val->name}}</td>
                                    <td>{{number_format($val->taxable_amount,2)}}</td>
                                    <td>{{$val->discount}}</td>
                                    <td>{{$val->taxpercentage}}</td>
                                    <td>{{number_format($val->total_amount,2)}}</td>
                                    <td>{{number_format($val->collected,2)}}</td>
                                    <?php
                                         $tottal += $val->total_amount;
                                         $collected += $val->collected;
                                    ?>
                                    <td>{{number_format($val->balance,0)}}</td>
                                    <td><a href="{{route('rent.rent_view', $val->r_id)}}"><i class="fa fa-eye" style="font-size:22px;color:#0041ff;"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row pt-4">
                        <div class="card border-left-primary shadow h-100 bg-dark bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Total Bill</h6>
                                        <strong class='text-white'><?= $bill; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Total Amount</h6>
                                        <strong class='text-white'><?=  $tottal; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Collected</h6>
                                        <strong class='text-white'><?= $collected; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Outstanding</h6>
                                        <strong class='text-white'><?= $tottal-$collected ; ?></strong>
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