<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #INV-{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { width: 100%; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header table { width: 100%; }
        .header h1 { margin: 0; font-size: 28px; }

        .section-divider { border-top: 1px solid #ccc; margin: 25px 0; }

        .billing, .items, .totals, .notes { margin-bottom: 25px; }
        .billing table { width: 100%; border-collapse: collapse; }
        .billing td { vertical-align: top; padding: 5px; }

        .items table { width: 100%; border-collapse: collapse; }
        .items th, .items td { border: 1px solid #ddd; padding: 8px; }
        .items th { background-color: #f5f5f5; text-align: left; }

        .totals table { width: 300px; float: right; border-collapse: collapse; }
        .totals td { padding: 5px; }
        .totals tr.total td { font-weight: bold; font-size: 16px; border-top: 2px solid #000; }

        .notes h3 { margin-bottom: 5px; }
        .notes p, .notes ul { margin: 0; padding-left: 20px; }
        .status { display: inline-block; padding: 3px 8px; font-size: 10px; color: #fff; background-color: #4a90e2; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <h1>INVOICE</h1>
                    <p>#INV-{{ $invoice->invoice_number }}</p>
                </td>
                <td style="text-align:right;">
                    <strong>{{ $globalSettings->company_name ?? config('app.name') }}</strong><br>
                    {{ $globalSettings->address ?? '' }}<br>
                    @if(!empty($globalSettings->contact_email))
                        {{ $globalSettings->contact_email }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Billing Info -->
    <div class="billing">
        <table>
            <tr>
                <td>
                    <strong>BILL TO:</strong><br>
                    {{ $invoice->customer->name ?? 'N/A' }}<br>
                    {{ $invoice->customer->email ?? 'N/A' }}<br>
                    {{ $invoice->customer->address ?? 'N/A' }}
                </td>
                <td style="text-align:right;">
                    <table>
                        <tr>
                            <td>Issue Date:</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Due Date:</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td><span class="status">{{ strtoupper($invoice->status) }}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-divider"></div>

    <!-- Items -->
    <div class="items">
        <table>
            <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th>QTY</th>
                <th>UNIT PRICE</th>
                <th>AMOUNT</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->activity }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $globalSettings->base_currency ?? '$' }}{{ number_format($item->amount, 2) }}</td>
                    <td>{{ $globalSettings->base_currency ?? '$' }}{{ number_format($item->quantity * $item->amount, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-divider"></div>

    <!-- Totals -->
    @php
        $subtotal = $invoice->items->sum(fn($item) => $item->quantity * $item->amount);
        $taxRate = $globalSettings->tax_percentage ? $globalSettings->tax_percentage / 100 : 0;
        $taxAmount = $subtotal * $taxRate;
        $total = $subtotal + $taxAmount;
    @endphp

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>{{ $globalSettings->base_currency ?? '$' }}{{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Tax ({{ $globalSettings->tax_percentage ?? 0 }}%):</td>
                <td>{{ $globalSettings->base_currency ?? '$' }}{{ number_format($taxAmount, 2) }}</td>
            </tr>
            <tr class="total">
                <td>Total:</td>
                <td>{{ $globalSettings->base_currency ?? '$' }}{{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section-divider" style="clear:both;"></div>

    <!-- Notes & Terms -->
    <div class="notes">
        @if(!empty($globalSettings->invoice_notes))
            <h3>Notes</h3>
            <p style="white-space: pre-line;">{{ $globalSettings->invoice_notes }}</p>
        @endif

        @if(!empty($globalSettings->invoice_terms))
            <h3>Terms & Conditions</h3>
            <p style="white-space: pre-line;">{{ $globalSettings->invoice_terms }}</p>
        @endif
    </div>

</div>
</body>
</html>
