<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guest\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function store(Request $request){
        
        $new_message = new Message();
        $data = $request->validate([
            'name' => ['nullable','max:30', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'surname' => ['nullable','max:40', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['nullable','max:100'],
            'doctor_id' => ['required'],
            'message'=>['required'],
        ]);
        

        $new_message->fill($data);
        $new_message->save();
        return $new_message;
    }
}
