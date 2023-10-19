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
                            <h3 class="card-title">Add holiday</h3>
                        </div>
                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id='form' method="post" action="{{route('holiday.store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">

                                    <div class="col-md-4">
                                        <label for="">Start Date<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="date" id='startDate' value="{{old('startDate')}}" placeholder="yyyy-mm-dd" class="form-control    @error('startDate') is-invalid @enderror" name="startDate" />
                                        </div>
                                        @error('startDate')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">End Date<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="date" id='endDate' class="form-control   @error('endDate') is-invalid @enderror" name="endDate" />
                                        </div>
                                        @error('endDate')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">holiday<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='name' class="form-control  @error('name') is-invalid @enderror" name="name" />
                                        </div>
                                        @error('name')
                                        <div class="error">*{{$message}}</div>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row pb-5">
                <table id="datatable" class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Holiday</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <?php
                            $startDate = date("d-m-Y", strtotime($val->startDate));
                            ?>
                            <td>{{$startDate}}</td>
                            <?php
                            $endDate = date("d-m-Y", strtotime($val->endDate));
                            ?>
                            <td>{{$endDate}}</td>
                            <td>{{$val->name}}</td>
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
    $(document).ready(function() {

        $('#datatable').DataTable({
            "ordering": false
        });
    });

    $(document).on('click','.edit_form',function(){
    // $(".edit_form").click(function() {
        id = $(this).val();
        $.ajax({
            type: 'get',
            data: {
                id: id
            },
            url: "{{route('holiday.index')}}",
            success: function(data) {
                console.log(data);
                $("#startDate").val(data.data.startDate);
                $("#endDate").val(data.data.endDate);
                $("#name").val(data.data.name);
                $(".card-title").html('Edit holiday').css('color', 'red');
                $("#startDate").focus();
                $("#id").val(data.data.id);
                scrollToTop();
            }
        });
    });

    $(document).on('click','.delete_modal',function(){

    // $(".delete_modal").click(function() {
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
            url: "{{route('holiday.delete')}}",
            success: function(data) {
                $("#delete_modal").modal('hide');
                document.location.reload()
            }
        });
    });


       
    $('form[id="form"]').validate({
        rules: {
            startDate: 'required',
            endDate: 'required',

            name: 'required',
        },
        messages: {
            startDate: 'This Start Date  is Required',
            endDate: 'This End Date  is Required',

            name: 'This Holiday is Required',
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

    setTimeout(function() {
        $(".alert-danger").slideUp(500);
        $(".alert-success").slideUp(500);
    }, 2000);

    function loaddate() {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "/" + month + "/" + year;

    }
    loaddate();


   


</script>
@endsection