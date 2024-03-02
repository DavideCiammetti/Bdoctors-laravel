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
                        <h1 class="mb-5">Welcome {{ $user->name }}</h1>
                        <h1  class="mb-5">
                            non hai aggiornato il tuo profilo fai sapere chi sei 
                            {{-- <button>{{route('admin.doctors.edit')}}</button> --}}
                            @if ($doctor)
                                welcome
                            @endif{{ $doctor?->address }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
