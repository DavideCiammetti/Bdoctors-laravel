@extends('layouts.admin')

@section('content')
    <div>
        {{ session('success_message') }}
        {{ session('error_message') }}
    </div>
    <div class="wrapper">
        <div class="checkout container">

            <header>
                <h1>Hi, <br>Let's test a transaction</h1>
                <p>
                    Make a test payment with Braintree using PayPal or a card
                </p>
            </header>

            <form method="post" id="payment-form" action='{{ route('admin.doctor.payment.checkout') }}'>
                @csrf

                <section>
                    {{-- Specializzazione --}}
                    <div class="mb-4">
                        <label for="sponsorships">{{ __('Sponsorizzazioni') }}</label>


                        <select id="sponsorships" class="form-select my-input  @error('sponsorships') is-invalid @enderror"
                            aria-label="Default select example" name="sponsorships" required autocomplete="sponsorships"
                            autofocus>
                            <option value="">Nessuna
                                Sponsorizzazione</option>
                            @foreach ($sponsorships as $key => $sponsorship)
                                {
                                <option value="{{ $sponsorship }}">
                                    {{ $sponsorship->title }}
                                </option>
                                }
                            @endforeach
                        </select>

                        @error('sponsorships')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    {{-- <label for="amount">
                        <span class="input-label">Amount</span>
                        <div class="input-wrapper amount-wrapper">
                            <input id="amount" name="amount" type="tel" min="1" placeholder="Amount"
                                value="10">
                        </div>
                    </label> --}}

                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>
                </section>

                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <button class="button" type="submit"><span>Test Transaction</span></button>
            </form>
        </div>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.41.0/js/dropin.min.js"></script>

    <script>
        var form = document.querySelector('#payment-form');
        var client_token = '{{ $clientToken }}';

        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin',

        }, function(createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.log('Request Payment Method Error', err);
                        return;
                    }

                    // Add the nonce to the form and submit
                    document.querySelector('#nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    </script>
@endsection
