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
                            <h3 class="card-title">Add Local Purchase</h3>
                        </div>
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('status.storeStatus')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="table" id="table" value="local_purchase" />
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
                                        <div class="error">*The Branch field is required.</div>
                                        @enderror
                                    </div>
                                   
                                    <div class="col-md-3">
                                        <label for="">State </label> <a class="fa fa-plus-circle" href="/state"></a>
                                        <div class="form-group">

                                            <select class="form-select txt-num  @error('state') is-invalid @enderror state" onchange="get_city(this.value,'');" id='state' name="state">
                                                <option value="">--Select--</option>
                                                @foreach($states as $val)
                                                <option value="{{$val->id}}"  >{{$val->state_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('state')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">City </label> <a class="fa fa-plus-circle" href="/city"></a>
                                        <div class="form-group">
                                            <select class="form-select txt-num  @error('city') is-invalid @enderror city" id='city' name="city">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        @error('city')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Pin Code<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Pin Code" id='pincode' class="form-control   @error('pincode') is-invalid @enderror" value="{{old('pincode')?old('pincode'):(isset($pincode->pincode)?$pincode->pincode:'')}}" name="pincode" />
                                        </div>
                                        @error('pincode')
                                        <div class="error">*The Branch field is required.</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">GST</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="GST" id='gst' class="form-control @error('gst') is-invalid @enderror" value="" name="gst" />
                                        </div>
                                        @error('gst')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">PAN</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="PAN" id='pan' class="form-control @error('pan') is-invalid @enderror" value="" name="pan" />
                                        </div>
                                        @error('pan')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">TAN</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="TAN" id='tan' class="form-control @error('tan') is-invalid @enderror" value="" name="tan" />
                                        </div>
                                        @error('tan')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="">MSME Registeration </label>
                                        <div class="form-group">
                                            <input type="text" placeholder="MSME Registeration" id='msme_reg_no' class="form-control @error('msme_reg_no') is-invalid @enderror" value="" name="msme_reg_no" />
                                        </div>
                                        @error('msme_reg_no')
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
                                        <label for="">Contact Person</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Contact Person" id='contact_person' style="text-transform:uppercase" class="form-control @error('contact_person') is-invalid @enderror" value="" name="contact_person" />
                                        </div>
                                        @error('contact_person')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Contact Mobile</label>
                                        <div class="form-group">
                                            <input type="number" placeholder="Contact Mobile" id='contact_mobile' class="form-control @error('contact_mobile') is-invalid @enderror" value="" name="contact_mobile" />
                                        </div>
                                        @error('contact_mobile')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Contact Email ID</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Contact Email ID" id='conatct_email' class="form-control @error('conatct_email') is-invalid @enderror" value="" name="conatct_email" />
                                        </div>
                                        @error('conatct_email')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Accounts Contact Person</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Accounts Contact Person" id='accounts_person' style="text-transform:uppercase" class="form-control @error('accounts_person') is-invalid @enderror" value="" name="accounts_person" />
                                        </div>
                                        @error('accounts_person')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Mobile</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Mobile" id='account_mobile' class="form-control @error('account_mobile') is-invalid @enderror" value="" name="account_mobile" />
                                        </div>
                                        @error('account_mobile')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Email ID</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Email ID" id='account_email' class="form-control @error('account_email') is-invalid @enderror" value="" name="account_email" />
                                        </div>
                                        @error('account_email')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class='row'>
                                    <h6>Credit Terms</h6>
                                    <div class="col-md-3">
                                        <label for="">Days</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Days" id='credit_days' class="form-control @error('credit_days') is-invalid @enderror" value="" name="credit_days" />
                                        </div>
                                        @error('credit_days')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <label for="">Advance</label>
                                        <div class="form-group">
                                            <input type="text" id='credit_advance' class="form-control @error('credit_advance') is-invalid @enderror" value="" name="credit_advance" />
                                        </div>
                                        @error('credit_advance')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="col-md-3">
                                        <label for="">Select Tax<span class="error"> * </span><a class="fa fa-plus-circle" href="/tax"></a></label>
                                        <div class="form-group">
                                            <select  id='credit_tax' class="form-select txt-num  @error('active') is-invalid @enderror" value="" name="credit_tax" >
                                               <option value="">--Select--</option>
                                               @foreach ($tax as $val)
                                               <option value="{{$val->name}}">{{$val->tax_name}} @({{$val->name}}%)</option>
                                               @endforeach
                                            </select>
                                            @error('credit_tax')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">CESS</label>
                                        <div class="form-group">
                                            <input type="number" placeholder="CESS" id='credit_cess' class="form-control @error('credit_cess') is-invalid @enderror" value="" name="credit_cess" />
                                        </div>
                                        @error('credit_cess')
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
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datatable as $val)
                        <tr>
                            <td>{{$val->purchase_company}}</td>
                            <td>{{$val->address}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               

                            <td><button value='{{$val->id}}' class='btn btn-primary edit_form'><i class="fa fa-edit"></i></button>
                            <button value='{{$val->id}}' data="{{$val->status}}" data-name="local_purchase" class='btn btn-info change'>status</button>
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
        // $('#datatable').DataTable({
        //     "ordering": false
        // });
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
        state: 'required',
        city: 'required',
        pincode: 'required',
        gst: {
        required: true,
        
        gstFormat: true, // Use our custom GST format validation method
        },
        contact_mobile: {
        required: true,
        number: true, // This rule ensures that the input is a valid number
        pattern:/^[0-9]{10}$/
        },
        pan: {
        required: true,
        pattern: /^[A-Z]{5}[0-9]{4}[A-Z]$/ // Regular expression pattern for alphanumeric input
        },
        tan: 'required',
        msme_reg_no: 'required',
        conatct_email: {
        required: true,
        email: true
        },
        account_mobile: {
        required: true,
        number: true, // This rule ensures that the input is a valid number
            pattern:/^[0-9]{10}$/
            },
            account_email: {
            required: true,
            email: true
            },
            credit_days: 'required',
            credit_advance: 'required',
            credit_tax: 'required',
            credit_cess: {
                required: true,
                number: true, // This rule ensures that the input is a valid number
                    },
          contact_person: 'required',
        accounts_person: 'required',
        },
        messages: {
            purchase_company: {
                    required: "This Purchase Company  Name is Required",
                    remote: "Purchase Company already exists",
                },
        address: 'This Address is required',
        state: 'This state is required',
        city: 'This City is required',
        pincode: 'This Pincode is required',
        gst: {
        required: "GST  is required.",
        gstFormat: "Invalid GST Number format.",
        },
        pan: {
        required: "PAN is Required",
        pattern: "Please Enter valid PAN number."
        },
        tan: 'This  TAN  is Required',

        msme_reg_no: 'This MSME is required',
        contact_mobile: {
        required: 'This  Mobile  is Required',
        number: 'Please enter a valid number', // This rule ensures that the input is a valid number
        pattern:'Enter 10 Digit number Only!'
        },
        conatct_email: {
        required: 'This  Email  is Required',
        email: 'Please enter a valid email address'
        },
        account_mobile: {
            required: 'This  Mobile  is Required',
            number: 'Please enter a valid number', // This rule ensures that the input is a valid number
                pattern:'Enter 10 Digit number Only!'
                },
                account_email: {
                required: 'This  Email  is Required',
                email: 'Please enter a valid email address'
                },
                credit_days: 'This Credit Days is required',
                credit_advance: 'This Credit Advance is required',
                credit_tax: 'This Tax is required',
                credit_cess: {
        required: 'CESS Percentage is Required',
        number: 'Please enter a valid number', // This rule ensures that the input is a valid number
        },
        contact_person: 'This Contact Person is Required',
        accounts_person: 'This Account Person is Required',
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


    // $(document).on('click', '.edit_form', function() {    
    //     id=$(this).data('id');
    //     var table='local_purchase';
    //     var url = "<?php echo url('/editMasters'); ?>/" + id+"/"+table;
    //         $.ajax({
    //             type: 'GET',
    //             url: url,                              
    //             success: function(data) {
    //                 console.log(data);   
    //                 if(data != 1){
    //                     var row = JSON.parse(data);    
    //                     console.log(row);                   
    //                     $("#purchase_company").val(row.purchase_company);
    //                     $("#sal_company").val(row.sal_company).select2();
    //             $("#address").val(row.address);
    //             $("#tan").val(row.tan);
    //             $("#msme_reg_no").val(row.msme_reg_no);
    //             $("#sal_contact_person").val(row.sal_contact_person).select2();
    //             $("#contact_person").val(row.contact_person);
    //             $("#contact_mobile").val(row.contact_mobile);
    //             $("#conatct_email").val(row.conatct_email);
    //             $("#pincode").val(row.pincode);
    //             $("#accounts_person").val(row.accounts_person);
    //             $("#account_mobile").val(row.account_mobile);
    //             $("#account_email").val(row.account_email);
    //             $("#credit_days").val(row.credit_days);
    //             $("#credit_advance").val(row.credit_advance);
    //             $("#credit_cess").val(row.credit_cess);
    //             $("#credit_tax").val(row.credit_tax).select2();
    //                 $(".state").val(row.state).select2();
    //                 $(".city").val(row.city).select2();
    //             $(".card-title").html('Edit Company').css('color', 'red');
    //             $("#purchase_company").focus();
    //             $("#id").val(row.id);
    //             $(".state").val(row.state).select2();
    //             $(".city").val(row.city).select2();
    //             $("#status").val(row.status).select2();

    //             // $("#tax").val(data.data.tax).select2();
    //             scrollToTop();
    //                 }               
    //             },
    //             error: function(data) {
    //                 console.log(data);
    //             }
    //         });
    // });

    // $(document).ready(function() {

    $(document).on('click', '.edit_form', function() {
        // $(".edit_form").click(function(){
            var table='local_purchase';
        id = $(this).val();
        // alert('hi');
        var url = "<?php echo url('/editMasters'); ?>/" + id+"/"+table;
        $.ajax({
            type: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            url: url,
            success: function(data) {
               
                if(data != 1){
                        var row = JSON.parse(data);    
                        console.log(row);  
                $("#sal_company").val(row.sal_company).select2();
                $("#purchase_company").val(row.purchase_company);
                $("#address").val(row.address);
                $("#tan").val(row.tan);
                $("#gst").val(row.gst);
                $("#pan").val(row.pan);
                $("#msme_reg_no").val(row.msme_reg_no);
                $("#sal_contact_person").val(row.sal_contact_person).select2();
                $("#contact_person").val(row.contact_person);
                $("#contact_mobile").val(row.contact_mobile);
                $("#conatct_email").val(row.conatct_email);
                $("#pincode").val(row.pincode);
                $("#accounts_person").val(row.accounts_person);
                $("#account_mobile").val(row.account_mobile);
                $("#account_email").val(row.account_email);
                $("#credit_days").val(row.credit_days);
                $("#credit_advance").val(row.credit_advance);
                $("#credit_cess").val(row.credit_cess);
                $("#credit_tax").val(row.credit_tax).select2();
                    $(".state").val(row.state).select2();
                    $(".city").val(row.city).select2();
                $(".card-title").html('Edit Company').css('color', 'red');
                $("#purchase_company").focus();
                $("#id").val(row.id);
                $(".state").val(row.state).select2();
                $(".city").val(row.city).select2();
                $("#status").val(row.status).select2();
                // $("#tax").val(data.data.tax).select2();
                scrollToTop();
                    }  
            }
        });
    });





    // });
</script>
@endsection