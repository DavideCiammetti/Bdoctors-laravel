@extends('layouts.admin')

@section('content')
    <div id="doctor-show" class="container py-5">

        {{-- Profilo --}}
        <div class="mb-3 mb-md-5">
            {{-- Immagine profilo --}}
            <div class="d-flex align-items-center flex-column flex-md-row">
                @if ($user->doctor->doctor_img)
                    <img src="{{ asset('storage/' . $user->doctor->doctor_img) }}"
                        class="profile-img @if ($user->doctor->sponsorships->first()) border border-warning @endif"
                        alt="{{ $user->name }} {{ $user->surname }} Img">
                @else
                    <a class="profile-img img-placeholder d-flex flex-column justify-content-center align-items-center"
                        href="{{ route('admin.doctors.edit', $user->doctor->id) }}">
                        <span class="mb-3">Inserisci Immagine</span>
                        <i class="fa-solid fa-plus"></i>
                    </a>
                @endif

                {{-- Nome e Cognome --}}
                <div class="ms-md-5 mt-3 mt-md-0 ">
                    <h1 id="doctor-show-name">{{ $user->name }} {{ $user->surname }}</h1>
                </div>
            </div>
        </div>

        {{-- Lista proprietà --}}
        <div class="row flex-md-wrap text-center text-md-start">
            {{-- Info testuali --}}
            <div class="col-lg-6">
                {{-- Specializzazioni --}}
                <div class="mb-4">
                    <h2 class="mb-3">Le tue Specializzazioni</h2>
                    <ul class="list-group">
                        {{-- prova specializations  --}}
                        @foreach ($doctor->specializations as $specialization)
                            <li class="list-group-item d-flex align-items-center list-item">
                                {{ $specialization->title }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Prestazioni --}}
                <div class="mb-4">
                    <h2 class="mb-3">Le tue Prestazioni</h2>
                    <ul class="list-group">
                        <li class="list-group-item d-flex align-items-center list-item">
                            <div>{{ $user->doctor?->services ?: 'Nessuna prestazione' }}</div>
                        </li>
                    </ul>
                </div>

                {{-- Indirizzo --}}
                <div class="mb-4">
                    <h2 class="mb-3">Indirizzo</h2>
                    <h5>{{ $user->doctor?->address ?: 'Nessun Indirizzo' }}</h5>
                </div>

                {{-- Cellulare --}}
                <div class="mb-4">
                    <h2 class="mb-3">Cellulare</h2>
                    <h5>{{ $user->doctor?->phone_number ?: 'Nessun Indirizzo' }}</h5>
                </div>

                {{-- Disponibilità --}}
                <div class="mb-3 mb-md-0 ">
                    <h2 class="mb-3">Disponibilità</h2>
                    <h5>
                        @if ($user->doctor->is_available === 1)
                            Disponibile
                        @else
                            Non Disponibile
                        @endif
                    </h5>
                </div>
            </div>

            {{-- CV --}}
            <div class="col-lg-6 d-flex align-items-center justify-content-center ">
                @if ($doctor->doctor_cv)
                    <div class="profile-cv rounded-3">
                        <iframe src="{{ asset('storage/' . $user->doctor->doctor_cv) }}" alt="Doctor CV" title="Doctor CV"
                            style="height:100%; width:100%"></iframe>
                    </div>
                @else
                    <a class="profile-cv cv-placeholder rounded-3 d-flex flex-column justify-content-center align-items-center "
                        href="{{ route('admin.doctors.edit', $user->doctor->id) }}">
                        <span class="mb-3">Inserisci CV</span>
                        <i class="fa-solid fa-plus"></i>
                    </a>
                @endif

            </div>
        </div>
    </div>
@endsection
