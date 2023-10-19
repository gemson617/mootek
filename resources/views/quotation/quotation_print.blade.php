

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Quotation</title>
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






<body style="margin:20px;padding: 1px;border: 1px solid black;background-color: #fff!important;" id="printdiv">

                        <div class="row page-header-space" style="padding: 30px;">
                            <h3 class=" text-center">Quote<span> ({{$datas->gsttaxamount}})</span></h3>
                          <div class="col-md-6 mt-2 p-2">
                                <p style="font-weight: bold;color: #000;font-size: 17px;"></p>

                                <p style="font-weight: bold;font-size: 17px;">Ref No :{{$datas->invoice}}</p>
                                <?php
                                $qdate = date("d-m-Y", strtotime($datas->q_created_at));
                                ?>
                                <p style="font-weight: bold;font-size: 17px;"> Date :{{$qdate}}</p>
                          </div>
                          <div class="col-md-6" style="text-align: right;">
                            <img src="{{$datas->logo}}" width="180px;">
                          </div>
                        </div>
                       



                    <hr class="mt-0 ">
                            <div class="row" style="padding: 30px;">
                                <div class="col-md-6">
                                    <!-- <p style="font-weight: bold;color: #000;font-size: 20px;">Supplier</p> -->

                                        <p style="font-weight: bold;font-size: 17px;">{{$datas->cus_name}},</p>
                                        <p> GST :  {{$datas->gst}}</p>
                                        <p style="font-size: 17px;">
                                        {{$datas->cus_address_line1}},<br>
                                        {{$datas->cus_address_line2}},<br>
                                        {{$datas->cus_city}}-{{$datas->cus_pincode}}.<br>
                                    </p>
                                    <p style="font-size: 17px;">PH :{{$datas->cus_phone_number}},<br>
                                        Email : {{$datas->cus_email}}.<br>
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
                                        <p> GST :  {{$datas->c_gst}}</p>
                                        <p style="font-size: 17px;"> {{$datas->c_address_line1}},</p>
                                        <p>{{$datas->c_address_line2}},</p>
                                        <p> {{$datas->city}} - {{$datas->c_pincode}},<br> </p>
                                        <p style="font-size: 17px;">PH :{{$datas->c_phone_number}},<br>
                                                Email : {{$datas->c_email}}.<br>
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



                        <div class="row" style="padding:30px;line-height: 27px;">
                         <p> Dear {{$datas->cus_name}},</p> 
                                  {!!$declaration->details!!}
                     </div> 





                          <div class="row mt-10" style="padding:30px;">
							              <div class="col-12 " style="">
								             
									              
                                 
                                        <table id="datatable_purchase" class="table table " >
                                            <thead>
                                                <tr >
                                                    <th>S.No</th>
                                                    <th>Product</th>
                                                    <th>description</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    @if ($datas->tax_per !=0)
                                                   
                                                    <th>Tax(%)</th>
                                                    <th>Tax Amount</th>   
                                                    @endif

                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <?php $grand_total = 0 ?>
                                            <?php $tot_gst = 0 
                                            ?>
                                            <tbody>
                                                @foreach($product as $val)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>

                                                    <td>{{$val->category_name}}-{{$val->brand_name}}-{{$val->productName}}</td>
                                                    <td>{{$val->description}}</td>
                                                    <td align='right' style="padding-right: 3%;">{{number_format($val->price,2)}}</td>
                                                    <td align='right' style="padding-right: 3%;">{{$val->qty}}</td>
                                                    @if ($datas->tax_per !=0)
                                                    <td align='right' style="padding-right: 3%;">{{$val->tax}}</td>
                                                    @endif
                                                    @if ($datas->tax_per !=0)
                                                    <td align='right' style="padding-right: 5%;">{{number_format($val->gsttaxamount,2)}}</td>
                                            
                                                    @endif
                                                    <?php $total = $val->price * $val->qty ?>
                                                    <td align='right' >{{number_format($val->gstamount, 2)}}</td>
                                                    <?php $grand_total += $total ?>
                                                    <?php $tot_gst += $val->gsttaxamount ?>

                                                </tr>
                                                @endforeach
                                                <!-- <tr>
                                                <th colspan="7" style="text-align:right;">Sub Total</th>
                                                  <td></td>
                                                </tr> -->
                                                @if ($datas->tax_per !=0)
                                                   
                                                <?php $count=7; ?>
                                                @else
                                                <?php $count=5; ?>
                                                @endif
                                                <tr>
                                                  <th colspan="<?php echo $count; ?>" style="text-align:right;">Sub Total</th>
                                                  <td align='right'>{{number_format($datas->taxable_price,2)}}</td>
                                                </tr>
                                                @if ($datas->tax_per !=0)
                                                <tr>
                                                  <th colspan="<?php echo $count; ?>" style="text-align:right;">Tax</th>
                                                  <td align='right'>{{number_format($datas->tax_per,2)}}</td>
                                                </tr>
                                                @endif

                                                <tr>
                                                <th colspan="<?php echo $count; ?>" style="text-align:right;">Grand Total</th>
                                                  <td align='right'>{{number_format($datas->grand_total,2)}}</td>
                                                </tr>

                                            </tbody>
                                        </table>

							              </div>
						              </div>


<footer class="page-footer-space">
          <div class="row " style="padding:30px; ">
            <div class="col-md-6">
                <p style="font-weight: bold;color: #000;font-size: 20px;">Bank Details</p>
                <p style="font-weight: bold;font-size: 17px;"> Account Holder Name :  {{$company->company}}</p>

                        <p style="font-weight: bold;font-size: 17px;">Bank Name :{{$datas->bank_name}},</p>
                        <p style="font-weight: bold;font-size: 17px;"> Account Number :  {{$datas->acc_no}}</p>
                        <p style="font-weight: bold;font-size: 17px;"> IFSC Code :  {{$datas->ifsc}}</p>
                        {{-- <p style="font-weight: bold;font-size: 17px;"> Branch Name  :  {{$datas->branch_name}}</p> --}}
                       <br>

                </p>
            </div>

            <div class="col-md-6">
              <!-- {!!$terms->details!!} -->
              <div class="ml-10">
              {!!$terms->details!!}
              </div>
            </div>
            <div class="col-md-12 text-center">
              <strong >Thanking you and assuring you the best of our services at all times.</strong>
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
