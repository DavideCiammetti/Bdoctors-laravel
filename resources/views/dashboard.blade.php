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


                        <h1 class="mb-4">Bentornato {{ $user->name }} {{ $user->surname }} </h1>

                        <div>
                            @if (!$user->doctor->phone_number || !$user->doctor->doctor_img || !$user->doctor->doctor_cv || !$user->doctor->services)
                                <h2 class="mb-3">Sembra che il tuo profilo
                                    non sia completo
                                </h2>
                                <h3 class="mb-3">
                                    I seguenti campi non sono stati compilati
                                </h3>
                                <h5>
                                    @if (!$user->doctor->phone_number)
                                        Numero di telefono -
                                    @endif
                                    @if (!$user->doctor->services)
                                        Prestazioni -
                                    @endif
                                    @if (!$user->doctor->doctor_img)
                                        Immagine Profilo -
                                    @endif
                                    @if (!$user->doctor->doctor_cv)
                                        CV
                                    @endif
                                </h5>
                            @endif
                        </div>




                    </div>

                    @if (session('success_message'))
                        <div class="card-footer">
                            <div class="alert alert-success mb-0">
                                {{ session('success_message') }}
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection
