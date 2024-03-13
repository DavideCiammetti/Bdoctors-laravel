@extends('layouts.admin')

@section('content')
    <div id="reviews" class="container pt-5">
        <h1 class="mb-4">Recensioni</h1>

        @if (count($user->doctor->reviews) > 0)
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($reviews as $key => $review)
                    @if ($key + 1 <= 5)
                        <div class="accordion-item">
                            <h6 class="accordion-header d-flex justify-content-between align-items-center bg-green-dark ">
                                <div class="d-flex justify-content-lg-between justify-content-around w-100 px-4">
                                    {{-- Nome e cognome  --}}
                                    <div class="w-25">
                                        @if ($review->name && $review->surname)
                                            {{ $review->name }} {{ $review->surname }}
                                        @else
                                            Anonimo
                                        @endif
                                    </div>

                                    {{-- Data di invio --}}
                                    <div class="w-25">
                                        {{ str_replace(array_keys($italianMonths), array_values($italianMonths), $review->created_at->isoFormat('DD MMMM YYYY', 'it')) }}
                                    </div>

                                    {{-- Numero di telefoni --}}
                                    <div class="w-25 d-none d-lg-block">
                                        {{ $review->phone_number }}
                                    </div>

                                    {{-- Email --}}
                                    <div class="w-25 d-none d-lg-block">
                                        {{ $review->email }}
                                    </div>
                                </div>
                                <button class="btn collapsed text-white " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree{{ $review->id }}" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>

                            </h6>
                            <div id="flush-collapseThree{{ $review->id }}" class="accordion-collapse collapse "
                                data-bs-parent="#accordionFlushExample" style="">
                                <div class="accordion-body">
                                    {{ $review->content }}
                                    {{-- Numero di telefoni --}}
                                    <div class="d-block d-lg-none">
                                        Telefono: {{ $review?->phone_number ?: '-' }}
                                    </div>

                                    {{-- Email --}}
                                    <div class="d-block d-lg-none">
                                        Email: {{ $review?->email ?: '-' }}
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
