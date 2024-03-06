<?php

namespace Database\Seeders;

use App\Models\Admin\DoctorVote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorVoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docsVotes = config('doctors_votes_db');

        foreach ($docsVotes as $docVote) {
            $new_docVote = new DoctorVote();
            $new_docVote->doctor_id = $docVote['doctorId'];
            $new_docVote->vote_id = $docVote['voteId'];

            $new_docVote->save();
        }
    }
}
