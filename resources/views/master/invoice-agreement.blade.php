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
                            <form method="post" action="{{route('add.invoice.agreement')}}">
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
                                        <textarea class="ckeditor form-control"  id='content' name="content"></textarea>
                                        </div>
                                        @error('content')
                                        <div class="error">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#" onclick="location.reload()" class="btn btn-sm btn-primary mr-1">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to list</button>
                                        <a href="#" onclick="location.reload()" class="btn btn-sm btn-danger mr-1">Cancel</a>
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
                        @foreach($data as $val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->title}}</td>
                            <td>{{$val->content}}</td>
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

        $(".edit_form").click(function(){
            id=$(this).val();
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
                    var value =data.content;
                    CKEDITOR.instances.content.setData(value);
                    // $('#details1').html(ckeditor.data.data.details);
                    $(".card-title").html('Edit Agreement').css('color','red');
                       $("#id").val(data.id);
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
        $("#delete").click(function(){
            id=$('#delete_id').val();
            $.ajax({
               type:'post',
               data:{
                "_token": "{{ csrf_token() }}",
                id:id,
                
               } ,
               url:"{{route('delete.invoice.agreement')}}",
               success: function(data)
                {
                   $("#delete_modal").modal('hide');
                   document.location.reload()
                }
            }); 
        });

        $('.ckeditor').ckeditor(); 
        
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
  
       

 
        $('#datatable').DataTable({
            "ordering": false
        });

</script>
@endsection