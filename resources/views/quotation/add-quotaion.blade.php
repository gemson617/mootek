@extends('layouts.app')

@section('content')
    <div class="app-content page-body">
        <div class="container">
        <form id="quotation" method="post" action="{{ route('quotation.store') }}">
        @csrf
            <div class="card">
                <h7 class="card-header">QUOTATION</h7>
                <div class="card-body  p-3">
                    <div class="row ">
                    <div class="row ">

                    <div class="col-md-4 mb-3">
                        <label for="">Select Customer <span class="error">*</span></label>
                        <select  class="form-select" id="customerID" name="customerID" >
                            <option value="">--Select--</option>
                            @foreach($customer as $val)
                           <option value="{{$val->id}}">{{$val->name}}</option>
                           @endforeach
                        </select>
                        @error('customerID')
                            <div class="error">*The customer field is required.</div>
                        @enderror
                        </div>


                        <div class="col-md-3 mb-3" >
                        <label for="validationCustom01"> Quotation Method <span class="error">*</span></label>
                        <select class="form-control " id="qm" name="qm">
                            <option value="Sales">Sales</option>
                            <option value="Rental">Rental</option>
                        </select>
                        </div>

                        


                        <div class="col-md-2 mb-3" id="tcmeth" style="display:none;">
                        <label for="validationCustom01"> T&amp;C Month <span class="error">*</span> </label>
                        <input type="number" class="form-control" id="tcmonth" name="tcmonth" placeholder="Enter month for T&amp;C">
                        @error('tcmonth')
                            <div class="error">*The T&C month field is required.</div>
                        @enderror
                        </div>

                        <div class="col-md-3 mb-3" style="width: 19.499999995%">
                            <label for="validationCustomUsername">Tax</label>
                            <select  class="form-select   @error('taxtype') is-invalid @enderror" id="taxtype" name="taxtype" placeholder=""  >
                                <!-- <option value="">--Select--</option> -->
                                @foreach($tax as $val)
                                @if($val->name != 0)
                                <option value="{{$val->name}}">Including Tax ({{$val->name}}%)</option>
                                @endif
                                @endforeach
                                <option value="0">Excluding Tax</option>
                            </select>
                            @error('rent_month')
                            <div class="error">*The rent day/week/month field is required.</div>
                            @enderror
                        </div>

                        {{-- <div class="col-md-3 mb-3">
                        <label for="validationCustom01">Grand Total</label>
                        <input type="number" readonly class="form-control" id="grandtotal" name="grandtotal" placeholder="0">
                        </div> --}}
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
                                <h3 class="card-title">Add Quotation</h3>
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
                               
                                    <input type="hidden" id='id' name='id'>
                                    <div class="row">
                                    <div class="row" id="purform">
                                        <div class="max rtl-bc">
                                            <div class="multi-fields">
                                                <div class="multi-field" style="margin: 15px;">
                                                    <div class="row" id="add_cal">

                                                    <div class="col-md-4">
                                                        <label for="">Select Product<span class="error">*</span></label>
                                                        <div class="form-group">
                                                            <select id='categoryID' onchange="getproductstock(this.value,0)"
                                                                class="selectDrop form-select txt-num  @error('categoryID') is-invalid @enderror"
                                                                value="" name="categoryID[]">
                                                                <option value=""> --Select--</option>
                                                                @foreach ($modal as $val)
                                                                <?php
                                                                    $cat = App\Models\category::where('id', $val->categoryID)->first();
                                                                    $category = isset($cat->category_name) ? $cat->category_name : 'null';
                                                                    $pro = App\Models\product::where('id', $val->productID)->first();
                                                                    $product = isset($pro->productName) ? $pro->productName : 'null';
                                                                    $bra = App\Models\brand::where('id', $val->brandID)->first();
                                                                    $brand = isset($bra->brand_name) ? $bra->brand_name : 'null';
                                                                    $NumberOfStock = App\Models\purchase::where('active', '1')->where('type', '0')->where('stock', '1')->where('categoryID', $val->categoryID)->where('brandID', $val->brandID)->where('productID', $val->productID)->where('selling_price', $val->selling_price)->get();
                                                                    $getNumberOfStock = $NumberOfStock->count();
                                                                ?>
                                                                <option value="{{$val->id}}|{{$cat->id}}|{{$bra->id}}|{{$pro->id}}">{{$category}}-{{$brand}}-{{$product}}({{$getNumberOfStock}})</option>
                                                                @endforeach
                                                            </select>
                                                            @error('categoryID.*')
                                                                <div class="error">*The Product field is required</div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                        <!-- <div class="col-md-3 mb-3">
                                                            <label for="validationCustomUsername">Model</label>
                                                            <input type="text" class="form-control" id="product" name="product[]">
                                                        </div> -->

                                                        <input type="hidden" class="form-control" id="id" name="id[]">
                                                            <input type="hidden" class="form-control" id="description0" name="description[]">

                                                        <!-- <div class="col-md-3 mb-3" >
                                                            <label for="validationCustomUsername">Description</label>
                                                            <input type="hidden" class="form-control" id="id" name="id[]">
                                                            <input type="text" class="form-control" id="description0" name="description[]">
                                                        </div> -->

                                                        <div class="col-md-2">
                                                            <label for="validationCustomUsername">Unit Price</label>
                                                            <input type="number" oninput="calculate(this.value,0)" class="form-control" id="price0" name="price[]">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="validationCustomUsername" >Quantity<span class="error">*</span></label>
                                                            <input type="number" oninput="calculate(this.value,0)" class="form-control" id="qty0" name="qty[]">
                                                            @error('qty.*')
                                                                <div class="error">*{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <input type="hidden"  onkeyup="calculate(this.value,0)" class="form-control tax" id="tax0" name="tax[]">

                                                        <!-- <div class="col-md-2">
                                                            <label for="validationCustomUsername">Tax %</label>
                                                            <input type="number"  onkeyup="calculate(this.value,0)" class="form-control tax" id="tax0" name="tax[]">
                                                        </div> -->

                                                        {{-- <div class="col-md-2">
                                                            <label for="validationCustomUsername" id="qtylal0">Tax Amount</label> --}}
                                                            <input type="hidden" class="form-control" id="gsttaxamount0" name="gsttaxamount[]" >
                                                        {{-- </div> --}}

                                                        <div class="col-md-2">
                                                            <label for="validationCustomUsername">Total Amount</label>
                                                            <input type="text" class="form-control totalPrice" id="gstamount0" name="gstamount[]" readonly>
                                                        </div>
                                                        </div>
                                                </div>
                                            </div>
                                                        <div class="col-md-4 col-lg-4" id="adremovebuttons"><br/>
                                                                <button type="button" id="button1"
                                                                    class="add-field btn btn-info btn-circle"><i class="fa fa-plus-circle"
                                                                    aria-hidden="true"></i></button>&nbsp;&nbsp;
                                                                <!-- <button type="button" id="button2"
                                                                    class="remove-field btn btn-danger btn-circle1"><i
                                                                    class="fa fa-minus-circle" aria-hidden="true"></i></button> -->
                                                        </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12  d-flex justify-content-end">
                                            <table class="table table-bordered text-right">
                                                <tr>
                                                    <td class="w-75">Taxable Price</td>
                                                    <td>
                                                    <input type="text" readonly  class="form-control " id="grandtotal" name="grandtotal">
                                                    </td>
                                                </tr>                                                                                       
                                                <tr>
                                                    <td>Tax(Amt)</td>
                                                    <td>
                                                        <input type="number" readonly id='tottaltax'  class="form-control  @error('tottaltax') is-invalid @enderror" name="tottaltax" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total</td>
                                                    <td>
                                                    <input type="text" readonly class="form-control  " name="taxable_amount" id="taxable_amount" style="background-color: white">                                                </td>
                                                </tr>
                                                <!--<tr>
                                                    <td>Collected Amount</td>
                                                    <td> -->
                                                    <input type="hidden" readonly class="form-control  " name="collected" id="collected" style="background-color: white" value="0">                                                </td>
                                                <!--</td>
                                                </tr>
                                                <tr>
                                                    <td>Balance Amount</td>
                                                    <td> -->
                                                    <input type="hidden" class="form-control  " name="balance" id="balance" style="background-color: white" value="0">                                                </td>
                                                <!--</td>
                                                </tr> -->
                                            </table>
                                        </div>
                                    </div>
                                        <!-- <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername"></label><br>
                                            <button class="btn btn-primary" id="add_product" onclick="myFunction()">Add
                                        Material</button> -->

                        <div class="col-md-3 mb-3">
                        <label for="validationCustomUsername" style="color: transparent;">Bill</label><br>
                        <button class="btn btn-primary" id="finalOrderPurchase" onclick="myFunction()">Add Quotation</button>
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
        

        <!-- <div class="card">
                <h7 class="card-header">Suplier</h7>
                <div class="card-body  p-4">
            </div>
        </div> -->


        <form action="{{ route('sale.final_invoice') }}" method="post">
            @csrf()
            <div class="row">
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script>

        function calculatefinal(val, no){

            var taxable =  Number($("#grandtotal").val());
            
                    var tax = Number($("#taxtype").val());
 
                    var tattax = taxable * tax / 100;
                    var tot = tattax + taxable;
                    $("#tottaltax").val(tattax);
                    var total_amount = $("#taxable_amount").val(Math.round(tot));
                    var collected = $("#collected").val();
                    var bal = tot - collected;
                    $("#balance").val(Math.round(bal));       
            
        }

        function calculate(val, no){

            var taxable = $("#price"+no).val();
           var qty = $("#qty"+no).val();
           var tax = Number($("#taxtype").val());

           var qty_amt = taxable * qty;
        
           var taxa = qty_amt * tax / 100;
           
                    var tot = taxa + taxable;
                    $("#gsttaxamount"+no).val(taxa);
                    
           var total_amount = $("#gstamount"+no).val(Math.round(qty_amt));

           var amount = 0;
                $(".totalPrice").each(function(j, ob) {
                    amount += parseFloat(ob.value);
                });

                $("#grandtotal").val(amount);
           calculatefinal();
        }

            function get_tax(val){

                cus_id = $("#customerID").val();

                $.ajax({
                    method: "POST",
                    url: "{{ route('customer.get_tax') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: val
                    },
                    datatype: "json",
                    success: function(data) {

                           $.each(data.data, function(key, value) {
                            $(".tax").val(value.gst);
                            console.log(value.gst);

                        });

                    }
                });
            }
            function getModal(no) {
        $.ajax({
            type: "GET",
            url: "{{ route('quotation.getmodal') }}",
            success: function(data) {
                var rows = jQuery.parseJSON(data);
                var options = [];
                for (var i = 0; i < rows.length; i++) {
                    options += "<option value="+rows[i].id +"|"+rows[i].catid+"|"+rows[i].brandid+"|"+rows[i].productid+">" + rows[i].cat + '-' + rows[i].brand + '-' + rows[i].product + '(' + rows[i].count + ')' + "</option>";
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

                $('#snackbar').html("Product Added Successfully!");
                $('body').css('cursor', 'default');
                var amount = 0;
                $(".totalPrice").each(function(j, ob) {
                    amount += parseFloat(ob.value);
                });

                $("#tax_price").val(amount);
                $("#grand_total").val(amount);
                calculate(val, no)
            },
            async: false
        });
    }

    function removediv(no){

                $('.multidiv'+no).remove();
                var amount = 0;
                $(".totalPrice").each(function(j, ob) {
                    amount += parseFloat(ob.value);
                });

                $("#grandtotal").val(amount);
            }

        $(document).ready(function() {
            $("#taxtype").on("change keyup paste", function(){
            calculate();
        });
    

            setTimeout(function() {
                $(".alert-danger").slideUp(500);
                $(".alert-success").slideUp(500);
            }, 2000);



            $("#qm").on('change', function() {

                var tccondition = $('#qm').val();

                if(tccondition == 'Rental'){
                    $('#tcmeth').show();
                }else{
                    $('#tcmeth').hide();
                }
                
            });


            

            $(".delete_modal").click(function() {
                id = $(this).val();
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
                    url: "{{ route('sale.sale_delete') }}",
                    success: function(data) {
                        $("#delete_modal").modal('hide');
                        document.location.reload()
                    }
                });
            });

            $('#datatable').DataTable({
                "ordering": false
            });

            $("select").on("select2:close", function(e) {
                                $(this).valid();
            });

            $('.max').each(function() {
                var con = 0;
                        var $wrapper = $('.multi-fields', this);
                        $(".add-field", $(this)).click(function(e, count) {
                        //     var con = $("#qty0").val();
                        // if(con != 0){
                            var count = $('.multi-field').length;
                            getModal(count);
                            var row = $(
                                '<div class="multi-fields rtl-bc" id="multi"> <div class="multi-field"> <div class="row multidiv'+count+'" id="add_cal" style="; padding: 18px;">' +
                               '<div class="col-md-4"><label for="">Select Product<span class="error">*</span></label><div class="form-group"><select id="getModal' + count + '"  onchange="getproductstock(this.value,' + count + ')" name="categoryID[]" class="form-select getModal selectDrop"><option value=""> --Select--</option></select></div></div> <input type="hidden" class="form-control id" id="id" name="id[]">' +
                                '<input type="hidden" id="description' +
                                count + '" name="description[]" class="form-control" placeholder=""/>' +
                                '<div class="col-md-2"><label for="">Unit Price</label><div class="form-group"><input type="number" id="price' +
                                count + '" name="price[]" class="form-control" placeholder=""/></div></div>' +
                                '<div class="col-md-2" ><label  for="">Quantity<span class="error">*</span></label><div class="form-group"><input type="number" onkeyup="calculate(this.value,'+ count +')" id="qty' +
                                count + '" name="qty[]" class="form-control" placeholder=""/></div></div>' +
                                count +'<input type="hidden" class="form-control" id="gsttaxamount'+count+'" name="gsttaxamount[]" >'+
                                '<div class="col-md-2" ><label for="">Total Amount</label><div class="form-group"><input readonly type="number" id="gstamount' +
                                count + '" name="gstamount[]" class="form-control totalPrice"  placeholder=""/></div><div class="error"> <p  id="sell_p'+count+'"></p></div></div>' +
                                '<div class="col-md-1" style="width:4.333333%"><i class="fa fa-trash mt-5" onclick="removediv('+count+')" id="remove'+count+'" style="font-size:22px;color:red"></i></div></div></div></div>');
                            row.appendTo($wrapper);
                        // }
                        });

                    $('.remove-field', $(this)).click(function() {
                        if ($('.multi-field').length > 1)
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
                        $('form[id="quotation"]').validate({

                                rules: {
                                customerID: 'required',
                                qm: 'required',
                                tcmonth: 'required',
                                
                                'categoryID[]': 'required',
                                'qty[]': 'required',

                                },
                                messages: {
                                customerID: 'This customer is required',
                                qm: 'This reference is required',
                                tcmonth: 'This tcmonth is required',
                                
                                'categoryID[]': 'This Product is required',
                               
                                'qty[]':' Qty is required',
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


                            
  
