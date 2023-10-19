@extends('layouts.app')

@section('content')

<style>
    #customer-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }

    #mop-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }

    #terms-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }

    #select2-tax_change-container {
        text-align: left;
    }

    #tax-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }
</style>
<div class="app-content page-body">
    <div class="container">
        
        <div class="">
            <form id='sale' action="" method='post'>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title pr-3">Add Service</h3>
                                <span id='error'></span>
                            </div>
                            <!-- <form action="{{route('sale.sale_store')}}" method='post'> -->
                            @csrf
                            <div class="card-body">
                                @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif
                                <p id='serial_error'></p>
                                <div class="row px-3">
                                    <div class="col-md-4">
                                        <label for="">Complaint ID<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='complaintId' value="" class="form-control  @error('complaintId') is-invalid @enderror" placeholder="Complaint Id" name="complaintId" />
                                            @error('complaintId')
                                            <div class="error">*The Complaint ID field is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Serial No<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='serial_no' value="" class="form-control  @error('serial_no') is-invalid @enderror" placeholder="Serial Number" name="serial_no" />
                                            @error('serial_no')
                                            <div class="error">*The Serial Number field is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Select Customer<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select id='customer' class="form-select txt-num  @error('customer') is-invalid @enderror" value="" name="customer" required>
                                                <option value="">--Select--</option>
                                                @foreach($customer as $val)
                                                <option value="{{$val->id}}" {{ old('customer') == $val->id ? 'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('customer')
                                        <div class="error mb-3">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Contact Number<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='contact_number' value="" class="form-control  @error('contact_number') is-invalid @enderror" placeholder="Contact_number" name="contact_number" />
                                            @error('contact_number')
                                            <div class="error">*The Customers Name field is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Complaint Status<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='complaint_status' value="" class="form-control  @error('complaint_status') is-invalid @enderror" placeholder="Complaint_status" name="complaint_status" />
                                            @error('complaint_status')
                                            <div class="error">*The Complaint Status field is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Sales Person<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='sale_person' value="" class="form-control  @error('sale_person') is-invalid @enderror" placeholder="Enter sale_person" name="sale_person" />
                                            @error('sale_person')
                                            <div class="error">*The Sales Person Name field is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Select Warranty<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select id='warranty' class="form-select txt-num  @error('warranty') is-invalid @enderror" value="" name="warranty" required>
                                                <option value="">--Select--</option>
                                                <option value="In">In</option>
                                                <option value="Out">Out</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Service Mode<span class="error">*</span></label>
                                        <div class="form-group">
                                            <select id='service' class="form-select txt-num  @error('service') is-invalid @enderror" value="" name="service" required>
                                                <option value="">--Select--</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Free">Free</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Contact mode <span class="error">*</span></label>
                                        <div class="form-group">
                                            <select id='contact_mode' class="form-select txt-num  @error('contact_mode') is-invalid @enderror" value="" name="contact_mode" required>
                                                <option value="">--Select--</option>
                                                <option value="By Hand">By Hand</option>
                                                <option value="By Employee">By Employee</option>
                                                <option value="By Courier">By Courier</option>
                                                <option value="By Call">By Call</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="">Notes<span class="error">*</span></label>
                                        <textarea style='height:45px' ; class="form-control  @error('notes') is-invalid @enderror" id="notes" name='notes' rows="3"></textarea>
                                        @error('notes')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                  
                                </div>
                                    <div class="col-md-2 mt-2">
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-sm btn-success mr-1">Add Purchase Bill</button>
                                    </div>
                            </div>            
                            </div>
                        </div>
                    </div>
                </div>

                <?php /*@include('layouts.partials.menu')*/ ?>
                {{-- <div class="row">
                    <div class="col-md-12 mt-4">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title pr-3">Add Service</h3>
                                <span id='error'></span>
                            </div>
                            <!-- <form action="{{route('sale.sale_store')}}" method='post'> -->
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="max rtl-bc">
                                            <div class="multi-fields">
                                                <div class="multi-field" style="margin: 15px;">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label for=""> Price (Per Model)<span class="error">*</span></label>
                                                            <div class="form-group">
                                                                <input type="number" id='price0' class="form-control  @error('price') is-invalid @enderror totalPrice" placeholder="Enter Amount" oninput="getprice(0)" name="price[]" required />
                                                                @error('price')
                                                                <div class="error">*{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4" id="adremovebuttons"><br />
                                                <button type="button" id="button1" class="add-field btn btn-info btn-circle"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                                <button type="button" id="button2" class="remove-field btn btn-danger btn-circle1"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
               


            </form>
        </div>
    </div>
    <script>
        $("#tax").change(function() {
            calculation();
        });

        function calculation() {
            var amount = 0;
            $('body').css('cursor', 'default');
            $(".totalPrice").each(function(j, ob) {
                if ($.isNumeric(ob.value)) {
                    amount += parseFloat(ob.value);

                }
            });
            $("#tax_price").val(amount);
            taxable = $("#tax_price").val();
            console.log(taxable);
            var disc = $('#discount').val();
                var disc_amt = taxable - disc;
            // de = parseInt($('#delivery').val());
            // oth = parseInt($('#others').val());
            id = $("#company_gst").val();
              if(id =='1'){
               var gst=18;
              }else{
              var  gst=0;
              }
                // tax_amount = disc_amt;
                var tax_a = disc_amt * gst / 100;
                $(".tax_value").val(tax_a);
                gst=tax_a/2;
                $("#cgst").val(gst);
                $("#sgst").val(gst);

                var tot = parseInt(disc_amt) + parseInt(tax_a);
               $("#grand_total").val(Math.round(tot));

        }
        // Initialize Select2 on multiple select elements
        function removediv(no) {

            $('.multiqtydiv' + no).remove();
            calculation();
        }
        $('.max').each(function() {

            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e, count) {

                var count = $('.multi-field').length;
                getModal(count);
                // getmanual_products(count);
                // $("#getModal"+count+"-error").addClass('getmodalclass');
                var row = $(
                    '<div class="multi-fields rtl-bc"> <div class="multi-field "> <div class="row multiqtydiv' + count + '" id="add_cal" style="; padding: 0px 18px;">' +
                    '<div class="col-md-5"><label for="">Select Model<span class="error">*</span></label><div class="form-group"><select id="order' + count + '"  onchange="getproductstock(this.value,' + count + ')"  name="order[]" class="form-select getModal selectDrop select2"><option value=""> --Select--</option></select></div><span class="geterror getall' + count + '"></span></div>' +
                    '<div class="col-md-5"><label for="">Price(Per Model)<span class="error">*</span></label><div class="form-group"><input type="number"  id="price' +
                    count + '" class="form-control totalPrice" name="price[]" placeholder="Enter Number" oninput="getprice(' + count + ')" required /></div></div>' + '<div class="col-md-1"><i class="fa fa-trash mt-5" onclick="removediv(' + count + ')" id="remove' + count + '" style="font-size:22px;color:red"></i></div>' +
                    '<input type="hidden" id="tax_per' + count + '" name="tax_per[]"><input type="hidden" id="tax_amount' + count + '"  class="tax_amount" name="tax_per_amount[]">' + '</div></div></div>');
                row.appendTo($wrapper);
                $(".selectDrop").select2();
                // }
            });

            $('.remove-field', $(this)).click(function() {

                if ($('.multi-field').length > 1)

                    $('.multi-field').last().remove();
                calculation();
            });
        });

        function getModal(no) {
            $.ajax({
                type: "GET",
                url: "{{ route('sale.getmodal') }}",
                success: function(data) {
                    var rows = jQuery.parseJSON(data);
                    console.log(rows);
                    var options = [];
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].check == 'stock') {
                            options += "<option value=" + rows[i].id + '-' + rows[i].check + ">" + rows[i].cat + '-' + rows[i].brand + '-' + rows[i].product + '(' + rows[i].count + ')' + "</option>";
                        }
                        //  else {
                        //     options += "<option value=" + rows[i].id + '-' + rows[i].check + ">" + rows[i].product + "</option>";
                        // }
                    }
                    $('#order' + no).append(options);
                    $('select').select2();
                }
            });
        }


        function serialvalidation(val, no) {
            var ar = $('.serial').map(function() {
                if ($(this).val() != '') return $(this).val()
            }).get();
            //Create array of duplicates if there are any
            var unique = ar.filter(function(item, pos) {
                return ar.indexOf(item) != pos;
            });
            //show/hide error msg
            (unique.length != 0) ? $('#serial_error' + no).text('*Serial no is already entered'): $('.error').text('');
        }

        function getprice(no) {
            calculation();
        }

        function collectedamount(val) {
            console.log(val);
            var grand_total = parseFloat($("#grand_total").val());
            collected = parseFloat(val);
            if (val > grand_total) {
                $('.collect').html('collected amount greater than  grand total').css('color', 'red').css('display', 'block');
            } else {
                $('.collect').css('display', 'none');
            }
        }

        function getproductstock(val, no) {
            console.log(val);
            alert('ok');
            $.ajax({
                url: '{{route("load.product")}}',
                type: 'POST',
                data: {

                    id: val,
                    "_token": "{{ csrf_token() }}",
                },

                beforeSend: function() {

                    $('body').css('cursor', 'progress');

                },

                success: function(data) {
                    var option = '';
                    $('#serial_name' + no).empty();
                    $('#price' + no).removeAttr("val");
                    $('#serial' + no).val("");
                    if (data.status == '1') {
                        $(".serial" + no).css('display', 'block');
                        // $('#price' + no).prop("readonly", true);
                        $.each(data.data, function(key, value) {
                            if (value.serial != null) {
                                console.log(data.data);

                                $('#serial_name' + no)
                                    .append($("<option></option>")
                                        .attr("value", value.serial)
                                        .text(value.serial));
                            }
                        });
                        $("#price" + no).val(data.data[0].selling_price);

                    } else {
                        // $('#price' + no).prop("readonly", false);
                        $('#price' + no).val("");
                        $('#serial' + no).val("");
                        $('#price' + no).attr("placeholder", 'Enter  Amount');
                        $('#serial' + no).attr("placeholder", 'Enter Serial Number');
                    }
                    $("#tax_per" + no).val(data.gst);
                    $("#tax_amount" + no).val(data.gst_calc);
                    $("select").on("select2:close", function(e) {
                        $(this).valid();
                    });
                    calculation();

                },

                async: false

            });
        }


        

        $(".modal_change").change(function() {
            var product_id = $('.modal_change').val();
            console.log(product_id);
            $.ajax({
                url: '{{route("load.product")}}',
                type: 'POST',
                data: {

                    id: product_id,
                    "_token": "{{ csrf_token() }}",
                },

                beforeSend: function() {

                    $('body').css('cursor', 'progress');

                },

                success: function(data) {
                    $('#serial_name0').val('');
                    $('#serial0').val("");
                    $('#price0').removeAttr("val");
                    $('#serial0').removeAttr("val");

                    $('#serial0').val(" ");
                    if (data.status == '1') {

                        $(".serial0").css('display', 'block');

                        var option = '';
                        $('#serial_name0').empty();
                        $('#serial_name0').val('');
                        // $('#price' + 0).prop("readonly", true);

                        $("#serial0").val('');
                        console.log(data.data);
                        $.each(data.data, function(key, value) {
                            if (value.serial != null) {
                                $('#serial_name0')
                                    .append($("<option></option>")
                                        .attr("value", value.serial)
                                        .text(value.serial));
                            }
                        });

                        $("#price0").val(data.data[0].selling_price);

                    } else {
                        console.log(data);

                        // $('#price' + 0).prop("readonly", false);
                        $('#price' + 0).val("");
                        $('#serial' + 0).val("");
                        $('#price' + 0).attr("placeholder", 'Enter  Amount');
                        $('#serial' + 0).attr("placeholder", 'Enter Serial Number');
                    }
                    calculation();
                },

                async: false

            });
        });

        $('#discount').on('input', function(e) {
            calculation();
        });
        $('#delivery').on('input', function(e) {
            calculation();
        });
        $('#others').on('input', function(e) {
            calculation();

        });

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);


        $("select").on("select2:close", function(e) {
            $(this).valid();
        });

        $('form[id="sale"]').validate({
            ignore: 'input[type=hidden], .select2-input, .select2-focusser',
            rules: {
                customer: 'required',
                warranty: 'required',
                terms: 'required',
                complaintId: 'required',
                serial_no: 'required',
                contact_number: 'required',
                complaint_status: 'required',
                sale_person: 'required',
                notes: 'required',
                'order[]': 'required',
                'price[]': {
                    required: true
                },
                'serial[]': {
                    validate: true,
                },
                tax: 'required',
                // 'purchaseid[]': {
                // required: true
                // },
            },
            messages: {
                customer: 'This customer field is required',
                serial_no: 'This Serial Number field is required',
                notes: 'This Notes field is required',
                complaintId: 'This Complaint field Id is required',
                contact_number: 'Contact Number field is required',
                complaint_status:'This Complaint Status field is required',
                sale_person: 'This Sales Person field is required',
                service: 'This Service Mode field is required',
                contact_mode: 'This Contact Mode field is required',
                warranty: 'This Warranty field is required',

            },
            errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                if(element.hasClass('form-select') && element.next('.select2-container').length) {
                label.insertAfter(element.next('.select2-container'));
                }
                else{
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
        jQuery.validator.addMethod("validate", function(value, element) {
            var ar = $('.serial').map(function() {
                if ($(this).val() != '') return $(this).val()
            }).get();

            var unique = ar.filter(function(item, pos) {
                return ar.indexOf(item) != pos;
            });
            //show/hide error msg
            // (unique.length != 0) ? $('#serial_error'+no).text('*Serial no is already entered') : $('.error').text('');
            if (unique.length != 0) {
                return false;
            } else {
                $('.error').text('');
                return true;
            }
        }, "* Serial Number Already used!");
    </script>
    @endsection