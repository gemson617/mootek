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
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<h5 class="card-header">Update Rental Price</h5>

										<div class="card-body">
                                        @if (session('msg'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('msg') }}
                                        </div>
                                        @endif
                                        <form id="paymentupdate" method="post" action="{{route('rental.update_payment')}}">
                                        @csrf
											<div class="row">

                                            <input type="hidden" id='rentID' name='rentID' value="{{$data->rentalID}}">

                                            <div class="col-md-3 mb-3">
													<label for="validationCustomUsername">Customer Name</label>
													<select disabled class="form-control   @error('mop') is-invalid @enderror" id="mop" value="{{$data->mop}}" name="mop">
                                                    <option value="">{{$customer->name}}</option>
                                                    </select>
                                                    <input readonly type="hidden" class="form-control   @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{$data->total_amount}}" >
                                                @error('mop')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
												</div>

												<div class="col-md-2 mb-3" id="loadData">
													<label for="validationCustom01">Balance Amount</label><br>
                                                    <div class="form-group">
                                                    <input readonly type="text" class="form-control   @error('balance') is-invalid @enderror" id="balance" name="balance" value="{{$data->balance}}" placeholder="Enter balance Amt">
                                                    <input readonly type="hidden" class="form-control   @error('balanceamt') is-invalid @enderror" id="balanceamt" name="balanceamt" value="{{$data->balance}}" placeholder="Enter balance Amt">
                                                @error('balance')
                                                <div class="error">*{{$message}}</div>
                                                @enderror

                                                </div>
												</div>
												<div class="col-md-2 mb-3" id="loadData">
													<label for="validationCustom01">Advance Amount(3mos)</label><br>
                                                    <div class="form-group">
                                                    <input  type="text" class="form-control   @error('balance') is-invalid @enderror" id="advance" name="advance" value="{{$data->advamt >0?$data->advamt:''}}" placeholder="Enter Advance Amt">
                                                @error('balance')
                                                <div class="error">*{{$message}}</div>
                                                @enderror

                                                </div>
												</div>

                                                <div class="col-md-2 mb-3">
													<label for="validationCustomUsername">Receive Date</label>
													<input type="date" class="form-control   @error('paymentDate') is-invalid @enderror" id="paymentDate" name="paymentDate" placeholder=""  >
                                                @error('paymentDate')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
												</div>


												<div class="col-md-2 mb-3">

													<label for="validationCustomUsername">Collected Amount </label>

												<input type="text" class="form-control   @error('collected') is-invalid @enderror" id="collected" name="collected" value="{{$data->collected}}" placeholder="Enter collected Amt"  >
                                                    @error('collected')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
												</div>



												<div class="col-md-3 mb-3"><br>
													<button class="btn btn-primary" id="add_roduct" >Update Payment</button>
												</div>
											</div>
                                            </form>
										</div>

								<div class="card-body" id="purchaseTempList">
                <?php
                $total1=$total2=0;
                ?>
            <div class="row pb-5">
                <table id="datatable_rental" class="display table responsive nowrap">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Collected Amount</th>
                            <th>Balance Amount</th>
                            <th>Paid Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pay_data as $val)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$val->collected}}</td>
                            <td>{{$val->balance}}</td>
                            <?php
                                $time =  date('d-m-Y', strtotime($val->paymentDate));
                            ?>
                            <td>{{$time}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

								</div>
								</div>
							</div>
						</div>

					</section>

				</div>
<script>
    $(document).ready(function() {

        $('#datatable_rental').DataTable();


        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
    });
    $(document).ready(function() {

           $("#discount").on("change keyup paste", function(){
            calculate();
        });

        $("#tax").on("change keyup paste", function(){
            calculate();
        });

        function calculate(){

            var collected = $("#collected").val();
            var balance = $("#balanceamt").val();
            var bal = balance - collected;
            $("#balance").val(Math.round(bal));
        }

        $("#collected").on("change keyup paste", function(){
            calculate();
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
           alert(id);
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


    function addPurchaceTemp(){


var categoryID = $('#categoryID').val();

var brandID = $('#brandID').val();

var productID = $('#productID').val();

var serial = $('#serial').val();

var hsn = $('#hsn').val();
var qty = $('#qty').val();

var purchase_price = $('#purchase_price').val();

var selling_price = $('#selling_price').val();


    $.ajax({

        url: "{{route('purchase.purchase_store')}}",

        type:'POST',

        data:{
            "_token": "{{ csrf_token() }}",

            categoryID:categoryID,
            brandID:brandID,
            productID:productID,
            serial:serial,
            hsn:hsn,
            qty:qty,
            purchase_price:purchase_price,
            selling_price:selling_price,

            // addPurchaceTemp:'addPurchaceTemp'

        },

        beforeSend : function() {

            $('body').css('cursor' , 'progress');

        },

        success : function(data){



            if (data==0) {

                $('.form-control').val('');

                $(".s2_demo1").select2("val", " ");

                loadPurchaseTempTable();

                $('#snackbar').html("Model Added Successfully!");

                document.location.reload();
            }else{

                $('#snackbar').html("Serial Number Already Exist!");

            }



          $('body').css('cursor', 'default');

        },

        async : false

    });
}


                    jQuery.validator.addMethod("notEqual", function(value, element, param) {
                      return this.optional(element) || value != param;
                    }, "Please specify a different (non-default) value");


                    // VALIDATION ON FORM SUBMIT
                    $('form[id="paymentupdate"]').validate({

                    rules: {
                        balance:{
                            required: true,
                            // notEqual: "0"
                        },
                        paymentDate: 'required',
                        collected: {
                            required: true,
                            // notEqual: "0",
                            // equalTo: "#balanceamt"
                        },
                           advance:'required',

                            },
                            messages: {
                                balance: {
                                required :'This Collected Amount is required',
                                // notEqual:'Payment Already Collected'
                            },
                            paymentDate: 'This Payment Date is required',
                            collected: {
                                required :'This Collected Amount is required',
                                // notEqual:'This Collected Amount is required',
                                // equalTo : 'Please Collected Full Amount'
                            },
                            advance:"Advance Amount is Required",

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


    $(document).on('click','#add_product',function(){
	addPurchaceTemp();
    });





    });
</script>



@endsection