<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .voucher-header {
            text-align: center;
        }

        .voucher-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .voucher-details {
            margin-top: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: bold;
        }

        .voucher-footer {
            margin-top: 20px;
            text-align: right;
        }

        .voucher-signature {
            margin-top: 20px;
        }

        .signature-label {
            margin-top: 10px;
        }

        .signature-line {
            border-bottom: 1px solid #ccc;
            width: 60%;
        }
        .voucher-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .voucher-details {
            margin-top: 20px;
        }

        .detail-label {
            font-weight: bold;
        }

        .voucher-footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="voucher">
        <div class="voucher-header">
            <div class="voucher-title">Payment Voucher</div>
        </div>
        <div class="voucher-details">
            <div class="detail-row">
                <span class="detail-label">Payee:</span>
                <span>{{$update->name}}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount:</span>
                <span>{{$update->amount}}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Date:</span>
                <?php
                $time =  date('d-m-Y', strtotime($update->receive_date));
                ?>
                <span>{{$time}}</span>
            </div>

        </div>
        <div class="voucher-footer">
            <span>Total:{{$update->amount}}</span>
        </div>
        <div class="voucher-signature">
            <div class="signature-label">Authorized Signature:</div>
            <div class="signature-line"></div>
        </div>
    </div>
</body>
</html>
