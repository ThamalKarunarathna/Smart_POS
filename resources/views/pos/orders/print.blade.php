<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_no }}</title>
    <style>
        /* Base styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            margin: 40px;
            color: #333;
            background: #f8fafc;
        }

        /* Print controls */
        .no-print {
            margin-bottom: 30px;
            padding: 16px 24px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .no-print a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .no-print a:hover {
            background: #eff6ff;
        }

        .no-print button {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .no-print button:hover {
            background: #2563eb;
        }

        /* Invoice container */
        .invoice-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 40px;
        }

        /* Header */
        h2 {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 40px;
            letter-spacing: -0.5px;
        }

        /* Row layout */
        .row {
            display: flex;
            justify-content: space-between;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            padding: 24px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .row > div {
            flex: 1;
        }

        .row strong {
            color: #475569;
            font-weight: 600;
            display: inline-block;
            min-width: 100px;
        }

        .row div {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            margin-top: 8px;
            font-style: italic;
        }

        /* Main table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        th {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
            font-weight: 600;
            padding: 16px 20px;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 15px;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .right {
            text-align: right;
            font-family: 'SF Mono', Monaco, 'Courier New', monospace;
        }

        /* Summary table */
        .summary {
            width: 320px;
            margin-left: auto;
            margin-top: 30px;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .summary td {
            padding: 16px 24px;
            border: none;
        }

        .summary tr:last-child {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        }

        .summary tr:last-child td {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }

        /* Status styling */
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 8px;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Print styles */
        @media print {
            body {
                margin: 20px;
                background: white;
            }

            .no-print {
                display: none;
            }

            .invoice-wrapper {
                box-shadow: none;
                padding: 0;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                margin: 20px;
            }

            .invoice-wrapper {
                padding: 24px;
            }

            .row {
                flex-direction: column;
                gap: 20px;
            }

            .summary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <a href="{{ url('/pos/orders') }}">← Back to Orders</a>
        <button onclick="window.print()">Print Invoice</button>
    </div>

    <div class="invoice-wrapper">
        <h2>INVOICE</h2>

        <div class="row">
            <div>
                <div><strong>Order No:</strong> {{ $order->order_no }}</div>
                <div><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</div>
                <div><strong>Status:</strong>
                    <span class="status status-{{ $order->status }}">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>
            </div>
            <div>
                <div><strong>Customer:</strong> {{ $order->customer?->name ?? 'WALK-IN' }}</div>
                <div class="muted">Printed from SmartPOS</div>
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

        <table class="summary">
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
    </div>
</body>
</html>
