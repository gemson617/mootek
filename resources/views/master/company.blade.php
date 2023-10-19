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
                            <h3 class="card-title">Add Company</h3>
                        </div>
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('company.company_store')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id='id'  value='<?= isset($cid)?$cid:'';  ?>' name='id'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" id='company' placeholder="Name" class="form-control   @error('company') is-invalid @enderror" value="{{old('company')?old('company'):(isset($company->company)?$company->company:'')}}" name="company" />
                                        </div>
                                        @error('company')
                                        <div class="error">*The Branch field is required.</div>
                                        @enderror
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <label for=""> Contact Name</label>

                                        <div class="form-group">
                                            <input type="text" id='contact_person' class="form-control " value="" name="contact_person" />
                                        </div>
                                    </div> -->
                                    <div class="col-md-4">
                                        <label for="">Email</label>

                                        <div class="form-group">
                                            <input type="text" placeholder="Email" id='email' class="form-control @error('email') is-invalid @enderror" value="{{old('email')?old('email'):(isset($company->email)?$company->email:'')}}" name="email" />
                                        </div>
                                        @error('email')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Contact No<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="number" placeholder="Contact No"  id='phone_number' class="form-control @error('phone_number') is-invalid @enderror" value="{{old('phone_number')?old('phone_number'):(isset($company->phone_number)?$company->phone_number:'')}}" name="phone_number" />
                                        </div>
                                        @error('phone_number')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Address Line 1<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" placeholder=" Address Line 1" id='address_line1' class="form-control @error('address_line1') is-invalid @enderror" value="{{old('address_line1')?old('address_line1'):(isset($address_line1)?$address_line1:'')}}" name="address_line1" />
                                        </div>
                                        @error('address_line1')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Address Line 2</label>
                                        <div class="form-group">
                                            <input type="text" placeholder=" Address Line 2" id='address_line2' class="form-control @error('address_line2') is-invalid @enderror" value="{{old('address_line2')?old('address_line2'):(isset($address_line2)?$address_line2:'')}}" name="address_line2" />
                                        </div>
                                        @error('address_line2')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
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

                                    <div class="col-md-4">
                                        <label for=""> City </label> <a class="fa fa-plus-circle" href="/city"></a>

                                        <div class="form-group">
                                            <select class="form-select txt-num  @error('city') is-invalid @enderror city" id='city' name="city">
                                                <option value="">--Select--</option>
                                               
                                            </select>
                                        </div>
                                        @error('city')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>

{{-- 
                                    <div class="col-md-4">
                                        <label for=""> Country</label>
                                            <input type="hidden" value="101" name="country">
                                        <div class="form-group">
                                            <select id='country' class="form-select txt-num  @error('country') is-invalid @enderror" onchange="get_state(this.value);" name="country" disabled>
                                                <option value="">--Select--</option>
                                                @foreach($country as $val)
                                                <option value="{{$val->id}}" <?php echo $val->id == 101 ?'selected':'' ?> >{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                            <!-- <input type="text" id='country' class="form-control @error('country') is-invalid @enderror" value="" name="country" /> -->
                                        </div>
                                        @error('country')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div> --}}


                                    <div class="col-md-4">
                                        <label for=""> Pincode<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" placeholder="Pincode" id='pincode' class="form-control @error('pincode') is-invalid @enderror" value="{{old('pincode')?old('pincode'):(isset($pincode)?$pincode:'')}}" name="pincode" />
                                        </div>
                                        @error('pincode')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> GST<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="text" placeholder="GST" id='gst' class="form-control @error('gst') is-invalid @enderror " value="{{old('gst')?old('gst'):(isset($gst)?$gst:'')}}" name="gst" style="text-transform:uppercase" />
                                        </div>
                                        @error('gst')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Bank Name</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Bank Name" id='bank_name' class="form-control  @error('bank_name') is-invalid @enderror" name="bank_name" />

                                     
                                            {{-- <input type="Text" id='bank_name' class="form-control  @error('bank_name') is-invalid @enderror" value="{{old('bank_name')?old('bank_name'):(isset($bank_name)?$bank_name:'')}}" name="bank_name" /> --}}
                                            @error('bank_name')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="">Account Number</label>
                                        <div class="form-group">
                                            <input type="number" placeholder="Account Number" id='acc_no' class="form-control  @error('acc_no') is-invalid @enderror" value="{{old('acc_no')?old('acc_no'):(isset($acc_no)?$acc_no:'')}}" name="acc_no" />
                                            @error('acc_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="">IFSC Code</label>
                                        <div class="form-group">
                                            <input type="Text" placeholder="IFSC Code" id='ifsc' class="form-control  @error('ifsc') is-invalid @enderror" value="{{old('ifsc')?old('ifsc'):(isset($ifsc)?$ifsc:'')}}" name="ifsc" />
                                            @error('ifsc')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- <div class="col-md-4">
                                        <label for="">Lattitude</label>
                                        <div class="form-group">
                                            <input type="Text" placeholder="Lattitude" id='lattitude' class="form-control  @error('lattitude') is-invalid @enderror" value="{{old('lattitude')?old('lattitude'):(isset($lattitude)?$lattitude:'')}}" name="lattitude" />
                                            @error('lattitude')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Longitude</label>
                                        <div class="form-group">
                                            <input type="Text" placeholder="Longitude" id='longitude' class="form-control  @error('longitude') is-invalid @enderror" value="{{old('longitude')?old('longitude'):(isset($longitude)?$longitude:'')}}" name="longitude" />
                                            @error('longitude')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    <div class="col-md-4">
                                        <label for="">Logo</label>
                                        <div class="form-group">
                                            <input type="file" id='imputlogo' class="form-control  @error('clogo') is-invalid @enderror" value="{{old('logo')}}" name="logo" />
                                            {{-- <img src="{{isset($company->logo)?$company->logo:''}}" alt="" id='logo_image' style="width: 12%;"> --}}
                                            <a href="" id='logo' class='pdf_file d-none'><i class="fa fa-download"></i></a>
                                            @error('logo')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <label for="">Purchase Prefix<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='purchase_prefix' placeholder="Purchase Prefix" class="form-control " value="{{old('purchase_prefix')?old('purchase_prefix'):(isset($purchase_prefix)?$purchase_prefix:'')}}" name="purchase_prefix" />
                                            @error('purchase_prefix')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Purchase Start<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='purchase_no' placeholder="Purchase Start" class="form-control" value="{{old('purchase_no')?old('purchase_no'):(isset($purchase_no)?$purchase_no:'')}}" name="purchase_no" />
                                            @error('purchase_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Status</label>

                                        <div class="form-group">
                                            <select id='status' class="form-select txt-num  @error('status') is-invalid @enderror" value="{{old('status')}}" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">In Active</option>
                                            </select>
                                            @error('status')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <label for="">Sale Prefix<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='sale_prefix' class="form-control " value="{{old('sale_prefix')?old('sale_prefix'):(isset($sale_prefix)?$sale_prefix:'')}}" name="sale_prefix" />
                                            @error('sale_prefix')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4">
                                        <label for="">Sale Start<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='sale_no' class="form-control" value="{{old('sale_no')?old('sale_no'):(isset($sale_no)?$sale_no:'')}}" name="sale_no" />
                                            @error('sale_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Rental Prefix<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='rental_prefix' class="form-control " value="{{old('rental_prefix')?old('rental_prefix'):(isset($rental_prefix)?$rental_prefix:'')}}" name="rental_prefix" />
                                            @error('rental_prefix')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Rental Start<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='rental_no' class="form-control" value="{{old('rental_no')?old('rental_no'):(isset($rental_no)?$rental_no:'')}}" name="rental_no" />
                                            @error('rental_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Quotation Prefix<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='quatation_prefix' class="form-control " value="{{old('quatation_prefix')?old('quatation_prefix'):(isset($quatation_prefix)?$quatation_prefix:'')}}" name="quatation_prefix" />
                                            @error('quatation_prefix')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Quotation Start<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='quatation_no' class="form-control" value="{{old('quatation_no')?old('quatation_no'):(isset($quatation_no)?$quatation_no:'')}}" name="quatation_no" />
                                            @error('quatation_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Lead Prefix<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='lead_prefix' class="form-control " value="{{old('lead_prefix')?old('lead_prefix'):(isset($lead_prefix)?$lead_prefix:'')}}" name="lead_prefix" />
                                            @error('lead_prefix')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Lead Start<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='lead_no' class="form-control" value="{{old('lead_no')?old('lead_no'):(isset($lead_no)?$lead_no:'')}}" name="lead_no" />
                                            @error('lead_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Proforma Prefix<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='proforma_prefix' class="form-control " value="{{old('proforma_prefix')?old('proforma_prefix'):(isset($proforma_prefix)?$proforma_prefix:'')}}" name="proforma_prefix" />
                                            @error('proforma_prefix')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Proforma Start<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="text" id='proforma_no' class="form-control" value="{{old('proforma_no')?old('proforma_no'):(isset($proforma_no)?$proforma_no:'')}}" name="proforma_no" />
                                            @error('proforma_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4">
                                        <label for="">Select Tax</label>

                                        <div class="form-group">
                                            <select class="form-select txt-num  @error('tax') is-invalid @enderror tax" id='tax' name="tax">
                                                <option value="">--Select--</option>
                                                <option value="1">GST</option>
                                                <option value="0">NON GST</option>
                                               
                                            </select>
                                        </div>
                                        @error('tax')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div> --}}

                                    
                              `  </div>
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
                            {{-- <th>ID</th> --}}
                            <th>company</th>
                            <th>email</th>
                            <th>phone_number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company as $val)
                        <tr>
                            {{-- <td>{{$val->id}}</td> --}}
                            <td>{{$val->company}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->phone_number}}</td>


                            <td><a style="text-decoration: none" href="javascript:void(0)"  class="badge <?= ($val->status == 1) ? 'badge-success' : 'badge-danger' ?>"><?= ($val->status == 0) ? 'In-Active' : 'Active' ?></a></td>

                            <td>
                                <button value='{{$val->id}}' class='btn btn-primary edit_form'><i class="fa fa-edit"></i></button>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="company" class='btn btn-info change'>status</button></td>
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
            // alert('ok');
        status=$(this).attr('data');
            check_status =status=='0'?'Active':'InActive';
            change =status=='0'?'1':'0';
            status_id=$(this).attr('data-id');
            $("#changestatus").val(change);
            $("#change_id").val(status_id);
			$("#table").val('company');
            if(check_status =='0'){
                $("#check_status").text(check_status).css('color','blue');
            }else{
                $("#check_status").text(check_status).css('color','red');
            }
         
           $(".change_status").modal('show');
		   
    });

       $(document).ready(function() {
        // $('#datatable').DataTable({
        //     "ordering": false
        // });
    }); 
    
    $('form[id="form"]').validate({
        rules: {
            company: 'required',
            phone_number: {
                required:true,
                minlength:10,
            },
            gst: {
                required:true,
                gstLength:true
            },
            purchase_prefix: 'required',
            purchase_no: 'required',
            sale_prefix: 'required',
            sale_no: 'required',
            rental_prefix: 'required',
            rental_no: 'required',
            quatation_prefix: 'required',
            quatation_no: 'required',
            lead_prefix: 'required',
            lead_no: 'required',
            proforma_prefix: 'required',
            proforma_no: 'required',
            tax:'required',
        },
        messages: {
            company: 'This Name is required',
            phone_number: {
                required:'This Contact No is required',
                minlength:'Minimum numer 10 is required',
            },
            pincode: 'This Pincode is required',
            gst: {
                required:'This GST is required',

            },
            purchase_prefix: ' Purchase Prefix is Required',
            purchase_no: 'Purchase Start  is Required',
            sale_prefix: 'Sale Prefix is Required',
            sale_no: ' Sale Start is Required',
            rental_prefix: 'Rental Prefix is Required',
            rental_no: 'Rental Start is Required',
            quatation_prefix: 'Quotation Prefix is Required',
            quatation_no: 'Quotation Start is Required',
            lead_prefix: 'Lead Prefix is Required',
            lead_no: 'Lead Start is Required',
            proforma_prefix: 'Porforma Prefix is required',
            proforma_no: 'Proforma No is required',
            tax:'Tax is required',

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

        $.validator.addMethod("gstLength", function(value, element) {
            return value.length === 15;
        }, "GST must be exactly 15 characters long.");

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


 

    // $(document).ready(function() {

    $(document).on('click', '.edit_form', function() {
        // $(".edit_form").click(function(){

        id = $(this).val();
        // alert('hi');
        $.ajax({
            type: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            url: "{{route('company.company_index')}}",
            success: function(data) {
                // console.log(data.data.city);
                $("#logo").click(function(event) {
                        event.preventDefault(); // Prevent the default link behavior (i.e., opening the URL in the current tab)
                        var url = $(this).attr('href'); // Get the URL from the link
                        window.open(url, '_blank'); // Open the URL in a new tab
                    });

                $("#logo").removeClass('d-none');
                console.log(data);
                $("#company").val(data.data.company);
                $("#contact_person").val(data.data.contact_person);
                $("#email").val(data.data.email);
                $("#phone_number").val(data.data.phone_number);
                $("#address_line1").val(data.data.address_line1);
                $("#address_line2").val(data.data.address_line2);
                $("#country").val(data.data.country).select2();
                    $(".state").val(data.data.state).select2();
                    $(".city").val(data.data.city).select2();
                    
                $("#gst").val(data.data.gst);
                // $("#bank_name").val(data.data.bank_name);
                $("#branch_name").val(data.data.branch_name);
                $("#acc_name").val(data.data.acc_name);
                $("#acc_no").val(data.data.acc_no);
                $("#prefix").val(data.data.prefix);
                $("#ifsc").val(data.data.ifsc);
                $("#pincode").val(data.data.pincode);
                $("#lattitude").val(data.data.lattitude);
                $("#longitude").val(data.data.longitude);
                $("#ilogo").val('hi');
                $("#logo_image").attr('src', data.data.logo);
                $("#logo").attr('href', data.data.logo);
                $("#purchase_prefix").val(data.data.purchase_prefix);
                $("#purchase_no").val(data.data.purchase_no);
                $("#sale_prefix").val(data.data.sale_prefix);
                $("#sale_no").val(data.data.sale_no);
                $("#rental_prefix").val(data.data.rental_prefix);
                $("#rental_no").val(data.data.rental_no);
                $("#quatation_prefix").val(data.data.quatation_prefix);
                $("#quatation_no").val(data.data.quatation_no);
                $("#lead_prefix").val(data.data.lead_prefix);
                $("#lead_no").val(data.data.lead_no);
                $("#proforma_prefix").val(data.data.proforma_prefix);
                $("#proforma_no").val(data.data.proforma_no);
                // $("#sale_gst_prefix").val(data.data.sale_gst_prefix);
                // $("#sale_gst_no").val(data.data.sale_gst_no);
                // $("#sale_not_gst_prefix").val(data.data.sale_not_gst_prefix);
                // $("#sale_not_gst_no").val(data.data.sale_not_gst_no);
                $(".card-title").html('Edit Company').css('color', 'red');
                $("#name").focus();
            
                $("#id").val(data.data.id);
                $(".state").val(data.data.state).select2();
                $(".city").val(data.data.city).select2();
                $("#tax").val(data.data.tax).select2();
                $("#bank_name").val(data.data.bank_name).select2();
             
                scrollToTop();
            }
        });
    });





    // });
</script>
@endsection