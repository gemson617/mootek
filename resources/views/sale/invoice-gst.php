<!doctype html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>Invoice-</title>

    <style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }

    table {
        font-size: x-small;
        /* border:1px solid black;
        border-collapse: collapse; */
    }

    .tbl tfoot tr td {
        border: 1px solid #000;
        border-collapse: collapse;
        /* font-weight: bold; */
        font-size: x-small;
    }



    .gray {
        background-color: lightgray
    }

    .bord {
        border: 1px solid black;
        border-collapse: collapse
    }

    .tbl {
        border: 1px solid black;
        border-collapse: collapse
    }
    .payment-tbl{
        width: 60%;
        border-radius: 7px;
        background-color: #d2d2d2;
        padding: 6px;
        border:1px solid black;
    }
    </style>

</head>

<body>

    <table width="100%">
        <tr>
            <td align="left" style="width:100px;"><img src="https://portal.agasnational.com.au/agas/images/agas-logo.webp" alt=""
                    width="100" /></td>
            <td align="left" >
                <h3>Agas National Pty. Ltd</h3>
                <p><b>PO Box 6063</b><br>
                    <b>Riverview Qld 4303</b>
                </p>
                <p>ABN: 54 124 522 032<br>
                    ACN: 124 522 032
                </p>
            </td>
            <td align="right">
                <h3>Tax Invoice</h3>
                <p>Invoice: </p>
                <p>Customer Number: </p>
            </td>
        </tr>

    </table>
<?php
$termsArr=array('','7 Days','14 Days','21 Days','30 Days','45 Days','60 Days');
$dueArr=array('','+7','+14','+21','+30','+45','+60');
?>
     <table width="100%">
        <tr>
            <td><strong>Bill To:</strong> </td>
            <td></td>
            <td style="border:1px solid #000;">
                <?php if(isset($customer_name)){
                   ?>
                    <p><?php echo ($account_type==2) ?  strtoupper($company_name):strtoupper($customer_name); ?></p>
                    <p><?php echo strtoupper($address); ?></p>
                <?php } ?>
            </td>
            <td></td>
            <td><strong>Ship To:</strong> </td>
            <td></td>
            <td style="border:1px solid #000;">
                <?php if(isset($customer_name)){
                   ?>
                    <p><?php echo ($account_type==2) ?  strtoupper($company_name):strtoupper($customer_name); ?></p>
                    <p><?php echo strtoupper($daddress); ?></p>
                <?php } ?>
            </td>
        </tr>
    </table>
    <br />
    <table width="50%" class="tbl">
        <tr>
            <th class="bord" align="left">Date</th>
            <th class="bord" align="left">Terms</th>
            <th class="bord" align="left">Due date</th>
        </tr>
        <tr>
            <td class="bord"><?php echo date("d-m-Y"); ?></td>
            <td class="bord" style="background-color: red;"><?php if(isset($terms)){ echo ($terms==7) ? 'COD':$termsArr[$terms];}else{ echo "COD";} ?></td>
            <td class="bord" style="background-color: #00d04b;"><?php if(isset($terms)){ echo ($terms==7) ? 'COD':date("d-m-Y", strtotime($dueArr[$terms].' days')); }else{ echo date("d-m-Y"); } ?></td>
        </tr>

    </table>
    <table width="100%" class="tbl" cellpadding="4">
        <thead style="background-color: lightgray;">
            <tr>
                <th class="bord">Docket No</th>
                <th class="bord">Docket Paid</th>
                <th class="bord">Del</th>
                <th class="bord">Ret</th>
                <th class="bord">Description</th>
                <th class="bord">Unit Price EX GST</th>
                <th class="bord">Unit Price INC GST</th>
                <th class="bord">Total INC GST</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="bord" scope="row"></th>
                <td class="bord" class="bord"></td>
                <td class="bord" align="left"><?php
                ?></td>
                <td class="bord" align="left"><?php
                ?></td>


                <td class="bord" align="center"></td>

                <td class="bord" align="right">

                </td>

                <td class="bord" align="right"></td>
                <td class="bord" align="right"></td>
            </tr>

                <tr>
                    <th class="bord" scope="row"></th>
                    <td class="bord"></td>
                    <td class="bord" align="right"></td>
                    <td class="bord" align="right"></td>
                    <td class="bord" align="center">
                    </td>
                    <td class="bord" align="right">

                    </td>
                    <td class="bord" align="right"></td>
                    <td class="bord" align="right"></td>
                </tr>

            <tr>
                <th class="bord" scope="row"></th>
                <td class="bord"></td>
                <td class="bord" align="right"></td>
                <td class="bord" align="right"></td>
                <td class="bord" align="center">
                    On Hand Cylinder Facility Maintenance Fee

                </td>
                <td class="bord" align="right">

                </td>
                <td class="bord" align="right"></td>
                <td class="bord" align="right"></td>
            </tr>

            <tr>
                <th class="bord" scope="row"></th>
                <td class="bord"></td>
                <td class="bord" align="right"></td>
                <td class="bord" align="right"></td>
                <td class="bord" align="center"></td>
                <td class="bord" align="right"></td>

                <td class="bord" align="right"></td>
                <td class="bord" align="right">
                </td>
            </tr>
        </tbody>

        <tfoot class="tfoots">
            <tr>
                <td colspan="6"></td>
                <td align="right">Total EX GST</td>
                <td align="right"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td align="right">GST Amount</td>
                <td align="right"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td align="right">Total INC GST</td>
                <td align="right"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td align="right">Paid Amt</td>
                <td align="right"></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td align="right">OutStanding Amt</td>
                <td align="right"></td>
            </tr>
        </tfoot>
    </table><br>

    <h5 style="color:#03a9f4e0">Agas National Bill Enquiries contact our office on (07) 3282 5783</h5><br>

    <table width="100%">
        <tr>
            <td align="left">
                Please send remittance to:<br>
                Fax 07 3041 3578
                Email:accounts@agasnational.com.au
            </td>
            <td>
                <b>Direct Deposit: NAB</b>
                BSB: 084-402
                Acct: 874 019 132
            </td>
            <td style="background-color: red;">
            This invoice number must be entered in the description
            box so your payment can be correctly allocated
            <b>Invoice:</b>
            </td>
        </tr>

    </table><br>

    <?php if(isset($payment_statement)){
    $pay_tot=0;
    ?>
    <div class="payment-tbl">
        <h3>Payment Statement</h3>
        <table width="100%" cellpadding="4">
            <tr>
                <th align="left">Invoice</th>
                <th align="left">Date</th>
                <th align="left">Due date</th>
                <th align="left">Amount</th>
                <th align="left">Outstanding</th>
            </tr>
            <?php foreach($payment_statement as $row){
                $pay_tot +=$row['outstanding_amount']; ?>
            <tr>
                <td><?php echo '#'.$row['invoice_id']; ?></td>
                <td><?php echo date('d-m-Y',strtotime($row['created_at'])); ?></td>
                <td><?php if(isset($terms) &&  ($terms !=7)){
                   $cur_date=date('d-m-Y');
                  // $date=strtotime($dueArr[$terms].' days',strtotime($row['created_at']));
                   $date = date('d-m-Y', strtotime($row['created_at'] . $dueArr[$terms]." days"));
                   echo ($date > $cur_date) ? 'OVER DUE':$date;
                     }else{ echo "OVER DUE";}?></td>
                <td><?php echo '$'.$row['grand_total']; ?></td>
                <td><?php echo '$'.$row['outstanding_amount']; ?></td>

            </tr>
            <?php } ?>
            <tfoot >
            <tr>
                <td  align="right" colspan="4">Total</td>
                <td align="left"><?php echo '$'.$pay_tot; ?></td>
            </tr>
            </tfoot>

        </table>
    </div><br>

 <?php  } ?>



</body>

</html>
