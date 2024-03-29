<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BDoctors') }}</title>
    
     {{-- favicon --}}
    <link rel="icon" href="{{asset('favicon.png')}}">

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Title font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&display=swap" rel="stylesheet">


    {{-- text font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    {{-- chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        <header id="admin-header" class="navbar sticky-top flex-md-nowrap p-2 shadow">
            {{-- logo torna home --}}
            <div class="row justify-content-between">
                <a class="title navbar-brand col-md-3 col-lg-2 text-white me-0 px-3" href="/">Bdoctors Pro</a>
                <button class="navbar-toggler position-absolute d-md-none collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>



            <div class="d-flex align-items-center ">
                @if ($user->doctor->sponsorships->first())
                    <i class="fa-solid fa-star text-warning me-2"></i>
                @endif
                {{-- link di utility --}}
                <div class="btn-group dropstart">
                    <button type="button" id="user-icon" data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($user->doctor->doctor_img)
                            <img src="{{ asset('storage/' . $user->doctor->doctor_img) }}" alt="Immagine del medico">
                        @else
                            <i class="fa-solid fa-user d-flex align-items-center justify-content-center "></i>
                        @endif

                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            {{-- Logout --}}
                            <div class="nav-item text-nowrap ms-2">
                                <a class="nav-link " href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                    {{ __('Esci') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li>
                            {{-- delete account --}}
                            <div class="nav-item text-nowrap ms-2">
                                <a class="nav-link text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                    document.getElementById('destroy').submit();">
                                    {{ __('Elimina Account') }}
                                </a>
                                <form id="destroy" action="{{ route('admin.user.destroy') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </header>

        <div class="container-fluid">
            <div class="row h-100">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            {{-- Link alla Dashboard --}}
                            <li class="nav-item">
                                <a class="nav-link  {{ Route::currentRouteName() == 'admin.dashboard' ? 'current-route' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i> Dashboard
                                </a>
                            </li>

                            {{-- Link Show --}}
                            <li class="nav-item">
                                <a class="nav-link  {{ Route::currentRouteName() == 'admin.doctors.show' ? 'current-route' : '' }}"
                                    href="{{ route('admin.doctors.show', $user->doctor->id) }}">
                                    <i class="fa-solid fa-circle-info fa-lg fa-fw"></i> Il Tuo Profilo
                                </a>
                            </li>

                            {{-- Link Edit --}}
                            <li class="nav-item">
                                <a class="nav-link  {{ Route::currentRouteName() == 'admin.doctors.edit' ? 'current-route' : '' }}"
                                    href="{{ route('admin.doctors.edit', $user->doctor->id) }}">
                                    <i class="fa-solid fa-pen-to-square fa-lg fa-fw"></i> Modifica Profilo
                                </a>
                            </li>

                            {{-- Link Pagamento --}}
                            <li class="nav-item">
                                <a class="nav-link  {{ Route::currentRouteName() == 'admin.doctor.payment' ? 'current-route' : '' }}"
                                    href="{{ route('admin.doctor.payment') }}">
                                    <i class="fa-solid fa-cart-shopping fa-lg fa-fw"></i> Sponsorizzazioni
                                </a>
                            </li>


                            {{-- Lista Messaggi --}}
                            <li class="nav-item">
                                <a class="nav-link  {{ Route::currentRouteName() == 'admin.doctor.messages' ? 'current-route' : '' }}"
                                    href="{{ route('admin.doctor.messages') }}">
                                    <i class="fa-solid fa-message fa-lg fa-fw"></i> Messaggi
                                </a>
                            </li>

                            {{-- Lista Recensioni --}}
                            <li class="nav-item">
                                <a class="nav-link  {{ Route::currentRouteName() == 'admin.doctor.reviews' ? 'current-route' : '' }}"
                                    href="{{ route('admin.doctor.reviews') }}">
                                    <i class="fa-solid fa-comments fa-lg fa-fw"></i> Recensioni
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>

    </div>


    @if (Route::currentRouteName() == 'admin.doctors.edit')
        <script src="{{ asset('js/validations.js') }}"></script>
    @endif

    @if (Route::currentRouteName() == 'admin.doctor.payment')
        <script src="{{ asset('js/payment.js') }}"></script>
    @endif



</body>

</html>
