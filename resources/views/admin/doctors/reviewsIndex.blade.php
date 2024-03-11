@extends('layouts.admin')

@section('content')
    <div id="messages" class="container pt-5">
        <h1 class="mb-4">Lista Messaggi</h1>

        @if (count($user->doctor->messages) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Recensione</th>
                        <th scope="col">Cellulare</th>
                        <th scope="col">E-mail</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <th scope="row">
                                @if ($review->name && $review->surname)
                                    {{ $review->name }} {{ $review->surname }}
                                @else
                                    Anonimo
                                @endif
                            </th>
                            <td>{{ $review->content }}</td>
                            <td>{{ $review?->phone_number ?: '-' }}</td>
                            <td>{{ $review->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3>Nessun Messaggio</h3>
        @endif

    </div>
@endsection
