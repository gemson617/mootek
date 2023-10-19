@extends('layouts.app')

@section('content')
    <div class="app-content page-body">
        <div class="container">
        <form id="quotation" method="post" action="{{ route('quotation.update') }}">
            @csrf
            <div class="card">
                <h7 class="card-header">QUOTATION</h7>
                <div class="card-body  p-3">
                    <div class="row mt-2">

                    <div class="col-md-3 mb-3">
                        <label for="">Select Customer</label>
                        <select class="form-select" id="customerID" name="customerID" value="{{$data->customerID}}">
                            <option value="">--Select--</option>
                            @foreach($customer as $val)
                            <option value="{{$val->id}}" <?php echo $data->customerID == $val->id?'selected':' ' ?>>{{$val->name}}</option>
                            <option value="{{$val->id}}">{{$val->name}}</option>
                           @endforeach
                        </select>
                        </div>

                        <div class="col-md-3 mb-3">
                        <label for="validationCustom01"> Quotation Method</label>
                        <select class="form-control " id="qm" name="qm" value="{{$data->gsttaxamount}}">
                            <!---->
                            <option value="Rental" <?php echo $data->gsttaxamount == "Rental"?'selected':' ' ?> >Rental</option>
                            <option value="Sales"  <?php echo $data->gsttaxamount == "Sales"?'selected':' ' ?> >Sales</option>
                        </select>
                        </div>

                        <div class="col-md-3 mb-3" id="tcmeth"  <?php echo $data->gsttaxamount == "Sales"? 'style="display:none"':'' ?>>
                        <label for="validationCustom01"> T&amp;C Month </label>
                        <input type="text" class="form-control" id="tcmonth" name="tcmonth" value="{{$data->tcmonth}}" placeholder="Enter month for T&amp;C">
                        </div>
                        <input type="hidden" class="form-control" id="quotation_id" name="quotation_id" value="{{$data->q_id}}">


                        <div class="col-md-3 mb-3" style="width: 19.499999995%">
                            <label for="validationCustomUsername">Tax</label>
                            <select  class="form-select   @error('taxtype') is-invalid @enderror" id="taxtype" name="taxtype" placeholder=""  >
                                <!-- <option value="">--Select--</option> -->
                                @foreach($tax as $val)
                                @if($val->name != 0)
                                <option value="{{$val->name}}" <?php echo $data->tax_type==$val->name?'selected':'';  ?>>Including Tax ({{$val->name}}%)</option>
                                @endif
                                @endforeach
                                <option value="0">Excluding Tax</option>
                            </select>
                            @error('rent_month')
                            <div class="error">*The rent day/week/month field is required.</div>
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
                                <h3 class="card-title">Edit Quotation</h3>
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
                                        <div class="max rtl-bc" >
                                            <div class="multi-fields">
                                            @foreach($quotation as $key=>$val)
                                        <hr>
                                                <div class="multi-field" >
                                                    <div class="row multidiv{{$key}}" id="add_cal">
                                                        <!-- <div class="col-md-3 mb-3">
                                                            <label for="validationCustomUsername">Model</label>
                                                            <input type="text" class="form-control" id="product" name="product[{{$key}}]" value="{{$val->product}}">
                                                        </div> -->

                                                    <div class="col-md-4 ">
                                                        <label for="">Select Product<span class="error">*</span></label>
                                                        <div class="form-group">
                                                            <select id='categoryID' onchange="getproductstock(this.value,0)" disabled
                                                                class="selectDrop form-select txt-num  @error('categoryID') is-invalid @enderror"
                                                                value="" name="categoryID[]">
                                                                <!-- <option value=""> --Select--</option> -->


                                                                <option value="{{$val->id}}">{{$val->category_name}}-{{$val->brand_name}}-{{$val->productName}}</option>

                                                            </select>
                                                            @error('categoryID.*')
                                                                <div class="error">*The Product field is required</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <input type="hidden" class="form-control" id="categoryID" name="categoryID[]" value="{{$val->id}}">
                                                    <input type="hidden" class="form-control" id="description" name="description[]" value="{{$val->description}}">
                                                    <input type="hidden" class="form-control product_id" id="product_id" name="product_id[]" value="{{$val->qp_id}}">

                                                        <!-- <div class="col-md-3 mb-3">
                                                        <input type="hidden" class="form-control product_id" id="product_id" name="product_id[{{$key}}]" value="{{$val->qp_id}}">
                                                            <label for="validationCustomUsername">Description</label>
                                                        </div> -->
                                                        <div class="col-md-2 ">
                                                            <label for="validationCustomUsername">Unit Price</label>
                                                            <input type="number" oninput="calculate(this.value,{{$key}})" class="form-control" value="{{$val->price}}" id="price{{$key}}" name="price[]">
                                                        </div>

                                                        <div class="col-md-1">
                                                            <label for="validationCustomUsername">Quantity</label>
                                                            <input type="number" oninput="calculate(this.value,{{$key}})" class="form-control" id="qty{{$key}}" name="qty[]" value="{{$val->qty}}">
                                                        </div>

                                                        <input type="hidden" readonly onkeyup="calculate(this.value,{{$key}})" class="form-control" id="tax{{$key}}" name="tax[]" value="{{$val->tax}}">

                                                        <!-- <div class="col-md-3 mb-3">
                                                            <label for="validationCustomUsername">Tax %</label>
                                                            <input type="number" readonly onkeyup="calculate(this.value,{{$key}})" class="form-control" id="tax{{$key}}" name="tax[{{$key}}]" value="{{$val->tax}}">
                                                        </div> -->

                                                        {{-- <div class="col-md-2 ">
                                                            <label for="validationCustomUsername">Tax Amount({{$val->tax}}%)</label> --}}
                                                            <input type="hidden" class="form-control" id="gsttaxamount{{$key}}" name="gsttaxamount[]" value="{{$val->gsttaxamount}}" readonly>
                                                        {{-- </div> --}}
                                                        <div class="col-md-2 ">
                                                            <label for="validationCustomUsername"> Total Amount</label>
                                                            <input type="text" class="form-control totalPrice" id="gstamount{{$key}}" name="gstamount[]"  value="{{$val->gstamount}}" readonly>
                                                        </div>

                                                        <div class="col-md-1 mt-4">
                                                        <i class="fa fa-trash delete_modalll" onclick="productremovediv({{$key}})"  id="{{$val->qp_id}}" style="font-size:22px;color:red"></i>
                                                        </div>
                                                        <input type="hidden" id='id{{$key}}' name='id[]' value="{{$val->qp_id}} ">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div id="removefield">
                                                <!-- <input type="hidden" id='removeid' name='removeid[]' value=""> -->
                                            </div>
                                                        <div class="col-md-4 col-lg-4" id="adremovebuttons"><br/>
                                                                <button type="button" id="button1"
                                                                    class="add-field btn btn-info btn-circle"><i class="fa fa-plus-circle"
                                                                    aria-hidden="true"></i></button>&nbsp;&nbsp;
                                                                <!-- <button type="button" id="button2"
                                                                    class="remove-field btn btn-danger btn-circle1"><i
                                                                    class="fa fa-minus-circle" aria-hidden="true"></i></button> -->
                                                            </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label for="validationCustomUsername" style="color: transparent;">Bill</label><br>
                                                            <button class="btn btn-primary" id="finalOrderPurchase" onclick="myFunction()">Update Quotation</button>
                                                        </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12  d-flex justify-content-end">
                                            <table class="table table-bordered text-right">
                                                <tr>
                                                    <td class="w-75">Taxable Price</td>
                                                    <td>
                                                    <input type="text" readonly  class="form-control " id="grandtotal" value="{{$data->taxable_price}}" name="grandtotal">
                                                    </td>
                                                </tr>                                                                                       
                                                <tr>
                                                    <td>Tax(Amt)</td>
                                                    <td>                                                        
                                                        <input type="number" readonly id="tottaltax" value="{{$data->q_tax}}"  class="form-control  @error('tottaltax') is-invalid @enderror" name="tottaltax" >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total</td>
                                                    <td>
                                                    <input type="text" readonly class="form-control" value="{{$data->grand_total}}" name="taxable_amount" id="taxable_amount" style="background-color: white">                                                </td>
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
                                                Material</button>
                                        </div>-->


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
							<div class="col-12">
								<div class="card">
									<h5 class="card-header">Product  List</h5>
									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">
                                        <table id="datatable" class="table table-Responsive  nowrap">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Model</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($quotation as $val)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$val->product}}</td>
                                                    <td>{{$val->description}}</td>
                                                    <td>{{$val->gstamount}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
									</div>
								</div>
							</div>
						</div> -->
        </form>
        </div>
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
        var tax = $("#taxtype").val();
         console.log(tax);
        var qty_amt = taxable * qty;

        var taxa = taxable * tax / 100;
                var tot = taxa + taxable;
                console.log(no);
                $("#gsttaxamount"+no).val(taxa);
                console.log($("#gsttaxamount"+no).val());
        var total_amount = $("#gstamount"+no).val(Math.round(qty_amt));

        var amount = 0;
            $(".totalPrice").each(function(j, ob) {
                amount += parseFloat(ob.value);
            });

            $("#grandtotal").val(amount);
        calculatefinal();
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
            },

            async: false

        });
    }

    function productremovediv(no){
                var idd = $('#id'+no).val();
                var $wrapper = $('#removefield');
                var row = $('<input type="hidden" id="removeid" name="removeid[]" value="'+idd+'">');
                row.appendTo($wrapper);
                $('.multidiv'+no).remove();
            }
    function removediv(no){
                // alert(no);
                $('.multidiv'+no).remove();
                calculate();
            }


        $(document).ready(function() {


        $("#taxtype").on("change keyup paste", function(){
            calculate();
        });



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
                if(tccondition == 'Rental'){
                    $('#tcmeth').show();
                }else{
                    $('#tcmeth').hide();
                }
            });

            var count_id = 0;
                $(".product_id").each(function(j, ob) {

                    if(ob.value != null){
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
                            '<div class="multi-fields mt-2 rtl-bc" id="multi"> <div class="multi-field"> <div class="row multidiv'+count+'" id="add_cal" style="; padding: 18px;">' +
                           '<div class="col-md-4"><label for="">Select Product<span class="error">*</span></label><div class="form-group"><select id="getModal' + count + '"  onchange="getproductstock(this.value,' + count + ')" name="categoryID[]" class="form-select getModal selectDrop"><option value=""> --Select--</option></select></div></div> <input type="hidden" class="form-control product_id" id="product_id" name="product_id[]">' +
                            '<input type="hidden" id="description' +
                            count + '" name="description[]" class="form-control" placeholder=""/>' +
                            '<div class="col-md-2"><label for="">Unit Price</label><div class="form-group"><input type="number" id="price' +
                            count + '" name="price[]" class="form-control" placeholder=""/></div></div>' +
                            '<div class="col-md-1"><label  for="">Quantity<span class="error">*</span></label><div class="form-group"><input type="number" onkeyup="calculate(this.value,'+ count +')" id="qty' +
                            count + '" name="qty[]" class="form-control" placeholder=""/></div></div>' +
                            '<input type="hidden" class="form-control" id="gsttaxamount'+count+'" name="gsttaxamount[]" >'+
                            '<div class="col-md-2"><label for="">Total Amount</label><div class="form-group"><input readonly type="number" id="gstamount' +
                            count + '" name="gstamount[]" class="form-control totalPrice"  placeholder=""/></div><div class="error"> <p  id="sell_p'+count+'"></p></div></div>' +
                            '<div class="col-md-1"><i class="fa fa-trash mt-4" onclick="removediv('+count+')" id="remove'+count+'" style="font-size:22px;color:red"></i></div></div></div></div>');
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
                            $('form[id="quotation"]').validate({
                                rules: {
                                customerID: 'required',
                                qm: 'required',
                                tcmonth: 'required',

                                'categoryID[]': 'required',
                                'qty[]': 'required',

                                },
                                messages: {
                                customerID: 'This supplier is required',
                                qm: 'This reference is required',
                                tcmonth: 'This purchaseDate is required',

                                'categoryID[]': 'This category is required',

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




