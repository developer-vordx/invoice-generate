<!DOCTYPE html>
<html>
<head>
    <title>Invoice Rejected</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 40px; text-align: center;">
<h1 style="color: #dc2626;">❌ Invoice #{{ $invoice->invoice_number }} Rejected</h1>
<p>The invoice has been rejected by the user.</p>
<a href="{{ route('invoices.show', $invoice->id) }}" style="color: #2563eb; text-decoration: underline;">View Invoice</a>
</body>
</html>
