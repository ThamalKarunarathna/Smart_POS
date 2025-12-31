<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery Note {{ $deliveryNote->delivery_note_no }}</title>
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

        /* Delivery Note container */
        .delivery-note-wrapper {
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
            min-width: 120px;
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
        }

        .center {
            text-align: center;
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

            .delivery-note-wrapper {
                box-shadow: none;
                padding: 0;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                margin: 20px;
            }

            .delivery-note-wrapper {
                padding: 24px;
            }

            .row {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <a href="{{ route('delivery_notes.index') }}">← Back to Delivery Notes</a>
        <button onclick="window.print()">Print Delivery Note</button>
    </div>

    <div class="delivery-note-wrapper">
        <h2>DELIVERY NOTE</h2>

        <div class="row">
            <div>
                <div><strong>Delivery Note No:</strong> {{ $deliveryNote->delivery_note_no }}</div>
                <div><strong>Date:</strong> {{ $deliveryNote->delivery_note_date->format('Y-m-d') }}</div>
                <div><strong>Order No:</strong> {{ $deliveryNote->order->order_no ?? '-' }}</div>
            </div>
            <div>
                <div><strong>Customer:</strong> {{ $deliveryNote->customer->name ?? 'Walk-in Customer' }}</div>
                @if($deliveryNote->delivery_address)
                    <div class="muted"><strong>Delivery Address:</strong><br>{{ $deliveryNote->delivery_address }}</div>
                @endif
                <div class="muted">Printed from SmartPOS</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="center">Qty</th>
                    <th>Unit</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveryNote->items as $item)
                    <tr>
                        <td>{{ $item->item->name ?? '-' }}</td>
                        <td class="center">{{ number_format($item->qty, 3) }}</td>
                        <td>{{ $item->unit ?? '-' }}</td>
                        <td>{{ $item->description ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($deliveryNote->notes)
            <div style="margin-top: 30px; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <strong>Notes:</strong>
                <p style="margin-top: 8px; color: #64748b;">{{ $deliveryNote->notes }}</p>
            </div>
        @endif

        <div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #e2e8f0; display: flex; justify-content: space-between;">
            <div>
                <div style="margin-bottom: 40px;">
                    <div style="font-weight: 600; margin-bottom: 8px;">Prepared By:</div>
                    <div style="color: #64748b;">{{ $deliveryNote->creator->name ?? '-' }}</div>
                </div>
            </div>
            <div>
                <div style="margin-bottom: 40px;">
                    <div style="font-weight: 600; margin-bottom: 8px;">Received By:</div>
                    <div style="color: #64748b; min-height: 20px; border-bottom: 1px solid #cbd5e1; width: 200px;"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

