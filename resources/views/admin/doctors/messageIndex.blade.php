@extends('layouts.admin')

@section('content')
    <div id="messages" class="container pt-5">
        <h1 class="mb-4">Lista Messaggi</h1>

        @if (count($user->doctor->messages) > 0)
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($messages as $key => $message)
                    @if ($key + 1 <= 5)
                        <div class="accordion-item">
                            <h6 class="accordion-header d-flex justify-content-between align-items-center bg-green-dark ">
                                <div class="d-flex justify-content-lg-between justify-content-around w-100 px-4">
                                    {{-- Nome e cognome meaaggio --}}
                                    {{-- Nome e cognome  --}}
                                    <div class="w-25">
                                        @if ($message->name && $message->surname)
                                            {{ $message->name }} {{ $message->surname }}
                                        @else
                                            Anonimo
                                        @endif
                                    </div>

                                    {{-- Data di invio --}}
                                    <div class="w-25 text-center">
                                        {{ str_replace(array_keys($italianMonths), array_values($italianMonths), $message->created_at->isoFormat('DD MMMM YYYY', 'it')) }}
                                    </div>

                                    <div class="w-25 text-center d-none d-lg-block">
                                        {{ $message->phone_number }}
                                    </div>

                                    <div class="w-25 text-center d-none d-lg-block">
                                        {{ $message->email }}
                                    </div>
                                </div>
                                <button class="btn collapsed text-white " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree{{ $message->id }}" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>

                            </h6>
                            <div id="flush-collapseThree{{ $message->id }}" class="accordion-collapse collapse "
                                data-bs-parent="#accordionFlushExample" style="">
                                <div class="accordion-body">
                                    {{ $message->message }}
                                    {{-- Numero di telefoni --}}
                                    <div class="d-block d-lg-none">
                                        Telefono: {{ $message?->phone_number ?: '-' }}
                                    </div>

                                    {{-- Email --}}
                                    <div class="d-block d-lg-none">
                                        Email: {{ $message?->email ?: '-' }}
                                    </div>
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
@endsection
