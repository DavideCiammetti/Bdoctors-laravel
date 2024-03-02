@extends('layouts.admin')

@section('content')
    <div id="doctor-show" class="container pt-5">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h1>Doctor: {{ $user->name }} {{ $user->surname }}</h1>
        </div>

        <ul class="list-group">
            {{-- Indirizzo --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h3>Address</h3>
                <div>{{ $doctor?->address ?: 'No Address' }}</div>
            </li>

            {{-- Cellulare --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h3>Phone Number</h3>
                <div>{{ $doctor?->phone_number ?: 'No Phone Number' }}</div>
            </li>

            {{-- Immagine Profilo --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h3>Profile Image</h3>
                <div>{{ $doctor?->doctor_img ?: 'No Profile Image' }}</div>
            </li>

            {{-- CV --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h3>CV</h3>
                <div>{{ $doctor?->doctor_cv ?: 'No CV' }}</div>
            </li>

            {{-- Disponibilità --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h3>Avaiability</h3>
                <div>
                    @if ($doctor->is_available === 1)
                        Avaiable
                    @else
                        Not Avaiable
                    @endif
                </div>
            </li>

            {{-- Prestazioni --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h3>Services</h3>
                <div>{{ $doctor?->services ?: 'No Services' }}</div>
            </li>

            {{-- Cellulare --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <h3>Specializations</h3>
                <div>{{ $doctor->specializations[0]->title ?: 'No Specialization' }}</div>
            </li>
        </ul>
    </div>
@endsection
