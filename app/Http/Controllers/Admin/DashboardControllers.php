<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardControllers extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();
        $sponsorship = $doctor->sponsorships;
        $messages = $user->doctor->messages->reverse();
        $reviews = $user->doctor->reviews->reverse();

        $averageVote = $this->averageVote($doctor);

        $italianMonths = [
            'January' => 'Gennaio',
            'February' => 'Febbraio',
            'March' => 'Marzo',
            'April' => 'Aprile',
            'May' => 'Maggio',
            'June' => 'Giugno',
            'July' => 'Luglio',
            'August' => 'Agosto',
            'September' => 'Settembre',
            'October' => 'Ottobre',
            'November' => 'Novembre',
            'December' => 'Dicembre',
        ];


        return view('dashboard', compact('user', 'doctor', 'sponsorship', 'averageVote', 'messages', 'reviews', 'italianMonths'));
    }

    public function averageVote($doctor)
    {
        if (count($doctor->votes) > 0) {
            $votes = $doctor->votes;
            $sommaId = 0;

            foreach ($votes as $vote) {
                $sommaId += $vote->id;
            }

            $averageVote = round($sommaId / count($votes));
        } else {
            $averageVote = 0;
        }
        return $averageVote;
    }
}
