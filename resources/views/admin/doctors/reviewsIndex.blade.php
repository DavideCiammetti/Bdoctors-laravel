@extends('layouts.admin')

@section('content')
    <div id="reviews" class="container pt-5">
        <h1 class="mb-4">Recensioni</h1>

        @if (count($user->doctor->messages) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="bg-green-dark"></th>
                        <th scope="col" class="bg-green-dark">Recensione</th>
                        <th scope="col" class="bg-green-dark">Cellulare</th>
                        <th scope="col" class="bg-green-dark">E-mail</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <th scope="row" class="bg-green-light">
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
