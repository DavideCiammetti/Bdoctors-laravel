@extends('layouts.admin')

@section('content')
    <div id="dashboard" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                        <h1 class="mb-4">Benvenuto {{ $user->name }} {{ $user->surname }} </h1>

                        @if (!$user->doctor->phone_number || !$user->doctor->doctor_img || !$user->doctor->doctor_cv || !$user->doctor->services)
                            <h2 class="mb-3">Sembra che il tuo profilo non sia completo</h2>
                            <h3 class="mb-3">
                                Fai sapere ai tuoi pazienti qualcosa in più su di te
                                <a class="btn btn-link ms-3" href="{{ route('admin.doctors.edit', $doctor->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </h3>
                            <ul class="list-group">
                                @if (!$user->doctor->phone_number)
                                    <li class="list-group-item">Numero di telefono</li>
                                @endif

                                @if (!$user->doctor->doctor_img)
                                    <li class="list-group-item">Immagine Profilo</li>
                                @endif

                                @if (!$user->doctor->doctor_cv)
                                    <li class="list-group-item">File CV</li>
                                @endif

                                @if (!$user->doctor->services)
                                    <li class="list-group-item">Le tue Prestazioni</li>
                                @endif
                            </ul>
                        @else
                            <h2 class="mb-3">Tutti i campi sono compilati</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
