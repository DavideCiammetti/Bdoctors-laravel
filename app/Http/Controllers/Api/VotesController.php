<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\DoctorVote;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function store(Request $request){
        
        $new_vote = new DoctorVote();
        $data = $request->validate([
            'doctor_id' => ['required'],
            'vote_id'=>['required', 'numeric'],
        ]);
        

        $new_vote->fill($data);
        $new_vote->save();
        return $new_vote;
    }
}
