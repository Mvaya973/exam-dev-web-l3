@extends('layouts.app')

@section('title', $event->exists ? 'Modifier un événement' : 'Créer un événement')

@section('content')
    <div class="mb-4">
        <a href="{{ $event->exists ? route('events.show', $event) : route('events.index') }}" class="btn btn-link px-0">
            Retour
        </a>
        <h1>{{ $event->exists ? 'Modifier l’événement' : 'Créer un événement' }}</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="mb-1">Veuillez corriger les erreurs suivantes :</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $event->exists ? route('events.update', $event) : route('events.store') }}" method="POST" class="row g-3">
        @csrf
        @if ($event->exists)
            @method('PUT')
        @endif

        <div class="col-12 col-md-6">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $event->title) }}" maxlength="150" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 col-md-6">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $event->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 col-md-6">
            <label for="event_date" class="form-label">Date</label>
            <input type="date" name="event_date" id="event_date" class="form-control @error('event_date') is-invalid @enderror" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" required>
            @error('event_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 col-md-6">
            <label for="location" class="form-label">Lieu <span class="text-secondary">(facultatif)</span></label>
            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $event->location) }}" maxlength="150">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">{{ $event->exists ? 'Enregistrer les modifications' : 'Créer l’événement' }}</button>
            <a href="{{ $event->exists ? route('events.show', $event) : route('events.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
@endsection