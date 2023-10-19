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
                            <h3 class="card-title">Product Master</h3>
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
                                <input type="hidden" id="table" name="table" value="product" />

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Product Type<span class="error">*</span></label>

                                        <div class="form-group">
                                            <select id='Producttype' class="form-select txt-num  @error('Producttype') is-invalid @enderror"  name="Producttype">
                                                <option value="">--Select--</option>
                                                <option value="local">Local</option>
                                                <option value="import">Import</option>
                                               
                                            </select>
                                            @error('Producttype')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Select Company<span class="error"> * </span> <a class="fa fa-plus-circle" href="/company_master"></a></label>

                                        <div class="form-group">
                                            <select id='companyID' class="form-select txt-num  @error('companyID') is-invalid @enderror"  name="companyID">
                                                <option value="">--Select Company--</option>
                                                @foreach ($company as $val)
                                                <option value="{{$val->id}}">{{$val->company}}</option>
                                                @endforeach
                                              
                                               
                                               
                                            </select>
                                            @error('companyID')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Nick Name<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='nick_name' class="form-control txt-num @error('nick_name') is-invalid @enderror" placeholder="Nick Name" name="nick_name" />
                                            @error('nick_name')
                                            <div class="error">*The Model Name is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Product Name<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='product_name' class="form-control txt-num @error('product_name') is-invalid @enderror" placeholder="Product Name" name="product_name" />
                                            @error('product_name')
                                            <div class="error">*The Model Name is required.</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Model Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='model_number' class="form-control txt-num @error('model_number') is-invalid @enderror" name="model_number"  placeholder="Model Name"/>
                                            @error('model_number')
                                            <div class="error">*The Model Name is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Version Number<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='version_number' class="form-control txt-num @error('version_number') is-invalid @enderror" name="version_number"  placeholder="Version Number"/>
                                            @error('version_number')
                                            <div class="error">*The Model Name is required.</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Status<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select  id='status' class="form-select txt-num  @error('status') is-invalid @enderror"  name="status" >
                                               <option value="">--Select--</option>
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
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Submit</button>
                                        <a href="#" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                    </div>
                                </div>
                        </div>

                        </form>
                    </div>
                </div>

            </div>



            <div class="row pb-5">

                <table id="datatable" class='display table nowrap'>
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Type</th>
                            <th>Product Name</th>
                            <th>Model Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <td>{{$val->Producttype}}</td>
                            <td>{{$val->product_name}}</td>
                            <td>{{$val->model_number}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                            <td><button value='{{$val->id}}'  class='btn btn-primary edit_form'><i class="fa fa-edit"></i></button>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="product" class='btn btn-info change ml-2'>status</button>
                                {{-- <button value='{{$val->id}}'  class='btn btn-danger delete_modall'><i class="fa fa-trash"></i></button> --}}
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
    $('form[id="form"]').validate({
        rules: {
            Producttype: 'required',
            companyID: 'required',
            nick_name: 'required',
            product_name: {
                    required: true,
                    remote: {
                        url: "{{route('exit.index') }}", // Laravel route for email validation
                        type: "post", // HTTP request method
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token
                            name: function () {
                                return $("#product_name").val();
                            },
                            id: function () {
                                 return $("#id").val(); // Replace with the actual input ID
                            },
                            table: function () {
                                 return $("#table").val(); // Replace with the actual input ID
                            },
                            column: function () {
                                 return 'product_name'; // Replace with the actual input ID
                            },
                        },
                     },
                     },
                     model_number: {
                    required: true,
                    remote: {
                        url: "{{route('exit.index') }}", // Laravel route for email validation
                        type: "post", // HTTP request method
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token
                            name: function () {
                                return $("#model_number").val();
                            },
                            id: function () {
                                 return $("#id").val(); // Replace with the actual input ID
                            },
                            table: function () {
                                 return $("#table").val(); // Replace with the actual input ID
                            },
                            column: function () {
                                 return 'model_number'; // Replace with the actual input ID
                            },
                        },
                    },
                     },
                     version_number: {
                    required: true,
                    remote: {
                        url: "{{route('exit.index') }}", // Laravel route for email validation
                        type: "post", // HTTP request method
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token
                            name: function () {
                                return $("#version_number").val();
                            },
                            id: function () {
                                 return $("#id").val(); // Replace with the actual input ID
                            },
                            table: function () {
                                 return $("#table").val(); // Replace with the actual input ID
                            },
                            column: function () {
                                 return 'version_number'; // Replace with the actual input ID
                            },
                        },
                    },
                     },
        },
        messages: {
            Producttype: 'This Product type is Required',
            companyID: 'This company field is Required',
            nick_name: 'This Nick Name is required',
            product_name: {
                    required: "This Product  Name is Required",
                    remote: "Product Name already exists",
                },
                model_number: {
                    required: "This Model Number  is Required",
                    remote: "Model Name already exists",
                },
                version_number: {
                    required: "This Version  Number is Required",
                    remote: "Version Number already exists",
                },
        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            if(element.hasClass('form-select') && element.next('.select2-container').length) {
            label.insertAfter(element.next('.select2-container'));
            }
            else{
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
    $(document).ready(function() {

        $("#categoryID").on('change', function() {
            // var id = $(this).val();
            brand_id();

        });

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);

        $(".edit_form").click(function(){      
        id=$(this).val();
        var table='product';
        var url = "<?php echo url('/editMasters'); ?>/" + id+"/"+table;
            $.ajax({
                type: 'GET',
                url: url,                              
                success: function(data) {   
                    if(data != 1){
                        var row = JSON.parse(data);                       
                        $("#Producttype").val(row.Producttype).select2();
                        $("#companyID").val(row.companyID).select2();     
                        $("#product_name").val(row.product_name);     
                        $("#nick_name").val(row.nick_name);     
                        $("#model_number").val(row.model_number);     
                        $("#version_number").val(row.version_number);     
                        $("#id").val(row.id);           
                        $(".card-title").html('Enquiry Status').css('color','blue');                  
                        $("#source_name").focus();
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
                url: "{{route('model.model_delete')}}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload();
                }
            });
        });



        // $('#datatable').DataTable({
        //     "ordering": false
        // });




    });
</script>
@endsection