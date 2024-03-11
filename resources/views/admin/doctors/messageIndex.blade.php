@extends('layouts.admin')

@section('content')
    <div id="messages" class="container pt-5">
        <h1 class="mb-4">Lista Messaggi</h1>

        @if (count($user->doctor->messages) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Messaggio</th>
                        <th scope="col">Cellulare</th>
                        <th scope="col">E-mail</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr>
                            <th scope="row">
                                @if ($message->name && $message->surname)
                                    {{ $message->name }} {{ $message->surname }}
                                @else
                                    Anonimo
                                @endif
                            </th>
                            <td>{{ $message->message }}</td>
                            <td>{{ $message?->phone_number ?: '-' }}</td>
                            <td>{{ $message->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3>Nessun Messaggio</h3>
        @endif

    </div>
@endsection
