@extends('layouts.app')

@section('content')



<div class="content-wrapper">
	   <div id="snackbar"></div>
			<div class="content container">
				<!--START PAGE HEADER -->

				<header class="page-header">
					<div class="d-flex align-items-center">
						<div class="mr-auto">
						</div>
						<ul class="actions top-right">
							<li class="dropdown">
								<!-- <a href="product.php" class="btn "  aria-expanded="false">
									View Product List<i class="la la-eye"></i>
								</a> -->
							</li>
						</ul>
					</div>
				</header>

				<section class="page-content">
                <form id="rental" method="post" action="{{route('rental.rental_store')}}">
                    @csrf
                    <div class="card">
                        <h7 class="card-header">RENTAL</h7>
                        <div class="card-body  p-3">
                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <div class="row ">
                                            <div class="col-md-3 mb-3">
												<label for="validationCustomUsername">Select Customer Name</label>
												<select class="form-select @error('customerID') is-invalid @enderror" id="customerID" name="customerID">
													<option value="">--Select--</option>
                                                    @foreach($cdata as $bdata)
                                                    <option value="{{$bdata->id}}">{{$bdata->name}}</option>
                                                    @endforeach
												</select>
                                                @error('customerID')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
											</div>

                                            <!-- <div class="col-md-3 mb-3">
												<label for="validationCustomUsername">Select Terms and Condition</label>
												<select class="form-select @error('terms') is-invalid @enderror" id="terms" name="terms">
													<option value="1">Sale Non Gst</option>
                                                    <option value="3">Rental</option>
                                                    <option value="4">Sale GST</option>
												</select>
                                                @error('terms')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
											</div> -->

                                            <div class="col-md-3 mb-3">
													<label for="validationCustomUsername">Date</label>
													<input type="date" class="form-control   @error('rent_date') is-invalid @enderror" id="rent_date" name="rent_date" placeholder=""  >
                                                @error('rent_date')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
											</div>

                                            <div class="col-md-2 mb-3">
													<label for="validationCustomUsername">Day/Week/Month </label>
													<select  class="form-select   @error('dayweekmonth') is-invalid @enderror" id="dayweekmonth" name="dayweekmonth">
                                                    <option value="">--Select--</option>
                                                    <option value="Day">Day</option>
                                                    <option value="Week">Week</option>
                                                    <option value="Month">Month</option>
                                                    </select>
                                                    @error('dayweekmonth')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
											</div>
                                         
                                            <div class="col-md-2 mb-3" style="width: 12.499999995%">
												<label for="validationCustomUsername">D/W/M</label>
                                                <select  class="form-select   @error('rent_month') is-invalid @enderror" onchange="calculatemoth()" id="rent_month" name="rent_month" placeholder=""  >
                                                    <!-- <option value="">--Select--</option> -->
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                                @error('rent_month')
                                                <div class="error">*The rent day/week/month field is required.</div>
                                                @enderror
												</div>


                                                <div class="col-md-2 mb-3" style="width: 19.499999995%">
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

											<!-- <div class="col-md-3 mb-3">
												<br><button class="btn btn-primary" id="final_purchase" >Add Rental</button>
											</div> -->
                            </div>
                        </div>
                    </div>



						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<h5 class="card-header">Add Rental</h5>

										<div class="card-body">
                                   


                            <div class="max rtl-bc">
                                <div class="multi-fields">
                                    <div class="multi-field" style="margin: 15px;">
										<div class="row">
                                            <input type="hidden" id='id' name='id'>
												<div class="col-md-4 mb-3">
                                                    <label for="">Select Product<span class="error">*</span></label>
                                                    <div class="form-group">
                                                        <select  id='getModal0' class="form-select   @error('categoryID') is-invalid @enderror" onchange="getproductstock(this.value,'0')" value="" name="categoryID[]" >
                                                        <option value=""> --Select--</option>{{$p_data}}
                                                        @foreach($p_data as $key => $val)
                                                        <?php
                                                        $product     = App\Models\product::where('id', $val->productID)->first();
                                                        $brand = App\Models\brand::where('id', $val->brandID)->first();
                                                        $NumberOfStock = App\Models\purchase::where('active', '1')->where('stock', '1')->where('type', '0')->where('categoryID', $val->categoryID)->where('brandID', $val->brandID)->where('productID', $val->productID)->where('selling_price', $val->selling_price)->get();
                                                        $getNumberOfStock = $NumberOfStock->count();
                                                        ?>
                                                        <option title="" value="{{$val->id}}|{{$val->categoryID}}|{{$brand->id}}|{{$product->id}}">{{$brand->brand_name}}-{{$product->productName}}({{$getNumberOfStock}})</option>
                                                        @endforeach
                                                        </select>
                                                            @error('productID')
                                                        <div class="error">*{{$message}}</div>
                                                        @enderror
                                                    </div>
												</div>
                                                <input type="hidden" id="id" name="id[]">

												<div class="col-md-3 mb-3" id="loadData">
													<label for="validationCustom01">Serial No</label><br>
                                                    <div class="form-group">
                                                    <!-- <input type="text" class="form-control   @error('serialID') is-invalid @enderror" id="serialID" name="serialID" placeholder="Enter Serial Number"> -->
                                                    <input type="text" id='serial0' list="serial_name0" placeholder="Enter Serial Number" class="form-select selectDrop  @error('serial') is-invalid @enderror serial" autocomplete="off" name="serial[]" required />
                                                    <datalist class="" id="serial_name0">

                                                    </datalist>
                                                    @error('serialID')
                                                    <div class="error">*{{$message}}</div>
                                                    @enderror
                                                    </div>
												</div>

												<!-- <div class="col-md-6 mb-3" id="loadData">
													    <label for="validationCustom01 ">Description</label><br>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control   @error('rentdescription') is-invalid @enderror" id="rentdescription" name="rentdescription" placeholder="Description">
                                                        @error('rentdescription')
                                                        <div class="error">*The description is required.</div>
                                                        @enderror
                                                    </div>
												</div> -->


												<!-- <div class="col-md-3 mb-3">
													<label for="validationCustomUsername">HSN </label>
												<input type="text" class="form-control   @error('hsn') is-invalid @enderror" id="hsn" name="hsn" placeholder="Enter HSN Code"  >
                                                    @error('hsn')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
												</div> -->

                                              

												<div class="col-md-3 mb-3">
													<label class="prize" for="validationCustomUsername">Price</label>
													<input type="number" class="form-control rent_price  @error('rent_price') is-invalid @enderror" oninput="calculatesubtotal(this.value,0)" id="rent_price0" name="rent_price[]" placeholder="Enter Price"  >
                                                    @error('rent_price')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
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

												<!-- <div class="col-md-3 mb-3"><br>
													<button class="btn btn-primary" id="add_roduct" >Save</button>
												</div> -->
                            </div>


                                <div class="row mt-3">
                                    <div class="col-md-12  d-flex justify-content-end">
                                        <table class="table table-bordered text-right">
                                            <tr>
                                                <td class="w-75">Taxable Price</td>
                                                <td>
                                                <input type="text" readonly  class="form-control " id="taxable_amount" name="taxable_amount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Discount(-)</td>
                                                <td>
                                                <input type="number" class="form-control  " name="discount" id="discount" style="background-color: white">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Delivery Charges(+)</td>
                                                <td>
                                                    <input type="number" id='delivery'  class="form-control  @error('discount') is-invalid @enderror" name="delivery" />
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td>Pickup Charges(+)</td>
                                                <td>
                                                    <input type="text" id='others' class="form-control  @error('discount') is-invalid @enderror " name="others" />
                                                </td>
                                            </tr>   --}}
                                            <tr>
                                                <td>Tax(%)</td>
                                                <td>
                                                    <input type="number" readonly id='tax_percentage'  class="form-control  @error('tax') is-invalid @enderror" disabled/>
                                                </td>
                                            </tr>                                         
                                            <tr>
                                                <td>Tax(Amt)</td>
                                                <td>
                                                    <input type="number" readonly id='tax'  class="form-control  @error('tax') is-invalid @enderror" name="tax" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Grand Total</td>
                                                <td>
                                                <input type="text" readonly class="form-control  " name="total_amount" id="total_amount" style="background-color: white">                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deposit Amount</td>
                                                <td>
                                                <input type="text"  class="form-control" value="0" name="deposit" id="deposit" style="background-color: white">                                                </td>
                                            </tr>
                                            <!--<tr>
                                                <td>Collected Amount</td>
                                                <td> -->
                                                <input type="hidden" class="form-control  " name="collected" id="collected" style="background-color: white" value="0">                                                </td>
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
                                    <div class="col-md-2 mt-2">
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-sm btn-success mr-1">Add Rental</button>
                                        </div>
                                    </div>
                                </div>
								</div>
							</div>
						</div>
                        </form>
					</section>
				</div>
			</div>
		</div>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
    });

        function calculatesubtotal(val, no){

            var amount = 0;
                $(".rent_price").each(function(j, ob) {
                    amount += parseFloat(ob.value);
                });

                // var rentalduration =  $("#rent_month").val();
                // var taxableprice = amount * rentalduration;

            if($.isNumeric(amount)){
                $("#taxable_amount").val(amount);
            }
               
                calculate();
        }

        function calculatemoth(){

            var amount = 0;
                $(".rent_price").each(function(j, ob) {
                    amount += parseFloat(ob.value);
                });

                var rentalduration =  $("#rent_month").val();
            // var taxableprice = amount * rentalduration;

            if($.isNumeric(amount)){
                $("#taxable_amount").val(amount);
            }
              
                calculate();
        }

                function calculate(){

                    var taxable =  $("#taxable_amount").val();
                    var disc = $("#discount").val();
                    var delivery = Number($("#delivery").val());
                    // var others = Number($("#others").val());
                    var tax = $("#taxtype").val();

                    var disc_amt = taxable - disc;

                    // var others = disc_amt + delivery + others;
                    var others = disc_amt + delivery;


                    var tax_a = others * tax / 100;
                    
                    var tot = tax_a + others;

                    $("#tax").val(tax_a);
                    var total_amount = $("#total_amount").val(Math.round(tot));
                    // $("#deposit").attr('min',Math.round(tot));
                    var collected = $("#collected").val();
                    var bal = tot - collected;
                    $("#balance").val(Math.round(bal));
                    $("#tax_percentage").val(tax);
                }

                function pricelabel(no){
                   var type = $("#dayweekmonth").val();
                   $("#rentprize"+no).text('Price Per('+type+')');
                }

    $(document).ready(function() {

        $("#taxtype").on('change', function() {
            calculate();
        });

        $("#discount").on("change keyup paste", function(){
            calculate();
        });

        $("#tax").on("change keyup paste", function(){
            calculate();
        });

        $("#collected").on("change keyup paste", function(){
            calculate();
        });

        $("#rent_price").on("change keyup paste", function(){
            calculate();
        });

        $("#taxable_amount").on("change keyup paste", function(){
            calculate();
        });

        $("#others").on("change keyup paste", function(){
            calculate();
        });


        $("#delivery").on("change keyup paste", function(){
            calculate();
        });
        

        $("#dayweekmonth").on('change', function() {

            var type =  $(this).val();
            var options = [];
            if(type == 'Day'){
                for (var i = 1; i <= 31; i++) {
                    options += "<option value="+i+">" +i+ "</option>";
                }
            }else if(type == 'Weeek'){
                for (var i = 1; i <= 7; i++) {
                    options += "<option value="+i+">" + i + "</option>";
                }
            }else{
                for (var i = 1; i <= 12; i++) {
                    options += "<option value="+i+">" + i + "</option>";
                }
            }
            $('#rent_month').empty();
            
        $('#rent_month').append(options).select2();

        $(".prize").each(function(j, ob) {
            // $(".prize").text('Price Per('+type+')');
        });
        });

     


    $(".edit_form").click(function(){
        id=$(this).val();
        $.ajax({
           type:'get',
           data:{
            id:id
           } ,
           url:"{{route('purchase.purchase_index')}}",
           success: function(data)
            {


                $("#categoryID").val(data.p_data.categoryID);
                $("#brandID").val(data.p_data.brandID);
                $("#productID").val(data.p_data.productID);
                $("#serial").val(data.p_data.serial);
                $("#hsn").val(data.p_data.hsn);
                $("#qty").val(data.p_data.qty);
                $("#purchase_price").val(data.p_data.purchase_price);
                $("#selling_price").val(data.p_data.selling_price);



                $(".card-title").html('Edit Model').css('color','red');
                   $("#id").val(data.data.id);
                   $("#categoryID").focus();
                   scrollToTop();
            }
        });
    });



        $(".delete_modall").click(function(){
           var id=this.id;
            $("#delete_id").val(id);
          $("#delete_modal").modal('show');
        });
        $("#delete").click(function(){

            id=$('#delete_id').val();
            $.ajax({
               type:'post',
               data:{
                "_token": "{{ csrf_token() }}",
                id:id,

               } ,
               url:"{{route('rent.rentaltemp_delete')}}",
               success: function(data)
                {
                   $("#delete_modal").modal('hide');
                   document.location.reload();
                }
            });
        });


//brand

    $("#categoryID").on('change', function() {
        var id = $(this).val();

        $.ajax({
            method: "POST",
            url: "{{route('model.getid')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            datatype: "json",
            success: function(data) {
    $('#brandID').empty();
    var x = document.getElementById("brandID");
  var option = document.createElement("option");
  option.text = "--Select--";
  option.value = "";
  x.add(option);

    $('#productID').empty();
    var x = document.getElementById("productID");
  var option = document.createElement("option");
  option.text = "--Select--";
  option.value = "";
  x.add(option);

    $.each(data.data, function(key, value) {
     $('#brandID')
         .append($("<option></option>")
                    .attr("value", value.id)
                    .text(value.brand_name));
    });



            }
        });
    });

// product

    $("#brandID").on('change', function() {
        var id = $(this).val();

        $.ajax({
            method: "POST",
            url: "{{route('product.getid')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            datatype: "json",
            success: function(data) {
    $('#productID').empty();
    var x = document.getElementById("productID");
    var option = document.createElement("option");
    option.text = "--Select--";
    option.value = "";
    x.add(option);
    $.each(data.data, function(key, value) {
     $('#productID')
         .append($("<option></option>")
                    .attr("title",value.description)
                    .attr("value",value.id)
                    .text(value.productName));
    });

            }
        });
    });


    //desc

    $("#productID").on('change', function() {
        var id = $(this).val();

        $.ajax({
            method: "POST",
            url: "{{route('desc.getid')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            datatype: "json",
            success: function(data) {

    $.each(data, function(key, value) {

        document.getElementById("desc").innerHTML = value.description;

    });
            }
        });
    });
        $('#datatable_rental').DataTable();

    });

    function getModal(no) {
        $.ajax({
            type: "GET",
            url: "{{ route('rental.getmodal') }}",
            success: function(data) {
                var rows = jQuery.parseJSON(data);
                var options = [];
                   console.log(rows);
                for (var i = 0; i < rows.length; i++) {
                   var desc = rows[i].description.replace( /\s+/g, "_" );
                    options += "<option title="+desc +" value="+rows[i].id +"|"+rows[i].catid+"|"+rows[i].brandid+"|"+rows[i].productid+">" + rows[i].brand + '-' + rows[i].product + '(' + rows[i].count + ')' + "</option>";
                }
                $('#getModal'+no).append(options).select2();
            }
        });
    }

    function getproductstock(val, no) {
            $.ajax({
            url: '{{route("rental.getserial")}}',
            type: 'POST',
            data: {
                id: val,
                "_token": "{{ csrf_token() }}",
            },

            beforeSend: function() {
                $('body').css('cursor', 'progress');
            },
            success: function(data) {
                
                $('#serial_name' + no).empty();
                $.each(data.data, function(key, value){
                    if (value.serial != null) {
                        $('#serial_name' + no)
                            .append($("<option></option>")
                                .attr("value", value.serial)
                                .text(value.serial));
                    }
                });
            },
            async: false
        });
    }

    $('.max').each(function() {
                var con = 0;
                        var $wrapper = $('.multi-fields', this);
                        $(".add-field", $(this)).click(function(e, count) {
                        //     var con = $("#qty0").val();
                        // if(con != 0){
                            var count = $('.multi-field').length;
                            getModal(count);
                            pricelabel(count);
                            var row = $(
                                '<div class="multi-fields rtl-bc" id="multi"> <div class="multi-field"> <div class="row multidiv'+count+'" id="add_cal" style="; padding: 18px;">' +
                               '<div class="col-md-4"><label for="">Select Product<span class="error">*</span></label><div class="form-group"><select id="getModal' + count + '"  onchange="getproductstock(this.value,' + count + ')" name="categoryID[]" class="form-select getModal selectDrop"><option value=""> --Select--</option></select></div></div> <input type="hidden" class="form-control id" id="id" name="id[]">' +
                                '<input type="hidden" id="description' +
                                count + '" name="description[]" class="form-control" placeholder=""/>' +
                                '<div class="col-md-3"><label for="">Serial No</label><div class="form-group"><input type="text" id="serial' + count + '"   name="serial[]" class="form-control serial"' + count + '" required placeholder="Enter Serial Number" list="serial_name' + count + '" autocomplete="off"/><datalist id="serial_name' + count + '" ></datalist></div></div>' +
                                '<div class="col-md-3" ><label class="prize" id="rentprize'+count+'" for="">Price</label><div class="form-group"><input  type="number" onkeyup="calculatesubtotal(this.value,'+ count +')" id="rent_price' +
                                count + '" name="rent_price[]" class="form-control rent_price"  placeholder="Enter Price"/></div><div class="error"> <p  id="rent_price'+count+'"></p></div></div>' +
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
            function removediv(no){
                $('.multidiv'+no).remove();
                calculatemoth();
            }



            // SERIAL NUMNBER VALIDATION

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
                }, "Serial is Already used");


                    var response;
                        $.validator.addMethod(
                            "serial",
                            function(value, element) {
                                
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('rental.serialvalidation') }}",
                                    data: {
                                    "_token": "{{ csrf_token() }}",
                                    checkserial : value,
                                    },
                                    datatype: "json",
                                    success: function(msg)
                                    {
                                        console.log(msg.msg);
                                        //If username exists, set response to true
                                        response = ( msg.msg == 'true' ) ? true : false;
                                    }
                                });
                                return response;
                            },
                            "Serial is Already Taken"
                        );


                        $("select").on("select2:close", function(e) {
                                $(this).valid();
                            });

                    // VALIDATION ON FORM SUBMIT
                    $('form[id="rental"]').validate({

                        rules: {
                                customerID: 'required',
                                rent_date: 'required',
                                dayweekmonth: 'required',
                                'categoryID[]': 'required',
                                'serial[]': {
                                    required: true,
                                    validate:true
                                },
                                'rent_price[]': 'required',
                                // deposit:'required'
                                },
                                messages: {
                                customerID: 'This customer is required',
                                rent_date: 'This rent date is required',
                                // dayweekmonth: 'Please Select Rental type',
                                'categoryID[]': 'This Product is required',
                                'serial[]': {
                                    required: 'This serial is required',
                                    remote: 'This serial is already used'
                                },
                                'rent_price[]':'This Price is required',
                                // deposit:'Deposit Amount is required'
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
                        // You can submit the form or perform other actions here
                    
                    }
                    });

</script>



@endsection