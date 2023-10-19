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
                            <h3 class="card-title">Add Vendor </h3>
                        </div>

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form method="post" action="{{route('vendor.index')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Vendor Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" id='name' class="form-control   @error('name') is-invalid @enderror" value="" name="name" />
                                        </div>
                                        @error('name')
                                        <div class="error">*The Vendor name is required.</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Contact Name</label>

                                        <div class="form-group">
                                            <input type="text" id='contact_person' class="form-control " value="" name="contact_person" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Email</label>

                                        <div class="form-group">
                                            <input type="text" id='email' class="form-control " value="" name="email" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Phone Number</label>

                                        <div class="form-group">
                                            <input type="text" id='phone_number' class="form-control " value="" name="phone_number" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Address Line 1</label>

                                        <div class="form-group">
                                            <input type="text" id='address_line1' class="form-control " value="" name="address_line1" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Address Line 2</label>

                                        <div class="form-group">
                                            <input type="text" id='address_line2' class="form-control" value="" name="address_line2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> city</label>

                                        <div class="form-group">
                                            <input type="text" id='city' class="form-control " value="" name="city" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> pincode</label>

                                        <div class="form-group">
                                            <input type="text" id='pincode' class="form-control " value="" name="pincode" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> GST No</label>

                                        <div class="form-group">
                                            <input type="text" id='gst' class="form-control " value="" name="gst" />
                                        </div>
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

                        <th>name</th>
                    <th>contact_person</th>
                    <th>email</th>
                    <th>phone_number</th>
                    <th>address_line1</th>  
                    <th>address_line2</th>
                    <th>city</th>
                    <th>gst</th>
                    <th>pincode </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->contact_person }}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->phone_number}}</td>
                            <td>{{$val->address_line1}}</td>
                            <td>{{$val->address_line2}}</td>
                            <td>{{$val->city}}</td>
                            <td>{{$val->gst}}</td>
                            <td>{{$val->pincode}}</td>
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
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
    });

    $(document).ready(function() {
        $('#datatable').DataTable({
            "ordering": false
        });
        $(".edit_form").click(function(){
            id=$(this).val();
            $.ajax({
               type:'get',
               data:{
                id:id
               } ,
               url:"{{route('vendor.index')}}",
               success: function(data)
                {
                    $("#name").val(data.data.name);
                    $("#contact_person").val(data.data.contact_person);
                    $("#email").val(data.data.email);
                    $("#phone_number").val(data.data.phone_number);
                    $("#address_line1").val(data.data.address_line1);
                    $("#address_line2").val(data.data.address_line2);
                    $("#city").val(data.data.city);
                    $("#gst").val(data.data.gst);
                    $("#pincode").val(data.data.pincode);

                    $(".card-title").html('Edit Vendor').css('color','red');
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
               url:"{{route('vendor.delete')}}",
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