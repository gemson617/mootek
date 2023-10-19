

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Agreement</title>
  <link href="{{ asset('agas') }}/css/style.css" rel="stylesheet" />
  <link href="{{ asset('agas') }}/css/bootstrap.css" rel="stylesheet" />
</head>
<body style="background-color: #fff!important;padding: 10px;">

  <div class="container" id="printdiv" style="padding: 30px;font-size: 20px;">
      <div class="row">
        <div class="col-md-12"><center><h4>IT PRODUCT RENTAL AGREEMENT</h3></center></div>
            <div class="col-md-12"><center><p style="font-size: 17px;text-align:center">We hereby declare that an agreement has been reached</p> </center></div>
            <div class="col-md-12"><center><p style="font-size: 17px;text-align:center">Between</p> </center></div>
            <div class="col-md-12">
                <p style="font-size: 17px;font-weight: bold;">Lessor</p>
                <p style="font-size: 17px;"><span style="font-weight: bold;">TeamWork System </span> (the “Lessor”) Managing Director: Mrs. Priya S with its office located at:# Plot No. 13/71, 28th Street,
1st Floor, Kambar Colony,
18th Main Road, Anna Nagar Chennai - 600040 Ph: 044-47412780  GST: 33BHIPP8670H1ZY</p></div>
            <div class="col-md-12"><center> <p style="font-size: 17px;text-align:center">And</p> </center></div>
            <div class="col-md-12"><p style="font-size: 17px;font-weight: bold;">Lessee</p></div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <p style="font-size: 17px;">Name </p>
                    </div>
                    <div class="col-md-9">
                        <p style="font-size: 17px;">: {{$data->name}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <p style="font-size: 17px;text-align:right">Mobile No</p>
                    </div>
                    <div class="col-md-9">
                        <p style="font-size: 17px;">:{{$data->phone_number}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <p style="font-size: 17px;">Address  </p>
                    </div>
                    <div class="col-md-9">
                        <p style="font-size: 17px;">:
                            <?php
                            echo $data->address_line1.'<br>';
                            if($data->address_line2 !=null){
                                echo $data->address_line2.'<br>';
                            }
                            ?><br>&nbsp; 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <p style="font-size: 17px;">ID / Address Proof  </p>
                    </div>
                    <div class="col-md-9">
                        <p style="font-size: 17px;">: 
                            @if ($data->aadhar_proof !=null)
                            Aadhar No:{{$data->aadhar_proof}}
                            @endif
                            @if ($data->pan_proof !=null)
                            PAN No::{{$data->pan_proof}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <p style="font-size: 17px;">To rent Laptop/Desktop/Monitor/Projector/Workstation/Printer for {{$data->nos_day_week_month}} {{$data->day_week_month}} from the date of {{date('d-m-Y', strtotime($data->rental_date))}} to {{date('d-m-Y', strtotime($data->receive_date))}} agreed by Lessee and Lessor Now therefore in consideration of the mutual covenants and promises hereinafter set forth, the parties here to agree as per the Terms &amp; Conditions attached as follows.
                </p>
            </div>
            @php
                 $count=0;
            @endphp
           
            @foreach ($products as $val )
            <div class="col-md-2">
                <p style="font-size: 16px;">EQUIPMENT DETAILS   </p>
            </div>
            <div class="col-md-10">
                <p style="font-size: 16px;">:{{$val->category_name}}/{{$val->brand_name}}{{$val->productName}}{{$val->description}}</p>
            </div>
            <div class="col-md-2">
                <p style="font-size: 16px;">SERIAL NUMBER </p>
            </div>
            <div class="col-md-10">
                <p style="font-size: 16px;">:{{$val->serialID}}</p>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <p style="font-size: 16px;">DURATION </p>
                    </div>
                    <div class="col-md-8">
                        <p style="font-size: 16px;"> : {{$data->nos_day_week_month}}{{$data->day_week_month}}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <p style="font-size: 16px;text-align:right">RENTAL/{{$data->day_week_month}}</p>
                    </div>
                    <div class="col-md-8">
                        <p style="font-size: 16px;">: {{$val->rent_price}}/-</p>
                    </div>
                </div>
            </div>
 
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <p style="font-size: 16px;">DESCRIPTION</p>
                    </div>
                    <div class="col-md-8"><?php $count+=($val->rent_price*$data->nos_day_week_month); ?>
                        <p style="font-size: 16px;">: Rs.{{$val->rent_price*$data->nos_day_week_month}}/{{$data->nos_day_week_month}}{{$data->day_week_month}}s</p>
                    </div>
                </div>
            </div>  
                        <div class="col-md-6">
            </div>
            @endforeach
            (Rental in Advance Rs.{{$data->deposit_amount}})

            <div class="col-md-12">
                <ul style="list-style-type: disc">
                    <li style="font-size: 17px;">Every month rent should be paid on or before 7th of every month as prepaid.</li>
                    <li style="font-size: 17px;">If rental is not paid by lessee on time it ends with termination of agreement And termination month advance amount should not be refunded</li>
                    <li style="font-size: 17px;">{{$data->nos_day_week_month}}{{$data->day_week_month}}s advance payment of Rs.{{$count}}/- should be paid by Lessee to Lessor</li>
                    <li style="font-size: 17px;">{{$data->nos_day_week_month}}{{$data->day_week_month}}s advance payment deducted for first {{$data->nos_day_week_month}}{{$data->day_week_month}}s  </li>
                    <p style="font-size: 17px;font-weight: bold;">Any damage/missing PC’s Lessee will take the full responsibility to rectify or replace</p>
                </ul>
            </div>
            <div class="col-md-12">
                <h4>1.  LOCATION </h4>
                <p style="font-size: 17px;">The above-mentioned PC’s shall be used at the lessee place of business, without prior information to lessor lessee should not move PC’s to other location</p>
                <h4>2.  ARBITRATION</h4>
                <p style="font-size: 17px;">The disputes, difference and questions whatsoever which may arise between the parties hereto during the continuance of the agreement or afterward, touching any clause or anything herein contained, or the rights, duties therewith, shall referred to arbitration and the arbitration shall be as per the rules of Indian Council of Arbitration.</p>
                <h4>3.  AGREEMENT</h4>
                <p style="font-size: 17px;">This document together with any attachment hereto signed by both parties shall constitute the entire binding agreement between Lessor and Lessee. The Lessor represents that he is the owner of the PC’s given to Lessee as rental usage covered by this agreement <br>IN WITNESS WHEREOF, the parties hereto have executed this Lease as of the day and year first above written.</p>
            </div>
            <div class="col-md-6">
                <p style="font-size: 17px;font-weight: bold;">LESSOR</p>
                <p style="font-size: 17px;">Authorized Signature</p><br><br><br>
                <p>_____________________________________</p>
                <p style="font-size: 17px;">Name: </p>
                <p style="font-size: 17px;">Teamwork System</p><br><br><br>
                <p>_____________________________________</p>
            </div>
            <div class="col-md-6">
                <p style="font-size: 17px;font-weight: bold;">LESSEE</p>
                <p style="font-size: 17px;">Authorized Signature</p><br><br><br>
                <p>_____________________________________</p>
                <p style="font-size: 17px;">Name: </p>
                <p style="font-size: 17px;"></p><br><br><br>
                <p>_____________________________________</p>
                <p style="font-size: 17px;">Company/Individual<br>
                    If Company Seal:<br>
                </p>
            </div>
        </div>
   </div>
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

</body>
</html>