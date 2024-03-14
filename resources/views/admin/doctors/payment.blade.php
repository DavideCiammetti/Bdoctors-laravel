@extends('layouts.admin')
@section('content')
    <div id="payment" class="wrapper text-center text-md-start">
        <div class="checkout container pt-5">

            {{-- titolo --}}
            <h1 class="mb-3">Compra una Sponsorizzazione</h1>

            {{-- errore transazione --}}
            @if (session('error_message'))
                <div class="alert alert-danger ">
                    {{ session('error_message') }}
                </div>
            @endif

            {{-- spiegazione --}}
            <h5 class="mb-4">Con la nostra sponsorizzazione apparirai prima nelle ricerce dei pazienti e sarai sempre
                in
                prima
                pagina nella
                sezione dei dottori consigliati.
                Se vuoi estendere la tua sponsorizzazione puoi acquistare nuovamente uno dei nostri piani e la data di
                scadenza sarà automaticamente prolungata.
            </h5>

            {{-- situazione sponsorizzazione --}}
            <div class="alert alert-green">
                @if ($user->doctor->sponsorships->first())
                    <h5 class="d-flex flex-column d-md-block">Sponsorizzazione attiva: <span
                            class="text-warning">{{ $user->doctor->sponsorships[0]->title }}</span></h5>

                    <h6 class="mb-0">
                        Scadenza:
                        {{ \Carbon\Carbon::parse($sponsorship[0]->pivot->end_date)->locale('it')->formatLocalized('%e %b %Y %H:%M') }}
                    </h6>
                @else
                    <h5 class="mb-0">Sponsorizzazione attiva: <span class="text-warning">Nessuna</span></h5>
                @endif
            </div>

            {{-- I nostri piani --}}
            <h2 class="mb-4">Scopri i nostri Piani:</h2>
            <div class="row text-center">
                {{-- Piano base --}}
                <div class="col-lg-4">
                    <div id="card-base" class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Piano Base</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">2.99€<small
                                    class="text-body-secondary fw-light">/24h</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Profilo in Home</li>
                                <li>Precedenza in ricerca</li>
                                <li>24h</li>

                            </ul>
                            <button id="base-sponsorship" type="button" class="w-50 btn btn-payment">Acquista</button>
                        </div>
                    </div>
                </div>

                {{-- Piano standard --}}
                <div class="col-lg-4">
                    <div id="card-standard" class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Piano Standard</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">5.99€<small
                                    class="text-body-secondary fw-light">/72h</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Profilo in Home</li>
                                <li>Precedenza in ricerca</li>
                                <li>72h</li>
                            </ul>
                            <button id="standard-sponsorship" type="button" class="w-50 btn btn-payment">Acquista</button>
                        </div>
                    </div>
                </div>

                {{-- Piano premium --}}
                <div class="col-lg-4">
                    <div id="card-premium" class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Piano Premium</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">9.99€<small
                                    class="text-body-secondary fw-light">/144h</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Profilo in Home</li>
                                <li>Primo in ricerca</li>
                                <li>144h</li>
                            </ul>
                            <button id="premium-sponsorship" type="button" class="w-50 btn btn-payment">Acquista</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- form --}}
            <form class="mb-5" method="post" id="payment-form" action='{{ route('admin.doctor.payment.checkout') }}'>
                @csrf

                <hr>

                <section>
                    {{-- Specializzazione --}}
                    <div>
                        <label for="sponsorships"></label>

                        <input type="hidden" id="sponsorships" name="sponsorships">

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
