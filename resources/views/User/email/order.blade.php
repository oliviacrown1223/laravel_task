<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body style="font-family: Arial; background:#f5f5f5; padding:20px;">

<div style="max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:10px;">

    <h2 style="text-align:center; color:green;">Order Confirmed ✅</h2>

    <p><strong>Order ID:</strong> {{ $order->order_id }}</p>

    <hr>

    <h4>Order Items:</h4>

    <table width="100%" border="1" cellspacing="0" cellpadding="8">
        <thead style="background:#eee;">
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>
        @php $total = 0; @endphp

        @foreach($order->items as $item)
            @php
                $line = $item->price * $item->qty;
                $total += $line;
            @endphp

            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>₹ {{ $item->price }}</td>
                <td>₹ {{ $line }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3 style="text-align:right; margin-top:15px;">
        Total: ₹ {{ $total }}
        </h3>

        <hr>

        <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone_no }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>

    <p style="text-align:center; margin-top:20px;">
        Thank you for shopping with us ❤️
    </p>


</div>

</body>
</html>
