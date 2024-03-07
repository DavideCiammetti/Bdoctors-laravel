<?php

namespace Database\Seeders;

use App\Models\Admin\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = config('doctors_db');

        foreach ($doctors as $doctor) {
            $new_doctor = new Doctor();

            // Recupera l'utente associato al medico
            $user = User::findOrFail($doctor['UserId']);

            $uniqueSlugId = microtime(true) * 10000;
            $doctorSlug = Str::of("{$user->name}-{$user->surname}-{$uniqueSlugId}")->slug('-');
            $new_doctor->slug = $doctorSlug;

            $new_doctor->address = $doctor['address'];
            $new_doctor->phone_number = $doctor['phoneNumber'];
            $new_doctor->is_available = $doctor['Is_available'];
            $new_doctor->services = $doctor['services'];
            $new_doctor->user_id = $doctor['UserId'];

            $new_doctor->save();
        }
    }
}
