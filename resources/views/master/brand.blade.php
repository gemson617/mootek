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
                            <h3 class="card-title">Accessories Product With Price</h3>
                        </div>

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('brand.brand_store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">

                                    <!-- <div class="col-md-4">
                                        <label for="">Select categoryID<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select  id='categoryID' class="form-select txt-num  @error('categoryID') is-invalid @enderror" value="" name="categoryID" >
                                            @foreach($cdata as $cdata)
                                            <option value="{{$cdata->id}}">{{$cdata->category_name}}</option>
                                            @endforeach
                                        </select>
                                            @error('categoryID')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div> -->

                                    <div class="col-md-4">
                                        <label for="">Brand Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='brand_name' class="form-control txt-num @error('brand_name') is-invalid @enderror" placeholder="Enter Brand" name="brand_name" />
                                            @error('brand_name')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                </div>




                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus"  class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and Update</button>
                                        <a href="#"   class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                    </div>
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
                            <!-- <th>ID</th> -->
                            <!-- <th>categoryID</th> -->
                            <th>Brand Name</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <!-- <td>{{$val->id}}</td> -->
                            <!-- <td>{{$val->category_name}}</td> -->
                            <td>{{$val->brand_name}}</td>

                      <td><button value='{{$val->b_id}}'  class='btn btn-primary edit_form'>Edit</button>
                      <button value='{{$val->b_id}}'  class='btn btn-danger delete_modall'>Delete</button></td>
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
            brand_name: 'required',
        },
        messages: {
            brand_name: 'This Brand Name  is Required',
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



    $(".edit_form").click(function(){
        $("#form").load("content.html");
        id=$(this).val();
        $.ajax({
           type:'get',
           data:{
            id:id
           } ,
           url:"{{route('brand.brand_index')}}",
           success: function(data)
            {


                // $("#categoryID").val(data.data.categoryID).select2();
                $("#brand_name").val(data.data.brand_name);

                $(".card-title").html('Edit Brand').css('color','red');
                   $("#id").val(data.data.id);
                   $("#categoryID").focus();
                   scrollToTop();
            }
        });
    });


        $(".delete_modall").click(function(){

            id=$(this).val();
            $("#delete_id").val(id);
          $("#delete_modal").modal('show');
        });
        $("#delete").click(function(){

            id=$('#delete_id').val();
            $.ajax({
               type:'post',
               data:{
                "_token": "{{ csrf_token() }}",
                id:id,

               } ,
               url:"{{route('brand.brand_delete')}}",
               success: function(data)
                {
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