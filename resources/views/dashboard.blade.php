@extends('layouts.admin')

@section('content')
    <div id="dashboard" class="container">
        <div class="row justify-content-between py-5">

            @if (session('success_message'))
                <div class="col-12 mb-3">
                    <div class="alert alert-success mb-0">
                        Pagamento avvenuto con successo.
                    </div>
                </div>
            @endif

            @if (!$user->doctor->phone_number || !$user->doctor->doctor_img || !$user->doctor->doctor_cv || !$user->doctor->services)
                <div class="col-12 alert mb-3 alert-green ">
                    <h5>
                        Il tuo profilo non è completo
                    </h5>
                    <h6 class="mb-0">
                        Mancano i seguenti campi:
                        <ul class="mb-0">
                            @if (!$user->doctor->phone_number)
                                <li>Numero di telefono</li>
                            @endif
                            @if (!$user->doctor->services)
                                <li>Prestazioni</li>
                            @endif
                            @if (!$user->doctor->doctor_img)
                                <li>Immagine Profilo</li>
                            @endif
                            @if (!$user->doctor->doctor_cv)
                                <li>CV</li>
                            @endif
                        </ul>
                    </h6>
                </div>
            @endif

            {{-- Welcome --}}
            <div class="col-lg-6 mb-4">
                <div class="card mb-4 h-100">

                    <div class="card-header">
                        <h4>Dashboard</h4>
                    </div>

                    <div class="card-body py-1">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h2 class="my-2">Ciao {{ $user->name }} {{ $user->surname }} </h2>

                        <h6>Nella tua Dashboard potrai vedere le informazioni più rilevanti riguardo il tuo account.</h6>
                        <h6>Per problemi e segnalazioni non esitare a contattarci:</h6>
                        <h6>Email: help.doctor@bdoctors.it</h6>
                        <h6 class="mb-0">Telefono: +39 4478365066</h6>
                    </div>
                </div>
            </div>

            {{-- Sponsorizzazione --}}
            <div class="col-lg-3 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h3>Sponsorizzazione</h3>
                    </div>

                    <div class="card-body d-flex flex-column justify-content-center">
                        @if ($user->doctor->sponsorships->first())
                            <h5 class="text-warning">{{ $user->doctor->sponsorships[0]->title }}</h5>
                            <p>Grazie alla Sponsorizzazione sarai più visibile sul sito e apparirai sempre
                                prima nelle ricerche dei clienti.</p>

                            <h6>
                                Scadenza:
                                {{ \Carbon\Carbon::parse($sponsorship[0]->pivot->end_date)->locale('it')->formatLocalized('%e %b %Y %H:%M') }}
                            </h6>
                        @else
                            <h5>Nessuna Sponsorizzazione</h5>
                            <p>Grazie alla Sponsorizzazione sarai più visibile sul sito e apparirai sempre
                                prima nelle ricerche dei clienti.</p>
                            <h6 class="mb-0">
                                <a class="nav-link btn-link btn  {{ Route::currentRouteName() == 'admin.doctor.payment' ? 'current-route' : '' }}"
                                    href="{{ route('admin.doctor.payment') }}">
                                    Acquista una Sponsorizzazione
                                </a>
                            </h6>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Media Voto --}}
            <div class="col-lg-3 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h3>Valutazione</h3>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5>Scopri cosa pensano di te i tuoi pazienti</h5>

                        <h6>Hai ricevuto {{ count($doctor->votes) }} voti</h6>
                        <h6>La tua media voti</h6>
                        <div>
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

            {{-- Messaggi --}}
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center ">
                        <h3 class="mb-0">Messaggi recenti</h3>
                        <div>
                            <a class="nav-link  {{ Route::currentRouteName() == 'admin.doctor.messages' ? 'current-route' : '' }}"
                                href="{{ route('admin.doctor.messages') }}">
                                <i class="fa-solid fa-message fa-lg fa-fw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($user->doctor->messages) > 0)
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                @foreach ($messages as $key => $message)
                                    @if ($key <= 5)
                                        <div class="accordion-item">
                                            <h6
                                                class="accordion-header d-flex justify-content-between align-items-center bg-green-dark ">
                                                <div class="d-flex justify-content-between w-100 ps-3">

                                                    {{-- Nome e cognome  --}}
                                                    <div class="w-50">
                                                        @if ($message->name && $message->surname)
                                                            {{ $message->name }} {{ $message->surname }}
                                                        @else
                                                            Anonimo
                                                        @endif
                                                    </div>

                                                    {{-- Data di invio --}}
                                                    <div class="w-50 text-center">
                                                        {{ str_replace(array_keys($italianMonths), array_values($italianMonths), $message->created_at->isoFormat('DD MMMM YYYY', 'it')) }}
                                                    </div>


                                                </div>
                                                <button class="btn collapsed text-white " type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseThree{{ $message->id }}"
                                                    aria-expanded="false" aria-controls="flush-collapseThree">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                </button>

                                            </h6>
                                            <div id="flush-collapseThree{{ $message->id }}"
                                                class="accordion-collapse collapse " data-bs-parent="#accordionFlushExample"
                                                style="">
                                                <div class="accordion-body">
                                                    {{-- Numero di telefoni --}}
                                                    <div class="fw-bold">
                                                        Telefono: {{ $message?->phone_number ?: '-' }}
                                                    </div>

                                                    {{-- Email --}}
                                                    <div class="fw-bold mb-1">
                                                        Email: {{ $message?->email ?: '-' }}
                                                    </div>
                                                    {{ $message->message }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <h3>Nessuno Messaggio ricevuto</h3>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Recensioni --}}
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center ">
                        <h3 class="mb-0">Recensioni recenti</h3>
                        <div>
                            <a class="nav-link  {{ Route::currentRouteName() == 'admin.doctor.reviews' ? 'current-route' : '' }}"
                                href="{{ route('admin.doctor.reviews') }}">
                                <i class="fa-solid fa-comments fa-lg fa-fw"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($user->doctor->reviews) > 0)
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                @foreach ($reviews as $key => $review)
                                    @if ($key <= 5)
                                        <div class="accordion-item">
                                            <h6
                                                class="accordion-header d-flex justify-content-between align-items-center bg-green-dark ">
                                                <div class="d-flex justify-content-between w-100 ps-3">
                                                    {{-- Nome e cognome  --}}
                                                    <div class="w-50">
                                                        @if ($review->name && $review->surname)
                                                            {{ $review->name }} {{ $review->surname }}
                                                        @else
                                                            Anonimo
                                                        @endif
                                                    </div>

                                                    {{-- Data di invio --}}
                                                    <div class="w-50 text-center ">
                                                        {{ str_replace(array_keys($italianMonths), array_values($italianMonths), $review->created_at->isoFormat('DD MMMM YYYY', 'it')) }}
                                                    </div>
                                                </div>
                                                <button class="btn collapsed text-white " type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseThree{{ $review->id }}"
                                                    aria-expanded="false" aria-controls="flush-collapseThree">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                </button>

                                            </h6>
                                            <div id="flush-collapseThree{{ $review->id }}"
                                                class="accordion-collapse collapse " data-bs-parent="#accordionFlushExample"
                                                style="">
                                                <div class="accordion-body">
                                                    {{-- Numero di telefoni --}}
                                                    <div class="fw-bold">
                                                        Telefono: {{ $review?->phone_number ?: '-' }}
                                                    </div>

                                                    {{-- Email --}}
                                                    <div class="fw-bold mb-1">
                                                        Email: {{ $review?->email ?: '-' }}
                                                    </div>
                                                    {{ $review->content }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <h3>Nessuna Recensione ricevuta</h3>
                        @endif
                    </div>
                </div>
            </div>

            {{-- grafico --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Andamento Messaggi e Recensioni nel Tempo</h3>
                        <h5>ultimi 12 mesi</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
