<?php

namespace Database\Seeders;

use App\Models\Admin\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecializatioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = ['Ortopedico', 'Dermatologo', 'Psicologo', 'Oculista', 'Ginecologo', 'Nutrizionista', 'Dentista','Cardiologo','Osteopata', 'Ostetrica', 'Anestetista', 'Logopedista'];

        foreach ($specializations as $specialization) {

            $new_specialization = new Specialization();

             $new_specialization->title = $specialization;
             $new_specialization->slug = Str::of($specialization)->slug('-');

             $new_specialization->save();
        }
    }
}
