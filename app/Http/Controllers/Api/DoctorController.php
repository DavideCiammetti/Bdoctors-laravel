<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
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
            'key' => ['nullable', 'string', 'min:3']
        ]);

        // condizione per ottenere i dottori
        if (request()->key) {
            $doctors = Doctor::with('user', 'specializations')
                ->whereHas('specializations', function ($customQuery) {
                    $customQuery->where('title', 'LIKE', '%' . request()->key . '%'); // cerca la key nel campo title tabella specializzazione
                })
                ->get(); // tutti i dottori filtrati per specializzazione con relazione tabella user - specializzazione 
        } else {
            $doctors = Doctor::with('user', 'specializations')->get(); // tutti i dottori con relazione tabella user - specializzazione
        }

        // risposta json
        return response()->json([
            'status' => true,
            'results' => $doctors
        ]);
    }



    
    /**
     * Pagina di dettaglio del dottore tramite slug
     */
    public function show(string $slug)
    {
        // dettaglio dottore con relazione tabella - user, specializzazioni, recensioni
        $doctor = Doctor::where('slug', $slug)->with('user', 'specializations', 'reviews')->first();

        // risposta json
        return response()->json([
            'status' => true,
            'results' => $doctor
        ]);
    }
}
