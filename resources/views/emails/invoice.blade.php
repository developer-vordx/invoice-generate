@component('mail::message')
    {{-- ================= HEADER ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 25px;">
        <tr>
            <td align="center">
                <h1 style="font-size: 28px; color: #111827; margin: 0; font-weight: 700;">
                    💼 Invoice #{{ $invoice->invoice_number }}
                </h1>
                <p style="color: #6B7280; font-size: 15px; margin-top: 6px;">
                    Issued by {{ $invoice->customer->company_name ?? config('app.name') }}
                </p>
            </td>
        </tr>
    </table>

    {{-- ================= GREETING ================= --}}
    <p style="font-size: 16px; color: #374151; line-height: 1.6; margin-bottom: 20px;">
        Hello <strong>{{ $invoice->customer->name }}</strong>,
    </p>

    <p style="font-size: 16px; color: #4B5563; line-height: 1.6; margin-bottom: 25px;">
        You’ve received a new invoice from <strong>{{ $invoice->customer->company_name ?? config('app.name') }}</strong>.
        Please review the details below.
    </p>

    {{-- ================= INVOICE SUMMARY TABLE ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse; margin-bottom: 30px; border-radius: 8px; overflow: hidden;">
        <tr>
            <td style="padding: 12px 16px; background-color: #F9FAFB; border: 1px solid #E5E7EB; font-weight: 600; width: 40%;">
                Invoice Number
            </td>
            <td style="padding: 12px 16px; border: 1px solid #E5E7EB;">
                {{ $invoice->invoice_number }}
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; background-color: #F9FAFB; border: 1px solid #E5E7EB; font-weight: 600;">
                Issue Date
            </td>
            <td style="padding: 12px 16px; border: 1px solid #E5E7EB;">
                {{ $invoice->issue_date ? $invoice->issue_date->format('F d, Y') : '—' }}
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; background-color: #F9FAFB; border: 1px solid #E5E7EB; font-weight: 600;">
                Due Date
            </td>
            <td style="padding: 12px 16px; border: 1px solid #E5E7EB;">
                {{ $invoice->due_date ? $invoice->due_date->format('F d, Y') : '—' }}
            </td>
        </tr>
        <tr>
            <td style="padding: 12px 16px; background-color: #F9FAFB; border: 1px solid #E5E7EB; font-weight: 600;">
                Total Amount
            </td>
            <td style="padding: 12px 16px; border: 1px solid #E5E7EB; color: #047857; font-weight: bold;">
                ${{ number_format($invoice->amount, 2) }}
            </td>
        </tr>
    </table>

    {{-- ================= LINE ITEMS ================= --}}
    @if($invoice->items && $invoice->items->count())
        <h3 style="font-size: 18px; color: #111827; margin-bottom: 10px;">Invoice Details</h3>
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse; margin-bottom: 25px;">
            <thead>
            <tr style="background-color: #F3F4F6;">
                <th align="left" style="padding: 10px; border: 1px solid #E5E7EB; font-weight: 600;">Description</th>
                <th align="center" style="padding: 10px; border: 1px solid #E5E7EB; font-weight: 600;">Qty</th>
                <th align="right" style="padding: 10px; border: 1px solid #E5E7EB; font-weight: 600;">Unit Price</th>
                <th align="right" style="padding: 10px; border: 1px solid #E5E7EB; font-weight: 600;">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td style="padding: 10px; border: 1px solid #E5E7EB;">{{ $item->activity }}</td>
                    <td align="center" style="padding: 10px; border: 1px solid #E5E7EB;">{{ $item->quantity }}</td>
                    <td align="right" style="padding: 10px; border: 1px solid #E5E7EB;">${{ number_format($item->amount, 2) }}</td>
                    <td align="right" style="padding: 10px; border: 1px solid #E5E7EB;">${{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    {{-- ================= PAY BUTTON ================= --}}
    @component('mail::button', ['url' => $checkoutUrl, 'color' => 'blue'])
        💳 Pay Invoice Now
    @endcomponent

    {{-- ================= NOTES ================= --}}
    @if(!empty($invoice->note))
        <p style="font-size: 14px; color: #6B7280; margin-top: 25px; line-height: 1.6;">
            <strong>Note:</strong> {{ $invoice->note }}
        </p>
    @endif

    {{-- ================= FOOTER ================= --}}
    <p style="font-size: 14px; color: #9CA3AF; margin-top: 30px; line-height: 1.6;">
        You can also download your invoice attached as a PDF for your records.
    </p>

    <p style="font-size: 14px; color: #6B7280; margin-top: 20px;">
        Thanks,<br>
        <strong>{{ config('app.name') }}</strong>
    </p>

    <p style="font-size: 12px; color: #9CA3AF; margin-top: 10px;">
        This is an automated email — please do not reply.
    </p>
@endcomponent
