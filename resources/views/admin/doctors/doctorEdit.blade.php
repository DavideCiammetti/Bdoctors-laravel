@extends('layouts.admin')

@section('content')
    <div id="doctor-edit" class="container pt-5">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h1>Update Doctor: {{ $user->name }} {{ $user->surname }}</h1>
        </div>

        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">

                    {{-- foto  --}}
                    <div class="card mb-4">

                        <div class="card-header">Foto</div>

                        <div class="card-body">
                            {{-- Immagine --}}
                            <div class="mb-3">
                                @if ($doctor->doctor_img)
                                    <img src="{{ asset('storage/' . $doctor->doctor_img) }}" class="img-fluid"
                                        alt="Doctor Image">
                                @endif
                            </div>

                            {{-- Testo "Change/Add image" --}}
                            <div class="mb-3">
                                <label for="doctor-img-edit" class="form-label d-flex justify-content-between">
                                    @if ($doctor->doctor_img)
                                        Change image
                                    @else
                                        Add an image
                                    @endif
                                    {{-- errore url immagine --}}
                                    @error('doctor_img')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Input "Scegli file" --}}
                            <div class="input-group">
                                <input class="upload-image my-input form-control @error('doctor_img') is-invalid @enderror"
                                    type="file" id="doctor-img-edit" name="doctor_img"
                                    value="{{ old('doctor_img', $doctor->doctor_img) }}">
                            </div>
                        </div>
                    </div>


                    {{-- CV --}}
                    <div class="card mb-4">

                        <div class="card-header">CV</div>

                        <div class="card-body">
                            <div class="mb-3">
                                @if ($doctor->doctor_cv)
                                    <img src="{{ asset('storage/' . $doctor->doctor_cv) }}" class="img-fluid"
                                        alt="Doctor CV">
                                @endif
                            </div>

                            {{-- Testo "Change/Add image" --}}
                            <div class="mb-3">
                                <label for="doctor-cv-edit" class="form-label d-flex justify-content-between">
                                    @if ($doctor->doctor_cv)
                                        Change CV
                                    @else
                                        Add a CV
                                    @endif
                                    {{-- errore url immagine --}}
                                    @error('doctor_cv')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </label>
                            </div>

                            {{-- Input "Scegli file" --}}
                            <div class="input-group">
                                <input class="upload-image my-input form-control @error('doctor_cv') is-invalid @enderror"
                                    type="file" id="doctor-cv-edit" name="doctor_cv"
                                    value="{{ old('doctor_cv', $doctor->doctor_cv) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
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
                            <option value="1" {{ $doctor->is_available == 1 ? 'selected' : '' }}>Available
                            </option>
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
                    {{-- prima select --}}
                    {{-- <div class="form-group">
                        <label for="specialization1">Specialization 1</label>
                        <select name="specializations[]" id="specialization1" class="form-control">
                            <option value="">Select Specialization</option>
                            @foreach ($specializations as $specialization)
                                <option value="{{ $specialization->id }}"
                                    {{ $doctor->specializations->contains($specialization->id) &&
                                    $doctor->specializations->pluck('id')->search($specialization->id) === 0
                                        ? 'selected'
                                        : '' }}>
                                    {{ $specialization->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('specializations.0')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- seconda select --}}
                    {{-- <div class="form-group">
                        <label for="specialization2">Specialization 2</label>
                        <select name="specializations[]" id="specialization2" class="form-control">
                            <option value="">Select Specialization</option>
                            @foreach ($specializations as $specialization)
                                <option value="{{ $specialization->id }}"
                                    {{ $doctor->specializations->contains($specialization->id) &&
                                    $doctor->specializations->pluck('id')->search($specialization->id) === 1
                                        ? 'selected'
                                        : '' }}>
                                    {{ $specialization->title }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- terza select --}}
                    {{-- <div class="form-group">
                        <label for="specialization3">Specialization 3</label>
                        <select name="specializations[]" id="specialization3" class="form-control">
                            <option value="">Select Specialization</option>
                            @foreach ($specializations as $specialization)
                                <option value="{{ $specialization->id }}"
                                    {{ $doctor->specializations->contains($specialization->id) &&
                                    $doctor->specializations->pluck('id')->search($specialization->id) === 2
                                        ? 'selected'
                                        : '' }}>
                                    {{ $specialization->title }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- prima select --}}
                    @for ($i = 0; $i < min(count($doctor->specializations), 3); $i++)
                        <div class="form-group" id="specialization{{ $i + 1 }}Div">
                            <label for="specialization{{ $i + 1 }}">Specialization {{ $i + 1 }}</label>
                            <select name="specializations[]" id="specialization{{ $i + 1 }}" class="form-control">
                                <option value="">Select Specialization</option>
                                @foreach ($specializations as $specialization)
                                    <option value="{{ $specialization->id }}"
                                        {{ $doctor->specializations[$i]->id == $specialization->id ? 'selected' : '' }}>
                                        {{ $specialization->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('specializations.' . $i)
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endfor

                    <!-- Bottone per aggiungere specializzazione -->
                    @if (count($doctor->specializations) < 3)
                        <div class="pt-3">
                            <button type="button" class="btn btn-primary" id="addSpecializationButton">Add
                                Specialization</button>
                        </div>
                    @endif

                    <!-- Script aggiunta dinamica delle select -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var specializationCount = {{ count($doctor->specializations) }};
                            var maxSpecializations = 3;
                            var lastSpecializationId = specializationCount;

                            document.getElementById('addSpecializationButton').addEventListener('click', function() {
                                if (specializationCount < maxSpecializations) {
                                    specializationCount++;
                                    var nextSpecializationId = specializationCount;
                                    var specializationDiv = document.createElement('div');
                                    specializationDiv.className = 'form-group';
                                    specializationDiv.id = 'specialization' + nextSpecializationId + 'Div';
                                    specializationDiv.innerHTML = '<label for="specialization' + nextSpecializationId +
                                        '">Specialization ' + nextSpecializationId + '</label>' +
                                        '<select name="specializations[]" id="specialization' + nextSpecializationId +
                                        '" class="form-control">' +
                                        '<option value="">Select Specialization</option>' +
                                        '@foreach ($specializations as $specialization)' +
                                        '<option value="{{ $specialization->id }}">{{ $specialization->title }}</option>' +
                                        '@endforeach' +
                                        '</select>';

                                    // Trovo ultima select utilizzando ultimo ID numerico
                                    var lastSpecializationDiv = document.getElementById('specialization' +
                                        lastSpecializationId + 'Div');
                                    lastSpecializationDiv.parentNode.insertBefore(specializationDiv, lastSpecializationDiv
                                        .nextSibling);

                                    // Aggiorno ID ultima select
                                    lastSpecializationId = nextSpecializationId;

                                    // Nascondo il bottone se abbiamo raggiunto il max di specializzazioni
                                    if (specializationCount === maxSpecializations) {
                                        document.getElementById('addSpecializationButton').style.display = 'none';
                                    }
                                }
                            });
                        });
                    </script>


                    <div class="py-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
        </form>
    </div>
    </div>
@endsection
