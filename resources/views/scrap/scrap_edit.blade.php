@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <form id="form" method="post" action="{{ route('update.scrap') }}">
            @csrf
            <div class="card">
                <h7 class="card-header">Scrap</h7>
                <div class="card-body  p-3">
                    <div class="row px-3">

                        <div class="col-md-3">
                          <input type="hidden" id='master_id' name="master_id" value='{{$sid}}'>
                            <label for=""> Select Vendor<span class="error">*</span></label>

                            <select id='vendor' class="form-select txt-num  @error('vendor') is-invalid @enderror" value="" name="vendor"  disabled required>
                                <option value="">--Select--</option>
                                @foreach($vendors as $val)
                                <option value="{{$val->id}}" <?php echo $vendor->vendor==$val->id?'selected':' '; ?>>{{$val->supplier_name}}</option>
                                @endforeach
                            </select>
                            @error('vendor')
                            <div class="error">*{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="">Date<span class="error">*</span></label>

                            <div class="form-group">

                                <input type="date" id='date' class="form-control  @error('price') is-invalid @enderror" autocomplete="off" placeholder="Enter Location" name="date" value="{{$vendor->date}}" required />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="">Notes<span class="error">*</span></label>
                            <textarea style='height:45px' ; class="form-control  @error('reference') is-invalid @enderror" id="reference" name='reference' value='' rows="3" required>{{$vendor->reference}}</textarea>
                            @error('reference')
                            <div class="error">*{{$message}}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>


            <div class="">
                <?php /*@include('layouts.partials.menu')*/ ?>
                <div class="row pb-5">
                    <div class="col-sm-12">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title">Edit Scrap</h3>
                            </div>

                            <div class="card-body">
                                @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif
                                @if (session('error'))
                                <div class="alert alert-warning" role="alert">
                                    {{ session('error') }}
                                </div>
                                @endif



                                <div class="row" id="purform">
                                    <div class="max rtl-bc">
                                        <div class="multi-fields">
                                            @foreach($all as $key=>$val)

                                            <div class="multi-field py-2">
                                                <div class="row multidiv{{$key}}" id="add_cal">
                                                    <!-- <div class="col-md-3 mb-3">
                                                            <label for="validationCustomUsername">Model</label>
                                                            <input type="text" class="form-control" id="product" name="product[{{$key}}]" value="{{$val->product}}">
                                                        </div> -->

                                                    <!-- <div class="col-md-3 mb-3">
                                                        <input type="hidden" class="form-control product_id" id="product_id" name="product_id[{{$key}}]" value="{{$val->qp_id}}">
                                                            <label for="validationCustomUsername">Description</label>
                                                        </div> -->
                                                    <input type="hidden" id='product_id' name='product_id[]' value='{{$val->id}}'>
                                                    <div class="col-md-4">
                                                        <label for="validationCustomUsername">Product</label>
                                                        <input type="text" class="form-control" value="{{$val->product}}" id="product0" name="product[]">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="validationCustomUsername">Quantity</label>
                                                        <input type="number" class="form-control" id="qty{{$key}}" name="qty[]" value="{{$val->qty}}">
                                                    </div>

                                                    <!-- <div class="col-md-3 mb-3">
                                                            <label for="validationCustomUsername">Tax %</label>
                                                            <input type="number" readonly onkeyup="calculate(this.value,{{$key}})" class="form-control" id="tax{{$key}}" name="tax[{{$key}}]" value="{{$val->tax}}">
                                                        </div> -->

                                                    <div class="col-md-1 mt-4">
                                                        <i class="fa fa-trash delete_modalll" onclick="productremovediv(<?= $key; ?>,<?= $val->id; ?>)" id="{{$val->id}}" style="font-size:22px;color:red"></i>
                                                    </div>

                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div id="removefield">
                                            <!-- <input type="hidden" id='removeid' name='removeid[]' value=""> -->
                                        </div>
                                        <div class="col-md-4 col-lg-4" id="adremovebuttons"><br />
                                            <button type="button" id="button1" class="add-field btn btn-info btn-circle"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                            <!-- <button type="button" id="button2"
                                                                    class="remove-field btn btn-danger btn-circle1"><i
                                                                    class="fa fa-minus-circle" aria-hidden="true"></i></button> -->
                                        </div>

                                        <div class="col-md-12 pt-3  d-flex justify-content-end">
                                            <table class="table table-bordered text-right">
                                                <tr>
                                                    <td class="w-75">Price</td>
                                                    <td>
                                                        <input type="Text" id='price' class="form-control txt-num @error('price') is-invalid @enderror" value='{{$vendor->price}}' name="price" />

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w-75">Payment Mode<span class="error">*</span></td>
                                                    <td>
                                                        
                                                        <select class="form-select @error('payment') payment is-invalid @enderror"
                                                        id="payment" name="payment">
                                                        <option value="" >--Select--</option>
                                                        @foreach ($payment as $value)
                                                            <option value="{{ $value->id }}" <?= $vendor->payment==$value->id ?'selected':''; ?>>{{ $value->payment_mode }}
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
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername" style="color: transparent;">Bill</label><br>
                                            <button class="btn btn-primary" id="finalOrderPurchase" onclick="myFunction()">Update Scrap</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername"></label><br>
                                            <button class="btn btn-primary" id="add_product" onclick="myFunction()">Add
                                                Material</button>
                                        </div>-->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
    function calculate(val, no) {
        var taxable = $("#price" + no).val();
        var qty = $("#qty" + no).val();
        var tax = $("#tax" + no).val();
        var qty_amt = taxable * qty;
        console.log(qty_amt);
        var tax_a = qty_amt * tax / 100;
        var tot = tax_a + qty_amt;
        console.log(tot);
        var total_amo = $("#gsttaxamount" + no).val(Math.round(tax_a));
        var total_amount = $("#gstamount" + no).val(Math.round(tot));

        var amount = 0;
        $(".totalPrice").each(function(j, ob) {
            amount += parseFloat(ob.value);
        });

        $("#grandtotal").val(amount);
        console.log(total_amount);
    }

    function getModal(no) {
        $.ajax({
            type: "GET",
            url: "{{ route('quotation.getmodal') }}",
            success: function(data) {
                var rows = jQuery.parseJSON(data);
                var options = [];
                for (var i = 0; i < rows.length; i++) {
                    options += "<option value=" + rows[i].id + "|" + rows[i].catid + "|" + rows[i].brandid + "|" + rows[i].productid + ">" + rows[i].cat + '-' + rows[i].brand + '-' + rows[i].product + '(' + rows[i].count + ')' + "</option>";
                }
                $('#getModal' + no).append(options).select2();
            }
        });
    }


    function getproductstock(val, no) {
        $.ajax({
            url: '{{route("load.quotation")}}',
            type: 'POST',
            data: {

                id: val,
                "_token": "{{ csrf_token() }}",
            },

            beforeSend: function() {

                $('body').css('cursor', 'progress');

            },

            success: function(data) {
                $("#price" + no).val(data.data.selling_price);
                $("#description" + no).val(data.product.description);
                $("#tax" + no).val(data.product.gst);
                // alert(data);
                $("#qtylal" + no).text('Tax Amount(' + data.product.gst + '%)');


                $('#snackbar').html("Product Added Successfully!");



                $('body').css('cursor', 'default');
                var amount = 0;
                $(".totalPrice").each(function(j, ob) {
                    amount += parseFloat(ob.value);
                });

                $("#tax_price").val(amount);
                $("#grand_total").val(amount);
            },

            async: false

        });
    }

    function productremovediv(no, val) {
        console.log(no);
        var $wrapper = $('#removefield');
        var row = $('<input type="hidden" id="removeid" name="removeid[]" value="' + val + '">');
        row.appendTo($wrapper);
        $('.multidiv' + no).remove();
    }

    function removediv(no) {
        // alert(no);
        $('.multidiv' + no).remove();
    }


    $(document).ready(function() {

        calculate();

        // $("#price").on("change keyup paste", function(){
        //     calculate();
        // });
        // $("#qty").on("change keyup paste", function(){

        //     calculate();
        // });
        // $("#tax").on("change keyup paste", function(){
        //     calculate();
        // });



        // $('#discount').on('input', function(e) {
        //     tax = $('#tax_price').val();
        //     dis = tax - $(this).val();
        //     $("#grand_total").val(dis);
        // });


        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);

        $("#qm").on('change', function() {
            var tccondition = $('#qm').val();
            if (tccondition == 'Rental') {
                $('#tcmeth').show();
            } else {
                $('#tcmeth').hide();
            }
        });

        var count_id = 0;
        $(".product_id").each(function(j, ob) {

            if (ob.value != null) {
                count_id = $(".product_id").length;

            }
        });
        // alert(count_id);
        $(".edit_form").click(function() {
            $("#form").load("content.html");
            id = $(this).val();
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{ route('brand.brand_index') }}",
                success: function(data) {
                    $("#categoryID").val(data.data.categoryID);
                    $("#name").val(data.data.name);

                    $(".card-title").html('Edit Brand').css('color', 'red');
                    $("#id").val(data.data.id);
                    $("#categoryID").focus();
                    scrollToTop();
                }
            });
        });


        $(".delete_modal").click(function() {
            id = $(this).attr("id");
            // alert(id);
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
                url: "{{ route('quotation.edit_delete') }}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload()
                }
            });
        });

        $('#datatable').DataTable({
            "ordering": false
        });


        $('.max').each(function() {
            var $wrapper = $('.multi-fields', this);

            $(".add-field", $(this)).click(function(e, count) {
                var count = $('.multi-field').length;
                getModal(count);
                var row = $(
                    '<div class="multi-fields mt-2 rtl-bc" id="multi"> <div class="multi-field"> <div class="row multidiv' + count + '" id="add_cal" style="; padding: 0px;">' +

                    '<div class="col-md-4"><label for="">Product</label><div class="form-group"><input placeholder="Enter Your Product" type="text" id="product' +
                    count + '" name="product[]" class="form-control" placeholder=""/></div></div>' +
                    "<input type='hidden' id='product_id' name='product_id[]' value=' '>" +
                    '<div class="col-md-4"><label for="">Quantity</label><div class="form-group"><input  type="number" placeholder="Enter Your qty" id="qty' +
                    count + '" name="qty[]" class="form-control totalPrice"  placeholder=""/></div><div class="error"> <p  id="sell_p' + count + '"></p></div></div>' +
                    '<div class="col-md-1"><i class="fa fa-trash mt-4" onclick="removediv(' + count + ')" id="remove' + count + '" style="font-size:22px;color:red"></i></div></div></div></div>');
                row.appendTo($wrapper);
            });

            $('.remove-field', $(this)).click(function() {

                // var count = $('.multi-field').length;
                //  alert(count_id);

                if ($('.multi-field').length > count_id)
                    $('.multi-field').last().remove();
                var amount = 0;
                $(".totalPrice").each(function(j, ob) {
                    amount += parseFloat(ob.value);
                });

                $("#grandtotal").val(amount);
            });
        });


    });


    // VALIDATION ON FORM SUBMIT
    $('form[id="form"]').validate({
        rules: {
            customerID: 'required',
            qm: 'required',
            tcmonth: 'required',

            'product[]': 'required',
            'qty[]': 'required',
            price:'required',

        },
        messages: {
            customerID: 'This supplier is Required',
            qm: 'This reference is Required',
            tcmonth: 'This purchaseDate is Required',

            'product[]': 'This product is Required',

            'qty[]': ' Qty is Required',
            price:'Price is Required',

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
</script>
@endsection