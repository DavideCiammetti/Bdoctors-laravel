<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guest\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function store(Request $request){
        
        $new_review = new Review();
        $data = $request->validate([
            'name' => ['required','max:30', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'surname' => ['required','max:40', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['nullable','max:100'],
            'doctor_id' => ['required'],
            'content'=>['required'],
        ]);
        

        $new_review->fill($data);
        $new_review->save();
        return $new_review;
    }
}
