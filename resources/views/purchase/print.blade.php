

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Purchase List</title>
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
  height: 349px;
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css" integrity="sha512-T584yQ/tdRR5QwOpfvDfVQUidzfgc2339Lc8uBDtcp/wYu80d7jwBgAxbyMh0a9YM9F8N3tdErpFI8iaGx6x5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />




<body style="margin:20px;padding: 1px;border: 1px solid black;background-color: #fff!important;" id="printdiv">
                        <div class="row" style="padding: 30px;text-align: center;">
                       <div class="col-md-12 text-center">
                        <h5 >Purchase Order List</h5>
                       </div>
                        </div>
                        <div class="row" style="padding: 30px;">
                           
                            <div class="col-md-6 mt-5">
                                <p style="font-weight: bold;color: #000;font-size: 17px;"></p>
                                
                                <p style="font-weight: bold;font-size: 17px;">Purchase NO :{{$local->invoiceID}}</p>
                                <?php
                                $purchasedate = date("d-m-Y", strtotime($local->purchaseDate));
                                ?>
                                <p style="font-weight: bold;font-size: 17px;">Purchase Date :{{$purchasedate}}</p>
                            </div>
                        <div class="col-md-6" style="    text-align: right;">
                        <img src="{{ asset('mootek/images/home.jpg') }}" width="180px;">
                           
                        </div>
                        </div>
                        </div>



                    <hr class="mt-1">
                            <div class="row" style="padding: 30px;">
                                <div class="col-md-6">
                                    
                                        <p style="font-weight: bold;font-size: 17px;">{{$local->purchase_company}},</p>
                                        <p style="font-size: 17px;">
                                        {{$local->address}},<br>
                                        {{-- {{$local->s_address_line2}},<br> --}}
                                        {{$local->city_name}}-{{$local->pincode}}.<br>
                                    </p>
                                    <p style="font-size: 17px;">PH :{{$local->contact_mobile}},<br>
                                        Email :{{$local->conatct_email}}.<br>
                                    </p>
                                </div>


                                <div class="col-sm-6" style="text-align: right;">

                                        <?php
                                        $purchasedate = date("d-m-Y", strtotime($local->purchaseDate));
                                        ?>
                                        <p style="font-weight: bold;color: #000;font-size: 20px;">{{$company->company}}</p>
                                        <p style="font-size: 17px;"> {{$company->address_line1}},</p>
                                        <p>{{$company->address_line2}},</p>
                                        <p> {{$company->city}} - {{$company->pincode}},<br> </p>
                                        <p style="font-size: 17px;">PH :{{$company->phone_number}},<br>
                                                Email :{{$company->email}}.<br>
                                            </p>

                                   
                                </div>
                                </div>
                            </div>
                        </div><br>









                        <div class="row mt-10">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
                                    <div class="row">
                                      
                                        <table id="datatable_purchase" class="table table- nowrap text-center ">
                                            <thead class="border" style="background: #008ad2 !important;">
                                                <tr >
                                                    <th>S.No</th>
                                                    <th>Product</th>
                                                    <th>Model No</th>
                                                    <th>Serial</th>
                                                    <th>Qty</th>
                                                    <th>Rate</th>
                                                    <th class="text-right">Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody class="border">
                                                @foreach($products as $key=>$val)
                                               
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                   
                                                    <td>{{$val->product_name}}</td>
                                                    <td>{{$val->model}}</td>
                                                    <td>{{$val->serial}}</td>
                                                    <td>{{$val->qty}}</td>
                                                    <td>{{number_format($val->rate,2)}}</td>
                                                    <td class="text-right">{{number_format($val->amount,2)}}</td>
                                                </tr>
                                                @endforeach
                                               
                                               
                                               
                                                <tr>
                                                <th colspan="6" style="text-align:right;">Sub Total</th>
                                                  <td align='right' >{{number_format($local->tax_price,2)}}</td>
                                                </tr>
                                                @if ($local->others)
                                                <tr>
                                                  <th colspan="6" style="text-align:right;">Others Charges(+)</th>
                                                  
                                                  <td align='right'>{{number_format($local->others,2)}}</td>
                                                </tr>
                                                @endif
                                                @if ($local->cess)
                                                <tr>
                                                  <th colspan="6" style="text-align:right;">CESS(+)</th>
                                                  
                                                  <td align='right'>{{number_format($local->cess,2)}}</td>
                                                </tr>
                                                @endif
                                              
                                                <tr>
                                                  <th colspan="6" style="text-align:right;">Tax(%)</th>
                                                  
                                                  <td align='right'>{{number_format($local->tax_percent,2)}}</td>
                                                </tr>

                                                <tr>
                                                <th colspan="6" style="text-align:right;">Grand Total</th>
                                                  <td align='right'> {{number_format($local->grand_total,2)}}</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                        
                                    </div>
									</div>
								</div>
							</div>
						</div>


          <div class="row " style="padding:30px;">
            <div class="col-md-12 text-center">
              <strong >Thanking you and assuring you the best of our services at all times,</strong>
            </div>
          </div>
            


</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js" integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


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

