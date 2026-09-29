@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <a href="/events" class="btn btn-link px-0 mb-3">
        Retour aux événements
    </a>

    <article class="card">
        <div class="card-body p-4">
            <p class="event-date">
                {{ $event->event_date->format('d/m/Y') }}
            </p>

            <h1>{{ $event->title }}</h1>

            <p class="lead mt-4">
                {{ $event->description }}
            </p>

            @if ($event->location)
                <p class="mb-0"><strong>Lieu :</strong> {{ $event->location }}</p>
            @endif

            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">Modifier</a>
                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Supprimer cet événement ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </article>
@endsection