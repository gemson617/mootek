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
                            <h3 class="card-title"> Tax</h3>
                        </div>
                          
                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif 
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                            @endif 
                            <form id="form" method="post" action="{{route('tax.store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id' value="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for=""> Tax Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" id='tax_name' class="form-control  @error('tax_name') is-invalid @enderror" value="" name="tax_name" placeholder="Tax Name"/>
                                        </div>
                                        @error('tax_name')
                                        <div class="error">*The Tax Name field is required.</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for=""> Tax %<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="number" placeholder="Tax Percentage" id='name' class="form-control  @error('name') is-invalid @enderror" value="" name="name" />
                                        </div>
                                        @error('name')
                                        <div class="error">*The Tax field is required.</div>
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
                                    
                                    {{-- <div class="col-md-8">
                                        <label for=""> Query Execution</label>
                                        <div class="form-group">
                                            <textarea type="text" id='iddd'  class="form-control" name='iddd'></textarea>
                                        </div>                                      
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Submit</button>
                                        <a href="" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
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
                            <th>Tax Name</th>
                            <th>Tax</th>
                            <th>Status</th>
                            <th>Action</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tax as $key=> $val)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$val->tax_name}}</td>
                            <td>{{$val->name}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               

                      <td><button value='{{$val->id}}' class='btn btn-primary edit_form'>Edit</button>
                        <button value='{{$val->id}}' data="{{$val->status}}" data-name="tax" class='btn btn-info change ml-2'>status</button>
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
            name: 'required',
            tax_name:'required',
        },
        messages: {
            name: 'This Tax Percentage is Required',
            tax_name:'This Tax Name required',
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
        // $('#datatable').DataTable({
        //     "ordering": false
        // });
        $(".edit_form").click(function(){
            id=$(this).val();
            $.ajax({
               type:'get',
               data:{
                id:id
               } ,
               url:"{{route('tax.index')}}",
               success: function(data)
                {
                    $("#name").val(data.data.name);
                    $("#tax_name").val(data.data.tax_name);
                    $(".card-title").html('Edit Tax').css('color','blue');
                       $("#id").val(data.data.id);
                    $("#name").focus();
                    scrollToTop();

                }
            }); 
        });
        $(".delete_modal").click(function(){
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
               url:"{{route('tax.delete')}}",
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