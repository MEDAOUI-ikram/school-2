@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Modifier une Classe</h2>

        <form action="{{ route('admin.classes.update', $classe) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            <div class="form-group">
                <label for="nom_classe">Nom de la Classe</label>
                <input type="text" name="nom_classe" id="nom_classe" class="form-control @error('nom_classe') is-invalid @enderror" value="{{ old('nom_classe', $classe->nom_classe) }}" required>
                @error('nom_classe')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="annee">Année</label>
                <input type="text" name="annee" id="annee" class="form-control @error('annee') is-invalid @enderror" value="{{ old('annee', $classe->annee) }}" required>
                @error('annee')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="niveau_id">Niveau</label>
                <select name="niveau_id" id="niveau_id" class="form-control @error('niveau_id') is-invalid @enderror" required>
                    <option value="">Sélectionner un Niveau</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ old('niveau_id', $classe->niveau_id) == $niveau->id ? 'selected' : '' }}>{{ $niveau->nom_niveau }}</option>
                    @endforeach
                </select>
                @error('niveau_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
