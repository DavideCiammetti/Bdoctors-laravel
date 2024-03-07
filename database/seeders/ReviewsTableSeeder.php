<?php

namespace Database\Seeders;

use App\Models\Guest\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = config('reviews_db');

        foreach ($reviews as $review) {
            $new_review = new Review();

            $new_review->doctor_id = $review['doctorId'];
            $new_review->name = $review['name'];
            $new_review->surname = $review['surname'];
            $new_review->email = $review['email'];
            $new_review->phone_number = $review['phone_number'];
            $new_review->content = $review['content'];

            $new_review->save();
        }
    }
}
