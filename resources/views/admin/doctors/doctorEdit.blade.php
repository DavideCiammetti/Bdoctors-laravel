@extends('layouts.admin')

@section('content')
    <div id="doctor-edit" class="container pt-5">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h1>Modifica Profilo</h1>
                <div>* I seguenti campi sono obbligatri</div>
            </div>
        </div>

        {{-- Campi mancanti --}}
        <div class="mb-5">
            @if (!$user->doctor->phone_number || !$user->doctor->doctor_img || !$user->doctor->doctor_cv || !$user->doctor->services)
                <h2 class="mb-3">Ciao {{ $user->name }} {{ $user->surname }}. Sembra che il tuo profilo non sia completo
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

        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row justify-content-between ">

                {{-- Campi testuali --}}
                <div class="col-md-7">

                    {{-- nome  --}}
                    <div class="form-group mb-3">
                        <label for="name" class="mb-2 form-label d-flex justify-content-between ">
                            Nome *
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="name-error text-warning"></div>
                        </label>
                        <input type="text" name="name" id="name" class="val-name form-control my-input"
                            value="{{ old('name', $user->name) }}">

                    </div>

                    {{-- cognome  --}}
                    <div class="form-group mb-3">
                        <label for="surname" class="mb-2 form-label d-flex justify-content-between ">
                            Cognome *
                            @error('surname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="surname-error text-warning"></div>
                        </label>
                        <input type="text" name="surname" id="surname" class="val-surname form-control my-input"
                            value="{{ old('surname', $user->surname) }}">
                    </div>

                    {{-- indirizzo  --}}
                    <div class="form-group mb-3">
                        <label for="address" class="mb-2 form-label d-flex justify-content-between ">
                            Indirizzo *
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="address-error text-warning"></div>
                        </label>
                        <input type="text" name="address" id="address" class="val-address form-control my-input"
                            value="{{ old('address', $user->doctor->address) }}">

                    </div>

                    {{-- numero di telefono  --}}
                    <div class="form-group mb-3">
                        <label for="phone_number" class="mb-2 form-label d-flex justify-content-between ">
                            Numero di telefono
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="phone-number-error text-warning"></div>

                        </label>
                        <input type="text" name="phone_number" id="phone_number"
                            class="val-phone-number form-control my-input"
                            value="{{ old('phone_number', $user->doctor->phone_number) }}">
                    </div>

                    {{-- disponibilità --}}
                    <div class="form-group mb-2">
                        <label class="mb-2 form-label d-flex justify-content-between ">
                            Disponibilità
                            @error('is_avaiable')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="avaiable-error text-warning"></div>

                        </label>
                        <div class="form-check">
                            <input type="radio" id="available" name="is_available" value="1"
                                class="val-avaiable form-check-input my-input"
                                {{ $user->doctor->is_available == 1 ? 'checked' : '' }}>
                            <label for="available" class="form-check-label">Disponibile</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="not_available" name="is_available" value="0"
                                class="val-not-avaiable form-check-input my-input"
                                {{ $user->doctor->is_available == 0 ? 'checked' : '' }}>
                            <label for="not_available" class="form-check-label">Non Disponibile</label>
                        </div>
                    </div>

                    {{-- specializzazione  --}}
                    {{-- <div class="form-group mb-3">
                        <label for="specializations"
                            class="col-md-4 col-form-label text-md-right mb-2 d-flex justify-content-between">
                            Specializzazioni *
                            @error('specializations')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </label>
                        <select id="specializations"
                            class="form-select my-input  @error('specializations') is-invalid @enderror"
                            aria-label="Default select example" name="specializations" required
                            autocomplete="specializations" autofocus>
                            <option selected value="">Nessuna Specializzazione</option>
                            @foreach ($specializations as $specialization)
                                {
                                <option value="{{ $specialization->id }}"
                                    {{ old('specialization->id', $user->doctor->specializations[0]['id']) == $specialization->id ? 'selected' : '' }}>
                                    {{ $specialization->title }}</option>
                                }
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- specializzazione --}}
                    <div class="mb-3">
                        <label class="form-label d-flex justify-content-between ">
                            Specializzazioni
                            {{-- errore --}}
                            @error('specializations')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </label>

                        <div class="input-group">
                            @foreach ($specializations as $specialization)
                                <div class="form-check form-check-inline">
                                    @if ($errors->any())
                                        <input class="my-input form-check-input" type="checkbox"
                                            id="specialization-{{ $specialization->id }}"
                                            value="{{ $specialization->id }}" name="specializations[]"
                                            {{ in_array($specialization->id, old('specializations', [])) ? 'checked' : '' }}>
                                        {{-- mando un array --}}
                                        <label class="form-check-label"
                                            for="specialization-{{ $specialization->id }}">{{ $specialization->title }}</label>
                                    @else
                                        <input class="my-input form-check-input" type="checkbox"
                                            id="specialization-{{ $specialization->id }}"
                                            value="{{ $specialization->id }}" name="specializations[]"
                                            {{ $doctor->specializations->contains($specialization->id) ? 'checked' : '' }}>
                                        {{-- mando un array --}}
                                        <label class="form-check-label"
                                            for="specialization-{{ $specialization->id }}">{{ $specialization->title }}</label>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Prestazioni  --}}
                    <div class="form-group pb-2">
                        <label for="services" class="mb-2 d-flex justify-content-between">
                            Prestazioni
                            @error('services')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="services-error text-warning"></div>
                        </label>
                        <textarea type="text" name="services" id="services" class="val-services form-control my-input" cols="30"
                            rows="10">{{ old('services', $user->doctor->services) }}</textarea>
                    </div>

                </div>

                {{-- Foto e CV --}}
                <div class="col-md-4 mt-4 d-flex flex-column align-items-between justify-content-center ">

                    {{-- Foto Profilo  --}}
                    <div class="card mb-4">
                        <div class="card-header">Foto Profilo</div>
                        <div class="card-body">
                            {{-- Immagine --}}
                            <div class="mb-3">
                                @if ($user->doctor->doctor_img)
                                    <img src="{{ asset('storage/' . $user->doctor->doctor_img) }}" class="img-fluid"
                                        alt="Doctor Image">
                                @endif
                            </div>

                            {{-- Testo "Change/Add image" --}}
                            <div class="mb-3">
                                <label for="doctor-img-edit" class="form-label d-flex justify-content-between">
                                    @if ($user->doctor->doctor_img)
                                        Cambia Immagine
                                    @else
                                        Aggiungi Immagine
                                    @endif
                                </label>
                            </div>

                            {{-- Input "Scegli file" --}}
                            <div class="input-group">
                                <input
                                    class="val-image upload-image my-input form-control @error('doctor_img') is-invalid @enderror"
                                    type="file" id="doctor-img-edit" name="doctor_img" value="1">
                                {{-- {{ old('doctor_img', $user->doctor->doctor_img) }} --}}
                            </div>
                        </div>
                        {{-- errore url immagine --}}
                        @error('doctor_img')
                            <div class="card-footer text-danger">{{ $message }}</div>
                        @enderror
                        <div class="image-error card-footer text-warning"></div>
                    </div>


                    {{-- CV --}}
                    <div class="card mb-4 ">

                        <div class="card-header">CV</div>

                        <div class="card-body">
                            <div class="mb-3">
                                @if ($user->doctor->doctor_cv)
                                    <iframe src="{{ asset('storage/' . $user->doctor->doctor_cv) }}" alt="Doctor CV"
                                        title="Doctor CV"></iframe>
                                @endif
                            </div>

                            {{-- Testo "Change/Add image" --}}
                            <div class="mb-3">
                                <label for="doctor-cv-edit" class="form-label d-flex justify-content-between">
                                    @if ($user->doctor->doctor_cv)
                                        Cambia CV
                                    @else
                                        Aggiungi un CV
                                    @endif
                                </label>
                            </div>

                            {{-- Input "Scegli file" --}}
                            <div class="input-group">
                                <input
                                    class="val-cv upload-image my-input form-control @error('doctor_cv') is-invalid @enderror"
                                    type="file" id="doctor-cv-edit" name="doctor_cv"
                                    value="{{ old('doctor_cv', $user->doctor->doctor_cv) }}">
                            </div>
                        </div>

                        {{-- errore url immagine --}}
                        @error('doctor_img')
                            <div class="card-footer text-danger">{{ $message }}</div>
                        @enderror
                        <div class="cv-error card-footer text-warning"></div>
                    </div>
                </div>

                {{-- Bottone di invio --}}
                <div class="py-5">
                    <button type="submit" class="send btn btn-link">Modifica</button>
                </div>
        </form>
    </div>
@endsection
