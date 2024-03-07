@extends('layouts.admin')

@section('content')
    <div id="doctor-show" class="container py-5">
        <div class="row align-items-center justify-content-between ">
            {{-- Nome e Cognome --}}
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <h1>{{ $user->name }} {{ $user->surname }}</h1>

                    <div>
                        <a class="btn btn-link" href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <a class="btn btn-link ms-3" href="{{ route('admin.doctors.edit', $doctor->id) }}">
                            <i class="fa-solid fa-pen-to-square fa-lg fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card Dottore --}}
            <div class="col-md-4">
                <div class="card py-4 d-flex justify-content-center align-items-center">
                    @if ($user->doctor->doctor_img)
                        <img src="{{ asset('storage/' . $user->doctor->doctor_img) }}" class="profile-img rounded-3 mb-2"
                            alt="{{ $user->name }} {{ $user->surname }} Img">
                    @else
                        <a class="profile-img img-placeholder rounded-3 d-flex flex-column justify-content-center align-items-center mb-2"
                            href="{{ route('admin.doctors.edit', $user->doctor->id) }}">
                            <span class="mb-3">Inserisci Immagine</span>
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    @endif

                    <div class="card-body pb-0">
                        {{-- Indirizzo --}}
                        <div class="mb-3">
                            <h5>Indirizzo: {{ $user->doctor?->address ?: 'Nessun Indirizzo' }}</h5>
                        </div>

                        {{-- Cellulare --}}
                        <div class="mb-3">
                            <h5>Cellulare: {{ $user->doctor?->phone_number ?: 'Nessun Cellulare' }}</h5>
                        </div>

                        {{-- Disponibilità --}}
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <h5>
                                Disponibilità:
                                @if ($user->doctor->is_available === 1)
                                    Disponibile
                                @else
                                    Non Disponibile
                                @endif
                            </h5>

                        </div>
                    </div>
                </div>

            </div>

            {{-- Servizi e Specializzazioni --}}
            <div class="col-md-4">
                {{-- Specializzazioni --}}
                <div class="card mb-5 p-3">
                    <h3>Specializzazioni</h3>
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
                <div class="card mb-5 p-3">
                    <h3>Prestazioni</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex align-items-center list-item">
                            <div>{{ $user->doctor?->services ?: 'Nessuna prestazione' }}</div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- CV --}}
            <div class="col-md-4">
                @if ($doctor->doctor_cv)
                    <div class="profile-cv rounded-3">
                        <iframe src="{{ asset('storage/' . $user->doctor->doctor_cv) }}" alt="Doctor CV" title="Doctor CV"
                            style="height:100%; width:100%"></iframe>
                    </div>
                @else
                    <a class="profile-cv img-placeholder rounded-3 d-flex flex-column justify-content-center align-items-center "
                        href="{{ route('admin.doctors.edit', $user->doctor->id) }}">
                        <span class="mb-3">Inserisci CV</span>
                        <i class="fa-solid fa-plus"></i>
                    </a>
                @endif

            </div>
        </div>
    </div>
@endsection
