<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        body {
            background: linear-gradient(135deg, #141e30, #243b55); /* ✅ changed background */
            font-family: 'Segoe UI', sans-serif;
        }

        /* Container */
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Card UI */
        .credit-card {
            width: 350px;
            height: 200px;
            border-radius: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .card-number {
            letter-spacing: 2px;
            font-size: 20px;
            margin-top: 40px;
        }

        .card-name, .card-expiry {
            font-size: 14px;
        }

        /* Payment box */
        .payment-box {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            width: 400px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        /* Button */
        .pay-btn {
            background: #667eea;
            color: #fff;
            border: none;
            height: 45px;
            border-radius: 10px;
        }

        .pay-btn:hover {
            background: #5a67d8;
        }

        /* Popup */
        .popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 10px;
            color: #fff;
            display: none;
            animation: slideIn 0.5s ease;
        }

        .success { background: #28a745; }
        .error { background: #dc3545; }

        @keyframes slideIn {
            from { right: -200px; opacity: 0; }
            to { right: 20px; opacity: 1; }
        }
    </style>
</head>

<body>

<div class="wrapper">

    <div>

        <!-- 💳 CARD PREVIEW -->
        <div class="credit-card">
            <div>💳 My Bank</div>
            <div class="card-number" id="card-number">**** **** **** ****</div>
            <div class="d-flex justify-content-between mt-4">
                <div class="card-name" id="card-name">YOUR NAME</div>
                <div class="card-expiry" id="card-expiry">MM/YY</div>
            </div>
        </div>

        <!-- 💰 PAYMENT FORM -->
        <div class="payment-box">
            <h5 class="text-center mb-3">Secure Payment</h5>

            <form id="payment-form" method="POST" action="{{ route('stripe.post') }}">
                @csrf

                <input type="text" id="name" class="form-control mb-2" placeholder="Card Holder Name" required>

                <input type="text" id="amount" name="amount" class="form-control mb-2" placeholder="Amount (USD)" required>

                <div id="card-element" class="mb-3 p-2 border rounded"></div>

                <div id="card-errors" class="text-danger mb-2"></div>

                <button class="btn w-100 pay-btn">Pay Now</button>
            </form>
        </div>

    </div>
</div>

<!-- Popup -->
<div id="popup" class="popup"></div>

{{--<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    /* Live Card Preview */
    card.on('change', function(event) {
        if (event.complete) {
            document.getElementById('card-number').innerText = "**** **** **** " + event.value?.last4 || "****";
        }
    });

    document.getElementById('name').addEventListener('input', function(){
        document.getElementById('card-name').innerText = this.value.toUpperCase();
    });

    /* Popup function */
    function showPopup(message, type){
        const popup = document.getElementById('popup');
        popup.innerText = message;
        popup.className = 'popup ' + type;
        popup.style.display = 'block';

        setTimeout(() => {
            popup.style.display = 'none';
        }, 3000);
    }

    /* Submit */
    document.getElementById('payment-form').addEventListener('submit', async (e)=>{
        e.preventDefault();

        const {token, error} = await stripe.createToken(card);

        if(error){
            showPopup(error.message, 'error');
        } else {
            const form = e.target;
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'stripeToken';
            hidden.value = token.id;
            form.appendChild(hidden);
            showPopup("Payment Processing...", 'success');
            setTimeout(()=> form.submit(), 1500);
        }
    });
</script>--}}
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    /* Submit */
    document.getElementById('payment-form').addEventListener('submit', async (e)=>{
        e.preventDefault();

        const {token, error} = await stripe.createToken(card);

        if(error){
            document.getElementById('card-errors').innerText = error.message;
        } else {
            const form = e.target;
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'stripeToken';
            hidden.value = token.id;
            form.appendChild(hidden);
            form.submit();
        }
    });
</script>
</body>
</html>
