<?php

namespace Database\Seeders;

use App\Models\Admin\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsorships = config('sponsorships_db');

        foreach ($sponsorships as $sponsorship) {

            $new_sponsorships = new Sponsorship();
            $new_sponsorships->title = $sponsorship['title'];
            $new_sponsorships->price = $sponsorship['price'];
            $new_sponsorships->duration = $sponsorship['duration'];

            $new_sponsorships->save();
        }
    }
}
