@extends('layouts.admin')

@section('content')
    <div id="reviews" class="container pt-5">
        <h1 class="mb-4">Recensioni</h1>

        @if (count($user->doctor->reviews) > 0)
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($reviews as $review)
                    <div class="accordion-item">

                        <h6 class="accordion-header d-flex justify-content-between align-items-center bg-green-dark ">
                            <div class="d-flex justify-content-between w-100 px-4">
                                {{-- Nome e cognome meaaggio --}}
                                <div class="w-25">{{ $review->name }} {{ $review->surname }}</div>

                                {{-- Data di invio --}}
                                <div class="w-25">
                                    {{ str_replace(array_keys($italianMonths), array_values($italianMonths), $review->created_at->isoFormat('DD MMMM YYYY', 'it')) }}
                                </div>

                                <div class="w-25">
                                    {{ $review->phone_number }}
                                </div>


                                <div class="w-25">
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
                            <div class="accordion-body">{{ $review->content }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h3>Nessuna Recensione</h3>
        @endif

    </div>
@endsection
