<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Receipt</title>
</head>

<body style='padding :5% !important;border:1px solid black;'>
    <?php
    // $purchase_details = App\Models\purchase_order::where('purchase_orders.id', $history->invoiceID)->leftjoin('customers', 'purchase_orders.customerID', '=', 'customers.id')
    // ->leftjoin('companies','purchase_orders.companyID','=','companies.id')->select('purchase_orders.*','customers.name','companies.*')->first();
    // //  dd($purchase_details);
    $number = $hand; 
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
    }

    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
        "." . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';
    $words  = $result . "Rupees  ";

    use Illuminate\Support\Facades\Auth;

    ?>

    <table width="100%">
        <tr width='100%'>
            <td align="left" style="width:50%;">
                <span>{{$details->company}}</span><br>
                <span> Address : <?php echo  $details->address_line1 . '<br>' . $details->address_line2; ?> </span><br>
                <span> Phone No : <?php echo $details->phone_number; ?></span><br>
                <span> Email ID : <?php echo  $details->email; ?></span><br>
            </td>
            <td align="right" style="width:50%;">
                <span>

                    <img src="https://app.teamworksystem.com/teamwork/images/512 x512_old.png" alt="img" style='width:100px' class="avatar avatar-md brround">
                </span>
            </td>
        </tr>

    </table>
    <table width="100%">
        <tr>
            <td style="width:100%">
                <p style="text-decoration: underline;text-align: center;">Receipt</p>
            </td>
        </tr>
    </table> 
    <table width='100%'>
        <tr width='100%'>
            <td align="left" style="width:50%;">No : <?php echo  $history->invoiceID;  ?> </td>
            <?php
                                    $paymentDate = date("d-m-Y", strtotime($history->paymentDate));
                                    ?>
            <td  align="right" style="width:50%;">Date : <?php echo  $paymentDate; ?> </td>

        </tr>
    </table>
    <table>
        <tr>
            <td style="width:70%">
                <p style="text-indent: 50px">Received with thanks from <span style="text-decoration: underline;"><?= $supplier->supplier_name; ?> </span>&nbsp;&nbsp;&nbsp;Rupees 
               <span style="text-decoration: underline;"><?= $words .'Only'; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                By Cash in Part/full.</p>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td align="left" style="width:50%;">
                <strong >Received  Amount:  Rs.<span style="padding:3px">  <?= $hand; ?></span></strong> <br>
                <strong >Payment Mode:<span style="padding:3px">  <?= $history->payment_mode; ?></span></strong> 
                <br>
          
            </td>
            <td align="right" style="width:50%;">
                <p>Receiver Signature</p>
            </td>

        </tr>
    </table>
</body>

</html>