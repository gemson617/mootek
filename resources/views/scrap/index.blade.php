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

    #vendor-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }
</style>
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <form id='sale' action="{{route('final.scrap')}}" method='post'>
                <div class="row">

                    <div class="col-md-12 mt-4">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title pr-3">Add Vendor</h3>
                                <span id='error'></span>
                            </div>
                            @csrf
                            <div class="card-body">
                                @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif
                                <p id='serial_error'></p>
                                <div class="row px-3">

                                    <div class="col-md-3">

                                        <label for=""> Select Vendor<span class="error">*</span></label>

                                        <select id='vendor' class="form-select txt-num  @error('vendor') is-invalid @enderror" value="" name="vendor" required>
                                            <option value="">--Select--</option>
                                            @foreach($vendor as $val)
                                            <option value="{{$val->id}}">{{$val->supplier_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('vendor')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Date<span class="error">*</span></label>

                                        <div class="form-group">

                                            <input type="date" id='date' class="form-control  @error('price') is-invalid @enderror" autocomplete="off" placeholder="Enter Location" name="date" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Notes</label>
                                        <textarea style='height:45px' ; class="form-control  @error('reference') is-invalid @enderror" id="reference" name='reference' rows="3" ></textarea>
                                        @error('reference')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <label for=""> Select tax<span class="error">*</span></label>
                                        <select id='tax' class="form-select txt-num  @error('customer')  is-invalid @enderror" name='tax'>
                                            <option value="">--Select--</option>
                                            <option value="1" selected>GST</option>
                                            <option value="0">NON GST</option>
                                        </select>
                                        @error('customer')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div> -->
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
                                <h3 class="card-title pr-3">Add Scrap</h3>
                                <span id='error'></span>
                            </div>
                                @csrf
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="max rtl-bc">
                                                <div class="multi-fields">
                                                    <div class="multi-field" style="margin: 15px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="">Product<span class="error">*</span></label>

                                                                <div class="form-group">

                                                                    <input type="text" id='product0' class="form-control  @error('price') is-invalid @enderror serial" placeholder="Enter Product Name" autocomplete="off" name="product[]" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="">Quantity<span class="error">*</span></label>

                                                                <div class="form-group">

                                                                    <input type="number" id='qty0' class="form-control  @error('price') is-invalid @enderror serial" min='0' placeholder="Enter Qty" autocomplete="off" name="qty[]" required />
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
                                    <div class="row mt-3">
                                        <div class="col-md-12  d-flex justify-content-end">
                                            <table class="table table-bordered text-right">
                                                <tr>
                                                    <td class="w-75">Price<span class="error">*</span></td>
                                                    <td>
                                                        <input type="Text" id='price' value="" class="form-control txt-num @error('price') is-invalid @enderror" name="price" />

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-75">Payment Mode<span class="error">*</span></td>
                                                    <td>
                                                        
                                                        <select class="form-select @error('payment') payment is-invalid @enderror"
                                                        id="payment" name="payment">
                                                        <option value="" >--Select--</option>
                                                        @foreach ($payment as $value)
                                                            <option value="{{ $value->id }}">{{ $value->payment_mode }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                        {{-- <input type="Text" id='price' value="" class="form-control txt-num @error('price') is-invalid @enderror" name="price" /> --}}

                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td class="w-75">Tax(%)</td>
                                                    <td>
                                                        <input type="Text" id='tax_price' value="" class="form-control txt-num @error('tax_price') is-invalid @enderror" name="tax_price" />

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-75">Total</td>
                                                    <td>
                                                        <input type="Text" id='total' value="" class="form-control txt-num @error('total') is-invalid @enderror" name="total" />

                                                    </td>
                                                </tr> -->
                                            </table>
                                        </div>

                                        <div class="col-md-2 mt-2">
                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-sm btn-success mr-1">Add Srap</button>
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
        // function calculation() {
        //     id = $("#tax").val();
        //     if (id == 0) {
        //         tax = 0;
        //         total = price;
        //     } else {
        //         price = $("#price").val();
        //         console.log(price);
        //         if ($.isNumeric(price)) {
        //             tax = price * 18 / 100;
        //             total = parseInt(price) + parseInt(tax);
        //         } else {
        //             tax = 0;
        //             total = price;
        //         }
        //     }
        //     $("#tax_price").val(tax);
        //     $("#total").val(total);
        // }
        // $("#tax").change(function() {
        //     calculation();
        // });
        // $('#price').on('input', function(e) {
        //     calculation();

        // });
        // Initialize Select2 on multiple select elements
        function removediv(no) {

            $('.multiqtydiv' + no).remove();
        }
        $('.max').each(function() {

            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e, count) {

                var count = $('.multi-field').length;
                // getmanual_products(count);
                // $("#getModal"+count+"-error").addClass('getmodalclass');
                var row = $(
                    '<div class="multi-fields rtl-bc"> <div class="multi-field "> <div class="row multiqtydiv' + count + '" id="add_cal" style="; padding: 0px 18px;">' +
                    '<div class="col-md-4"><label for="">Product<span class="error">*</span></label><div class="form-group"><input type="text" name="product[]" class="form-control "' + count + '"  id="product' + count + '"  required placeholder="Enter Product Name" autocomplete="off"/></div></div>' +
                    '<div class="col-md-4 serial' + count + '"><label for="">Quantity<span class="error">*</span></label><div class="form-group"><input type="number" name="qty[]" class="form-control"' + count + '" id="qty' + count + '" required placeholder="Enter Qty" autocomplete="off" required/></div></div>' +
                    '<div class="col-md-1"><i class="fa fa-trash mt-5" onclick="removediv(' + count + ')" id="remove' + count + '" style="font-size:22px;color:red"></i></div>' +
                    +'</div></div></div>');
                row.appendTo($wrapper);
                $(".selectDrop").select2();
                // }
            });

            $('.remove-field', $(this)).click(function() {

                if ($('.multi-field').length > 1)

                    $('.multi-field').last().remove();
            });
        });

        $("select").on("select2:close", function(e) {
            $(this).valid();
        });

        $('form[id="sale"]').validate({
            ignore: 'input[type=hidden], .select2-input, .select2-focusser',

            rules: {
                vendor: 'required',
                date: 'required',
                // reference: 'required',
                price : 'required',
                payment : 'required',

                
                'qty[]': 'required',
                'product[]': {
                    required: true
                },
                
            },
            messages: {
                vendor: 'This Vendor is required',
                date: 'This Date is required',
                terms: 'This terms is required',
                // reference: 'This Notes is required',
                price : 'This Price is required',
                payment : 'This Payment Mode is required',

                'qty[]': 'This  Qty is required',
                'product[]': 'This  Product is required',
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