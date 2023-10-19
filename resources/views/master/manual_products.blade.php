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
                            <h3 class="card-title">Add Material Product</h3>
                        </div>

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id='form' method="post" action="{{route('m_products.store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for=""> Product<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" id='product' class="form-control  @error('product') is-invalid @enderror" placeholder="Enter Material"  name="product" />
                                        </div>
                                        @error('product')
                                        <div class="error">*The Material field is required.</div>
                                        @enderror
                                    </div>
                          
                                    <div class="col-md-6">
                                        <label for=""> HSN<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" id='hsn' class="form-control  @error('hsn') is-invalid @enderror" placeholder="Enter HSN"  name="hsn" />
                                        </div>
                                        @error('hsn')
                                        <div class="error">*The Material field is required.</div>
                                        @enderror
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

                <table id="datatable" class='table table-striped'>
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Product</th>
                            <th>HSN</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <!-- <td>{{$loop->iteration}}</td> -->
                            <td>{{$val->product}}</td>
                            <td><?php echo $val->hsn==null ?'-':$val->hsn; ?></td>

                      <td><button value='{{$val->id}}' class='btn btn-primary edit_form'>Edit</button><button value='{{$val->id}}' class='btn btn-danger delete_modal'>Delete</button></td>
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
            product: 'required',
            hsn: 'required',
        },
        messages: {
            product: 'This Material   is Required',
            hsn: 'This HSN is Required',
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

    $(document).ready(function() {
        $('#datatable').DataTable({
            "ordering": false
        });
        
        $(document).on('click','.edit_form',function(){
        // $(".edit_form").click(function(){
            id=$(this).val();
            $.ajax({
               type:'get',
               data:{
                id:id
               } ,
               url:"{{route('m_products.index')}}",
               success: function(data)
                {
                    $("#product").val(data.data.product);
                    $("#hsn").val(data.data.hsn);
                    $(".card-title").html('Edit MANUAL PRODUCT').css('color','red');
                       $("#id").val(data.data.id);
                    $("#product").focus();
                    scrollToTop();                
                }
            }); 
        });

        $(document).on('click','.delete_modal',function(){
        // $(".delete_modal").click(function(){
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
               url:"{{route('m_products.delete')}}",
               success: function(data)
                {
                   $("#delete_modal").modal('hide');
                   document.location.reload()
                }
            }); 
        });

    });
</script>
@endsection