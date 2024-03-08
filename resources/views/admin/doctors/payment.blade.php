@extends('layouts.admin')

@section('content')
    <div class="text-warning">
        Sucesso
        {{ session('success_message') }}
    </div>
    <div class="text-danger">
        Fallito
        {{ session('error_message') }}

    </div>
    <form method="post" action="{{ route('admin.doctor.payment.checkout') }}">
        @csrf

        {{-- Mio form --}}
        {{-- <div class="form-group">
            <label for="cardholder-name">Nome del Titolare della Carta</label>
            <input type="text" name="cardholder_name" id="cardholder-name" class="form-control" required>
        </div> --}}

        {{-- <div class="form-group">
            <label for="card-number">Numero della Carta</label>
            <input type="text" name="card_number" id="card-number" class="form-control" data-braintree-name="number" required>
        </div> --}}

        {{-- <div class="form-group">
            <label for="expiration-date">Data di Scadenza</label>
            <input type="text" name="expiration_date" id="expiration-date" class="form-control" data-braintree-name="expirationDate" required>
        </div> --}}

        {{-- <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" name="cvv" id="cvv" class="form-control" data-braintree-name="cvv" required>
        </div> --}}

        <div class="form-group">
            <div id="card-container"></div>
        </div>

        <button type="submit" class="btn btn-primary">Invia Pagamento</button>
    </form>

    <script src="https://js.braintreegateway.com/web/dropin/1.27.0/js/dropin.min.js"></script>

    <script>
        var form = document.querySelector('form');


        braintree.dropin.create({
            authorization: 'sandbox_yk9pz94y_njjd8z9g7kkr2qvs',
            container: '#card-container',
        }, function(createErr, instance) {
            if (createErr) {
                console.error(createErr);
                return;
            }
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }

                    // Registra il nonce del metodo di pagamento per il debug
                    console.log('Nonce del Metodo di Pagamento:', payload.nonce);

                    // Imposta il valore del nonce in un campo nascosto per l'invio del modulo
                    var nonceInput = document.createElement('input');
                    nonceInput.name = 'payment_method_nonce';
                    nonceInput.value = payload.nonce;
                    nonceInput.type = 'hidden';
                    form.appendChild(nonceInput);

                    // Invia il modulo
                    form.submit();
                });
            });
        });
    </script>
@endsection
