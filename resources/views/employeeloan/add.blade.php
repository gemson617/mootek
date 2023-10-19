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
                            <h3 class="card-title">Salary Advance Request</h3>
                        </div>
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('employee_loan.store')}}">
                                @csrf
                                <input type="hidden" id='id' value='<?= isset($attendance->id)? $attendance->id:'';?>' name='id'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Select Employee<span class="error">*</span></label>

                                        <div class="form-group">
                                            <select id='empID' class="brand form-select txt-num  @error('empID') is-invalid @enderror"  name="empID">
                                                <option value="">--Select--</option>
                                                @foreach($employeelist as $data)
                                                <option value="{{$data->user_id}}" <?php if(isset($attendance->empID)){ echo $attendance->empID==$data->user_id ? 'selected':' ';}  ?>>{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('empID')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="advanceAmount">Advance Amount:<span class="error">*</span></label>
                                        <div class="form-group">
                                       <input type="hidden" class="form-control" id="requestType" name="requestType" value="Deduction">

                                            <input type="number" class="form-control" id="advanceAmount" name="advanceAmount">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <label for="requestType">Request Type:<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select class="form-select" id="requestType" name="requestType">
                                                <option value="">--Select--</option>
                                                <option value="Return">Return</option>
                                                <option value="Deduction">Salary Deduction</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4 received_date d-none">
                                        <label for="advanceAmount">Received Date<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="received_date" name="received_date">
                                        </div>
                                    </div> --}}

                                    <div class="col-md-4 month_deduction ">
                                        <label for="requestType">Monthly Deduction<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select class="form-select" id="month_deduction" name="month_deduction">
                                                <option value="">--Select--</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="reason">Reason for Advance:<span class="error">*</span></label>
                                        <div class="form-group">
                                            <textarea class="form-control" id="reason" name="reason" rows="4"></textarea>
                                        </div>
                                    </div>

                                </div>




                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#" onclick="location.reload()" class="btn btn-sm btn-primary mr-1">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and Update</button>
                                        <a href="#" onclick="location.reload()" class="btn btn-sm btn-danger mr-1">Cancel</a>
                                    </div>
                                </div>
                        </div>

                        </form>
                    </div>
                </div>

            </div>

            <div class="row">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>Employee</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Basic Salary</th>

                            <th>AdvanceAmount</th>
                            {{-- <th>RequestType</th> --}}
                            <th>no.Months</th>
                            <th>Action</th>
                            {{-- <th>Received Date</th> --}}
                            {{-- <th>Return/</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                      
                      @foreach($list as $key => $val)
                          {{-- <td>{{$key+1}}</td> --}}
                          <td>{{$val->first_name}}</td>
                          <td>{{$val->email}}</td>
                          <td>{{$val->mobile}}</td>
                          <td>{{$val->basic_salary}}</td>

                          <td>{{$val->advanceAmount}}</td>
                          <td>{{$val->month_deduction}}</td>
                          <td>
                            <a href="{{route('view.loan.histories',$val->id)}}"  class="btn btn-sm btn-primary">
                                <i class="fa fa-eye fa-sm"></i>
                                
                            </a>
                          </td>

                            {{-- // $date = date("d-m-Y", strtotime($val->received_date)); --}}
                           {{-- <td>
                            @if ($val->requestType =='Return')
                            {{$date}}
                            @else
                            -
                            @endif
                            
                        </td> --}}
                          {{-- <td>
                            @if ($val->requestType =='Return')
                            <a href="{{route('employee_loan.return_pay',$val->id)}}"><button class="btn btn-primary">Return</button></a>
                            @else
                            -
                            @endif
                          </td> --}}
                          
                    {{-- <td><button value='{{$val->id}}'  class='btn btn-primary edit_form'>Edit</button>
                    <button value='{{$val->id}}'  class='btn btn-danger delete_modall'>Delete</button></td>
                       --}}
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
<script>
    
        $('#requestType').on('change', function() {
        id = $(this).val();
        if(id ==='Return'){
            console.log(id);
           $(".received_date").removeClass('d-none');
           $(".month_deduction").addClass('d-none');

           
        }else if(id ==='Deduction'){
           $(".received_date").addClass('d-none');
           $(".month_deduction").removeClass('d-none');
		$("#month_deduction").select2();

            
        }else{
           $(".month_deduction").addClass('d-none');
           $(".received_date").addClass('d-none');

        }
        // $("#form_submit").submit();

    })

$('form[id="form"]').validate({
        rules: {
            empID: 'required',
            advanceAmount: 'required',
            requestType: 'required',
            received_date: 'required',
            month_deduction: 'required',
            reason: 'required',


            
        },
        messages: {
            empID: 'This Date is Required',
            advanceAmount: 'This Advance Amount is Required',
            requestType: 'This RequestType is Required',
            received_date: 'This Received Date is Required',
            month_deduction: 'This Deduction Amount is Required',

            reason: 'Reason Amount is Required',

        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            if (element.hasClass('form-select') && element.next('.select2-container').length) {
                label.insertAfter(element.next('.select2-container'));
            } else {
                label.insertAfter(element);
            }
        },

        highlight: function(element, errorClass) {
            $(element).parent().addClass('has-danger')
            $(element).addClass('form-control-danger')
        },
        unhighlight: function(label, element) {
            $(element).parent().removeClass('has-danger')
            $(element).parent().removeClass('form-control-danger')
        },
        submitHandler: function(form) {
            form.submit();
        }

    });

    $(document).ready(function() {
 

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);



        $(".edit_form").click(function() {
            id = $(this).val();
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{route('attendance.index')}}",
                success: function(data) {
                    $("#attdate").val(data.data.attdate);
                    ''
                    $('#empID').val(data.data.empID).select2();
                    $("#status").val(data.data.status).select2();
                    $("#atttime").val(data.data.atttime);
                    $("#login").val(data.data.login_type).select2();
                    //   console.log(data.data.login_type);
                    $(".card-title").html('Edit Attendace').css('color', 'red');
                    $("#id").val(data.data.id);
                    $("#attdate").focus();
                    scrollToTop();
                }
            });
        });



        $(".delete_modall").click(function() {

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
                url: "{{route('attendance.attendance_delete')}}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload();
                }
            });
        });

        $('#datatable').DataTable({
            "ordering": false,
        });



    });




    
</script>
@endsection