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
                            <h3 class="card-title">Bank Master</h3>
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
                                    <input type="hidden" name="table" value="Bank_master" />
                                    <div class="col-md-4">
                                        <label for="">Company Name<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select  id='company_id' class="form-select txt-num  @error('company_id') is-invalid @enderror" value="" name="company_id" >
                                                <option value="">--select--</option>
                                                @foreach ($branch as $val)
                                                <option value="{{$val->id}}">{{$val->company}}</option>
                                                
                                            @endforeach
                                                
                                        </select>
                                            @error('payment_mode')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Bank Name<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" placeholder="Bank Name" id='bank_name' class="form-control txt-num @error('bank_name') is-invalid @enderror" name="bank_name" placeholder="Bank Name"/>
                                            @error('bank_name')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">IFSC<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='ifsc' placeholder="IFSC" class="form-control txt-num @error('ifsc') is-invalid @enderror" name="ifsc" />
                                            @error('ifsc')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Account Number<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" placeholder="Account Number" id='account_number' class="form-control txt-num @error('account_number') is-invalid @enderror" name="account_number" />
                                            @error('account_number')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">IMCR<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" placeholder="IMCR" id='imcr' class="form-control txt-num @error('imcr') is-invalid @enderror" name="imcr" />
                                            @error('imcr')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="">Status<span class="error">*</span></label>

                                        <div class="form-group">
                                        <select  id='status' class="form-select txt-num  @error('status') is-invalid @enderror" value="" name="status" >
                                                <option value="">--select--</option>
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
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and Update</button>
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
                            <th>ID</th>                           
                            <th>Company Name</th> 
                            <th>Bank Name</th>
                            <th>IFSC</th> 
                            <th>Account Number</th> 
                            <th>IMCR</th> 
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
                            <td><?= $val->company ?></td>
                            <td><?= $val->bank_name ?></td>
                            <td><?= $val->ifsc ?></td>
                            <td><?= $val->account_number ?></td>
                            <td><?= $val->imcr ?></td>

                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               


                            <td><a href="javascript:void(0)" data-id="<?= $val->id ?>" class="btn btn-primary edit_form "><i class="fa fa-edit"></i></a>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="Bank_master" class='btn btn-info change'>status</button></td>

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
			$("#table").val('Payment');
          $("#check_status").text(check_status).css('color','red');
           $(".change_status").modal('show');
		   
    });

        $('form[id="form"]').validate({
        rules: {
            company_id: 'required',
            bank_name: 'required',
            ifsc: 'required',
            account_number: 'required',
            imcr: 'required',

            status: 'required',
        },
        messages: {
            company_id: 'This Company Name is Required',
            bank_name: 'This Bank Name is Required',
            ifsc: 'This IFSC Code is required',
            account_number: 'This  Account Number required',
            imcr: 'This IMCR Number required',

            status: 'This Status is Required',
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
        id=$(this).data('id');
        var table='Bank_master';
        var url = "<?php echo url('/editMasters'); ?>/" + id+"/"+table;
            $.ajax({
                type: 'GET',
                url: url,                              
                success: function(data) {   
                    if(data != 1){
                        var row = JSON.parse(data);                       
                        $("#company_id").val(row.company_id).select2();
                        $("#bank_name").val(row.bank_name);
                        $("#ifsc").val(row.ifsc);
                        $("#account_number").val(row.account_number);
                        $("#imcr").val(row.imcr);

                        
                        $("#status").val(row.status).select2();     
                        $("#id").val(row.id);           
                        $(".card-title").html('Bank Master').css('color','blue');                  
                        $("#payment_mode").focus();
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

        $('#datatable').DataTable({
            "ordering": false
        });
        
        

        
       
    });
</script>
@endsection