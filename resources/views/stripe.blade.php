<script src="https://js.stripe.com/v3/"></script>

<h3>Stripe Test Payment</h3>
<form action="{{ route('stripe.post') }}" method="POST" id="payment-form">
    @csrf
    <label>Amount (USD):</label>
    <input type="text" name="amount" placeholder="Enter amount in USD" required>

    <label>Card Details:</label>
    <div id="card-element" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;"></div>

    <div id="card-errors" role="alert" style="color:red; margin-top:10px;"></div>

    <button type="submit" style="margin-top:10px;">Pay</button>
</form>

<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}'); // publishable key
    const elements = stripe.elements();
    const card = elements.create('card', {
        hidePostalCode: true // optional, hides postal code field
    });
    card.mount('#card-element');

    // show errors in real-time
    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const {token, error} = await stripe.createToken(card);

        if(error){
            document.getElementById('card-errors').textContent = error.message;
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>
