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
                            <h3 class="card-title">Customer Category Management</h3>
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
                                <input type="hidden" name="table" value="customer_category" />
                                <div class="row">
                                        
                                    <div class="col-md-4">
                                        <label for="">Category Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='category_name' class="form-control txt-num @error('category_name') is-invalid @enderror" name="category_name" placeholder="Category Name" />
                                            @error('category_name')
                                        <div class="error">*{{$message}}</div>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus"  class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Submit</button>
                                        <a href="#"   class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                    </div>
                                </div>
                         </div>
                        </form>
                    </div>
                </div>

            </div>



            <div class="row pb-5 mt-5">

                <table id="datatable" class='table table-striped'>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Status</th> 
                            <th>Action</th>                           
                                                  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$val)
                        <tr>
                            <td>{{$key+1}}</td>    
                            <td>{{$val->category_name}}</td>                               
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                       <td><button value='{{$val->id}}'  class='btn btn-primary edit_form'><i class="fa fa-edit"></i></button>
                       <button value='{{$val->id}}'  class='btn btn-danger delete_modall'><i class="fa fa-trash"></i></button>
                       <button value='{{$val->id}}' data="{{$val->status}}" data-name="customer_category" class='btn btn-info change'>status</button></td>
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
            category_name: 'required',
            status: 'required',
        },
        messages: {
            category_name: 'This category name  is required',
            status: 'This Status is required',
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
        
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);



        $(".edit_form").click(function(){      
        id=$(this).val();
        var table='customer_category';
        var url = "<?php echo url('/editMasters'); ?>/" + id+"/"+table;
            $.ajax({
                type: 'GET',
                url: url,                              
                success: function(data) {   
                    if(data != 1){
                        var row = JSON.parse(data);                       
                        $("#category_name").val(row.category_name);
                        $("#status").val(row.status).select2();     
                        $("#id").val(row.id);           
                        $(".card-title").html('CUSTOMER CATEGORY MANAGEMENT').css('color','blue');                  
                        $("#source_name").focus();
                        scrollToTop();
                    }               
                },
                error: function(data) {
                    console.log(data);
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
               url:"{{route('category.category_delete')}}",
               success: function(data)
                {
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