@extends('layouts.admin')

@section('title', 'Créer une Matière')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus"></i> Créer une Nouvelle Matière
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.matieres.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nom_matiere" class="form-label">Nom de la Matière *</label>
                                    <input type="text" class="form-control @error('nom_matiere') is-invalid @enderror"
                                           id="nom_matiere" name="nom_matiere" value="{{ old('nom_matiere') }}" required>
                                    @error('nom_matiere')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coefficient" class="form-label">Coefficient *</label>
                                    <input type="number" step="0.5" min="0.5" max="10"
                                           class="form-control @error('coefficient') is-invalid @enderror"
                                           id="coefficient" name="coefficient" value="{{ old('coefficient', 1) }}" required>
                                    @error('coefficient')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="niveau_id" class="form-label">Niveau *</label>
                                    <select class="form-select @error('niveau_id') is-invalid @enderror"
                                            id="niveau_id" name="niveau_id" required>
                                        <option value="">Sélectionner un niveau</option>
                                        @foreach($niveaux as $niveau)
                                            <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                                                {{ $niveau->nom_niveau }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('niveau_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="enseignant_id" class="form-label">Enseignant</label>
                                    <select class="form-select @error('enseignant_id') is-invalid @enderror"
                                            id="enseignant_id" name="enseignant_id">
                                        <option value="">Aucun enseignant assigné</option>
                                        @foreach($enseignants as $enseignant)
                                            <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                                {{ $enseignant->nom }}
                                                @if($enseignant->specialite)
                                                    ({{ $enseignant->specialite }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('enseignant_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Description optionnelle de la matière...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer la Matière
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
