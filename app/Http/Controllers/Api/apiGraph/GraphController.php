<?php

namespace App\Http\Controllers\Api\apiGraph;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function index(){

        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();
        $messages = DB::table('messages')
        ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), 'doctor_id', DB::raw('COUNT(*) as message_count'))
        ->where('doctor_id', $doctor->id) // Filtra per l'id dello user corrente
        ->groupBy('month', 'doctor_id')
        ->get();
        
        
        $reviews = DB::table('reviews')
        ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), 'doctor_id', DB::raw('COUNT(*) as reviews_count'))
        ->where('doctor_id', $doctor->id) // Filtra per l'id dello user corrente
        ->groupBy('month', 'doctor_id')
        ->get();

        return response()->json([
            'status' => true,
            'results' => $messages,
            'reviews' => $reviews,
        ]);
    }
}
