<?php

namespace Database\Seeders;

use App\Models\Guest\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $votes = ['Scarso', 'Sufficiente', 'Discreto', 'Buono', 'Ottimo'];

        foreach ($votes as $vote) {
            $new_vote = new Vote();
            $new_vote->title = $vote;
            $new_vote->save();
        }
    }
}
