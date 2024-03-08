@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Registrati</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Nome --}}
                            <div class="mb-4 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}*</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="val-name form-control my-input @error('name') is-invalid @enderror"
                                        name="name" placeholder="Mario" value="{{ old('name') }}" required
                                        autocomplete="name" autofocus>

                                    {{-- errori --}}
                                    <div class="name-error text-danger"></div>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>

                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Cognome --}}
                            <div class="mb-4 row">
                                <label for="surnname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}*</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="val-surname form-control my-input @error('surname') is-invalid @enderror"
                                        name="surname" placeholder="Rossi" value="{{ old('surname') }}" required
                                        autocomplete="surname" autofocus>

                                    {{-- errori --}}
                                    <div class="surname-error text-danger"></div>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Indirizzo --}}
                            <div class="mb-4 row">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo') }}*</label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                        class="val-address form-control my-input @error('address') is-invalid @enderror"
                                        name="address" placeholder="Via Roma" value="{{ old('address') }}" required
                                        autocomplete="address" autofocus>

                                    {{-- errori --}}
                                    <div class="address-error text-danger"></div>

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Specializzazione --}}
                            <div class="mb-4 row">
                                <label for="specializations"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Specializzazione') }}*</label>

                                <div class="col-md-6">
                                    <select id="specializations"
                                        class="form-select my-input  @error('specializations') is-invalid @enderror"
                                        aria-label="Default select example" name="specializations" required
                                        autocomplete="specializations" autofocus>
                                        <option value="" @if (old('specializations') == '') selected @endif>Nessuna
                                            Specializzazione</option>
                                        @foreach ($specializations as $key => $specialization)
                                            {
                                            <option value="{{ $specialization->id }}"
                                                @if (old('specializations') == $specialization->id) selected @endif>
                                                {{ $specialization->title }}
                                            </option>
                                            }
                                        @endforeach
                                    </select>

                                    @error('specializations')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo E-Mail') }}*</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="val-email form-control my-input @error('email') is-invalid @enderror"
                                        name="email" placeholder="mario@rossi.com" value="{{ old('email') }}" required
                                        autocomplete="email">

                                    {{-- errori --}}
                                    <div class="email-error text-danger"></div>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}*</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="val-password form-control my-input @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">

                                    {{-- errori --}}
                                    <div class="password-error text-danger"></div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Conferma Password --}}
                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}*</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password"
                                        class=" val-confirm-password my-input form-control" name="password_confirmation"
                                        required autocomplete="new-password">
                                </div>
                            </div>

                            {{-- Bottone di invio --}}
                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="send btn btn-access">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <div>* I seguenti campi sono obbligatri</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
