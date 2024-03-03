@extends('layouts.admin')

@section('content')
    <div id="doctor-edit" class="container pt-5">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h1>Update Doctor: {{ $user->name }} {{ $user->surname }}</h1>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">Foto</div>
                    <div class="card-body">
                        @if ($doctor->doctor_img)
                            <img src="{{ asset($doctor->doctor_img) }}" class="img-fluid mb-3" alt="Doctor Image">
                            <button class="btn btn-secondary btn-sm">Change Image</button>
                        @else
                            <div class="text-center">
                                <button class="btn btn-primary btn-sm">Add an image</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                {{-- enctype="multipart/form-data" --}}
                <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- nome  --}}
                    <div class="form-group pb-2">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- cognome  --}}
                    <div class="form-group pb-2">
                        <label for="surname">Surname</label>
                        <input type="text" name="surname" id="surname" class="form-control"
                            value="{{ old('surname', $user->surname) }}">
                        @error('surname')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- indirizzo  --}}
                    <div class="form-group pb-2">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ old('address', $doctor->address) }}">
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- numero di telefono  --}}
                    <div class="form-group pb-2">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                            value="{{ old('phone_number', $doctor->phone_number) }}">
                        @error('phone_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- disponibilità  --}}
                    <div class="form-group pb-2">
                        <label for="is_available">Available</label>
                        <select name="is_available" id="is_available" class="form-control">
                            <option value="1" {{ $doctor->is_available == 1 ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ $doctor->is_available == 0 ? 'selected' : '' }}>Not Available
                            </option>
                        </select>
                    </div>

                    {{-- servizi  --}}
                    <div class="form-group pb-2">
                        <label for="services">Services</label>
                        <input type="text" name="services" id="services" class="form-control"
                            value="{{ old('services', $doctor->services) }}">
                    </div>

                    {{-- specializzazione  --}}
                    <div class="form-group">
                        <label for="specializations">Specialization</label>
                        <select name="specializations" id="specializations" class="form-control">
                            @foreach ($specializations as $specialization)
                                <option value="{{ $specialization->id }}"
                                    {{ $doctor->specializations->contains($specialization->id) ? 'selected' : '' }}>
                                    {{ $specialization->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="py-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
