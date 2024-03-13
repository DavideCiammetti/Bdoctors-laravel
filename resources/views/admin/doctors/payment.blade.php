@extends('layouts.admin')
@section('content')
    <div id="payment" class="wrapper">
        <div class="checkout container pt-5">


            <h1 class="mb-3">Compra una Sponsorizzazione</h1>

            @if (session('error_message'))
                <div class="alert alert-danger ">
                    {{ session('error_message') }}
                </div>
            @endif

            <h5 class="mb-4">Con la nostra sponsorizzazione apparirai prima nelle ricerce dei pazienti e sarai sempre
                in
                prima
                pagina nella
                sezione dei dottori consigliati.
                Se vuoi estendere la tua sponsorizzazione puoi acquistare nuovamente uno dei nostri piani e la data di
                scadenza sarà automaticamente prolungata.
            </h5>

            <h2 class="mb-4">Scopri i nostri Piani:</h2>

            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card text-center">
                        <div class="card-header">Piano Base</div>
                        <div class="card-body">Acquistando questo Piano sarai messo in evidenza per 24 ore</div>
                        <div class="card-footer">2,99€</div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card text-center ">
                        <div class="card-header">Piano Standard</div>
                        <div class="card-body">Acquistando questo Piano sarai messo in evidenza per 72 ore</div>
                        <div class="card-footer">5,99€</div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card text-center ">
                        <div class="card-header">Piano Premium</div>
                        <div class="card-body">Acquistando questo Piano sarai messo in evidenza per 144 ore</div>
                        <div class="card-footer">9,99€</div>
                    </div>
                </div>
            </div>


            <h2>Acquista Sponsorizzazione</h2>
            <form class="mb-5" method="post" id="payment-form" action='{{ route('admin.doctor.payment.checkout') }}'>
                @csrf

                <section>
                    {{-- Specializzazione --}}
                    <div>
                        <label for="sponsorships"></label>


                        <select id="sponsorships" class="form-select my-input  @error('sponsorships') is-invalid @enderror"
                            aria-label="Default select example" name="sponsorships" required autocomplete="sponsorships"
                            autofocus>
                            <option value="">Nessuna
                                Sponsorizzazione</option>
                            @foreach ($sponsorships as $key => $sponsorship)
                                {
                                <option value="{{ $sponsorship->id }}">
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


                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>
                </section>

                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <button class="btn btn-link mt-2" type="submit"><span>Acquista</span></button>
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
