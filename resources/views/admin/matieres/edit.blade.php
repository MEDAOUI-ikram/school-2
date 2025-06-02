@extends('layouts.admin')

@section('title', 'Modifier la Matière')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-book-edit"></i> Modifier la Matière : {{ $matiere->nom_matiere }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.matieres.update', $matiere) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nom_matiere" class="form-label">Nom de la matière <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom_matiere') is-invalid @enderror"
                                   id="nom_matiere" name="nom_matiere"
                                   value="{{ old('nom_matiere', $matiere->nom_matiere) }}"
                                   placeholder="Ex: Mathématiques" required>
                            @error('nom_matiere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="coefficient" class="form-label">Coefficient</label>
                            <input type="number" class="form-control @error('coefficient') is-invalid @enderror"
                                   id="coefficient" name="coefficient"
                                   value="{{ old('coefficient', $matiere->coefficient) }}"
                                   min="0.5" max="10" step="0.5" placeholder="Ex: 2">
                            @error('coefficient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="niveau_id" class="form-label">Niveau</label>
                            <select class="form-select @error('niveau_id') is-invalid @enderror"
                                    id="niveau_id" name="niveau_id">
                                <option value="">Tous les niveaux</option>
                                @foreach($niveaux as $niveau)
                                    <option value="{{ $niveau->id }}"
                                            {{ old('niveau_id', $matiere->niveau_id) == $niveau->id ? 'selected' : '' }}>
                                        {{ $niveau->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('niveau_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="heures_par_semaine" class="form-label">Heures par semaine</label>
                            <input type="number" class="form-control @error('heures_par_semaine') is-invalid @enderror"
                                   id="heures_par_semaine" name="heures_par_semaine"
                                   value="{{ old('heures_par_semaine', $matiere->heures_par_semaine) }}"
                                   min="1" max="20" step="0.5" placeholder="Ex: 4">
                            @error('heures_par_semaine')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Description de la matière">{{ old('description', $matiere->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                       {{ old('active', $matiere->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Matière active
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
