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
                            <h3 class="card-title">Add Expense</h3>
                        </div>

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('expense.store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Expense Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='expense' class="form-control  @error('name') is-invalid @enderror" placeholder="Expense Name" name="name" />
                                        </div>
                                        @error('name')
                                        <div class="error">*The Expense field is required.</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Status<span class="error">*</span></label>

                                        <div class="form-group">
                                        <select  id='status' class="form-select txt-num  @error('status') is-invalid @enderror" value="" name="status" >
                                                <option value="">--select--</option>
                                                <option value="1" selected>Active</option>
                                                <option value="0">In-Active</option>
                                        </select>
                                            @error('status')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>  

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus"  class="btn btn-sm btn-primary mr-1">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Submit</button>
                                        <a href="#"  class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
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
                            <th>expense</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <td>{{$val->name}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                            <td><button value='{{$val->id}}' class='btn btn-primary edit_form'><i class="fa fa-edit"></i>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="expense" class='btn btn-info change ml-2'>status</button>                        </td>
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
            $(".edit_form").click(function() {
            id = $(this).val();
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{route('expense.index')}}",
                success: function(data) {
                    
                    $("#id").val(data.data.id);
                    $("#status").val(data.data.status).select2();
                    $("#expense").focus();
                    
                    $("#expense").val(data.data.name).select2();
                    $(".card-title").html('Edit Expense').css('color', 'red');
                    scrollToTop();
                }
            });
        });

    $('form[id="form"]').validate({
        rules: {
            name: 'required',
        },
        messages: {
            name: 'This Expense  is Required',
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
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
    });
    $(".delete_modal").click(function() {
            id = $(this).val();
            $("#delete_id").val(id);
            $("#delete_modal").modal('show');
        });
      
        $(document).on('click',"#delete",function() {
            id = $('#delete_id').val();
            $.ajax({
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,

                },
                url: "{{route('expense.delete')}}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload()
                }
            });
        });
    $(document).ready(function() {
        // $('#datatable').DataTable({
        //     "ordering": false
        // });


    });
</script>
@endsection