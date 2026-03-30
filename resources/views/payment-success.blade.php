<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #00c9ff, #92fe9d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .success-card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
        }
    </style>
</head>

<body>

<div class="success-card">
    <div class="success-icon">✅</div>

    <h3 class="mt-3">Payment Successful!</h3>

    <p>Order ID: <strong>{{ $order->order_id }}</strong></p>
    <p>Total Amount: <strong>${{ $order->total_amount }}</strong></p>
    <p>Status: <strong class="text-success">{{ ucfirst($order->payment_status) }}</strong></p>

    <a href="{{ route('order.view', $order->id) }}" class="btn btn-success mt-3">
        View Order
    </a>
</div>

<script>
    function launchConfetti() {
        const duration = 3000;
        const end = Date.now() + duration;

        (function frame() {
            confetti({ particleCount: 5, angle: 60, spread: 55, origin: { x: 0 } });
            confetti({ particleCount: 5, angle: 120, spread: 55, origin: { x: 1 } });

            if (Date.now() < end) requestAnimationFrame(frame);
        })();
    }

    launchConfetti();
</script>

</body>
</html>
