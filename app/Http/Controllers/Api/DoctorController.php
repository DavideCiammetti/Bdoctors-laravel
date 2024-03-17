<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use App\Models\Admin\Sponsorship;
use App\Models\Guest\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DoctorController extends Controller
{
    /**
     * Index con ricerca per singola specializzazione
     */
    public function index()
    {
        // key
        request()->validate([
            'key' => ['nullable', 'string', 'min:3'],
        ]);

        if (request()->key) {

            $doctors = DB::table('doctors AS doctor')
                ->select(
                    'doctor.*',
                    'users.*',
                    'doctor_sponsorship.end_date',
                    DB::raw('GROUP_CONCAT(DISTINCT specializations.title) as specialization_titles'),
                    DB::raw('GROUP_CONCAT(DISTINCT doctor_sponsorship.end_date) as sponsorships_end_date'),
                    DB::raw('GROUP_CONCAT(DISTINCT votes.id) as votes_id'),
                    DB::raw('GROUP_CONCAT(DISTINCT reviews.id) as reviews_id'),
                )
                ->leftJoin('doctor_specialization', 'doctor_specialization.doctor_id', '=', 'doctor.id')
                ->leftJoin('specializations', 'doctor_specialization.specialization_id', '=', 'specializations.id')
                ->leftJoin('doctor_sponsorship', 'doctor_sponsorship.doctor_id', '=', 'doctor.id')
                ->leftJoin('sponsorships', 'doctor_sponsorship.sponsorship_id', '=', 'sponsorships.id')
                ->leftJoin('users', 'users.id', '=', 'doctor.user_id')
                // votes
                ->leftJoin('doctor_vote', 'doctor_vote.doctor_id', '=', 'doctor.id')
                ->leftJoin('votes', 'doctor_vote.vote_id', '=', 'votes.id')
                ->leftJoin('reviews', 'reviews.doctor_id', '=', 'doctor.id')
                ->whereIn('doctor.id', function ($query) {
                    $query->select('doctor_id')
                        ->from('doctor_specialization')
                        ->join('specializations', 'doctor_specialization.specialization_id', '=', 'specializations.id')
                        ->where('specializations.title', 'LIKE', '%' . request()->key . '%');
                })
                ->groupBy('doctor.id', 'users.id', 'doctor_sponsorship.end_date')
                ->orderBy('doctor_sponsorship.end_date', 'desc')
                ->get();

            // Raggruppa i risultati per ID del dottore
            $uniqueDoctors = collect($doctors)->groupBy('id')->map(function ($doctorGroup) {
                // Prende solo la prima riga di ogni gruppo (poiché ogni gruppo rappresenta lo stesso dottore)
                return $doctorGroup->first();
            })->values()->all();

            foreach ($uniqueDoctors as $doctor) {
                $doctor->specializations = explode(',', $doctor->specialization_titles);
                $doctor->doctor_sponsorship = explode(',', $doctor->sponsorships_end_date);
                $doctor->votes = explode(',', $doctor->votes_id);
                $doctor->reviews = explode(',', $doctor->reviews_id);
            }
        } else {
            $doctors = Doctor::with('user', 'specializations')->get(); // tutti i dottori con relazione tabella user - specializzazione
        }
        // risposta json
        return response()->json([
            'status' => true,
            'results' => $uniqueDoctors,
        ]);
    }




    /**
     * Pagina di dettaglio del dottore tramite slug
     */
    public function show(string $slug)
    {
        // dettaglio dottore con relazione tabella - user, specializzazioni, recensioni
        $doctor = Doctor::where('slug', $slug)->with('user', 'specializations', 'reviews', 'votes','sponsorships')->first();

        // risposta json
        return response()->json([
            'status' => true,
            'results' => $doctor
        ]);
    }


    /**
     * dottori che hanno una sponsorizzazione
     */
    public function sponsor(Request $request)
{
    $currentDate = now()->toDateString(); // Ottieni la data corrente

    $sponsoredDoctors = Doctor::with(['user', 'specializations', 'reviews', 'votes', 'sponsorships' => function ($query) {
            $query->where('end_date', '>', now()->toDateString())->orderBy('id', 'desc'); // Sponsorizzazioni attive ordinate per ID in ordine decrescente
        }])
        ->whereHas('sponsorships', function ($query) use ($currentDate) {
            $query->where('end_date', '>', $currentDate); // Solo medici con sponsorizzazione attiva
        })
        ->with(['specializations' => function ($query) {
            $query->orderBy('title', 'asc'); // Specializzazioni per titolo in ordine alfabetico
        }])
        ->join('doctor_sponsorship', 'doctors.id', '=', 'doctor_sponsorship.doctor_id')
        ->orderByRaw("FIELD(doctor_sponsorship.sponsorship_id, " . implode(',', Sponsorship::orderBy('id', 'desc')->pluck('id')->toArray()) . ")")
        ->orderByRaw("(SELECT MIN(title) FROM specializations WHERE specializations.id IN (SELECT specialization_id FROM doctor_specialization WHERE doctor_id = doctors.id))") // Ordina per il titolo più basso tra tutte le specializzazioni associate a ciascun dottore
        ->paginate(3);

    return response()->json([
        'status' => true,
        'results' => $sponsoredDoctors,
    ]);
}

    /**
     * Api per ricerca avanzata
     */
    public function advancedSearch()
    {
        // Validazione della richiesta
        request()->validate([
            // key
            'key' => ['nullable', 'string', 'min:3'],

            // specializzazioni
            'ortopedico' => ['nullable', 'string', 'min:3'],
            'dermatologo' => ['nullable', 'string', 'min:3'],
            'psicologo' => ['nullable', 'string', 'min:3'],
            'oculista' => ['nullable', 'string', 'min:3'],
            'ginecologo' => ['nullable', 'string', 'min:3'],
            'nutrizionista' => ['nullable', 'string', 'min:3'],
            'dentista' => ['nullable', 'string', 'min:3'],
            'cardiologo' => ['nullable', 'string', 'min:3'],
            'osteopata' => ['nullable', 'string', 'min:3'],
            'ostetrica' => ['nullable', 'string', 'min:3'],
            'anestesista' => ['nullable', 'string', 'min:3'],
            'logopedista' => ['nullable', 'string', 'min:3'],

            // voti
            "voteValue" => ['nullable', 'integer'],

            // recensioni
            'reviewValue' => ['nullable', 'integer'],
        ]);

        // Array per memorizzare i risultati
        $results = [];

        if (request()) {
            /**
             * Filtra i dottori per specializzazione.
             */
            $specializations = ['ortopedico', 'dermatologo', 'psicologo', 'oculista', 'ginecologo', 'nutrizionista', 'dentista', 'cardiologo', 'osteopata', 'ostetrica', 'anestesista', 'logopedista'];
            foreach ($specializations as $specialization) {
                if (request()->$specialization) {
                    $results[] = $this->specializations($specialization);
                }
            }

            // Unione dei risultati
            // --- collect($results) racchiude l'array in una collection
            // --- flatten() trasforma l'array multidimensionale in monodimensionale
            // --- unique('id') rimuove eventuali duplicati all'interno dell'array
            // --- restituisce tutti i valori dell'array come una nuova collection
            $mergedResults = collect($results)->flatten()->unique('id')->values();

            // Divido i dottori in due gruppi: quelli con sponsorizzazione e quelli senza
            $sponsoredDoctors = [];
            $notSponsoredDoctors = [];

            foreach ($mergedResults as $doctor) {
                if ($doctor->sponsorships->isNotEmpty()) {
                    $sponsoredDoctors[] = $doctor;
                } else {
                    $notSponsoredDoctors[] = $doctor;
                }
            }

            // Unisco i due gruppi di dottori in un unico array
            $orderedResults = array_merge($sponsoredDoctors, $notSponsoredDoctors);
        }

        // Risposta JSON
        return response()->json([
            'status' => true,
            'results' => $orderedResults,
        ]);
    }

    /**
     * Filtra i dottori in base alla specializzazione specificata.
     */
    private function specializations($specialization)
    {
        return Doctor::with('user', 'specializations', 'reviews', 'sponsorships', 'votes')
            ->whereHas('specializations', function ($query) use ($specialization) {
                $query->where('title', 'LIKE', '%' . $specialization . '%');
            })
            ->get();
    }
}
