@extends('layouts.app')

@section('content')

<style>
    #employee-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }
</style>
<div class="app-content page-body">
    <div class="container">

        <?php /*@include('layouts.partials.menu')*/ ?>
        <form id='role' action="{{route('role.permission')}}" method='post'>
            @csrf
            <div class="row pb-5">

                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-header">
                            <h3 class="card-title">Select Role</h3>
                        </div>
                        <div class="card-body">
                        @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                            </div>
                                @endif
                            <div class="col-md-6">
                                <label for="">Select  User or Employee<span class="error">*</span></label>
                                <input type="hidden" name='id' id='emp_id'>
                                <div class="form-group">
                                    <select id='elmployee' class="form-select txt-num" name="employee" required>
                                        <option value="">--Select--</option>
                                        @foreach($user as $val)
                                        <option value="{{$val->id}}">{{$val->user_name}}-<?php echo  $val->role_id == '1' ? 'Admin' : 'Employee'; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                        </div>

                    </div>
                </div>

            </div>
            <div class="row mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-wrap justify-start mb-4">
                            <div class="block w-full mb-5">
                                @foreach($menu as $menu_key=>$menu)
                                <p class="d-flex align-items-center px-3 bg-azure-lighter py-2 border">
                                    <input type="checkbox" class="form-checkbox h-4 w-4 select-checkboxes_{{$menu_key+1}} border bg-azure-light mr-2" data-id="{{$menu_key+1}}" name="" value="">
                                    {{$menu->menu}}
                                </p>
                                <div id="group-checkboxes-Customers" class="group-checkboxes">
                                    <div class="flex flex-wrap justify-start">
                                        @foreach($menu_sub as $sub_key=>$sub)
                                        @if($sub->menuID ==$menu->id )
                                        <label class="col-sm-3">
                                            <input type="checkbox" class="form-checkbox h-4 w-4 permission-checkbox_{{$menu_key+1}} border bg-azure-light check_{{$menu_key+1}}-{{$sub_key+1}}" id='permissions0' name="permissions[]" value="{{$menu_key+1}}-{{$sub_key+1}}">
                                            <span class="ml-2">{{$sub->subName}}</span>
                                        </label>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <button type="submit" class='btn btn-primary'>Save</button>
        </form>





    </div>
</div>
<script>
            $('form[id="role"]').validate({
            rules: {
                employee: 'required',
                'permissions[]': 'required',
            },
            messages: {
                employee: 'Choose User or Employee is required',
                'permissions[]': 'Select Atleast one field!',

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


        $('input[type="checkbox"]').change(function() {
            num = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                $(".permission-checkbox_" + num).prop("checked", true);

            } else {
                $(".permission-checkbox_" + num).prop("checked", false);

            }
        });
        $("select").on("select2:close", function(e) {
            $(this).valid();
        });
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);


        $('#elmployee').change(function() {
            num = $(this).val();
            $.ajax({
                url: "{{route('employee.check')}}",
                method: 'POST',
                data: {
                    id: num,
                    _token: '{{csrf_token()}}',
                },
                success: function(data) {
                    $("#emp_id").val(data.id);
                    $.each(data.per, function(key, value) {
                        $(".check_" + value.menu + '-' + value.menu_sub).prop("checked", true);
                    });
                    for (i = 0; i < 9; ++i) {
                        len1 = $(".permission-checkbox_" + i + ":checkbox:checked").length;
                        len = $(".permission-checkbox_" + i + ":checkbox:unchecked").length;
                        if (len1 == (len1 + len)) {
                            $(".select-checkboxes_" + i).prop("checked", true);
                        }
                    }
                }
            });

        });






    });
</script>
@endsection