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
                            <h3 class="card-title">Add Email Template</h3>
                        </div>

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('status.storeStatus')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">
                                    <input type="hidden" name="table" value="EmailTemplate" />
                                    <div class="col-md-6">
                                        <label for="">Stage<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select id='stage_id' class="form-select txt-num  @error('stage_id') is-invalid @enderror" value="" name="stage_id">
                                                <option value="">--select--</option>
                                                <?php if (isset($stage)) {
                                                    foreach ($stage as $row) { ?>
                                                        <option value="<?= $row->id ?>"><?= $row->stage_name ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                            @error('stage_id')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Email Name<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='email_name' class="form-control txt-num @error('email_name') is-invalid @enderror" placeholder="Enter Email Name" name="email_name" />
                                            @error('email_name')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-3">
                                        <label for="">Status<span class="error">*</span></label>
                                        <div class="form-group">
                                        <select  id='status' class="form-select txt-num  @error('status') is-invalid @enderror" value="" name="status" >
                                                <option value="">--select--</option>
                                                <option value="0">Active</option>
                                                <option value="1">In-Active</option>
                                        </select>
                                            @error('status')
                                        <div class="error">*{{$message}}
                                </div>
                                @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-10">
                        <label for="">Email Body<span class="error">*</span></label>
                        <div class="form-group">
                            <textarea id='email_body' class="form-control txt-num @error('email_body') is-invalid @enderror" name="email_body" required></textarea>
                            @error('email_body')
                            <div class="error">*{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and Update</button>
                        <a href="#" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>



<div class="row pb-5">
    <table id="datatable" class='table table-striped'>
        <thead>
            <tr>
                {{-- <th>ID</th> --}}
                <th>Stage</th>
                <th>Email Name</th>
                <th>Email Body</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($status)) {
                $i = 1;
                foreach ($status as $val) {
            ?>
                    <tr>
                        {{-- <td><?= $i ?></td> --}}
                        <td><?= $val->stage_name; ?></td>
                        <td><?= $val->email_name ?></td>
                        <td><?= $val->email_body ?></td>
                        <td><a href="javascript:void(0)" data-id="<?= $val->id ?>" class="btn btn-primary edit_form">Edit</a></td>
                    </tr>
            <?php $i++;
                }
            } ?>
        </tbody>
    </table>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script>
    $('form[id="form"]').validate({
        ignore: [],
        rules: {
            stage_id: 'required',
            email_name: 'required',
            email_body:
            {
                ckrequired:'required'
            },
        },
        messages: {
            stage_id: 'This Stage is Required',
            email_name: 'This Email Name is Required',
            // email_body: 'This Email Body is Required',


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
    jQuery.validator.addMethod('ckrequired', function(value, element, params) {
        var idname = jQuery(element).attr('id');
        var messageLength = jQuery.trim(CKEDITOR.instances[idname].getData());
        return !params || messageLength.length !== 0;
    }, "This Email Body is Required");

    $(document).ready(function() {

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);

        CKEDITOR.editorConfig = function(config) {
            config.language = 'es';
            config.uiColor = '#F7B42C';
            config.height = 300;
            config.toolbarCanCollapse = true;
        };
        CKEDITOR.replace('email_body');

        $(".edit_form").click(function() {
            id = $(this).data('id');
            var table = 'EmailTemplate';
            var url = "<?php echo url('/editMasters'); ?>/" + id + "/" + table;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    if (data != 1) {
                        var row = JSON.parse(data);
                        $("#email_name").val(row.email_name);
                        // $("#email_body").val(row.email_body);
                        CKEDITOR.instances['email_body'].setData(row.email_body)
                        $("#id").val(row.id);
                        $("#stage_id").val(row.stage_id).select2();
                        $(".card-title").html('Edit Email Template').css('color', 'blue');
                        $("#email_name").focus();
                        scrollToTop();
                    }
                },
                error: function(data) {
                    console.log(data);
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
                url: "{{route('category.category_delete')}}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload();
                }
            });
        });

        $('#datatable').DataTable({
            "ordering": false
        });





    });
</script>
@endsection