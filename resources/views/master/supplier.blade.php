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
                            <h3 class="card-title">Add Supplier (or) Vendor</h3>
                        </div>
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('supplier.index')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">

                                    <div class="col-md-4">
                                        <label for=""> Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" id='supplier_name' class="form-control   @error('supplier_name') is-invalid @enderror" placeholder="Enter Name" name="supplier_name" />
                                        </div>
                                        @error('supplier_name')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Contact Name</label>

                                        <div class="form-group">
                                            <input type="text" id='contact_person' class="form-control" placeholder="Enter Contact Person" name="contact_person" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Email</label>

                                        <div class="form-group">
                                            <input type="text" id='email' class="form-control " placeholder="Enter Email" name="email" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Phone Number<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="number" required id='phone_number' class="form-control txt-num" placeholder="Enter Phone Number" name="phone_number" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for=""> Address Line 1</label>

                                        <div class="form-group">
                                            <input type="text" id='address_line1' class="form-control " placeholder="Enter Address1" name="address_line1" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Address Line 2</label>

                                        <div class="form-group">
                                            <input type="text" id='address_line2' class="form-control " placeholder="Enter Address2" name="address_line2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Country</label>
                                        <input type="hidden" name="country" value="101">
                                        <div class="form-group">
                                            <select id='country' class="form-select   @error('country') is-invalid @enderror" onchange="get_state(this.value);" name="country" disabled>
                                                <option value="">--Select--</option>
                                                @foreach($country as $val)
                                                <option value="{{$val->id}}" <?php echo $val->id == 101 ? 'selected' : ' ' ?>>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                            <!-- <input type="text" id='country' class="form-control @error('country') is-invalid @enderror" value="" name="country" /> -->
                                        </div>
                                        @error('country')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">State</label>
                                        <div class="form-group">

                                            <select class="form-select   @error('state') is-invalid @enderror state" onchange="get_city(this.value);" id='state' name="state">
                                                <option value="">--Select--</option>
                                                @foreach($states as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for=""> City</label>

                                        <div class="form-group">
                                            <select class="form-select   @error('city') is-invalid @enderror city" id='city' name="city">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        @error('city')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Pincode</label>

                                        <div class="form-group">
                                            <input type="number" id='pincode' class="form-control " placeholder="Enter Pincode" name="pincode" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> GST No</label>
                                        <div class="form-group">
                                            <input type="text" id='gst' class="form-control txt-num" placeholder="GST" name="gst" style="text-transform:uppercase" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Select Supplier or Vendor Scrap</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="1" name='mgt_status' id="mgt_status">
                                            <label class="form-check-label" for="">
                                                Supplier
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="2" name='mgt_status' id="mgt_status" checked>
                                            <label class="form-check-label" for="">
                                                Vendor Scrap
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and Update</button>
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
                            <!-- <th>ID</th> -->

                            <th> Name</th>
                            <th>Email</th>
                            <th>Ph NO</th>
                            <th>Supplier or Vendor Scrap</th>
                            <th>GST</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <!-- <td>{{$val->id}}</td> -->
                            <td>{{$val->supplier_name}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->phone_number}}</td>
                            <td>{{$val->mgt_status=='1'?'Supplier':'Vendor Scrap'}}</td>
                            <td>{{$val->gst}}</td>
                            <td><i class="fa fa-edit edit_form mr-2" data='{{$val->supplier_id}}' style="font-size:22px;color:blue"></i><i class="fa fa-trash delete_modal" data="{{$val->supplier_id}}" style="font-size:22px;color:red"></i></td>
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
            supplier_name: 'required',
            phone_number: {
                required: true,
                phoneUS: true,
            },
        },
        messages: {
            supplier_name: 'This Supplier Name  is Required',
            phone_number: {
                required: "This Phone Number is required",
                phoneUS: 'Please Enter Valid Number',
            },

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
    $(".delete_modal").click(function() {
        id = $(this).attr('data');
        $("#delete_id").val(id);
        $("#delete_modal").modal('show');
    });
    $(document).on('click','#delete',function(){
        id = $('#delete_id').val();
        $.ajax({
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
            },
            url: "{{route('supplier.delete')}}",
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
        $(".edit_form").click(function() {
            id = $(this).attr('data');
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{route('supplier.index')}}",
                success: function(data) {
                    $("#supplier_name").val(data.data.supplier_name);
                    $("#contact_person").val(data.data.contact_person);
                    $("#email").val(data.data.email);
                    $("#phone_number").val(data.data.phone_number);
                    $("#address_line1").val(data.data.address_line1);
                    $("#address_line2").val(data.data.address_line2);
                    $("#gst").val(data.data.gst);
                    $("#pincode").val(data.data.pincode);
                    $("#country").val(data.data.country).select2();
                    $("#state").val(data.data.state).select2();

                    $('#city').empty();
                    $('#city')
                        .append($("<option></option>")
                            .attr('selected', true)
                            .attr('value', data.data.c_id)
                            .text(data.data.c_name));
                    $("input[name=mgt_status][value=" + data.data.mgt_status + "]").prop('checked', true);

                    $("#id").val(data.data.supplier_id);
                    $(".card-title").html('Edit Supplier').css('color', 'red');
                    $("#name").focus();

                    scrollToTop();
                }
            });
        });


    });
</script>
@endsection