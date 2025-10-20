<!DOCTYPE html>
<html>
<head>
    <title>Payment Cancelled</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 40px; text-align: center;">
<h1 style="color: #f59e0b;">⚠️ Payment Cancelled</h1>
<p>You cancelled the payment for Invoice #{{ $invoice->invoice_number }}.</p>
<a href="{{ route('invoices.show', $invoice->id) }}" style="color: #2563eb; text-decoration: underline;">Return to Invoice</a>
</body>
</html>
