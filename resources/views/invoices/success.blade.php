<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 40px; text-align: center;">
<h1 style="color: #16a34a;">✅ Payment Successful</h1>
<p>Thank you for paying Invoice #{{ $invoice->invoice_number }}.</p>
<p>Amount: ${{ number_format($invoice->amount, 2) }}</p>
<a href="{{ route('invoices.show', $invoice->id) }}" style="color: #2563eb; text-decoration: underline;">View Invoice</a>
</body>
</html>
