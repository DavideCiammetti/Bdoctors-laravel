@extends('layouts.admin')

@section('content')
    <div id="doctor-show" class="container py-5">
        <div class="row">
            {{-- Nome e Cognome --}}
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <h1>{{ $user->name }} {{ $user->surname }}</h1>
                </div>
            </div>

            {{-- Card Dottore --}}
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card">
                    @if ($doctor->doctor_img)
                        <img src="{{ asset('storage/' . $doctor->doctor_img) }}" class="img-fluid" alt="Doctor Image">
                    @else
                        <div class="bg-danger"></div>
                    @endif

                    <div class="card-body">
                        <ul class="list-group">
                            {{-- Indirizzo --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h3>Address</h3>
                                <div>{{ $user->doctor?->address ?: 'No Address' }}</div>
                            </li>

                            {{-- Cellulare --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h3>Phone Number</h3>
                                <div>{{ $user->doctor?->phone_number ?: 'No Phone Number' }}</div>

                            </li>


                            {{-- Disponibilità --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h3>Avaiability</h3>
                                <div>
                                    @if ($user->doctor->is_available === 1)
                                        Available
                                    @else
                                        Not Available
                                    @endif
                                </div>
                            </li>

                            {{-- Prestazioni --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h3>Services</h3>
                                <div>{{ $user->doctor?->services ?: 'No Services' }}</div>
                            </li>



                            {{-- prova specializations  --}}
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h3>Specializations</h3>
                                <div>
                                    @if ($doctor->specializations->isNotEmpty())
                                        @php
                                            $specializations = $doctor->specializations->pluck('title')->implode(', ');
                                        @endphp
                                        {{ $specializations }}
                                    @else
                                        No Specialization
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            {{-- CV --}}
            <div class="col-md-6">
                {{-- CV --}}
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h3>CV</h3>
                    <div>{{ $user->doctor?->doctor_cv ?: 'No CV' }}</div>
                </li>
            </div>
        </div>
    </div>
@endsection
