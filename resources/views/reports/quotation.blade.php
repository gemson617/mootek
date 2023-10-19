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
                    <h3 class="card-title">Quotation Report</h3>
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
                                    <a href="/report-quotation-list">
                                        <button type="button" class="btn btn-warning submit">Reset</button>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </form>
                    <div class="row">
                        <table id="datatable" class="table -table">
                            <thead>
                                <tr>
                                    <!-- <th>S.No</th> -->
                                    <th>invoice no</th>
                                    <th>Customer Name</th>
                                    <th>Service</th>
                                    <th>Quotation Date</th>
                                    <!-- <th>Email</th> -->
                                    <!-- <th>View</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $stock_in=0;
                                $stock_out=0;
                                $pur_price=0;
                               ?>
                                @foreach($data as $val)
                                <tr>
                                    <!-- <td>{{$loop->iteration}}</td> -->
                                    <td>{{$val->invoice}}</td>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->gsttaxamount}}</td>
                                    <?php
                                    $datetime = date("d-m-Y", strtotime($val->date));
                                    ?>
                                    <td>{{$datetime}}</td>
                                    {{-- <td><a  target="_blank" href="{{route('quotation.quotation_print', $val->q_id)}}"><button class="btn btn-success">Quotation</button></a></td> --}}
                                    <!-- <td><a href="#"><button class="btn btn-success">Send Email</button></a></td> -->
                                     <td><a href="{{route('quotation.list', $val->q_id)}}"><i class="fa fa-eye" style="font-size:22px;color:#0041ff;"></i></a></td> 
                                    {{-- <td>
                                        <a href="{{route('quotation.edit', $val->q_id)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                        <i class="fa fa-trash delete_modal"  id="{{$val->q_id}}" style="font-size:22px;color:red"></i>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    {{-- <div class="row pt-4">
                        <div class="card border-left-primary shadow h-100 bg-dark bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Stock In</h6>
                                        <strong class='text-white'><?= $stock_in; ?></strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Stock Out </h6>
                                        <strong class='text-white'><?= $stock_out; ?></strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Purchased Price</h6>
                                        <strong class='text-white'><?= number_format($pur_price,2); ?></strong>
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                    </div> --}}

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