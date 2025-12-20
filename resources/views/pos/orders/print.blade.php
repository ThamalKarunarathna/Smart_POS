<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .row { display:flex; justify-content:space-between; }
        table { width:100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border:1px solid #ccc; padding: 8px; text-align:left; }
        th { background:#f2f2f2; }
        .right { text-align:right; }
        .muted { color:#666; font-size: 12px; }
        @media print { .no-print { display:none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom:10px;">
        <a href="{{ url('/pos/orders') }}">← Back to Orders</a>
        <button onclick="window.print()">Print</button>
    </div>

    <h2>INVOICE</h2>
    <div class="row">
        <div>
            <div><strong>Order No:</strong> {{ $order->order_no }}</div>
            <div><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</div>
            <div><strong>Status:</strong> {{ strtoupper($order->status) }}</div>
        </div>
        <div>
            <div><strong>Customer:</strong> {{ $order->customer?->name ?? 'WALK-IN' }}</div>
            <div class="muted">Print from SmartPOS</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Unit Price</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $line)
                <tr>
                    <td>{{ $line->item->name }}</td>
                    <td class="right">{{ number_format($line->qty, 3) }}</td>
                    <td class="right">{{ number_format($line->unit_price, 2) }}</td>
                    <td class="right">{{ number_format($line->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width:320px; margin-left:auto; margin-top:12px;">
        <tr>
            <td><strong>Sub Total</strong></td>
            <td class="right">{{ number_format($order->sub_total, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Discount</strong></td>
            <td class="right">{{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Grand Total</strong></td>
            <td class="right"><strong>{{ number_format($order->grand_total, 2) }}</strong></td>
        </tr>
    </table>
</body>
</html>
