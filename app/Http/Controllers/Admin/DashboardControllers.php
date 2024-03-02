<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardControllers extends Controller
{
    public function index(){
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();
        return view('dashboard', compact('user', 'doctor'));
    }
}
