<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Doctor;
use App\Models\Admin\Specialization;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $specializations = Specialization::all();
        return view('auth.register', compact('specializations'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['max:30', 'required', 'string', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'surname' => ['max:40', 'required', 'string', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'address' => ['required', 'string',  'max:100'],
            'specializations' => ['required', Rule::in($this->SpecializationsId())],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        do {
            $uniqueSlugId = microtime(true) * 10000;
            $doctorSlug = Str::of("{$request->name}-{$request->surname}-{$uniqueSlugId}")->slug('-');
        } while (Doctor::where('slug', $doctorSlug)->exists());


        $doctor = Doctor::create([
            'user_id' => $user->id,
            'slug' => $doctorSlug,
            'address' => $request->address,
        ]);

        $doctor->specializations()->attach($request->specializations);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function SpecializationsId()
    {
        $specializations = Specialization::all();
        return $specializationIds = Specialization::pluck('id')->toArray();
    }
}
