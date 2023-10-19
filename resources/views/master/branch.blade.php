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
                            <h3 class="card-title">Add Branch</h3>
                        </div>
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('branch.branch_store')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id='id'  value='<?= isset($cid)?$cid:'';  ?>' name='id'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Branch Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" id='company' class="form-control   @error('company') is-invalid @enderror" value="{{old('company')?old('company'):(isset($company->company)?$company->company:'')}}" name="company" />
                                        </div>
                                        @error('company')
                                        <div class="error">*The Branch field is required.</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Branch Address</label>
                                        <div class="form-group">
                                            <input type="text" id='address_line' class="form-control @error('address_line') is-invalid @enderror" value="" name="address_line" />
                                        </div>
                                        @error('address_line')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Branch State</label>
                                        <div class="form-group">

                                            <select class="form-select txt-num  @error('state') is-invalid @enderror state" onchange="get_city(this.value,'','city');" id='state' name="state">
                                                <option value="">--Select--</option>
                                                @foreach($states as $val)
                                                <option value="{{$val->id}}"  >{{$val->state_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('state')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Branch City</label>

                                        <div class="form-group">
                                            <select class="form-select txt-num  @error('city') is-invalid @enderror city" id='city' name="city">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        @error('city')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Status<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select  id='status' class="form-select txt-num  @error('status') is-invalid @enderror" value="" name="status" >
                                               <option value="">--Select--</option>
                                               <option value="1">Active</option>
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
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to list</button>
                                        <a href="#" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row pb-5">

                <table id="datatable" class="table table-striped " style="width:100%;">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>company</th>
                            <td>Status</td>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company as $val)
                        <tr>
                            {{-- <td>{{$val->id}}</td> --}}
                            <td>{{$val->company}}</td>

                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               


                            <td><button value='{{$val->id}}' class='btn btn-primary edit_form'><i class="fa fa-edit"></i></button>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="branch" class='btn btn-info change'>status</button></td>
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
<script>
        $(".change").click(function(){    
        status=$(this).attr('data');
            check_status =status=='0'?'Active':'InActive';
            change =status=='0'?'1':'0';
            status_id=$(this).attr('data-id');
            $("#changestatus").val(change);
            $("#change_id").val(status_id);
			$("#table").val('company');
          $("#check_status").text(check_status).css('color','red');
           $(".change_status").modal('show');
		   
    });

       $(document).ready(function() {
        $('#datatable').DataTable({
            "ordering": false
        });
    }); 
    
    $('form[id="form"]').validate({
        rules: {
            company: 'required',
            address_line: 'required',
            state: 'required',
            active: 'required',

        },
        messages: {
            company: 'This Name is required',
            address_line: 'This Address is required',
            state: 'This state is required',
            active: 'This Status is required',

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
        unhighlight: function(element) {
            $(element).parent().removeClass('has-danger')
            $(element).parent().removeClass('form-control-danger')
        },
        submitHandler: function(form) {

            form.submit();
        }

    });

    $(document).on('click', '.delete_modal', function() {
        // $(".delete_modal").click(function(){
        id = $(this).val();
        $("#delete_id").val(id);
        $("#delete_modal").modal('show');
    });
    $(document).on('click', '.delete', function() {
        id = $('#delete_id').val();
        $.ajax({
            url: "{{route('branch.exp_delete')}}",

            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,

            },
            success: function(data) {
                $("#delete_modal").modal('hide');
                document.location.reload()
            }
        });
    });


 

    // $(document).ready(function() {

    $(document).on('click', '.edit_form', function() {
        // $(".edit_form").click(function(){

        id = $(this).val();
        // alert('hi');
        $.ajax({
            type: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            url: "{{route('branch.branch_index')}}",
            success: function(data) {
                // console.log(data.data.city);
                console.log(data);
                $("#company").val(data.data.company);
                $("#contact_person").val(data.data.contact_person);
                $("#email").val(data.data.email);
                $("#phone_number").val(data.data.phone_number);
                $("#address_line").val(data.data.address_line);
                    $(".state").val(data.data.state).select2();
                    $('#city').empty();
                    $('#city')
                        .append($("<option></option>")
                            .attr('selected', true)
                            .attr('value', data.data.city)
                            .text(data.data.city_name));
                    // $(".city").val(data.data.city).select2();
                $(".card-title").html('Edit Branch').css('color', 'red');
                $("#name").focus();
                $("#id").val(data.data.id);
                $(".state").val(data.data.state).select2();
                $(".city").val(data.data.city).select2();
                $("#status").val(data.data.status).select2();

                // $("#tax").val(data.data.tax).select2();
                scrollToTop();
            }
        });
    });





    // });
</script>
@endsection