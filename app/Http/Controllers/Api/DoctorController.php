<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use App\Models\Guest\Review;
use App\Models\User;
use App\Models\Admin\Sponsorship;
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
    public function sponsor(Request $request){
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
        ->paginate(5);
    
        return response()->json([
            'status' => true,
            'results' => $sponsoredDoctors,
        ]);
    }
    
}