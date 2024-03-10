<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use App\Models\Guest\Review;
use App\Models\User;
use App\Models\Admin\Sponsorship;
use Illuminate\Http\Request;

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
            $doctors = Doctor::with('user', 'specializations', 'reviews', 'sponsorships', 'votes')
                ->whereHas('specializations', function ($customQuery) {
                    $customQuery->where('title', 'LIKE', '%' . request()->key . '%');
                })  ->get(); // tutti i dottori filtrati per specializzazione con relazione tabella user - specializzazione 
                // ->orWhereHas('user', function ($customQuery) {
                //     $customQuery->where('name', 'LIKE', '%' . request()->key . '%');
                // })->orWhereHas('user', function ($customQuery) {
                //     $customQuery->where('surname', 'LIKE', '%' . request()->key . '%');
                // })
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
    public function sponsor(){
    // $sponsoredDoctors = Doctor::with('user', 'specializations', 'reviews', 'sponsorships', 'votes')
    //     ->whereHas('sponsorships')
    //     ->with(['specializations' => function ($query) {
    //         $query->orderBy('title', 'asc'); // specializzazioni per titolo in ordine alfabetico crescente
        // }])
        // ->join('doctor_sponsorship', 'doctors.id', '=', 'doctor_sponsorship.doctor_id')
        // ->orderByRaw("FIELD(doctor_sponsorship.sponsorship_id, 3, 2, 1)") // ordina per ID
        // ->orderByRaw("(SELECT MIN(title) FROM specializations WHERE specializations.id IN (SELECT specialization_id FROM doctor_specialization WHERE doctor_id = doctors.id))") // ordina per il titolo più basso tra tutte le specializzazioni associate a ciascun dottore
        // ->get();

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
        ->get();

    return response()->json([
        'status' => true,
        'results' => $sponsoredDoctors,
    ]);
    }
}