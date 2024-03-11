@extends('layouts.admin')

@section('content')
    <div id="messages" class="container pt-5">
        <h1>Lista Messaggi</h1>

        <ul>
            @foreach ($messages as $message)
                <li>{{ $message->message }}</li>
            @endforeach
        </ul>
    </div>
@endsection
