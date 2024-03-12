<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index()
    {
        //variabili
        $user = Auth::user();
        $messages = $user->doctor->messages;

        $italianMonths = [
            'January' => 'Gennaio',
            'February' => 'Febbraio',
            'March' => 'Marzo',
            'April' => 'Aprile',
            'May' => 'Maggio',
            'June' => 'Giugno',
            'July' => 'Luglio',
            'August' => 'Agosto',
            'September' => 'Settembre',
            'October' => 'Ottobre',
            'November' => 'Novembre',
            'December' => 'Dicembre',
        ];

        return view('admin.doctors.messageIndex', compact('user', 'messages', 'italianMonths'));
    }
}
