<!doctype html>
<html lang="en">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>Invoice-</title>

   <style type="text/css">
      * {
         font-family: sans-serif;
         margin: 0px;
         padding: 0px;
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

      td {}

      .gray {
         background-color: lightgray
      }


      .bord {
         border: 1px solid black;
         border-collapse: collapse;
         text-align: center;
      }

      .tbl {
         border: 1px solid black;
         border-collapse: collapse
      }

      .payment-tbl {
         width: 60%;
         border-radius: 7px;
         background-color: #d2d2d2;
         padding: 6px;
         border: 1px solid black;
      }

      body {
         margin: 0px !important;
      }
   </style>

</head>
<?php
$user = $purchase_details->user_id;
//sequence number
$invoiceID  = $purchase_details->invoiceID;
if ($purchase_details->collected == 0) {
   $collected1 = 0;
} else {
   $collected1 = App\Models\payment_history::where('invoiceID', $purchase_details->id)->sum('collected');
}

$user_list = App\Models\User::where('id', $user)->first();
$user_name = $user_list->user_name;
$taxable_price = $purchase_details->taxable_price;
$tax = intval($purchase_details->tax);
$discount = $purchase_details->discount;
$grand_total = $purchase_details->grand_total;
$collected = $purchase_details->collected;
$balance = $purchase_details->balance;
$delivery = $purchase_details->delivery;
$others = $purchase_details->others;
$tax_amount = $purchase_details->tax_amount;
use Illuminate\Support\Facades\DB;
//customer details

$cusID = $purchase_details->customerID;
$customer_details = App\Models\customer::where('id', $cusID)->first();
$ship_status=$customer_details->s_check_status;
$s_name=$customer_details->s_name;
$s_address_line1=$customer_details->s_address_line1;
$s_pincode=$customer_details->s_pincode;
$s_address_line2=$customer_details->s_address_line2;
$s_country=$customer_details->s_country;
$s_state=$customer_details->s_state;
$s_city=$customer_details->s_city;
$s_city_list = DB::table ('cities')->select('name')->where('id',$s_city)->first();
$s_n_city=isset($s_city_list->name)?$s_city_list->name:' ';

$customerID = ucfirst($customer_details->company);
$customerName = $customer_details->name;
$gst = $customer_details->gst;
$address_line1 = isset($customer_details->address_line1) ? $customer_details->address_line1:' ';
$address_line2 = isset($customer_details->address_line2) ? $customer_details->address_line2:' ';
$city_id = $customer_details->city;

$city_list = DB::table ('cities')->select('name')->where('id',$city_id)->first();
$companyID = $purchase_details->companyID;

$company =App\Models\company::where('id',$companyID)->first();

$city=isset($city_list->name)?$city_list->name:' ';
// dd($city_list->name);
$pincode = $customer_details->pincode;

$invoice = $purchase_details->invoice;
$date = $purchase_details->created_at;
$dateinvoice = date("d/m/Y", strtotime($date));
// $termID = $purchase_details->terms;
// $terms = App\Models\terms::where('id', $termID)->first();

if ($tax != 0) {
   $id = 4;
} else {
   $id = 2;
}
$details = App\Models\terms::where('id', $id)->first();
$termDetails = isset($details->details) ? $details->details : '';
$branch_prefix = $purchase_details->invoiceID;

//branch details
$branch = App\Models\company::where('id', $companyID)->first();

$branch_company = $branch->company;
$branch_address1 = $branch->address_line1;
$branch_address2 = $branch->address_line2;
$branch_city = $branch->city;
$branch_pincode = $branch->pincode;
$branch_gst = $branch->gst;
// $branch_prefix = $branch->prefix;
$branch_email = $branch->email;
$branch_sale_prefix = $branch->sale_prefix;
$branch_sale_no = $branch->sale_no;


// $taxhalf = $tax / 2;
// $taxhalfAmount = ($taxable_price * $tax) / 100;
// $taxhalfAmount = $taxhalfAmount / 2;
if($purchase_details->balance != 0){
   $number = $purchase_details->balance;

}else{
   $number = $purchase_details->collected;
}
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
$img = (explode("/", $branch));
?>

<?php 
if ($tax > 0) {  

?>

   <body style="margin:20px !important">
      <table width="100%">
         <tr>
            <td align="left" style="width:30%;"><img src="<?php echo isset($branch->logo)?$branch->logo:' '; ?>" width='100px'></td>
            <td align="left" style="width:40%;padding: 25px 0px 20px 13px;text-align: center;">
               <h1><?php echo $branch_company; ?></h1>
               <p ><?php echo $branch_address1 . "<br>" . $branch_address2 . "&nbsp;" . $branch_city . " - " . $branch_pincode . "<br>" . $branch_email . " " ?></p>
            </td>
            <td align="right" style="width:30%;">
               <h3>TAX INVOICE</h3>
               <p style=""><?php echo  "GST No:" . $branch_gst; ?></p>
            </td>
         </tr>
      </table>
      <table width="100%">
         <tr>
            <td style="width:30%;" align="text-align:left">
               <h3>Invoice Number:<?php echo $invoiceID; ?></h3>
               <p>Invoice Date:<?php echo $dateinvoice ?></p>
            </td>
            <td style='width:40%'>

            </td>
            <td align="text-align:right" style='width:30%'>
               <h3>Place Of Supply : Tamil Nadu(33)</h3>
               <p>Sales person :<?php echo $user_name; ?></p>
            </td>
         </tr>

      </table>
      <table width="100%">
         <tr>
            <td style='width:50%;'><strong>Bill To:</strong>
               <?php

               if ($customerID != '') {
                  echo "<p style=\"font-weight: bold;\">{$customerID},</p>";
               } else {
                  echo "<p style=\"font-weight: bold;\">{$customerName},</p>";
               }
               echo "<p style=\"\">" . $address_line1 . "<br>
           " . $address_line2 . "<br>
           " . $city . "
           " . $pincode . "<br>";
               if ($gst != '') {
                  echo "GST :" . $gst . "";
               }
               echo "</p>";
               ?>
            </td>
            <td style='width:20%;'></td>
            <td style='width:30%;'>
               <div>
                  <strong>Ship To:</strong>
                  <?php
                     if($ship_status =='1'){
                       
                        echo "<p style=\"font-weight: bold;\">{$customerName},</p>".
                        "<p style=\"\">" . $address_line1 . "<br>
          " . $address_line2 . "<br>
          " . $city . " 
          " . $pincode . "<br>";
                  if ($gst != '') {
                     echo "GST :" . $gst . "";
                  }
                  echo "</p>";
                     }else{
                        echo "<p style=\"font-weight: bold;\">{$s_name},</p>".
                        "<p style=\"\">" . $s_address_line1 . "<br>
          " . $s_address_line2 . "<br>
          " . $s_n_city . " 
          " . $s_pincode . "<br>";
                  if ($gst != '') {
                     echo "GST :" . $gst . "";
                  }
                  echo "</p>";
                     }
  

                  ?>
               </div>

            </td>
         </tr>
      </table>
      <br />
      <table width="100%" class="tbl" cellpadding="4">
         <thead style="background-color: lightgray;">
            <tr>
               <th class="bord">S.no</th>
               <th class="bord" style='width:25%'>Item & Description</th>
               <th class="bord">HSN/SAC</th>
               <th class="bord">Rate</th>
               <th class="bord">Qty</th>
               <th class="bord"> Amount</th>


            </tr>
         </thead>
         <tbody>
            <?php $tax = App\Models\tax_purchase::where('tax_purchases.active', '1')->where('tax_purchases.invoice_number', $purchase_details->id)
               ->leftJoin('categories', 'categories.id', '=', 'tax_purchases.category')
               ->leftJoin('brands', 'brands.id', '=', 'tax_purchases.brand')
               ->leftJoin('products', 'products.id', '=', 'tax_purchases.product')
               ->get();
            // $tax_amount = App\Models\tax_purchase::where('tax_purchases.active', '1')->where('tax_purchases.invoice_number', $purchase_details->id)->sum('tax_per_amount');
            $half_amount = $tax_amount / 2;
            foreach ($tax as $key => $val) {
            ?>
               <tr>
                  <td class="bord"><?php echo $key + 1; ?></td>
                  <?php if ($val->stock_status == 1) {  ?>
                     <td class="bord" style='text-align:center;' scope="row">
                        <?php echo $val->category_name . ' ' . $val->brand_name . ' ' . $val->productName; ?><br><?php echo  $val->description . '<br>'; ?>
                        <?php
                        $serial = App\Models\purchase::where('id', $purchase_details->id)->first();
                        if ($val->seial_number != '') {  ?>
                           Serial No: <?php echo  $val->seial_number;  ?>
                        <?php    }  ?>
                        </p>
                     </td>
                  <?php } else {
                  ?>
                     <td class="bord" style='text-align:center;' scope="row">
                        <?php
                        $product =  App\Models\manual_product::where('id', $val->product)->first();
                        echo  isset($product->product) ? $product->product : '' . '<br>';
                        if ($val->seial_number != '') {  ?>
                           Serial No: <?php echo  $val->seial_number;  ?>
                        <?php    }  ?>
                        </p>
                     </td>
                  <?php  }  ?>
                  <?php if ($val->stock_status == 1) {   ?>
                     <td class="bord" style='text-align:center;'><?php echo $val->hsn;  ?></td>
                  <?php     } else {
                     $product =  App\Models\manual_product::where('id', $val->product)->first();

                  ?>

                     <td class="bord" style='text-align:center;'><?php echo  isset($product->hsn) ? $product->hsn : '';  ?></td>

                  <?php      } ?>
                  <td class="bord" style='text-align:right;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($val->price, 2);   ?></td>
                  <td class="bord" class="bord" scope="row">
                     <?php
                     if ($val->quantity == '') {  ?>
                        <p style="">1</p>
                     <?php     } else { ?>
                        <p style=""><?php echo $val->quantity;   ?></p>
                     <?php         }
                     ?>
                  </td>
                  <td class="bord" style='text-align:right;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($val->price, 2);   ?></td>
               </tr>
            <?php } ?>
         </tbody>
         <?php $count = 0;
         if ($balance != 0) {
            $count += 1;
         }
         if ($collected1 != 0) {
            $count += 1;
         }
         if ($others != 0) {
            $count += 1;
         }

         if ($delivery != 0) {
            $count += 1;
         }
         if ($discount != 0) {
            $count += 1;
         }

         ?>

         <tfoot class="tfoots">
            <tr>
               <td colspan="4" rowspan="<?= 4 + $count; ?>" style="text-align: center;">
                  <p> Total In Words</p> <br>
                  <p><?= ucfirst($words) . 'Only'; ?></p><br>
                  <p style='padding:0px 0px 20px 0px;'>Thanks for your business.</p>
               </td>
               <td align="right" style='font-weight:bold;'>Sub Total</td>
               <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($taxable_price, 2); ?></td>
            </tr>
            <?php if ($discount != 0) { ?>
               <tr>

                  <td align="right" style='font-weight:bold;'>Discount</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($discount, 2); ?></td>
               </tr>
            <?php } ?>
            <?php
            if ($delivery != 0) { ?>
               <tr>
                  <td align="right" style='font-weight:bold;'>Delivery Charges</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($delivery, 2); ?></td>
               </tr>
            <?php }
            if ($others != 0) { ?>

               <tr>

                  <td align="right" style='font-weight:bold;'>Others Charges</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($others, 2); ?></td>
               </tr>
            <?php } ?>
            <tr>

               <td align="right" style='font-weight:bold;'>CGST</td>
               <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($half_amount, 2); ?></td>
            </tr>
            <tr>
               <td align="right" style='font-weight:bold;'>SGST </td>
               <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($half_amount, 2); ?></td>
            </tr>
            <tr>
               <td align="right" style='font-weight:bold;'>TOTAL</td>
               <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($grand_total, 2); ?></td>
            </tr>
            <?php if ($collected1 != 0) { ?>
               <tr>
                  <td align="right" style='font-weight:bold;'>Amount Paid</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo isset($collected1) ? number_format($collected1, 2) : ' '; ?></td>
               </tr>
            <?php }
            if ($balance != 0) { ?>

               <tr>
                  <td align="right" style='font-weight:bold;'>Balance Due (INR)</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo isset($balance) ? number_format($balance, 2) : ' '; ?></td>
               </tr>
            <?php } ?>

         </tfoot>
      </table><br><br>
      <table width="100%" class="tbl" cellpadding="4">

         <tr>
            <th class="bord" rowspan="2">Taxable Amount</th>
            <th class="bord" colspan="2">CGST</th>
            <th class="bord" colspan="2">SGST</th>
            <th class="bord" rowspan="2">Total Tax Amount</th>
         </tr>
         <tr>
            <td class="bord" style='text-align:center;'>Rate</td>
            <td class="bord" style='text-align:center;'>Amount</td>
            <td class="bord" style='text-align:center;'>Rate</td>
            <td class="bord" style='text-align:center;'>Amount</td>
         </tr>
         <?php   foreach($tax_details as $val){  ?>
         <tr>
            <td class="bord" style='text-align:center;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($val->price,2); ?></td>
       
         <td class="bord" style='text-align:center;'><?= $val->tax_per/2;  ?>%</td>
         <td class="bord" style='text-align:center;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($val->tax_per_amount/2,2); ?></td>
         <td class="bord" style='text-align:center;'><?= $val->tax_per/2;  ?>%</td>
         <td class="bord" style='text-align:center;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($val->tax_per_amount/2,2); ?></td>
            <td class="bord" style='text-align:right;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format(($val->price+$val->tax_per_amount),2); ?></td>
          
         </tr>
         <?php   }  ?>
         <tr>
         <td class="bord"  colspan="5" style='text-align:right;'>Total</td>
            <td class="bord" style='text-align:right;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format(($grand_total),2); ?></td>
          
         </tr>
      </table><br><br>

      <table width="100%">
         <tr>
            <td align="left" style="width:35%;padding: 25px 0px 20px 13px;">
               <h3>Bank Details</h3><br>
               <strong>Holder Name :</strong><?= $company->company ?>,<br>
               <strong>Bank Name :</strong><?= $branch->bank_name; ?>,<br>
               <strong>Account No :</strong><?= $branch->acc_no; ?>,<br>
               <strong>IFSC Code :</strong><?= $branch->ifsc; ?>,<br>
            </td>
            <td align="left" style="width:35%;" style="display: flex;align-content: center;justify-content: center;"><img src="https://app.teamworksystem.com/teamwork/images/signature1.png" width='100px' class='align-items:center;'></td>

            <td align="right" style="width:30%;">
               <p style=""> Terms & Conditions</p>
               <?php echo $termDetails; ?>
            </td>
         </tr>
      </table>
      <table width="100%">
         <tr>
            <td>
               <p style="font-weight: bold;text-align: center;">Material Received with Good Condition</p><br><br>

               <p style="font-weight: bold;text-align: center;">Receiver Signature</p>
            </td>
            <td width='50%'>

            </td>
            <td style='text-align: right;'>
               <p style="font-weight: bold;text-align: center;">For Teamwork System </p>
            </td>
         </tr>
      </table>
   </body>
<?php } else if ($tax == 0) {  ?>

   <body style="margin:20px !important">
      <table width="100%">
         <tr>
            <td align="left" style="width:30%;"><img src="<?php echo isset($branch->logo)?$branch->logo:' '; ?>" width='100px'></td>
            <td align="left" style="width:40%;padding: 25px 0px 20px 13px;">
               <h1><?php echo $branch_company; ?></h1>
               <p style=""><?php echo $branch_address1 . "<br>" . $branch_address2 . "&nbsp;" . $branch_city . " - " . $branch_pincode . "<br>" . $branch_email . " " ?></p>
            </td>
            <td align="right" style="width:30%;">
               <h3>TAX INVOICE</h3>
               <p style=""><?php echo  "GST No:" . $branch_gst; ?></p>
            </td>
         </tr>

      </table>
      <table width="100%">
         <tr>
            <td style="width:30%;" align="text-align:left">
               <h3>Invoice Number:<?php echo $invoiceID; ?></h3>
               <p>Invoice Date:<?php echo $dateinvoice ?></p>
            </td>
            <td style='width:40%'>

            </td>
            <td align="text-align:right" style='width:30%'>
               <h3>Place Of Supply : Tamil Nadu(33)</h3>
               <p>Sales person :<?php echo $user_name; ?></p>
            </td>
         </tr>

      </table>
      <table width="100%">
         <tr>
            <td style='width:50%;'><strong>Bill To:</strong>
               <?php

               if ($customerID != '') {
                  echo "<p style=\"font-weight: bold;\">{$customerID},</p>";
               } else {
                  echo "<p style=\"font-weight: bold;\">{$customerName},</p>";
               }
               echo "<p style=\"\">" . $address_line1 . "<br>
           " . $address_line2 . "<br>
           " . $city . "
           " . $pincode . "<br>";
               if ($gst != '') {
                  echo "GST :" . $gst . "";
               }
               echo "</p>";

               ?>
            </td>
            <td style='width:30%;'></td>
            <td style='width:20%;'>
               <div>
                  <strong>Ship To:</strong>
                  <?php
                  echo "<p style=\"\">" . $address_line1 . "<br>
          " . $address_line2 . "<br>
          " . $city . " 
          " . $pincode . "<br>";
                  if ($gst != '') {
                     echo "GST :" . $gst . "";
                  }
                  echo "</p>";
                  ?>
               </div>

            </td>
         </tr>
      </table>
      <br />
      <table width="100%" class="tbl" cellpadding="4">
         <thead style="background-color: lightgray;">
            <tr>
               <th class="bord">S.no</th>
               <th class="bord">Item & Description</th>
               <th class="bord">HSN/SAC</th>
               <th class="bord">Qty</th>
               <th class="bord">Amount</th>

            </tr>
         </thead>
         <tbody>
            <?php $tax = App\Models\tax_purchase::where('tax_purchases.active', '1')->where('tax_purchases.invoice_number', $purchase_details->id)
               ->leftJoin('categories', 'categories.id', '=', 'tax_purchases.category')
               ->leftJoin('brands', 'brands.id', '=', 'tax_purchases.brand')
               ->leftJoin('products', 'products.id', '=', 'tax_purchases.product')
               ->get();
            foreach ($tax as $key => $val) {
            ?>
               <tr>
                  <td class="bord"><?php echo $key + 1; ?></td>
                  <?php if ($val->stock_status == 1) {  ?>
                     <td class="bord" style='text-align:center;' scope="row">
                        <?php echo $val->category_name . ' ' . $val->brand_name . ' ' . $val->productName; ?><br><?php echo  $val->description . '<br>'; ?>
                        <?php
                        if ($val->seial_number != '') {  ?>
                           Serial No: <?php echo  $val->seial_number;  ?>
                        <?php    }  ?>
                        </p>
                     </td>
                  <?php } else {
                  ?>
                     <td class="bord" style='text-align:center;' scope="row">
                        <?php
                        $product =  App\Models\manual_product::where('id', $val->product)->first();
                        echo  isset($product->product) ? $product->product : '' . '<br>';
                        if ($val->seial_number != '') {  ?>
                           Serial No: <?php echo  $val->seial_number;  ?>
                        <?php    }  ?>
                        </p>
                     </td>
                  <?php  }  ?>
                  <?php if ($val->stock_status == 1) {   ?>
                     <td class="bord" style='text-align:center;'><?php echo $val->hsn;  ?></td>
                  <?php     } else {
                     $product =  App\Models\manual_product::where('id', $val->product)->first();
                  ?>

                     <td class="bord" style='text-align:center;'><?php echo  isset($product->hsn) ? $product->hsn : '';  ?></td>

                  <?php      } ?>

                  <td class="bord" class="bord">
                     <?php
                     if ($val->quantity == '') {  ?>
                        <p style="">1</p>
                     <?php     } else { ?>
                        <p style=""><?php echo $val->quantity;   ?></p>
                     <?php         }
                     ?>
                  </td>
                  <td class="bord" style='text-align:right;'><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo $val->price;   ?></td>
               </tr>
            <?php } ?>
         </tbody>
         <tfoot class="tfoots">
            <tr>
               <?php
               $count = 0;
               if ($balance != 0) {
                  $count += 1;
               }
               if ($collected1 != 0) {
                  $count += 1;
               }
               if ($others != 0) {
                  $count += 1;
               }
               if ($delivery != 0) {
                  $count += 1;
               }
               if ($discount != 0) {
                  $count += 1;
               }
               ?>
               <td colspan="3" rowspan="<?php echo 2 + $count; ?>" style="text-align: center;">
                  <p> Total In Words</p> <br>
                  <p><?= ucfirst($words) . 'Only'; ?></p><br>
                  <p style='padding:0px 0px 20px 0px;'>Thanks for your business.</p>
               </td>
               <td align="right" style='font-weight:bold;'>Sub Total</td>
               <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($taxable_price, 2); ?></td>
            </tr>
            <?php if ($discount != 0) { ?>
               <tr>

                  <td align="right" style='font-weight:bold;'>Discount</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($discount, 2); ?></td>
               </tr>

            <?php }
            if ($delivery != 0) { ?>
               <tr>

                  <td align="right" style='font-weight:bold;'>Delivery Charges</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($delivery, 2); ?></td>
               </tr>
            <?php }
            if ($others != 0) { ?>

               <tr>

                  <td align="right" style='font-weight:bold;'>Others Charges</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($others, 2); ?></td>
               </tr>
            <?php } ?>
            <tr>
               <td align="right" style='font-weight:bold;'>TOTAL</td>
               <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo number_format($grand_total, 2); ?></td>
            </tr>
            <?php if ($collected1 != 0) { ?>
               <tr>
                  <td align="right" style='font-weight:bold;'>Amount Paid</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo isset($collected1) ? number_format($collected1, 2) : ' '; ?></td>
               </tr>
            <?php }
            if ($balance != 0) { ?>

               <tr>
                  <td align="right" style='font-weight:bold;'>Balance Due (INR)</td>
                  <td align="right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo isset($balance) ? number_format($balance, 2) : ' '; ?></td>
               </tr>
            <?php } ?>

         </tfoot>
      </table><br><br>
      <table width="100%">
         <tr>
            <td align="left" style="width:35%;padding: 25px 0px 20px 13px;">
               <h3>Bank Details</h3><br>
               <strong>Holder Name :</strong><?= $company->company ?>,<br>
               <strong>Bank Name :</strong><?= $branch->bank_name; ?>,<br>
               <strong>Account No :</strong><?= $branch->acc_no; ?>,<br>
               <strong>IFSC Code :</strong><?= $branch->ifsc; ?>,<br>
            </td>
            <td align="left" style="width:35%;" style="display: flex;align-content: center;justify-content: center;"><img src="https://app.teamworksystem.com/teamwork/images/signature1.png" width='100px' class='align-items:center;'></td>

            <td align="right" style="width:30%;">
               <p style=""> Terms & Conditions</p>
               <?php echo $termDetails; ?>
            </td>
         </tr>
      </table>
      <table width="100%">
         <tr>
            <td>
               <p style="font-weight: bold;text-align: center;">Material Received with Good Condition</p><br><br>

               <p style="font-weight: bold;text-align: center;">Receiver Signature</p>
            </td>
            <td width='50%'>

            </td>
            <td style='text-align: right;'>
               <p style="font-weight: bold;text-align: center;">For Teamwork System </p>
            </td>
         </tr>
      </table>
   </body>

<?php } ?>






</html>