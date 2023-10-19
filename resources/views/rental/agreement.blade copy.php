

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
      from {
          bottom: 0;
          opacity: 0;
      }

      to {
          bottom: 50px;
          opacity: 1;
      }
  }

  @keyframes fadein {
      from {
          bottom: 0; opacity: 0; 
        }

      to {
          bottom: 50px;
          opacity: 1;
      }
  }

  @-webkit-keyframes fadeout {
      from {
          bottom: 50px;
          opacity: 1;
      }

      to {
          bottom: 0;
          opacity: 0;
      }
  }

  @keyframes fadeout {
      from {
          bottom: 50px;
          opacity: 1;
      }

      to {
          bottom: 0;
          opacity: 0;
      }
  }
  @media print {
      body {
          -webkit-print-color-adjust: exact;
      }
  }

  p {
      text-align: justify;
  }
</style>

  <div class="container" id="printdiv" style="padding: 30px;font-size: 20px;">
      <div class="row">
          <h3>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; IT PRODUCT RENTAL AGREEMENT</h3>

          <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; We hereby declare that an agreement
              has been reached</p>

          <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Between
          </p>

          <p><strong>Lessor</strong></p>

          <p>(the &ldquo;Lessor&rdquo;) Managing Director: Mrs. Priya S with its office located at:# - Ph: GST:
          </p>

          <p>And</p>

          <p><strong>Lessee</strong></p>
          <div class="row"></div>
          <p>Name     <span>: </span>{{$data->name}}</p>

          <p>Mobile No:{{$data->email}}</p>

          <p>Address:{{$data->address_line1}}<br />
            {{$data->address_line2}}
              &nbsp;</p>

          <p>ID / Address Proof:</p>


          <p>To rent @foreach ($products as $key => $val)
                  {{ $val->category_name }}-{{ $val->productName }}-{{ $val->brand_name }}
                  @if (count($products) != 1)
                      /
                  @endif
              @endforeach for from the date of <?php echo date('d-m-y', strtotime($data->rental_date)); ?> to <?php echo date('d-m-y', strtotime($data->receive_date)); ?>
              &nbsp;agreed by Lessee and Lessor Now therefore in consideration of the mutual covenants and
              promises hereinafter set forth, the parties here to agree as per the Terms &amp; Conditions attached
              as follows.</p>


          <ul style="list-style-type: disc;margin-left: 45px;">
              <li>Every month rent should be paid on or before 7th of every month as prepaid.</li>
              <li>If rental is not paid by lessee on time it ends with termination of agreement And termination
                  month advance amount should not be refunded</li>
              <li>advance payment of Rs./- should be paid by Lessee to Lessor</li>
              <li>advance payment deducted for first</li>
          </ul>
          <p>Any damage/missing PC&rsquo;s Lessee will take the full responsibility to rectify or replace</p>

          <p>1. <strong>LOCATION</strong></p>

          <p>The above-mentioned PC&rsquo;s shall be used at the lessee place of business, without prior
              information to lessor lessee should not move PC&rsquo;s to other location</p>

          <p>2. <strong>ARBITRATION</strong></p>

          <p>The disputes, difference and questions whatsoever which may arise between the parties hereto during
              the continuance of the agreement or afterward, touching any clause or anything herein contained, or
              the rights, duties therewith, shall referred to arbitration and the arbitration shall be as per the
              rules of Indian Council of Arbitration.</p>

          <p>3. <strong>AGREEMENT</strong></p>

          <p>This document together with any attachment hereto signed by both parties shall constitute the entire
              binding agreement between Lessor and Lessee. The Lessor represents that he is the owner of the
              PC&rsquo;s given to Lessee as rental usage covered by this agreement<br />
              IN WITNESS WHEREOF, the parties hereto have executed this Lease as of the day and year first above
              written.</p>

          <p>&nbsp;</p>



          <div class="col-md-6">
              <p><strong>LESSOR</strong></p>
              <p>Authorized Signature</p>

              <p>

                  &nbsp;</p>

              <p>_____________________________________</p>

              <p>Name:</p>


              <p><strong>Teamwork System</strong></p>
              <p>

                  &nbsp;</p>

              <p>_____________________________________</p>



          </div>
          <div class="col-md-6">

              <p><strong>LESSEE</strong></p>

              <p>Authorized Signature</p>

              <p>

                  &nbsp;</p>

              <p>_____________________________________</p>

              <p>Name:</p>


              <p>&nbsp;</p>

              <p>

                  &nbsp;</p>

              <p>_____________________________________</p>

              <p><strong>Company/Individual<br />
                      If Company Seal:</strong></p>

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