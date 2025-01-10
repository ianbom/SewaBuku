<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            font-size: 24px;
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice</h1>
        <p><strong>Invoice ID:</strong> {{ $order->id_order }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
        <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>
    </div>

    <div class="details">
        <p><strong>Package Name:</strong> {{ $order->nama_paket }}</p>
        <p><strong>Order Status:</strong> {{ $order->status_order }}</p>
        <p><strong>Payment Method:</strong> {{ $order->payment->metode_pembayaran }}</p>
        <p><strong>Payment Status:</strong> {{ $order->payment->status_pembayaran }}</p>
        <p><strong>Total Payment:</strong> Rp{{ number_format($order->total_bayar, 2) }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- In this case, the order data doesn't provide specific items, but you can customize if needed -->
            <tr>
                <td>1</td>
                <td>{{ $order->nama_paket }}</td>
                <td>1</td>
                <td>{{ number_format($order->total_bayar, 2) }}</td>
                <td>{{ number_format($order->total_bayar, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <p class="total">Total Amount: Rp{{ number_format($order->total_bayar, 2) }}</p>
</body>
</html>
