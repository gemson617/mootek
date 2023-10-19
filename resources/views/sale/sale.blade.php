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
                                       
                                        <label for=""> Select Tax<span class="error">*</span></label>

                                        <select id='tax' class="form-select txt-num  @error('tax') is-invalid @enderror" value="" name="tax" required>
                                            <option value="">--Select--</option>
                                            @foreach($tax as $val)

                                            <option value="{{$val->id}}" {{ old('tax') == $val->id ? 'selected' : '' }}>{{$val->name}}</option>

                                            @endforeach
                                        </select>
                                       
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
                                                        <div class="col-md-2">
                                                            <label for=""> Select Type <span class="error">*</span></label>
                                                            <div class="form-group">
                                                                <select id="type0" name="type[]" class="form-select" onchange="getproductstock(this.value,'0')">
                                                                    <option value="">--Select--</option>
                                                                    <option value="1">Local</option>
                                                                    <option value="2">Import</option>
                                                                    <option value="3">Group Products</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for=""> Select Product <span class="error">*</span></label>
                                                            <div class="form-group">
                                                                <select id="product0" name="product[]" class="form-select modal_change" onchange="getproductserial(this.value,'0')"> 
                                                                    <option value="">--Select--</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 serial0">
                                                            <label for="">Model No<span class="error">*</span></label>

                                                            <div class="form-group">

                                                                <input type="text" id='model0'  placeholder="Model Number" class="form-control  @error('price') is-invalid @enderror" autocomplete="off" name="model[]" required />
                                                              
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 serial0">
                                                            <label for="">Serial No<span class="error">*</span></label>

                                                            <div class="form-group">

                                                                <input type="text" id='serial0' list="serial_name0" placeholder="Serial Number" class="form-control  @error('price') is-invalid @enderror serial" autocomplete="off" name="serial[]" required />
                                                                <datalist id="serial_name0">

                                                                </datalist>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <label for=""> Price (Per Model)<span class="error">*</span></label>

                                                            <div class="form-group">
                                                                <input type="number" id='price0' class="form-control  @error('price') is-invalid @enderror totalPrice pricetax" placeholder="Enter Amount" oninput="getprice(0)" name="price[]" required />
                                                                @error('price')
                                                                <div class="error">*{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                       <input type="hidden" class="gstper" id="tax_percentange0" name='tax_per[]' >

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
                                            <tr id="gst_list">
                                                <td>Others Charges(+)</td>
                                                <td>
                                                    <input type="number" id='others' value='0' class="form-control  @error('discount') is-invalid @enderror " name="others" />
                                                </td>
                                            </tr>
                                            <input type="hidden" id='tax_amount' value='0' class="form-control  @error('tax') is-invalid @enderror tax_value" name="tax_amount" readonly />
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
//  const newRow = `<tr id="cgst${index}">
//                 <td>CGST(${gst / 2}%)</td>
//                 <td>
//                 <input type="text" class="form-control cgst${gst}" data=${index_array}  data-value=${gst} value="${cgst.toFixed(2)}" readonly />
//                 </td>
//                 </tr>
//                 <tr id="sgst${index}">
//                 <td>SGST(${gst / 2}%)</td>
//                 <td>
//                 <input type="text" class="form-control sgst${gst}" data-value=${gst} value="${sgst.toFixed(2)}" readonly />
//                 </td>
//                 </tr>`;
//                 $("#gst_list").after(newRow);
                
// function gst(price, gst, index) {

//   }


        $("#tax").change(function() {
            calculation();
        });

        function calculation(price,gst) {
            var amount = 0;
            $('body').css('cursor', 'default');
            $(".totalPrice").each(function(j, ob) {
                if ($.isNumeric(ob.value)) {
                    amount += parseFloat(ob.value);

                }
            });
            console.log(amount);
            $("#tax_price").val(amount);
            taxable = $("#tax_price").val();
            
            var disc = $('#discount').val();
                var disc_amt = taxable - disc;
            de = parseInt($('#delivery').val());
            if($.isNumeric(de)){
                 delivery=de;
            }else{
                 delivery=0;
            }
            oth = parseInt($('#others').val());
            if($.isNumeric(oth)){
                 others=de;
            }else{
                 others=0;
            }
            id = $("#tax").val();
                tax_amount = disc_amt+delivery+others;
                // var tax_a = tax_amount * id / 100;
                // $(".tax_value").val(tax_a);
                // gst=tax_a/2;
                company_gst=$("#company_gst").val();
                var  totalgst=0;
                if(company_gst =='1'){
                 
                    $(".total_gst").each(function(j, ob) {
                if ($.isNumeric(ob.value)) {
                    totalgst += parseFloat(ob.value);
                }
            });
                }

                var tot = parseInt(tax_amount) + parseInt(totalgst);
               $("#grand_total").val(Math.round(tot));

        }
        // Initialize Select2 on multiple select elements
        function removediv(no) {

            $('.multiqtydiv' + no).remove();
            gst();
            calculation();
            
        }
        $('.max').each(function() {

            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e, count) {

                var count = $('.multi-field').length;
                // getmanual_products(count);
                // $("#getModal"+count+"-error").addClass('getmodalclass');
                var row = $(
                    '<div class="multi-fields rtl-bc"> <div class="multi-field "> <div class="row multiqtydiv' + count + '" id="add_cal" style="; padding: 0px 18px;">' +
                    '<div class="col-md-2"><label for="">Select Type<span class="error">*</span></label><div class="form-group"><select id="type' + count + '"    name="type[]"  onchange="getproductstock(this.value,' + count + ')" class="form-select  selectDrop select2"><option value=""> --Select--</option><option value="1">local</option><option value="2">Import</option><option value="3">Group Products</option></select></div><span class="geterror getall' + count + '"></span></div>' +
                    '<div class="col-md-4"><label for="">Select Product<span class="error">*</span></label><div class="form-group"><select id="product' + count + '"   name="product[]" onchange="getproductserial(this.value,' + count + ')" class="form-select getModal selectDrop select2"><option value=""> --Select--</option></select></div><span class="geterror getall' + count + '"></span></div>' +
                    '<div class="col-md-3 serial' + count + '"><label for="">Serial No</label><div class="form-group"><input type="text" id="serial' + count + '"   name="serial[]" class="form-control serial"' + count + '" required placeholder="Enter Serial Number" list="serial_name' + count + '" autocomplete="off"/><datalist id="serial_name' + count + '" ></datalist></div></div>' +
                    '<div class="col-md-2"><label for="">Price(Per Model)<span class="error">*</span></label><div class="form-group"><input type="number"  id="price' +
                    count + '" class="form-control totalPrice pricetax" name="price[]" placeholder="Enter Number" oninput="getprice(' + count + ')" required /></div></div>' + '<div class="col-md-1"><i class="fa fa-trash mt-5" onclick="removediv(' + count + ')" id="remove' + count + '" style="font-size:22px;color:red"></i></div>' +
                    '<input type="hidden" id="tax_percentange' + count + '" class="gstper" name="tax_per[]"><input type="hidden" id="tax_amount' + count + '"  class="tax_amount" name="tax_per_amount[]">' + '</div></div></div>');
                row.appendTo($wrapper);
                $(".selectDrop").select2();
                // }
            });

            $('.remove-field', $(this)).click(function() {

                if ($('.multi-field').length > 1)

                    $('.multi-field').last().remove();
                    gst();
                calculation();
            });
        });




        function getproductstock(val, no) {

            $.ajax({
                url: '{{route("get.products")}}',
                type: 'POST',
                data: {

                    id: val,
                    "_token": "{{ csrf_token() }}",
                },

                beforeSend: function() {

                    $('body').css('cursor', 'progress');
                },
                success: function(data) {
                    $("#serial"+no).val('');
                    $('#product'+no).empty();
                    var select = $('#product'+no); // Get a reference to the select element
                    // Loop through the data array and create options
                     select.append($('<option>', {
                    value: "", // Set the value attribute to an empty string or any value you prefer
                    text: "--select--"  // Set the text content of the option
                    }));
                      if(data.status ==1){
                        $.each(data.data, function(index, item) {
                    var option = $('<option>', {
                    value: item.id, // Set the value attribute
                    text: item.product_name  // Set the text content of the option
                    });
                    select.append(option); // Append the option to the select element
                    });
                      }else if(data.status =='2'){
                        $.each(data.data, function(index, item) {
                    var option = $('<option>', {
                    value: item.id, // Set the value attribute
                    text: item.product_name+'('+item.qty+')'  // Set the text content of the option
                    });
                    select.append(option); // Append the option to the select element
                    });
                      }
                
                },

                async: false

            });
        }
        function getproductserial(val, no) {

            $.ajax({
                url: '{{route("get.serial")}}',
                type: 'POST',
                data: {

                    id: val,
                    "_token": "{{ csrf_token() }}",
                },

                beforeSend: function() {

                    $('body').css('cursor', 'progress');
                },
                success: function(data) {
                console.log(data);
                $("#serial"+no).val(data.data.serial);
                },

                async: false

            });
}



        $('#discount').on('input', function(e) {
            var tax_price=$("#tax_price").val();

            if(tax_price>0){
                gst();
            }
            calculation();
        });
        $('#delivery').on('input', function(e) {
            var tax_price=$("#tax_price").val();

            if(tax_price >0){
                gst();
            }
           
            calculation();
        });
        $('#others').on('input', function(e) {
            var tax_price=$("#tax_price").val();

        if(tax_price >0){
            gst();
        }
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
                // terms: 'required',
                'type[]': 'required',

                'product[]': 'required',
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
                // reference: 'This reference is required',
                price: 'Please fill in the Price (Per Model)',
                'type[]':' Select  Type is Required',
                'product[]': 'Select  Product is Required',
                'serial[]': 'This  Serial is Required',
                'price[]': 'This  Price is Required',
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
 


    </script>
    @endsection