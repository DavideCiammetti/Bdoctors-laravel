@extends('layouts.admin')

@section('content')
    <div id="dashboard" class="container">
        <div class="row justify-content-between py-5">
            {{-- Welcome --}}
            <div class="col-md-6">
                {{-- Centro Notifiche --}}
                <div class="card mb-4">

                    <div class="card-header">
                        <h3>Le tue Notifiche</h3>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <h2 class="mb-4">Ciao {{ $user->name }} {{ $user->surname }} </h2>

                        @if (!$user->doctor->phone_number || !$user->doctor->doctor_img || !$user->doctor->doctor_cv || !$user->doctor->services)
                            <h2 class="mb-3">Sembra che il tuo profilo
                                non sia completo
                            </h2>
                            <h3 class="mb-3">
                                I seguenti campi non sono stati compilati
                            </h3>
                            <h5>
                                @if (!$user->doctor->phone_number)
                                    Numero di telefono -
                                @endif
                                @if (!$user->doctor->services)
                                    Prestazioni -
                                @endif
                                @if (!$user->doctor->doctor_img)
                                    Immagine Profilo -
                                @endif
                                @if (!$user->doctor->doctor_cv)
                                    CV
                                @endif
                            </h5>
                        @endif

                        @if (count($user->doctor->votes) < 5 && !$user->doctor->sponsorships->first())
                            <h5>Hai ricevuto pochi voti, prova il nostro servizio di Sponsorizzazione a partire da 2.99€
                            </h5>
                        @endif
                    </div>

                    @if (session('success_message'))
                        <div class="card-footer">
                            <div class="alert alert-success mb-0">
                                Pagamento avvenuto con successo.
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sponsorizzazioni e Voto --}}
                <div class="row">
                    {{-- Abbonamento --}}
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Sponsorizzazione</h3>
                            </div>

                            <div class="card-body">
                                @if ($user->doctor->sponsorships->first())
                                    <h5 class="text-warning">{{ $user->doctor->sponsorships[0]->title }}</h5>
                                    <p>Grazie alla Sponsorizzazione sarai più visibile sul sito e apparirai sempre
                                        prima nelle ricerche dei clienti.</p>
                                    <h6>Scadenza: {{ $sponsorship[0]->pivot->end_date }}</h6>
                                @else
                                    <h5>Nessuna Sponsorizzazione</h5>
                                    <p>Grazie alla Sponsorizzazione sarai più visibile sul sito e apparirai sempre
                                        prima nelle ricerche dei clienti.</p>
                                    <h6 class="mb-0">
                                        <a class="nav-link btn-link btn  {{ Route::currentRouteName() == 'admin.doctor.payment' ? 'current-route' : '' }}"
                                            href="{{ route('admin.doctor.payment') }}">
                                            Abbonati ora
                                        </a>
                                    </h6>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- Media Voto --}}
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Valutazione</h3>
                            </div>
                            <div class="card-body">
                                <h5>Scopri cosa pensano di te i tuoi pazienti</h5>

                                <h6>Hai ricevuto {{ count($doctor->votes) }} voti</h6>
                                <h6>La tua media voti</h6>
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($averageVote > $i)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Messaggi --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Messaggi recenti</h3>
                    </div>
                    <div class="card-body">

                        @if (count($user->doctor->messages) > 0)
                            <ul class="list-group">
                                @foreach ($messages as $key => $message)
                                    @if ($key <= 4)
                                        <li class="list-group-item">
                                            {{ $message->message }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <h4>Nessuno Messaggio ricevuto</h4>
                        @endif
                    </div>
                    <div class="card-footer">
                        <h6 class="mb-0">
                            <a class="nav-link btn-link btn  {{ Route::currentRouteName() == 'admin.doctor.messages' ? 'current-route' : '' }}"
                                href="{{ route('admin.doctor.messages') }}">
                                Messaggi Ricevuti
                            </a>
                        </h6>
                    </div>
                </div>
            </div>

            {{-- Recensioni --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Recensioni recenti</h3>
                    </div>
                    <div class="card-body">

                        @if (count($user->doctor->reviews) > 0)
                            <ul class="list-group">
                                @foreach ($reviews as $key => $review)
                                    @if ($key <= 4)
                                        <li class="list-group-item">
                                            {{ $review->content }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <h4>Nessuna Recensione ricevuta</h4>
                        @endif
                    </div>
                    <div class="card-footer">
                        <h6 class="mb-0">
                            <a class="nav-link btn-link btn  {{ Route::currentRouteName() == 'admin.doctor.reviews' ? 'current-route' : '' }}"
                                href="{{ route('admin.doctor.reviews') }}">
                                Recensioni Ricevute
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
