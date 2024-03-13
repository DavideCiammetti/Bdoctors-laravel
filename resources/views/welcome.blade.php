@extends('layouts.app')
@section('content')
    <div id="welcome" class="container py-5">

        <div class="row">
            {{-- Presentazione --}}
            <div class="col-md-12 mb-4 text-center ">
                <div class="card">
                    <div class="card-header">
                        <h1>Bdoctors Pro</h1>
                    </div>
                    <div class="card-body">
                        <p>
                            Se sei un professionista del settore sanitario e desideri ottimizzare la gestione dei tuoi
                            appuntamenti,
                            migliorare la tua visibilità e offrire un servizio impeccabile ai tuoi pazienti, Bddoctors Pro è
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
            <div class="col-md-6 mb-3 h-100">
                {{-- Descrizione --}}
                <div class="card">
                    <div class="card-header">
                        <h2>Metti in risalto il tuo Profilo</h2>
                    </div>
                    <div class="card-body d-flex">
                        <p class="d-flex align-items-center justify-content-center mb-0">
                            Metti in rilievo il tuo profilo: Bddoctors Pro ti offre l'opportunità di distinguerti nel
                            settore sanitario, collegandoti con una vasta rete di pazienti e migliorando la tua visibilità
                            professionale in modo rapido e efficace
                        </p>
                        {{-- Immagine --}}
                        <div class="img-container">
                            <img class="img-welcome" src="{{ asset('img/Profilo welcome.jpg') }}" alt="Profilo img">
                        </div>
                    </div>
                </div>


            </div>

            {{-- Paziente --}}
            <div class="col-md-6 mb-3 h-100">
                {{-- Descrizione --}}
                <div class="card">
                    <div class="card-header">
                        <h2>Contatto diretto col Paziente</h2>
                    </div>
                    <div class="card-body d-flex">
                        <p class="d-flex align-items-center justify-content-center mb-0">
                            Contatto diretto col paziente: Con Bddoctors Pro, accedi a strumenti avanzati per comunicare
                            direttamente con i tuoi pazienti, garantendo un servizio personalizzato e tempestivo per
                            soddisfare al meglio le loro esigenze
                        </p>
                        {{-- Immagine --}}
                        <div class="img-container">
                            <img class="img-welcome" src="{{ asset('img/Paziente welcome.jpg') }}" alt="Profilo img">
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-6">
                <h2>Diventa un membro Sponsorizzato</h2>
            </div>
            <div class="col-md-6">
                <h2>Divertiti con le statistiche</h2>
            </div>
        </div>
    </div>
@endsection
