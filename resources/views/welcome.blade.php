@extends('layouts.app')
@section('content')
    <div id="welcome" class="container py-5">

        <div class="row">
            {{-- Presentazione --}}
            <div class="col-md-12 mb-4 text-center ">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">Bdoctors Pro</h1>
                    </div>
                    <div class="card-body">
                        <p>
                            Se sei un professionista del settore sanitario e desideri ottimizzare la gestione dei tuoi
                            appuntamenti,
                            migliorare la tua visibilità e offrire un servizio impeccabile ai tuoi pazienti, BDoctors Pro è
                            la
                            soluzione che fa al caso tuo. Unisciti alla nostra community di oltre 30 dottori già iscritti e
                            collegati con più di 80.000 pazienti in tutta Italia. Con Bddoctors Pro, potrai gestire in modo
                            efficiente e professionale la tua agenda, offrire un'esperienza migliore ai pazienti e
                            amplificare la
                            tua presenza online per raggiungere un pubblico più vasto.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Profilo --}}
            <div class="col-md-6 mb-3 ">
                {{-- Descrizione --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Metti in risalto il tuo Profilo</h2>
                    </div>
                    <div class="card-body d-flex">
                        <p class="d-flex align-items-center justify-content-center mb-0 pe-5">
                            BDoctors Pro ti offre l'opportunità di distinguerti nel
                            settore sanitario, collegandoti con una vasta rete di pazienti e migliorando la tua visibilità
                            professionale in modo rapido e efficace.
                        </p>
                        {{-- Immagine --}}
                        <div class="img-container">
                            <img class="img-welcome" src="{{ asset('img/Profilo welcome.jpg') }}" alt="Profilo img">
                        </div>
                    </div>
                </div>


            </div>

            {{-- Paziente --}}
            <div class="col-md-6 mb-3">
                {{-- Descrizione --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Contatto diretto col Paziente</h2>
                    </div>
                    <div class="card-body d-flex">
                        <p class="d-flex align-items-center justify-content-center mb-0 pe-5">
                            Con BDoctors Pro, accedi a strumenti avanzati per comunicare
                            direttamente con i tuoi pazienti, garantendo un servizio personalizzato e tempestivo per
                            soddisfare al meglio le loro esigenze.
                        </p>
                        {{-- Immagine --}}
                        <div class="img-container">
                            <img class="img-welcome " src="{{ asset('img/Paziente welcome.jpg') }}" alt="Profilo img">
                        </div>
                    </div>
                </div>


            </div>

            {{-- Sponsorizzazione --}}
            <div class="col-md-6 mb-3">
                {{-- Descrizione --}}
                <div class="card ">
                    <div class="card-header">
                        <h2 class="mb-0">Diventa un membro Sponsorizzato</h2>
                    </div>
                    <div class="card-body d-flex">
                        <p class="d-flex align-items-center justify-content-center mb-0 pe-5">
                            Diventa membro sponsorizzato per essere in cima alla ricerca e in primo piano sulla prima
                            pagina. Espandi la tua esposizione e attrai nuovi pazienti con facilità.
                        </p>
                        {{-- Immagine --}}
                        <div class="img-container">
                            <img class="img-welcome" src="{{ asset('img/Sponsorizzazione welcome.jpg') }}"
                                alt="Profilo img">
                        </div>
                    </div>
                </div>


            </div>

            {{-- Statistiche --}}
            <div class="col-md-6 mb-3">
                {{-- Descrizione --}}
                <div class="card ">
                    <div class="card-header">
                        <h2 class="mb-0">Divertiti con le statistiche</h2>
                    </div>
                    <div class="card-body d-flex">
                        <p class="d-flex align-items-center justify-content-center mb-0 pe-5">
                            Con BDoctors Pro, monitora il tuo progresso attraverso statistiche mensili su voti, messaggi e
                            recensioni. Ottieni preziose informazioni per migliorare il tuo servizio e soddisfare al meglio
                            le esigenze dei pazienti.
                        </p>
                        {{-- Immagine --}}
                        <div class="img-container">
                            <img class="img-welcome" src="{{ asset('img/Statistiche welcome.jpg') }}" alt="Profilo img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
