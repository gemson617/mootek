

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Rental</title>
	<link href="{{ asset('agas') }}/css/style.css" rel="stylesheet" />
	<link href="{{ asset('agas') }}/css/bootstrap.css" rel="stylesheet" />

	<style>
        #snackbar {
          visibility: hidden;
          min-width: 250px;
          margin-left: -125px;
          background-color: #333;
          color: #fff;
          text-align: center;
          border-radius: 50px;
          padding: 10px;
          position: fixed;
          z-index: 1;
          left: 50%;
          bottom: 50px;
          font-size: 15px;
        }

        #snackbar.show {
          visibility: visible;
          -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
          animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
          from {bottom: 0; opacity: 0;}
          to {bottom: 50px; opacity: 1;}
        }

        @keyframes fadein {
          from {bottom: 0; opacity: 0;}
          to {bottom: 50px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
          from {bottom: 50px; opacity: 1;}
          to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
          from {bottom: 50px; opacity: 1;}
          to {bottom: 0; opacity: 0;}
        }
        </style>
</head>

<style>

/* Styles go here */

.page-header, .page-header-space {
  height: 230px;
}

.page-footer, .page-footer-space {
  height: 280px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
}

.page-header {
  position: fixed;
  top: 0px;
  width: 100%;
  padding: 10px;
}


.page {
  page-break-after: always;
}

p{
  line-height: 1.1;
  margin-bottom: 5px;
}

@page { margin: 40px; }
.page-border { position: fixed; left: 1px; top: 1px; bottom: 1px; right: 1px; border: 1px solid #000; }

@media print {
   thead {display: table-header-group;}
   tfoot {display: table-footer-group;}

   button {display: none;}

   body {margin: 0;}
}


</style>






<body style="padding: 1px;border: 1px solid black;background-color: #fff!important;" id="printdiv">

                        <div class="row page-header-space" style="padding: 30px;">
                            <h3 class=" text-center">Rental</h3>
                          <div class="col-md-6 mt-2 p-2">
                                <p style="font-weight: bold;color: #000;font-size: 17px;"></p>

                                <?php
                                $qdate = date("d-m-Y", strtotime($datas->rental_date));
                                ?>
                                <p style="font-weight: bold;font-size: 17px;">Invoice No&nbsp;  :&nbsp;{{$datas->rentalID}},</p>
                                <p style="font-weight: bold;font-size: 17px;"> Invoice Date &nbsp; &nbsp; :&nbsp; {{$qdate}},</p>
                                @if ($datas->payment_mode !=null)
                                <p style="font-weight: bold;font-size: 17px;"> Payment Type &nbsp;:&nbsp; {{$datas->payment_mode}},</p>
                                @endif
                                <p style="font-weight: bold;font-size: 17px;"> During  Period &nbsp; &nbsp; :&nbsp; {{'1'.'-'.$datas->day_week_month}},</p>

                          </div>
                          <div class="col-md-6" style="text-align: right;">
                            <img src="{{$datas->logo}}" width="180px;">
                          </div>
                        </div>


                    <hr class="mt-0 ">
                            <div class="row" style="padding: 30px;">
                                <div class="col-md-6">
                                    <!-- <p style="font-weight: bold;color: #000;font-size: 20px;">Supplier</p> -->

                                        <p style="font-weight: bold;font-size: 17px;">{{$datas->c_name}},</p>
                                        <p> GST :  {{$datas->c_gst}}</p>
                                        <p style="font-size: 17px;">
                                        {{$datas->c_address_line1}},<br>
                                        {{$datas->c_address_line2}},<br>
                                        {{$datas->c_city}}-{{$datas->c_pincode}}.<br>
                                    </p>
                                    <p style="font-size: 17px;">PH :{{$datas->c_phone_number}},<br>
                                        Email :{{$datas->c_email}}.<br>
                                    </p>
                                </div>


                                <div class="col-sm-6" style="text-align: right;">
                                    <div  class="row">
                                        <!-- <p style="font-weight: bold;text-align: right;font-size: 17px;">Purchase NO :</p>

                                        <p style="font-weight: bold;text-align: right;font-size: 17px;">Purchase Date :  </p>
                                        <p style="font-weight: bold;text-align: right;font-size: 17px;"></p>
                                        -->
                                        <p style="font-weight: bold;color: #000;font-size: 20px;">{{$datas->company}}</p>
                                        <br>
                                        <p> GST :  {{$datas->cp_gst}}</p>
                                        <p style="font-size: 17px;"> {{$datas->cp_address_line1}},</p>
                                        <p>{{$datas->cp_address_line2}},</p>
                                        <p> {{$datas->city}} - {{$datas->cp_pincode}},<br> </p>
                                        <p style="font-size: 17px;">PH :{{$datas->cp_phone_number}},<br>
                                                Email :{{$datas->cp_email}}.<br>
                                            </p>
                                            <!-- <div class="col-sm-3"><br><br>
                                            <h1 style="text-align: right;font-size: 17px;">Contact Information</h1>
                                            <p style="text-align: right;font-size: 17px;">{{$datas->c_phone_number}}</p>
                                            <p style="text-align: right;font-size: 17px;">{{$datas->c_email}}</p>
                                            </div> -->
                                    </div>
                                    <div class="col-sm-6">
                                            <!-- <p style="font-size: 17px;"></p>
                                            <p style="font-size: 17px;"></p>
                                            -->
                                        <p style="font-size: 17px;"></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div><br>



                        <div class="row" style="padding:30px;">
                     </div>
                          <div class="row mt-10" style="padding:30px;">
							              <div class="col-12 " style="">
                                <table id="datatable_purchase" class="table table " >
                                    <thead>
                                        <tr >
                                            <th>S.No</th>
                                            <th>Product</th>
                                            <th>HSN</th>
                                            <th>description</th>
                                            <th>Price Per ({{$datas->day_week_month}})</th>
                                            <th>Total ({{$datas->day_week_month}})</th>
                                            
                                            <!-- <th>Tax Amount</th> -->
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <?php $tot_amt = 0 ?>
                                    <?php $tot_gst = 0 ?>
                                    <tbody>
                                        @foreach($product as $val)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$val->category_name}}-{{$val->brand_name}}-{{$val->productName}} - {{$val->serialID}}</td>
                                            <td>{{$val->hsn}}</td>
                                            <td>{{$val->description}}</td>
                                            <td align='right' style="padding-right: 5%;">{{number_format($val->rent_price / $val->rent_month,2)}}</td>
                                            <td align='center' style="padding-right: 3%;">1</td>
                                           
                                            <?php $tax_a = $val->rent_price / $val->rent_month;  ?>
                                            <!-- <td align='right' style="padding-right: 5%;">{{number_format($tax_a,2)}}</td> -->
                                            <td align='right' >{{number_format($tax_a, 2)}}</td>
                                            <?php $tot_gst += $tax_a ?>
                                            <?php $tot_amt += $val->taxable_amount ?>
                                        </tr>
                                        @endforeach
                                        <!-- <tr>
                                        <th colspan="7" style="text-align:right;">Sub Total</th>
                                          <td></td>
                                        </tr> -->
                                        <tr>
                                          <th colspan="6" style="text-align:right;">Sub Total</th>
                                          <td align='right'>{{number_format($tot_gst,2)}}</td>
                                        </tr>
                                        @if($datas->discount != 0)
                                        <tr>
                                          <th colspan="6" style="text-align:right;">Discount</th>
                                          <td align='right'>{{number_format($val->discount,2)}}</td>
                                        </tr>
                                        @endif
                                        @if($datas->delivery != 0)
                                        <tr>
                                          <th colspan="6" style="text-align:right;">Delivery Charge</th>
                                          <td align='right'>{{number_format($val->delivery,2)}}</td>
                                        </tr>
                                        @endif
                                        @if($datas->others != 0)
                                        <tr>
                                          <th colspan="6" style="text-align:right;">Pickup Charge</th>
                                          <td align='right'>{{number_format($val->others,2)}}</td>
                                        </tr>
                                        @endif
                                        @if($datas->taxpercentage != 0)
                                        <tr>
                                          <th colspan="6" style="text-align:right;">Tax Amount({{$val->tax}}%)</th>
                                          <td align='right'>{{number_format($val->tax_amt,2)}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                        <th colspan="6" style="text-align:right;">Grand Total</th>
                                          <td align='right'>{{number_format($val->total_amount,2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
							              </div>
						              </div>

          <footer class="page-footer-space">
           <div class="row " style="padding:30px; ">
            <div class="col-md-6">
                <p style="font-weight: bold;color: #000;font-size: 20px;">Bank Details</p>
                <p style="font-weight: bold;font-size: 17px;"> Account Holder Name :  {{$datas->company}}</p>

                        <p style="font-weight: bold;font-size: 17px;">Bank Name :{{$datas->bank_name}},</p>
                        <p style="font-weight: bold;font-size: 17px;"> Account Number :  {{$datas->acc_no}}</p>
                        <p style="font-weight: bold;font-size: 17px;"> IFSC Code :  {{$datas->ifsc}}</p>
                       <br>
                </p>
            </div>

            <div class="col-md-6">
            Notes / Terms

            We declare that this invoice shows the actual price of the goods described above and that all particulars are true and correct.The goods sold are intended for end user consumption and not for resale.
              <div class="ml-10">


              </div>
            </div>
            <div class="text-center">
            We Declare that his invoice shows the actual price of the goods described and that all particulars are true and correct
            </div>
            <div class="row " style="padding:30px; ">
              <div class="col-md-6">
              Material Received with Good Condition
              Receiver Signature
              </div>
            <div class="col-md-6">
            For Teamwork System
            
            </div>
            <br><br><br><br>
            </div>
            <br><br>
</footer>

</body>

        <script type="text/javascript">

              printpage();

            function printpage() {
             var tableDiv = document.getElementById("printdiv").innerHTML;
             printContents = '';
             printContents += tableDiv;
             var originalContents = document.body.innerHTML;
             document.body.innerHTML = printContents;
             window.print();
             document.body.innerHTML = originalContents;
             }

        </script>

                <script>
					$(function(e) {
						$(".datePickerInput").datepicker({
							format: "yyyy-mm-dd",
							autoclose: true,
							orientation: "bottom",
							templates: {
								leftArrow: '<i class="icon dripicons-chevron-left"></i>',
								rightArrow: '<i class="icon dripicons-chevron-right"></i>'
							}
						});
					});
				</script>

	</body>
</html>
