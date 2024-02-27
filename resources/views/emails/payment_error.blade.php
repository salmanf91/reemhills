<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h5>Dear {{$data['buyers_name'] ?? ''}},</h5>
    <p>
        We regret to inform you that we encountered an issue processing your recent payment. Unfortunately, the transaction was unsuccessful.
    </p>
    <p>
        Order ID: {{$data['order_id'] ?? ''}} <br>
    </p>
    <p>
        If you believe this to be an error or require assistance, please <a href="mailto:{{$data['contact_us'] ?? ''}}">contact us</a>. We'll do our best to resolve the issue promptly and ensure a smooth transaction.
        <br>
        Thank you for your understanding and cooperation.
    </p>
    <p>
        Thanks & Regards,<br>
        QProperties Team
    </p>
</body>
</html>