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
                            <h3 class="card-title"><?= isset($attendance->id)? 'Edit':'Add';?> Attendance</h3>
                        </div>
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('attendance.attendance_store')}}">
                                @csrf
                                <input type="hidden" id='id' value='<?= isset($attendance->id)? $attendance->id:'';?>' name='id'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Date<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="date" id='attdate' value="<?= isset($attendance->attdate)?$attendance->attdate:' ' ?>" class="form-control txt-num @error('attdate') is-invalid @enderror" max="<?= date("Y-m-d") ?>"; name="attdate" />
                                            @error('attdate')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Select Employee<span class="error">*</span></label>

                                        <div class="form-group">
                                            <select id='empID' class="brand form-select txt-num  @error('empID') is-invalid @enderror"  name="empID">
                                                <option value="">--Select--</option>
                                                @foreach($employee as $data)
                                                <option value="{{$data->user_id}}" <?php if(isset($attendance->empID)){ echo $attendance->empID==$data->user_id ? 'selected':' ';}  ?>>{{$data->name}}</option>
                                                @endforeach

                                            </select>
                                            @error('empID')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Status<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select id='status' class="brand form-select txt-num  @error('status') is-invalid @enderror" name="status">
                                                <option value="">--Select--</option>
                                                <option value="Present" <?= isset($attendance->status)=='Present'? 'selected':' ' ?>>Present</option>
                                                <option value="Absent" <?= isset($attendance->status)=='Absent'? 'selected':' ' ?>>Absent</option>
                                            </select>
                                            @error('status')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Time<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="time" id='atttime' class="form-control @error('atttime') is-invalid @enderror" name="atttime" value="<?= isset($attendance->atttime)?$attendance->atttime:' ' ?>"/>
                                            @error('atttime')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Login</label>
                                        <div class="form-group">
                                            <select id='login' class="brand form-select txt-num  @error('status') is-invalid @enderror" value="" name="login_type">
                                                <option value="">--Select--</option>
                                                <option value="1" <?= isset($attendance->active)=='1'? 'selected':' ' ?>>Office</option>
                                                
                                            </select>
                                            @error('status')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
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


        </div>
    </div>
</div>
</div>
</div>
</div>
<script>

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




    $('form[id="form"]').validate({
        rules: {
            attdate: 'required',
            empID: 'required',
            status: 'required',
            atttime: 'required',
            login_type: 'required',


        },
        messages: {
            attdate: 'This Date is Required',
            empID: 'This Employee is Required',
            status: 'This Status is Required',
            atttime: 'This Time is Required',
            login_type: 'This login is Required',


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
</script>
@endsection