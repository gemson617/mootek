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
                    <h3 class="card-title">Pending Report</h3>
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
                                    <a href="/pending">
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Rating</th>
                                    <th>Assign to </th>
                                    <th>Category</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                 $bill=0;
                                ?>
                                @foreach($datatable as $key=>$val)
                                <?php
                                 $bill=$key+1;
                                ?>
                                <tr>
                                    <td>{{$val->lead_name}}</td>
                                    <td>{{$val->lead_email}}</td>
                                    <td>{{$val->lead_rating}}</td>
                                    <td>
                                        <?php
                                        if ($val->status != 1) { 
                                           $user =  App\Models\user::where('id',$val->employee_id)->first();
                                           $firstname =isset($user->first_name) ?$user->first_name:' ';
                                           $lastname = isset($user->last_name) ? $user->last_name:'';
                                             echo $firstname.' '.$lastname;
                                            ?>
                                        <?php   } else {  ?>
                                              -
                                        <?php    }  ?>
                                    </td>
                                    <td><?php $cat = App\Models\category::where('id',$val->category_id)->first();
                                    echo $cat->category_name; ?></td>

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
                                        <strong class='text-white'><?= 0; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Collected</h6>
                                        <strong class='text-white'><?= 0; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Outstanding</h6>
                                        <strong class='text-white'><?= 0; ?></strong>
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