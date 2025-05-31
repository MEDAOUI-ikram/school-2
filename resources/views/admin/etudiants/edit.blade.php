@extends('layouts.admin')

@section('title', 'Modifier un Étudiant')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-edit"></i> Modifier l'Étudiant
            </h1>
            <div class="btn-group">
                <a href="{{ route('admin.etudiants.show', $etudiant) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Voir
                </a>
                <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.etudiants.update', $etudiant) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror"
                               id="nom" name="nom" value="{{ old('nom', $etudiant->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="courriel" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('courriel') is-invalid @enderror"
                               id="courriel" name="courriel" value="{{ old('courriel', $etudiant->courriel) }}" required>
                        @error('courriel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="niveau" class="form-label">Niveau <span class="text-danger">*</span></label>
                        <select class="form-select @error('niveau') is-invalid @enderror" id="niveau" name="niveau" required>
                            <option value="">Sélectionner un niveau</option>
                            @foreach($niveaux as $niveau)
                                <option value="{{ $niveau->nom_niveau }}"
                                        {{ old('niveau', $etudiant->niveau) == $niveau->nom_niveau ? 'selected' : '' }}>
                                    {{ $niveau->nom_niveau }}
                                </option>
                            @endforeach
                        </select>
                        @error('niveau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('mot_de_passe') is-invalid @enderror"
                               id="mot_de_passe" name="mot_de_passe">
                        <div class="form-text">Laissez vide pour conserver le mot de passe actuel</div>
                        @error('mot_de_passe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control"
                               id="mot_de_passe_confirmation" name="mot_de_passe_confirmation">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                        <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-info-circle"></i> Informations</h6>
            </div>
            <div class="card-body">
                <p><strong>Créé le :</strong> {{ $etudiant->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le :</strong> {{ $etudiant->updated_at->format('d/m/Y H:i') }}</p>
                <p><strong>Classes :</strong> {{ $etudiant->classes->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

