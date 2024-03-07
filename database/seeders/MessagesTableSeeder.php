<?php

namespace Database\Seeders;

use App\Models\Guest\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = config('messages_db');

        foreach ($messages as $message) {
            $new_message = new Message();

            $new_message->doctor_id = $message['doctorId'];
            $new_message->name = $message['name'];
            $new_message->surname = $message['surname'];
            $new_message->email = $message['email'];
            $new_message->phone_number = $message['phone_number'];
            $new_message->message = $message['message'];

            $new_message->save();
        }
    }
}
