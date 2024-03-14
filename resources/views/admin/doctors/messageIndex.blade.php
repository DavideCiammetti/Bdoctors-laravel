@extends('layouts.admin')

@section('content')
    <div id="messages" class="container pt-5">
        <div class="d-flex justify-content-between align-items-center flex-column flex-md-row mb-4">
            <h1>Lista Messaggi</h1>
            <h5>Hai {{ count($user->doctor->messages) }} Messaggi</h5>
        </div>

        @if (count($user->doctor->messages) > 0)
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($messages as $message)
                    <div class="accordion-item">
                        <h6 class="accordion-header d-flex justify-content-between align-items-center bg-green-dark ">
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
                            <button class="btn collapsed text-white " type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree{{ $message->id }}" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                        </h6>
                        <div id="flush-collapseThree{{ $message->id }}" class="accordion-collapse collapse "
                            data-bs-parent="#accordionFlushExample" style="">
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
                @endforeach
            </div>
        @else
            <h3>Nessuno Messaggio ricevuto</h3>
        @endif

    </div>
@endsection
