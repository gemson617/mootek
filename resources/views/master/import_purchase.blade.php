@extends('layouts.app')

@section('content')
<style>
</style>
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/ ?>
            <div class="row pb-5">

                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-header">
                            <h3 class="card-title">Import Purchase</h3>
                        </div>
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('status.storeStatus')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="table" id="table" value="import_purchase" />
                                <input type="hidden" id='id'  value='<?= isset($cid)?$cid:'';  ?>' name='id'>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Salutation</label>
                                        <select class="form-select txt-num  @error('sal_company') is-invalid @enderror data-input sal_company" id='sal_company' name="sal_company">
                                            @foreach($salutation as $val)
                                            <option value="{{$val->id}}" >{{$val->salutation_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Purchase Company<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" placeholder="Purchase Company" id='purchase_company' class="form-control   @error('purchase_company') is-invalid @enderror" value="{{old('purchase_company')?old('purchase_company'):(isset($purchase_company->purchase_company)?$purchase_company->purchase_company:'')}}" name="purchase_company" />
                                        </div>
                                        @error('purchase_company')
                                        <div class="error">*The Branch field is required.</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Address<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" placeholder="Address" id='address' class="form-control   @error('address') is-invalid @enderror" value="{{old('address')?old('address'):(isset($address->address)?$address->address:'')}}" name="address" />
                                        </div>
                                        @error('address')
                                        <div class="error">*The Address is required.</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="">Country<span class="error">*</span></label>

                                        <div class="form-group">
                                            <select  id='country' class="form-select txt-num  @error('country') is-invalid @enderror" value="" name="country" >
                                                <option value="">--Select--</option>
                                                @foreach ($country as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                             </select>
                                            {{-- <input type="text" id='country' class="form-control   @error('country') is-invalid @enderror" value="{{old('country')?old('country'):(isset($country->country)?$country->country:'')}}" name="country" /> --}}
                                        </div>
                                        @error('country')
                                        <div class="error">*The Country is required.</div>
                                        @enderror
                                    </div>
                                   
                                   
                                    
                                    <div class="col-md-3">
                                        <label for="">Pin Code<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" placeholder="Pin Code" id='pincode' class="form-control   @error('pincode') is-invalid @enderror" value="{{old('pincode')?old('pincode'):(isset($pincode->pincode)?$pincode->pincode:'')}}" name="pincode" />
                                        </div>
                                        @error('pincode')
                                        <div class="error">*The Pincode field is required.</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Skype ID</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Skype ID" id='skype_id' class="form-control @error('skype_id') is-invalid @enderror" value="" name="skype_id" />
                                        </div>
                                        @error('skype_id')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="">Salutation</label>
                                        <select class="form-select txt-num  @error('sal_contact_person') is-invalid @enderror data-input sal_contact_person" id='sal_contact_person' name="sal_contact_person">
                                            @foreach($salutation as $val)
                                            <option value="{{$val->id}}" >{{$val->salutation_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="">Contact Person<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Contact Person" id='contact_person' class="form-control @error('contact_person') is-invalid @enderror" value="" name="contact_person" />
                                        </div>
                                        @error('contact_person')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Mobile<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="number" placeholder="Mobile" id='mobile' class="form-control @error('mobile') is-invalid @enderror" value="" name="mobile" />
                                        </div>
                                        @error('mobile')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Email ID<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Email ID" id='email' class="form-control @error('email') is-invalid @enderror" value="" name="email" />
                                        </div>
                                        @error('email')
                                        <div class="error">*{{$message}}</div>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row pb-5">

                <table id="datatable" class="table table-striped " style="width:100%;">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Contact Person</th>
                            <th>Mobile No</th>
                            <th>Email ID</th>
                            <th>Skype ID</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datatable as $val)
                        <tr>
                            <td>{{$val->purchase_company}}</td>
                            <td>{{$val->contact_person}}</td>
                            <td>{{$val->mobile}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->skype_id}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               

                            <td><button value='{{$val->id}}' class='btn btn-primary edit_form'><i class="fa fa-edit"></i></button>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="import_purchase" class='btn btn-info change'>status</button>

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
    $(".change").click(function(){    
    status=$(this).attr('data');
        check_status =status=='0'?'Active':'InActive';
        change =status=='0'?'1':'0';
        status_id=$(this).attr('data-id');
        $("#changestatus").val(change);
        $("#change_id").val(status_id);
        $("#table").val('company');
      $("#check_status").text(check_status).css('color','red');
       $(".change_status").modal('show');
       
});

   $(document).ready(function() {

    setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
}); 

$('form[id="form"]').validate({
        rules: {
            purchase_company: {
                    required: true,
                    remote: {
                        url: "{{route('exit.index') }}", // Laravel route for email validation
                        type: "post", // HTTP request method
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token
                            name: function () {
                                return $("#purchase_company").val();
                            },
                            id: function () {
                                 return $("#id").val(); // Replace with the actual input ID
                            },
                            table: function () {
                                 return $("#table").val(); // Replace with the actual input ID
                            },
                            column: function () {
                                 return 'purchase_company'; // Replace with the actual input ID
                            },
                        },
                     },
                     },
        address: 'required',
        pincode: 'required',
        country: 'required',
        contact_person: 'required',
        skype_id: 'required',
        mobile: {
        required: true,
        number: true, // This rule ensures that the input is a valid number
        pattern:/^[0-9]{10}$/
        },
        email: {
        required: true,
        email: true
        },
        },
        messages: {
            purchase_company: {
                    required: "This Purchase Company  Name is Required",
                    remote: "Purchase Company already exists",
                },
        address: 'This Address is required',
        country: 'This Country is required',
        skype_id: 'This Skype   is required',
        pincode: 'Pincode is Required',
        mobile: {
        required: 'This  Mobile  is Required',
        number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            pattern:'Enter 10 Digit number Only!'
            },
            email: {
        required: 'This  Email  is Required',
        email: 'Please enter a valid email address'
        },
        contact_person: 'This Contact Person is Required',
        },
        errorPlacement: function(label, element) {
        label.addClass('mt-2 text-danger');
        if (element.hasClass('form-select') && element.next('.select2-container').length) {
        label.insertAfter(element.next('.select2-container'));
        } else {
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

$(document).on('click', '.delete_modal', function() {
    // $(".delete_modal").click(function(){
    id = $(this).val();
    $("#delete_id").val(id);
    $("#delete_modal").modal('show');
});
$(document).on('click', '.delete', function() {
    id = $('#delete_id').val();
    $.ajax({
        url: "{{route('branch.exp_delete')}}",

        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
            id: id,

        },
        success: function(data) {
            $("#delete_modal").modal('hide');
            document.location.reload()
        }
    });
});


$(document).on('click', '.edit_form', function() {    
    id=$(this).val();
    var table='import_purchase';
    var url = "<?php echo url('/editMasters'); ?>/" + id+"/"+table;
        $.ajax({
            type: 'GET',
            url: url,                              
            success: function(data) {
                console.log(data);   
                if(data != 1){
                    var row = JSON.parse(data);    
                    console.log(row);                   
                    $("#purchase_company").val(row.purchase_company);
                    $("#sal_company").val(row.sal_company).select2();
            $("#address").val(row.address);
            $("#country").val(row.country).select2();
            $("#skype_id").val(row.skype_id);
            $("#pincode").val(row.pincode);
            $("#mobile").val(row.mobile);
            $("#email").val(row.email);
            $("#sal_contact_person").val(row.sal_contact_person).select2();
            $("#contact_person").val(row.contact_person);
            $(".card-title").html('Edit Import Purchase').css('color', 'blue');
            $("#purchase_company").focus();
            $("#id").val(row.id);

            $("#status").val(row.status).select2();

            // $("#tax").val(data.data.tax).select2();
            scrollToTop();
                }               
            },
            error: function(data) {
                console.log(data);
            }
        });
});





// });
</script>
@endsection