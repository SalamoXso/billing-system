<!DOCTYPE html>
<html>
<head>
    <title>Invoice - {{ $invoice->invoice_number }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        .company-info {
            text-align: left;
            float: left;
            width: 50%;
        }
        .invoice-info {
            text-align: right;
            float: right;
            width: 50%;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        .client-info {
            margin-bottom: 30px;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .totals { 
            float: right; 
            width: 300px; 
            margin-top: 20px; 
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .totals table {
            margin-bottom: 0;
        }
        .totals table, .totals th, .totals td {
            border: none;
        }
        .totals th {
            text-align: right;
            background: none;
            padding: 5px;
        }
        .totals td {
            text-align: right;
            padding: 5px;
        }
        .serial-numbers { 
            font-size: 0.85em; 
            color: #666; 
            margin-top: 5px; 
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.85em;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .grand-total {
            font-weight: bold;
            font-size: 1.1em;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="company-info">
            <h2>COMPANY NAME</h2>
            <p>123 Business Street<br>
            City, State ZIP<br>
            Phone: (123) 456-7890<br>
            Email: info@company.com</p>
        </div>
        <div class="invoice-info">
            <h1>INVOICE</h1>
            <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date->format('d/m/Y') }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
        </div>
    </div>
    
    <div class="client-info clearfix">
        <h3>Bill To:</h3>
        <p>
            <strong>{{ $invoice->client->name }}</strong><br>
            {{ $invoice->client->email }}<br>
            {{ $invoice->client->phone ?? '' }}<br>
            {{ $invoice->client->address ?? '' }}
        </p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price (inc GST)</th>
                <th>Total (inc GST)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>
                    {{ $item->product->name }}
                    @if($item->serialNumbers->count())
                    <div class="serial-numbers">
                        <strong>Serial Numbers:</strong> 
                        {{ $item->serialNumbers->pluck('serial_number')->implode(', ') }}
                    </div>
                    @endif
                </td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="totals">
        <table>
            <tr>
                <th>Subtotal (ex GST):</th>
                <td>${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <th>GST (10%):</th>
                <td>${{ number_format($invoice->gst_amount, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <th>Total:</th>
                <td>${{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>
    
    <div class="clearfix"></div>
    
    @if($invoice->notes)
    <div style="margin-top: 30px;">
        <h3>Notes:</h3>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif
    
    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>