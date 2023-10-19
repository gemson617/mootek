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
            <form id='sale' action="{{route('sale.final_invoice')}}" method='post'>
                <div class="row">

                    <div class="col-md-12 mt-4">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title pr-3">Add Customer</h3>
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
                                       
                                        <label for=""> Select Customer<span class="error">*</span></label>

                                        <select id='customer' class="form-select txt-num  @error('customer') is-invalid @enderror" value="" name="customer" required>
                                            <option value="">--Select--</option>
                                            @foreach($customer as $val)

                                            <option value="{{$val->id}}" {{ old('customer') == $val->id ? 'selected' : '' }}>{{$val->name}}</option>

                                            @endforeach
                                        </select>
                                        @error('customer')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Notes<span class="error">*</span></label>
                                        <textarea style='height:45px' ; class="form-control  @error('reference') is-invalid @enderror" id="reference" name='reference' rows="3"></textarea>
                                        @error('reference')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for=""> Select tax<span class="error">*</span></label>
                                        <select id='tax' class="form-select txt-num  @error('customer')  is-invalid @enderror" name='tax'>
                                            <option value="">--Select--</option>
                                            
                                            <option value="<?php echo $tax->name; ?>" selected>GST({{$tax->name}}%)</option>
                                            <option value="0">NON GST</option>
                                        </select>
                                        @error('customer')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php /*@include('layouts.partials.menu')*/ ?>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title pr-3">Add Sale</h3>
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
                                                        <div class="col-md-4">
                                                            <label for=""> Select Model <span class="error">*</span></label>
                                                            <div class="form-group">
                                                                <select id="order0" name="order[]" class="form-select modal_change">
                                                                    <option value="">--Select--</option>
                                                                    @foreach($modal as $key => $val)
                                                                    <?php
                                                                    $cat = App\Models\category::where('id', $val->categoryID)->first();
                                                                    $category = isset($cat->category_name) ? $cat->category_name : 'null';
                                                                    $pro = App\Models\product::where('id', $val->productID)->first();
                                                                    $product = isset($pro->productName) ? $pro->productName : 'null';
                                                                    $bra = App\Models\brand::where('id', $val->brandID)->first();
                                                                    $brand = isset($bra->brand_name) ? $bra->brand_name : 'null';
                                                                    $NumberOfStock = App\Models\purchase::where('active', '1')->where('stock', '1')->where('type', '0')->where('categoryID', $val->categoryID)->where('brandID', $val->brandID)->where('productID', $val->productID)->where('selling_price', $val->selling_price)->get();
                                                                    $getNumberOfStock = $NumberOfStock->count();
                                                                    ?>
                                                                    <option value="{{$val->categoryID}}|{{$val->brandID}}|{{$val->productID}}|{{$val->selling_price}}-<?= 'stock'; ?>">{{$category}}-{{$brand}}-{{$product}}({{$getNumberOfStock}})</option>
                                                                    @endforeach
                                                                    @foreach($manual_products as $val)
                                                                    <option value="{{$val->id}}-<?= 'others'; ?>" {{ old('othersproduct[]') == $val->id ? 'selected' : '' }}>{{$val->product}}</option>

                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-4 serial0">
                                                            <label for="">Serial No<span class="error">*</span></label>

                                                            <div class="form-group">

                                                                <input type="text" id='serial0' list="serial_name0" placeholder="Enter Serial Number" class="form-control  @error('price') is-invalid @enderror serial" autocomplete="off" name="serial[]" required />
                                                                <datalist id="serial_name0">

                                                                </datalist>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for=""> Price (Per Model)<span class="error">*</span></label>

                                                            <div class="form-group">
                                                                <input type="number" id='price0' class="form-control  @error('price') is-invalid @enderror totalPrice" placeholder="Enter Amount" oninput="getprice(0)" name="price[]" required />
                                                                @error('price')
                                                                <div class="error">*{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id='tax_per0' name='tax_per[]'>
                                                        <input type="hidden" id='tax_amount0' class='tax_amount' name='tax_per_amount[]'>

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
                                <div class="row mt-3">
                                    <div class="col-md-12  d-flex justify-content-end">
                                        <table class="table table-bordered text-right">
                                            <tr>
                                                <td class="w-75">Taxable Price</td>
                                                <td>
                                                    <input type="Text" id='tax_price' value="" class="form-control txt-num @error('tax_price') is-invalid @enderror" name="tax_price" readonly />

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Discount(-)</td>
                                                <td>
                                                    <input type="number" id='discount' value='0' class="form-control txt-num @error('discount') is-invalid @enderror" name="discount" />

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Delivery Charges(+)</td>
                                                <td>
                                                    <input type="number" id='delivery' value='0' class="form-control  @error('discount') is-invalid @enderror" name="delivery" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Others Charges(+)</td>
                                                <td>
                                                    <input type="number" id='others' value='0' class="form-control  @error('discount') is-invalid @enderror " name="others" />
                                                </td>
                                            </tr>
                                            <input type="hidden" id='tax_amount' value='0' class="form-control  @error('tax') is-invalid @enderror tax_value" name="tax_amount" readonly />
                                            <tr>
                                                <td>CGST(%)</td>
                                                <td>
                                                    <input type="text" id='cgst' value='0' class="form-control  @error('tax') is-invalid @enderror" readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SGST(%)</td>
                                                <td>
                                                    <input type="text" id='sgst'  class="form-control  @error('tax') is-invalid @enderror"  readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Grand Total</td>
                                                <td>
                                                    <input type="Text" id='grand_total'  class="form-control txt-num @error('grand_total') is-invalid @enderror" name="grand_total" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-2 mt-2">
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-sm btn-success mr-1">Generate Invoice</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            de = parseInt($('#delivery').val());
            oth = parseInt($('#others').val());
            id = $("#tax").val();
                tax_amount = disc_amt+(de+oth);
                var tax_a = tax_amount * id / 100;
                $(".tax_value").val(tax_a);
                gst=tax_a/2;
                $("#cgst").val(gst);
                $("#sgst").val(gst);

                var tot = parseInt(tax_amount) + parseInt(tax_a);
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
                    '<div class="col-md-4"><label for="">Select Model<span class="error">*</span></label><div class="form-group"><select id="order' + count + '"  onchange="getproductstock(this.value,' + count + ')"  name="order[]" class="form-select getModal selectDrop select2"><option value=""> --Select--</option></select></div><span class="geterror getall' + count + '"></span></div>' +
                    '<div class="col-md-4 serial' + count + '"><label for="">Serial No</label><div class="form-group"><input type="text" id="serial' + count + '"   name="serial[]" class="form-control serial"' + count + '" required placeholder="Enter Serial Number" list="serial_name' + count + '" autocomplete="off"/><datalist id="serial_name' + count + '" ></datalist></div></div>' +
                    '<div class="col-md-3"><label for="">Price(Per Model)<span class="error">*</span></label><div class="form-group"><input type="number"  id="price' +
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
                        } else {
                            options += "<option value=" + rows[i].id + '-' + rows[i].check + ">" + rows[i].product + "</option>";
                        }
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
                        $('#price' + no).prop("readonly", true);
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
                        $('#price' + no).prop("readonly", false);
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
                        $('#price' + 0).prop("readonly", true);

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

                        $('#price' + 0).prop("readonly", false);
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
                mop: 'required',
                terms: 'required',
                reference: 'required',
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
                customer: 'This customer is required',
                mop: 'This mop is required',
                terms: 'This terms is required',
                reference: 'This reference is required',
                price: 'Please fill in the Price (Per Model)',
                // 'purchaseid[]':'This Product price is required',
                'order[]': 'This  Model is required',
                'serial[]': 'This  Serial is required',
                'price[]': 'This  Price is required',
                tax: 'Please Select Tax',

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