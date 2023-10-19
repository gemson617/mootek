@extends('layouts.app')

@section('content')
<style>
       #status-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }
</style>
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/ ?>
            <div class="row pb-5">
                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-header">
                            <h3 class="card-title">City Management</h3>
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
                                    <input type="hidden" name="table" value="cities" />
                                    <div class="col-md-4">
                                        <label for="">City Name<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" placeholder="City Name" id='city_name' class="form-control txt-num @error('city_name') is-invalid @enderror" name="city_name" />
                                            @error('city_name')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">State Name <span class="error">* </span> <a class="fa fa-plus-circle" href="/state"></a></label>
                                        <div class="form-group">
                                            <select  id='state_id' class="form-select txt-num  @error('state_id') is-invalid @enderror" value="" name="state_id" >
                                                <option value="">--select--</option>
                                                @foreach ($state as $val)
                                                <option value="{{$val->id}}">{{$val->state_name}}</option>
                                                @endforeach
                                        </select>
                                        </div>
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
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
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
                            <th>S.No</th>                           
                            <th>State Name</th> 
                            <th>City Name</th> 
                            <th>Status</th>
                            <th>Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                       <?php if(isset($status)){ 
                        $i=1;
                        foreach($status as $val){ 
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $val->state_name ?></td>
                            <td><?= $val->city_name ?></td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                            <td><a href="javascript:void(0)" data-id="<?= $val->id ?>" class="btn btn-primary edit_form"><i class="fa fa-edit"></i></a>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="cities" class='btn btn-info change'>status</button></td>

                            </td>
                        </tr>
                        <?php $i++; }  } ?>
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
            check_status =status=='0'?'Inactive':'Active';
            change =status=='0'?'1':'0';
            status_id=$(this).attr('data-id');
            $("#changestatus").val(change);
            $("#change_id").val(status_id);
			$("#table").val('Source');
          $("#check_status").text(check_status).css('color','red');
           $(".change_status").modal('show');
		   
    });
            $('form[id="form"]').validate({
        rules: {
            city_name: 'required',
            state_id:'required',
            status: 'required',
        },
        messages: {
            city_name: 'This City Name is Required',
            state_id:'This State Name is Required',
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
        
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);



    $(".edit_form").click(function(){      
        id=$(this).data('id');
        var table='cities';
        var url = "<?php echo url('/editMasters'); ?>/" + id+"/"+table;
            $.ajax({
                type: 'GET',
                url: url,                              
                success: function(data) {   
                    if(data != 1){
                        var row = JSON.parse(data);                       
                        $("#city_name").val(row.city_name);
                        $("#status").val(row.status).select2();     
                        $("#id").val(row.id);           
                        $(".card-title").html('State Management').css('color','blue');                  
                        $("#city_name").focus();
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