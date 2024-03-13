@extends('layouts.admin')

@section('content')
    <div id="messages" class="container pt-5">
        <h1 class="mb-4">Lista Messaggi</h1>

        @if (count($user->doctor->messages) > 0)
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($messages as $message)
                    <div class="accordion-item">

                        <h6 class="accordion-header d-flex justify-content-between align-items-center bg-green-dark ">
                            <div class="d-flex justify-content-between w-100 px-4">
                                {{-- Nome e cognome meaaggio --}}
                                <div class="w-25">{{ $message->name }} {{ $message->surname }}</div>

                                {{-- Data di invio --}}
                                <div class="w-25">
                                    {{ str_replace(array_keys($italianMonths), array_values($italianMonths), $message->created_at->isoFormat('DD MMMM YYYY', 'it')) }}
                                </div>

                                <div class="w-25">
                                    {{ $message->phone_number }}
                                </div>


                                <div class="w-25">
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
                            <div class="accordion-body">{{ $message->message }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h3>Nessun Messaggio</h3>
        @endif

    </div>
@endsection
