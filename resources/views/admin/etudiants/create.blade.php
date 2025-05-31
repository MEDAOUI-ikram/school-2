@extends('layouts.admin')

@section('content')
<h2>Créer un Étudiant</h2>

<form action="{{ route('admin.etudiants.store') }}" method="POST">
    @csrf
    <input name="nom" value="{{ old('nom') }}" placeholder="Nom">
    <input name="courriel" value="{{ old('courriel') }}" placeholder="Email" type="email">
    <input name="mot_de_passe" type="password" placeholder="Mot de passe">
    <input name="mot_de_passe_confirmation" type="password" placeholder="Confirmer">
    <select name="niveau">
        @foreach($niveaux as $niveau)
            <option value="{{ $niveau->nom_niveau }}">{{ $niveau->nom_niveau }}</option>
        @endforeach
    </select>
    <button type="submit">Créer</button>
</form>
@endsection
