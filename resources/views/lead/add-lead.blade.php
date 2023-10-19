@extends('layouts.app')

@section('content')
    <div class="app-content page-body">
        <div class="container">
            <div class="">
                <?php /*@include('layouts.partials.menu')*/ ?>

                <div class="row pb-5">

                    <div class="col-sm-12">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title">Add Lead</h3>
                            </div>

                            <div class="card-body">

                                @if (session('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('msg') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-warning" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form id="form" method="post" action="{{ route('createLead') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Ticket No</label>
                                            <input type="text" class="form-control" name="tid" value="<?= $id ?>"
                                                readonly>
                                        </div>
                                        <input type="hidden" name="id" id="id" />
                                        <input type="hidden" name="cus_id" id="cus_id" />
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Lead name</label>
                                            <input type="text" class="form-control" id="lead_name" name="lead_name"
                                                value="">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Lead contact</label>
                                            <input type="text" class="form-control" id="mobile_number"
                                                name="mobile_number" value="">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Lead Email</label>
                                            <input type="text" class="form-control" id="lead_email" name="lead_email"
                                                value="">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom01">Select Source</label>
                                            <select class="form-control" id="source" name="source_id">
                                                <option value="">--Select--</option>
                                                <?php if(isset($source)){ foreach ($source as $key => $row) { ?>
                                                <option value="<?= $row->id ?>"><?= $row->source_name ?></option>
                                                <?php }   } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom01">Select Referrer</label>
                                            <select class="form-control" id="referrer_id" name="referer_id">
                                                <option value="">--Select--</option>
                                                <?php if(isset($referer)){ foreach ($referer as $key => $row) { ?>
                                                <option value="<?= $row->id ?>"><?= $row->referrer_name ?></option>
                                                <?php }   } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom01">Select Category</label>
                                            <select class="form-control" id="category" name="category_id">
                                                <option value="">--Select--</option>
                                                <?php if(isset($category)){ foreach ($category as $key => $row) { ?>
                                                <option value="<?= $row->id ?>"><?= $row->category_name ?></option>
                                                <?php }   } ?>
                                            </select>
                                        </div>

                                        {{-- <div class="col-md-3 mb-3">
                                            <label for="validationCustom01">Lead Rating</label>
                                            <select class="form-control" id="lead_rating" name="lead_rating">
                                                <option value="">--Select--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div> --}}

                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Preferred Timing </label>
                                            <input type="time" class="form-control" id="time" name="time">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Preferred date </label>
                                            <input type="date" class="form-control" id="date" name="date">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom01">Select Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1">Open</option>
                                                <option value="3">Close</option>
                                                {{-- <?php if(isset($status)){ foreach ($status as $key => $row) { ?>
                                                <option value="<?= $row->id ?>"><?= $row->status_name ?></option>
                                                <?php }   } ?> --}}
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustomUsername">Remarks</label>
                                            <textarea class="form-control" id="remarks" name="remark" placeholder="Enter Remarks"></textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light">
                                        <button class="btn btn-primary" id="addServiceList">Create Lead</button>
                                    </div>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row pb-5">

                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lead Name</th>
                                <th>Lead Email </th>
                                {{-- <th>Lead Rating</th> --}}
                                <th>Lead Status</th>
                                <th>Assigned to</th>
                                <th>Preferred Date </th>
                                <th>View</th>
                                <th>Action</th>
                                <th>Reject</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leads as $val)
                                <tr>
                                    <td>{{ $val->id }}</td>
                                    <td>{{ $val->lead_name }}</td>
                                    <td>{{ $val->lead_email }}</td>
                                    {{-- <td>{{ $val->lead_rating }}</td> --}}
                                    <?php $badge = ($val->status==1 && $val->employee_id ==null?'New':(($val->status==1 && $val->employee_id !=null) ?'Waiting':($val->status == 2 ? 'Pending' :($val->status == 3?'completed':'rejected'))));
                                    $badge_color = $val->status == 1 ? 'badge-danger' : ($val->status == 2 ? 'badge-info' : ($val->status == 3 ? 'badge-success' : 'badge-warning'));
                                    ?>
                                    <td><span class="badge {{$badge_color}}">{{$badge}}</span></td>
                                    <td>
                                        <?php
                                        if ($val->status != 1) { 
                                           $user =  App\Models\user::select('employees.name as full_name')->leftjoin('employees','employees.user_id','=','users.id')->where('users.id',$val->employee_id)->first();
                                             echo isset($user->full_name)?$user->full_name:'-';
                                            ?>
                                        <?php   } else if($val->status == 1 && $val->employee_id !=null) {  
                                                $user =  App\Models\user::select('employees.name as full_name')->leftjoin('employees','employees.user_id','=','users.id')->where('users.id',$val->employee_id)->first();
                                           
                                        echo isset($user->full_name)?$user->full_name:' '; }else{  ?>
                                            -
                                    <?php    }  ?>
                                    </td>
                                    @if($val->date !=null)
                                    @php
                                        $date =  date('d-m-Y', strtotime($val->date));
                                    @endphp
                                    @else
                                      @php
                                    $date =  date('d-m-Y', strtotime($val->created_at));
                                  @endphp
                                       
                                    @endif
                                    <td>{{$date}}</td>
                                    <td><a href="/service-products/<?=$val->id;   ?>"><i class="fa fa-eye" style="color:blue" aria-hidden="true"></i></a></td>

                                    <td>
                                        @if ($val->status !='4')
                                        <button value='{{ $val->id }}' data-id="{{ $val->id }}"    class='btn btn-primary edit_form'>Edit</button>
                                        {{-- <button value='{{ $val->id }}'
                                            class='btn btn-danger delete_modal'>Delete</button> --}}
                                            <?php 
                                            if($val->status=='1' && $val->employee_id ==null)
                                            {  ?>
                                <button class="btn btn-success" onclick="assignLead({{ $val->id }})">Assign
                                            Lead</button>
                                         <?php   } ?>
                                         @else
                                         -
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if ($val->status !='4')
                                        <button class="btn btn-danger" data='{{$val->id}}'><i class="fa fa-trash" aria-hidden="true"></i>
                                            @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="modal fade" id="rejectmodal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h7 id="exampleModalLabel" class="modal-title">Reject Status
                    </h7>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                     Are you Sure to Reject Status?
                     <form action="{{route('lead.reject')}}" method="post">
                       <input type="hidden" name="reject_id" id="reject_id">
                    @csrf
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="leadModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning p-3">
                    <h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Assign Lead
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assign_lead" method="POST" action="{{ route('assignLead') }}">
                        @csrf
                        <input type="hidden" name="lead_id" id="lead_id" />
                        <input type="hidden" name="customer_id" id="customer_id" />
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Select Employee</label>
                            </div>
                            <div class="form-group col-md-7">
                                <select name="employee_id" id="employee_id" class="form-select selectDrop" required>
                                    <option value=''>--select--</option>
                                    <?php if(isset($employee)){ foreach($employee as $row){ ?>
                                    <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-sm">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
$(".btn-info").click(function(){
 alert('ok');
});
$(".btn-danger").click(function(){
    id=$(this).attr('data');
      $("#reject_id").val(id);
    $('#rejectmodal').modal('show');
});

 $("#mobile_number").on("change keyup paste", function() {
var ph_no = $('#mobile_number').val();
$.ajax({
    url: "{{ route('lead.getcustomet') }}",
    type: 'POST',
    data: {
        ph_no: ph_no,

        "_token": "{{ csrf_token() }}",
    },
    beforeSend: function() {
        $('body').css('cursor', 'progress');
    },
    success: function(data) {
        // if (data.name != null) {
            $("#cus_id").val(data.data.id)
            $("#lead_name").val(data.data.name)
            $("#lead_email").val(data.data.email)
        // }
    },
    async: false
});
});
        function assignLead(id) {
            $('#leadModal').modal('show');
            $('#lead_id').val(id);
            // $('#employee_id');
            $("#employee_id").select2({
                dropdownParent: $("#leadModal"),
                width: '100%'
            });
        }


        $('form[id="assign_lead"]').validate({


            rules: {
                employee_id: 'required',

            },
            messages: {
                employee_id: 'This employee is Required',

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




        $(".edit_form").click(function() {
            id = $(this).data('id');
            var table = 'lead';
            var url = "<?php echo url('/editMasters'); ?>/" + id + "/" + table;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    console.log(data);
                    if (data != 1) {
                        var row = JSON.parse(data);
                        $("#companyID").val(row.companyID).trigger('change');
                        $('#mobile_number').val(row.mobile_number);
                        $("#status").val(row.status).trigger('change');
                        $("#lead_name").val(row.lead_name);
                        $("#lead_email").val(row.lead_email);
                        $("#lead_rating").val(row.lead_rating).trigger('change');
                        $("#category").val(row.category_id).trigger('change');
                        $("#source").val(row.source_id).trigger('change');
                        $("#time").val(row.time);
                        $("#remarks").val(row.remark);
                        $("#referrer_id").val(row.referer_id).trigger('change');
                        $("#id").val(row.id);
                        $("#cus_id").val(row.customer_id);
                        $("#date").val(row.date);
                        $(".card-title").html('Edit Lead').css('color', 'blue');
                        $("#companyID").focus();
                        $('#addServiceList').text("Edit Lead");
                        scrollToTop();
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        $(document).ready(function() {






            $("#tax_change").change(function() {
                taxable_price = parseInt($("#tax_price").val());
                tax = parseInt($('#tax_change').val());
                discount = $("#discount").val();
                console.log(taxable_price);

                $.ajax({

                    url: '{{ route('load.tax.grand') }}',

                    type: 'POST',

                    data: {

                        price: taxable_price,
                        tax: tax,
                        discount: discount,

                        "_token": "{{ csrf_token() }}",


                    },

                    beforeSend: function() {

                        $('body').css('cursor', 'progress');

                    },

                    success: function(data) {
                        $("#grand_total").val(data.total)
                    },

                    async: false

                });


            });
            $(".modal_change").change(function() {
                var product_id = $('.modal_change').val();
                console.log(product_id);
                $.ajax({
                    url: '{{ route('load.product') }}',
                    type: 'POST',
                    data: {

                        id: product_id,
                        "_token": "{{ csrf_token() }}",
                    },

                    beforeSend: function() {

                        $('body').css('cursor', 'progress');

                    },

                    success: function(data) {
                        console.log(data.serial_number.serial);
                        $("#loadProduct").val(data.category.category_name);
                        $("#loadBrand").val(data.brand.brand_name);
                        $("#loadPName").val(data.product.productName);
                        $("#loadPDes").val(data.product.description);
                        $("#loadPrice").val(data.product.selling_price);
                        $("#loadQuantity").val('1');
                        $("#serial_name").val(data.serial_number.serial);
                        if (data.serial_number.serial == null) {
                            $("#loadCheck").val('0');
                        } else {
                            $("#loadCheck").val('1');
                        }

                        // alert(data);

                        $('#snackbar').html("Product Added Successfully!");



                        $('body').css('cursor', 'default');

                    },

                    async: false

                });


            });
            $('#discount').on('input', function(e) {
                tax = $('#tax_price').val();
                dis = tax - $(this).val();
                $("#grand_total").val(dis);
            });


            setTimeout(function() {
                $(".alert-danger").slideUp(500);
                $(".alert-success").slideUp(500);
            }, 2000);







            $(".delete_modal").click(function() {
                id = $(this).val();
                $("#delete_id").val(id);
                $("#delete_modal").modal('show');
            });
            $("#delete").click(function() {
                id = $('#delete_id').val();
                $.ajax({
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,

                    },
                    url: "{{ route('lead.lead_delete') }}",
                    success: function(data) {
                        $("#delete_modal").modal('hide');
                        document.location.reload()
                    }
                });
            });

            $('#datatable').DataTable({
                "ordering": false,
            });

        });
    </script>
@endsection
