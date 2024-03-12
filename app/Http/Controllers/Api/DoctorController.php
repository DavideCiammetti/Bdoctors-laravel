<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use App\Models\Admin\Sponsorship;
use App\Models\Guest\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    'votes.id',
                    DB::raw('GROUP_CONCAT(specializations.title) as specialization_titles'),
                    'votes.title',
                    'sponsorships.price'
                )
                ->leftJoin('doctor_specialization', 'doctor_specialization.doctor_id', '=', 'doctor.id')
                ->leftJoin('specializations', 'doctor_specialization.specialization_id', '=', 'specializations.id')
                ->leftJoin('doctor_sponsorship', 'doctor_sponsorship.doctor_id', '=', 'doctor.id')
                ->leftJoin('sponsorships', 'doctor_sponsorship.sponsorship_id', '=', 'sponsorships.id')
                ->leftJoin('users', 'users.id', '=', 'doctor.user_id')
                // votes
                ->leftJoin('doctor_vote', 'doctor_vote.doctor_id', '=', 'doctor.id')
                ->leftJoin('votes', 'doctor_vote.vote_id', '=', 'votes.id')
                ->whereIn('doctor.id', function ($query) {
                    $query->select('doctor_id')
                        ->from('doctor_specialization')
                        ->join('specializations', 'doctor_specialization.specialization_id', '=', 'specializations.id')
                        ->where('specializations.title', 'LIKE', '%' . request()->key . '%');
                })
                ->groupBy('doctor.id', 'users.id', 'sponsorships.price', 'votes.id')
                ->orderBy('sponsorships.price', 'desc')
                ->get();

            foreach ($doctors as $doctor) {
                $doctor->specializations = explode(',', $doctor->specialization_titles);
            }

            foreach ($doctors as $doctor) {
                $doctor->votes = explode(',', $doctor->id);
            }
        } else {
            $doctors = Doctor::with('user', 'specializations')->get(); // tutti i dottori con relazione tabella user - specializzazione
        }
        // risposta json
        return response()->json([
            'status' => true,
            'results' => $doctors,
        ]);
    }




    /**
     * Pagina di dettaglio del dottore tramite slug
     */
    public function show(string $slug)
    {
        // dettaglio dottore con relazione tabella - user, specializzazioni, recensioni
        $doctor = Doctor::where('slug', $slug)->with('user', 'specializations', 'reviews', 'votes')->first();

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
        $sponsoredDoctors = Doctor::with(['user', 'specializations', 'reviews', 'votes', 'sponsorships' => function ($query) {
            $query->orderBy('id', 'desc'); // sponsorizzazioni per ID in ordine decrescente
        }])
            ->whereHas('sponsorships')
            ->with(['specializations' => function ($query) {
                $query->orderBy('title', 'asc'); // specializzazioni per titolo in ordine alfabetico
            }])
            ->join('doctor_sponsorship', 'doctors.id', '=', 'doctor_sponsorship.doctor_id')
            ->orderByRaw("FIELD(doctor_sponsorship.sponsorship_id, " . implode(',', Sponsorship::orderBy('id', 'desc')->pluck('id')->toArray()) . ")")
            ->orderByRaw("(SELECT MIN(title) FROM specializations WHERE specializations.id IN (SELECT specialization_id FROM doctor_specialization WHERE doctor_id = doctors.id))") // ordina per il titolo più basso tra tutte le specializzazioni associate a ciascun dottore
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
            "ottimo" => ['nullable'],
            "buono" => ['nullable'],
            "discreto" => ['nullable'],
            "sufficiente" => ['nullable'],
            "scarso" => ['nullable'],

            // recensioni
            'minDieci' => ['nullable'],
            'maxDieci' => ['nullable'],
        ]);

        // Array per memorizzare i risultati
        $results = [];

        if (request()) {
            /**
             * Filtro per nome, cognome o specializzazione
             */
            // 
            if (request()->key) {
                $results[] = Doctor::with('user', 'specializations', 'reviews', 'sponsorships', 'votes')
                    ->whereHas('specializations', function ($query) {
                        $query->where('title', 'LIKE', '%' . request()->key . '%');
                    })
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'LIKE', '%' . request()->key . '%')
                            ->orWhere('surname', 'LIKE', '%' . request()->key . '%');
                    })
                    ->get();
            }

            /**
             * Filtra i dottori per specializzazione.
             */
            $specializations = ['ortopedico', 'dermatologo', 'psicologo', 'oculista', 'ginecologo', 'nutrizionista', 'dentista', 'cardiologo', 'osteopata', 'ostetrica', 'anestesista', 'logopedista'];
            foreach ($specializations as $specialization) {
                if (request()->$specialization) {
                    $results[] = $this->specializations($specialization);
                }
            }

            /**
             * Filtra i dottori in base al voto specificato.
             */
            // ottimo
            if (request()->ottimo) {
                $results[] = Doctor::with('user', 'reviews', 'votes', 'sponsorships')
                    ->select('doctors.*', 'users.*')
                    ->join('doctor_vote', 'doctors.id', '=', 'doctor_vote.doctor_id')
                    ->join('users', 'users.id', '=', 'doctors.user_id')
                    ->groupBy('doctors.id')
                    ->havingRaw('FLOOR(AVG(doctor_vote.vote_id)) = ?', [1])
                    ->get();
            }
            // discreto
            if (request()->discreto) {
                $results[] = Doctor::with('user', 'reviews', 'votes', 'sponsorships')
                    ->select('doctors.*', 'users.*')
                    ->join('doctor_vote', 'doctors.id', '=', 'doctor_vote.doctor_id')
                    ->join('users', 'users.id', '=', 'doctors.user_id')
                    ->groupBy('doctors.id')
                    ->havingRaw('FLOOR(AVG(doctor_vote.vote_id)) = ?', [2])
                    ->get();
            }
            // buono
            if (request()->buono) {
                $results[] = Doctor::with('user', 'reviews', 'votes', 'sponsorships')
                    ->select('doctors.*', 'users.*')
                    ->join('doctor_vote', 'doctors.id', '=', 'doctor_vote.doctor_id')
                    ->join('users', 'users.id', '=', 'doctors.user_id')
                    ->groupBy('doctors.id')
                    ->havingRaw('FLOOR(AVG(doctor_vote.vote_id)) = ?', [3])
                    ->get();
            }
            // sufficiente
            if (request()->sufficiente) {
                $results[] = Doctor::with('user', 'reviews', 'votes', 'sponsorships')
                    ->select('doctors.*', 'users.*')
                    ->join('doctor_vote', 'doctors.id', '=', 'doctor_vote.doctor_id')
                    ->join('users', 'users.id', '=', 'doctors.user_id')
                    ->groupBy('doctors.id')
                    ->havingRaw('FLOOR(AVG(doctor_vote.vote_id)) = ?', [4])
                    ->get();
            }
            // scarso
            if (request()->scarso) {
                $results[] = Doctor::with('user', 'reviews', 'votes', 'sponsorships')
                    ->select('doctors.*', 'users.*')
                    ->join('doctor_vote', 'doctors.id', '=', 'doctor_vote.doctor_id')
                    ->join('users', 'users.id', '=', 'doctors.user_id')
                    ->groupBy('doctors.id')
                    ->havingRaw('FLOOR(AVG(doctor_vote.vote_id)) = ?', [5])
                    ->get();
            }

            /**
             * Filtra i dottori in base al voto specificato.
             */
            // num recensioni < 10
            if (request()->minDieci) {
                $results[] = Doctor::with('user', 'reviews', 'votes', 'sponsorships')
                    ->select('doctors.*')
                    ->whereExists(function ($query) {
                        $query->select(DB::raw('COUNT(reviews.id)'))
                            ->from('reviews')
                            ->whereColumn('doctors.id', 'reviews.doctor_id')
                            ->havingRaw('COUNT(reviews.id) < ?', [10]);
                    })
                    ->get();
            }
            // recensioni > 10
            if (request()->maxDieci) {
                $results[] = Doctor::with('user', 'reviews', 'votes', 'sponsorships')
                    ->select('doctors.*')
                    ->whereExists(function ($query) {
                        $query->select(DB::raw('COUNT(reviews.id)'))
                            ->from('reviews')
                            ->whereColumn('doctors.id', 'reviews.doctor_id')
                            ->havingRaw('COUNT(reviews.id) > ?', [10]);
                    })
                    ->get();
            }

            // Unione dei risultati
            // --- collect($results) racchiude l'array in una collection
            // --- flatten() trasforma l'array multidimensionale in monodimensionale
            // --- unique('id') rimuove eventuali duplicati all'interno dell'array
            // --- restituisce tutti i valori dell'array come una nuova collection
            $mergedResults = collect($results)->flatten()->unique('id')->values();
        }

        // Risposta JSON
        return response()->json([
            'status' => true,
            'results' => $mergedResults,
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
