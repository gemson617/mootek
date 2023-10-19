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
                            <h3 class="card-title">Add Terms and Condition</h3>
                        </div>

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('terms.store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">

                                    <div class="col-md-8">
                                        <label for="">Terms Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" placeholder="Terms Name" id='terms' class="form-control" name="terms" />
                                        </div>
                                        @error('terms')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Details<span class="error">*</span></label>

                                        <div class="form-group">
                                        <textarea class="ckeditor form-control"  id='content' name="details"></textarea>
                                        </div>
                                        @error('details')
                                        <div class="error">*The terms & condition field is required.</div>
                                        @enderror
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

                <table id="datatable" class='table table-striped'>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Terms</th>
                            <th>Terms and Condition</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $val)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$val->terms}}</td>
                            <td>{!! $val->details !!}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                      <td><button value='{{$val->id}}' class='btn btn-primary edit_form'>Edit</button>
                        <button value='{{$val->id}}' data="{{$val->status}}" data-name="terms" class='btn btn-info change'>status</button>
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
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
                $('form[id="form"]').validate({
                    ignore: []  ,
        rules: {
            terms: 'required',
            details: 'required',
        },
        messages: {
            terms: 'This Terms   is Required',
            details: 'This Details is Required',
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
        $('.ckeditor').ckeditor();

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
    });
    $(".edit_form").click(function(){
            id=$(this).val();
            $.ajax({
               type:'get',
               data:{
                id:id
               } ,
               url:"{{route('terms.index')}}",
               success: function(data)
                {
                    $("#terms").val(data.data.terms);
                    // $("#ckeditor").val(data.data.details);
                    var value =data.data.details;
                    CKEDITOR.instances.content.setData(value);
                    // $('#details1').html(ckeditor.data.data.details);
                    $(".card-title").html('Edit Terms').css('color','red');
                       $("#id").val(data.data.id);
                    $("#name").focus();
                    scrollToTop();

                }
            });
        });


    $(document).ready(function() {
        // $('#datatable').DataTable({
        //     "ordering": false
        // });

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
               url:"{{route('terms.delete')}}",
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