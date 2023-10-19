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
                            <h3 class="card-title">Add Agreement</h3>
                        </div>

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('add.agreement')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">

                                    <div class="col-md-8">
                                        <label for="">Heading Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='title' class="form-control @error('title') is-invalid @enderror" name="title" />
                                        </div>
                                        @error('title')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Content<span class="error">*</span></label>

                                        <div class="form-group">
                                            <textarea class="ckeditor form-control" id='content' name="content"></textarea>
                                        </div>
                                        @error('content')
                                        <div class="error">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to list</button>
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
                            <th>ID</th>
                            <th>Heading Name</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key=>$val)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$val->title}}</td>
                            <td><?php echo  $val->content ; ?></td>
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
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    $('form[id="form"]').validate({
        ignore: [],
        rules: {
            title: 'required',
            content:{
                ckrequired:'required',
            } ,
        },
        messages: {
            title: 'This Heading Name  is Required',
            content: 'This Content is Required',
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
    jQuery.validator.addMethod('ckrequired', function(value, element, params) {
        var idname = jQuery(element).attr('id');
        var messageLength = jQuery.trim(CKEDITOR.instances[idname].getData());
        return !params || messageLength.length !== 0;
    }, "This  Content is Required");
    $(document).ready(function() {
        $('.ckeditor').ckeditor();

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
    });

    // $(document).on('click','.edit_form',function(){
    $(".edit_form").click(function(){
            id=$(this).val();

            console.log(id);
            $.ajax({
               type:'get',
               data:{
                id:id
               } ,
               url:"{{route('invoice.agreement.index')}}",
               success: function(data)
                {
                    console.log(data);
                    $("#title").val(data.data.title);
                    $("#companyID").val(data.company);
                    // $("#ckeditor").val(data.data.details);
                    var value =data.data.content;
                    CKEDITOR.instances.content.setData(value);
                    // $('#details1').html(ckeditor.data.data.details);
                    $(".card-title").html('Edit Agreement').css('color','red');
                       $("#id").val(data.data.id);
                    $("#title").focus();
                    scrollToTop();

                }
            });
        });

        $(".delete_modal").click(function(){
            id=$(this).val();
            $("#delete_id").val(id);
          $("#delete_modal").modal('show');
        });
        $(document).on('click','#delete',function(){
        // $("#delete").click(function(){
            id=$('#delete_id').val();
            $.ajax({
               type:'post',
               data:{
                "_token": "{{ csrf_token() }}",
                id: id,

            },
            url: "{{route('delete.agreement')}}",
            success: function(data) {
                $("#delete_modal").modal('hide');
                document.location.reload()
            }
        });
    });


    $(document).ready(function() {
        $('#datatable').DataTable({
            "ordering": false
        });


    });
</script>
@endsection