<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class UserController extends Controller
{
    // elimina definitivamente l'utente 
    public function destroy(Request $request): RedirectResponse
    {
        $del_user = Auth::user();
        $user = User::find($del_user->id);
        $doctor = $user->doctor;
        // logout
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // delete
        if ($user) {
            $user->delete();
            $doctor->delete();
        }
        return redirect('/');
    }
}
