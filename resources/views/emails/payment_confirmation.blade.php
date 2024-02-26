<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h5>Dear {{$data['buyers_name'] ?? ''}},</h5>
    <p>
        Thank you for your application. We are pleased to inform you that your payment has been successfully processed with <br>
        
        Order ID: {{$data['order_id'] ?? ''}} 
        Transaction ID: {{$data['transaction_id'] ?? ''}} 
        
        We appreciate your business and our team will be in touch with you within 24 hours.  
    </p>

    <p>
        Thanks & Regards,<br>
        QProperties Team
    </p>
</body>
</html>