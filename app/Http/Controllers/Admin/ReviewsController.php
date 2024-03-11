<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reviews = $user->doctor->reviews;

        return view('admin.doctors.reviewsIndex', compact('user', 'reviews'));
    }
}
