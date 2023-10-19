

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






<body style="margin:20px;padding: 1px;border: 1px solid black;background-color: #fff!important;" id="printdiv">

                        <div class="row" style="padding: 30px;">
                            <h5 class=" text-center">Purchase Order List</h5>
                            <div class="col-md-6 mt-5">
                                <p style="font-weight: bold;color: #000;font-size: 17px;"></p>
                                
                                <p style="font-weight: bold;font-size: 17px;">Purchase NO :{{$data->po_no}}</p>
                                <?php
                                $purchasedate = date("d-m-Y", strtotime($data->purchaseDate));
                                ?>
                                <p style="font-weight: bold;font-size: 17px;">Purchase Date :{{$purchasedate}}</p>
                            </div>
                        <div class="col-md-6" style="    text-align: right;">
                        <img src="{{isset($data->logo) ? $data->logo:''}}" width="180px;">
                           
                        </div>
                        </div>
                        </div>



                    <hr class="mt-1">
                            <div class="row" style="padding: 30px;">
                                <div class="col-md-6">
                                    <p style="font-weight: bold;color: #000;font-size: 20px;">Supplier</p>
                                    
                                        <p style="font-weight: bold;font-size: 17px;">{{$data->supplier_name}},</p>
                                        <p> Reference ID :  {{$data->referenceID}},</p>
                                        <p style="font-size: 17px;">
                                        {{$data->s_address_line1}},<br>
                                        {{$data->s_address_line2}},<br>
                                        {{$data->s_city}}-{{$data->s_pincode}}.<br>
                                    </p>
                                    <p style="font-size: 17px;">PH :{{$data->s_phone_number}},<br>
                                        Email :{{$data->s_email}}.<br>
                                    </p>
                                </div>


                                <div class="col-sm-6" style="text-align: right;">

                                    <div  class="row">
                                        <!-- <p style="font-weight: bold;text-align: right;font-size: 17px;">Purchase NO :</p>
                                        <?php
                                        $purchasedate = date("d-m-Y", strtotime($data->purchaseDate));
                                        ?>
                                        <p style="font-weight: bold;text-align: right;font-size: 17px;">Purchase Date :  </p>
                                        <p style="font-weight: bold;text-align: right;font-size: 17px;"></p>
                                        -->
                                        <p style="font-weight: bold;color: #000;font-size: 20px;">{{$data->company}}</p>
                                        <br>
                                        <p style="font-size: 17px;"> {{$data->c_address_line1}},</p>
                                        <p>{{$data->c_address_line2}},</p>
                                        <p> {{$data->city}} - {{$data->c_pincode}},<br> </p>
                                        <p style="font-size: 17px;">PH :{{$data->c_phone_number}},<br>
                                                Email :{{$data->c_email}}.<br>
                                            </p>

                                            <!-- <div class="col-sm-3"><br><br>

                                            <h1 style="text-align: right;font-size: 17px;">Contact Information</h1>

                                            <p style="text-align: right;font-size: 17px;">{{$data->c_phone_number}}</p>

                                            <p style="text-align: right;font-size: 17px;">{{$data->c_email}}</p>

                                            </div> -->
                                    </div>
                                    <div class="col-sm-6">
                                            <!-- <p style="font-size: 17px;">{{$data->p_id}}</p>
                                            <p style="font-size: 17px;">{{$purchasedate}}</p>
                                            -->
                                        <p style="font-size: 17px;"></p>
                                    </div>
                                   
                                </div>
                                </div>
                            </div>
                        </div><br>









                        <div class="row mt-10">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">
                                      
                                        <table id="datatable_purchase" class="table table- nowrap">
                                            <thead>
                                                <tr >
                                                    <th>S.No</th>
                                                    <th>Product</th>
                                                    @if($data->type == 1)
                                                    <th></th>
                                                    @else
                                                    <th>Qty</th>
                                                    @endif
                                                    <th>HSN</th>
                                                    <th>Purchase Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Tax</th>
                                                    <th>Tax Amount</th>                                                    
                                                    <th style="text-align: right;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $subtotal = 0 ?>
                                            <?php $totaltax = 0 ?>
                                            @if($data->type == 1)
                                                @foreach($datas as $val)
                                               
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                   
                                                    <td>{{$val->category_name}}-{{$val->brand_name}}-{{$val->productName}} - {{$val->serial}}</td>
                                                    <td></td>
                                                    <td>{{$val->hsn}}</td>
                                                    <td align='right' style="padding-right: 5%;">{{number_format($val->purchase_price,2)}}</td>
                                                    <td align='right' style="padding-right: 5%;">{{number_format($val->selling_price,2)}}</td>
                                                    <td >{{$val->p_gst}}%</td>
                                                    <?php $gst = $val->selling_price * $val->p_gst / 100 ?>
                                                    <?php $subtotal += $val->purchase_price ?>
                                                    <td align='right' style="padding-right: 5%;">{{number_format($gst,2)}}</td>
                                                    <?php $totaltax += $gst ?>
                                                    <td align='right'>{{number_format($val->purchase_price,2)}}</td>
                                                    <td>
                                                    <a href="{{route('purchase.purchase_print', $val->p_id)}}"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a>
                                                        <a href="{{route('purchase.purchase_edit', $val->p_id)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                                        <i class="fa fa-trash delete_modall"  id="{{$val->p_id}}" style="font-size:22px;color:red"></i>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                @foreach($datas as $val)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <?php
                                                    $product = App\Models\product::where('id', $val->productID)->first();
                                                    $brand = App\Models\brand::where('id', $val->brandID)->first();
                                                    $NumberOfStock = App\Models\purchase::where('active', '1')->where('sale', '0')->where('rental', '0')->where('categoryID', $val->categoryID)->where('brandID', $val->brandID)->where('productID', $val->productID)->where('selling_price', $val->selling_price)->get();
                                                    $getNumberOfStock = $NumberOfStock->count();
                                                    ?>
                                                    <td>{{$val->category_name}}-{{$val->brand_name}}-{{$val->productName}}</td>
                                                    <td>{{$val->count}}</td>
                                                    <td>{{$val->hsn}}</td>
                                                    <td align='right' style="padding-right: 3%;">{{number_format($val->purchase_price,2)}}</td>
                                                    <td align='right' style="padding-right: 3%;">{{number_format($val->selling_price,2)}}</td>
                                                    <td>{{$val->p_gst}}%</td>
                                                    <?php $gst = $val->purchase_price * $val->p_gst / 100 ?>
                                                    <td align='right' style="padding-right: 3%;">{{number_format($gst,2)}}</td>
                                                    <?php $totaltax += $gst ?>
                                                    <?php $total = $val->purchase_price * $val->count ?>
                                                    <td align='right'>{{number_format($total,2)}}</td>
                                                    <?php $subtotal += $total?>
                                                    <td>
                                                    <a href="{{route('purchase.purchase_print', $val->p_id)}}"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a>
                                                        <a href="{{route('purchase.purchase_edit', $val->p_id)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                                        <i class="fa fa-trash delete_modall"  id="{{$val->p_id}}" style="font-size:22px;color:red"></i>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                               
                                               
                                                <tr>
                                                <th colspan="8" style="text-align:right;">Sub Total</th>
                                                  <td align='right' >{{number_format($subtotal,2)}}</td>
                                                </tr>
                                                <tr>
                                                  <th colspan="8" style="text-align:right;">Tax(%)</th>
                                                  
                                                  <td align='right'>{{number_format($totaltax,2)}}</td>
                                                </tr>
                                                <tr>
                                                <th colspan="8" style="text-align:right;">Grand Total</th>
                                                  <td align='right'> {{number_format($totaltax + $subtotal,2)}}</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    </div>
									</div>
								</div>
							</div>
						</div>


<footer class="page-footer-space">
          <div class="row " style="padding:30px;">
            <div class="col-md-6">
                <p style="font-weight: bold;color: #000;font-size: 20px;">Bank Details</p>
                
                        <p style="font-weight: bold;font-size: 17px;"> Account Holder Name :  {{$company->company}}</p>
                        <p style="font-weight: bold;font-size: 17px;">Bank Name :{{$data->bank_name}},</p>
                        <p style="font-weight: bold;font-size: 17px;"> Account Number :  {{$data->acc_no}}</p>
                        <p style="font-weight: bold;font-size: 17px;"> IFSC Code :  {{$data->ifsc}}</p>
                        {{-- <p style="font-weight: bold;font-size: 17px;"> Branch Name  :  {{$data->branch_name}}</p> --}}
                       <br>

                </p>
            </div>

            <div class="col-md-6" style="">
              <!-- {!!$terms->details!!} -->
              <div>
                <!-- <?php echo '$'.$terms['details']; ?> -->

              {!!$terms->details!!}
              </div>
            </div>
            <div class="col-md-12 text-center">
              <strong >Thanking you and assuring you the best of our services at all times,</strong>
            </div>
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
