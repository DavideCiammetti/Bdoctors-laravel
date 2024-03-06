<?php

namespace Database\Seeders;

use App\Models\Admin\DoctorSpecialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSpecializationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docsSpecs = config('doctors_specializations_db');

        foreach ($docsSpecs as $docSpec) {

            $new_docSpec = new DoctorSpecialization();
            $new_docSpec->doctor_id = $docSpec['doctorId'];
            $new_docSpec->specialization_id = $docSpec['specializationId'];

            $new_docSpec->save();
        }
    }
}
