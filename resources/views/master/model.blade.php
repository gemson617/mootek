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
                            <h3 class="card-title">Accessories Product With Price </h3>
                        </div>

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('model.model_store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Accessories Category Name <span class="error"> * </span> <a class="fa fa-plus-circle" href="/category"></a></label>

                                        <div class="form-group">
                                            <select id='categoryID' class="form-select txt-num  @error('categoryID') is-invalid @enderror"  name="categoryID">
                                                <option value="">--Select--</option>
                                                @foreach($cdata as $cdata)
                                                <option value="{{$cdata->id}}">{{$cdata->category_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('categoryID')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Accessories Product<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='product' class="form-control txt-num @error('product') is-invalid @enderror" placeholder="Accessories Product" name="product" />
                                            @error('product')
                                            <div class="error">*The Model Name is required.</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Accessories Model<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='model' class="form-control txt-num @error('model') is-invalid @enderror" name="model"  placeholder="Accessories Model"/>
                                            @error('model')
                                            <div class="error">*The Model Name is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Accessories Price<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='price' class="form-control txt-num @error('price') is-invalid @enderror" name="price"  placeholder="Accessories Price"/>
                                            @error('price')
                                            <div class="error">*The Model Name is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Status<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select  id='status' class="form-select txt-num  @error('status') is-invalid @enderror" value="" name="status" >
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
                            <th> Accessories Category</th>
                            <th>Accessories Product</th>
                            <th>Accessories Model</th>
                            <th>Accessories Price</th>
                            <th>Status</th> 
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                 
                        @foreach($data as $val)
                        <tr>
                           
                            <td>{{$val->category_name}}</td>
                            <td>{{$val->product}}</td>
                            <td>{{$val->model}}</td>
                            <td>{{$val->price}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                            <td><button value='{{$val->id}}'  class='btn btn-primary edit_form'><i class="fa fa-edit"></i></button>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="accessories_products" class='btn btn-info change'>status</button></td>
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
            categoryID: 'required',
            product: 'required',
            model: 'required',
            price: 'required',
            status: 'required',
        },
        messages: {
            categoryID: 'This Accessories Category Name   is Required',
            product: 'This Accessories Product    is Required',
            model: 'This Accessories Model  is Required',
            price: 'This Accessories Price is Required',
            status: 'This Status is Required',
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

        $(document).on('click', '.edit_form', function() {
            //  $(".edit_form").click(function(){
            id = $(this).val();
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{route('model.model_index')}}",
                success: function(data) {
                    console.log(data.data);
                    // var theValue = $('#categoryID').val(data.data.categoryID);
                    // $('option[value=' + theValue + ']').attr('selected',true);

                    // $("select#categoryID >  option:contains(" + data.data.categoryID + ")").prop('selected', true);
                    $("#categoryID").val(data.data.categoryID).select2();
                    $('#product').val(data.data.product);
                    // $("#brandID").val(data.data.brand_name);
                    $("#model").val(data.data.model);
                    $("#price").val(data.data.price);
                    $("#status").val(data.data.status).select2();
                    $(".card-title").html('Edit Model').css('color', 'red');
                    $("#id").val(data.data.p_id);
                    $("#categoryID").focus();
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