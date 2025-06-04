@extends('layouts.student')

@section('title', 'Informations Personnelles - Étudiant')

@section('content')
<div class="section">
    <h2>Informations Personnelles</h2>
    
    <div class="info-display">
        <h4>Informations Actuelles</h4>
        @foreach($infos as $key => $value)
            <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
        @endforeach
    </div>
    
    <h3>Modifier Informations</h3>
    <form action="{{ route('etudiant.update-infos') }}" method="POST" class="modification-form">
        @csrf
        @method('PUT')
        
        <input type="text" name="nom" value="{{ Auth::user()->nom }}" placeholder="Nom" style="margin: 5px; padding: 8px;">
        <input type="email" name="email" value="{{ Auth::user()->email }}" placeholder="Email" style="margin: 5px; padding: 8px;">
        
        <select name="niveau" style="margin: 5px; padding: 8px;">
            <option value="primaire" {{ Auth::user()->etudiant->niveau == 'primaire' ? 'selected' : '' }}>Primaire</option>
            <option value="college" {{ Auth::user()->etudiant->niveau == 'college' ? 'selected' : '' }}>Collège</option>
            <option value="lycee" {{ Auth::user()->etudiant->niveau == 'lycee' ? 'selected' : '' }}>Lycée</option>
        </select>
        
        <br>
        <button type="submit" class="btn">Modifier</button>
    </form>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection