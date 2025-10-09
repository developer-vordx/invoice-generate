<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .content h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .invoice-summary {
            margin: 20px 0;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 6px;
        }
        .invoice-summary p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4a90e2;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>{{ config('app.name') }}</h2>
    </div>
    <div class="content">
        <h1>Hello {{ $invoice->customer->name ?? 'Customer' }},</h1>
        <p>We’ve generated your invoice <strong>#INV-{{ $invoice->invoice_number }}</strong>.</p>

        <div class="invoice-summary">
            <h3>Invoice Summary</h3>
            <p><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
            <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
        </div>

        <a href="{{ route('invoices.show', $invoice->id) }}" class="button">View Invoice Online</a>

        <p style="margin-top: 20px;">A PDF copy of your invoice is attached for your convenience.</p>

        <p>Thanks for your business!<br><strong>{{ config('app.name') }}</strong></p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
