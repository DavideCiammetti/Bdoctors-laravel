@extends('layouts.admin')

@section('content')
    <div class="container">
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
                        <h1 class="mb-5">Welcome {{ $user->name }} </h1>

                        <h2 class="mb-3">I seguenti campi non sono ancora stati inseriti</h2>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
