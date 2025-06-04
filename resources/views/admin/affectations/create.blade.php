@extends('layouts.admin')

@section('title', 'Créer une Affectation')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-link"></i> Créer une Nouvelle Affectation</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.affectations.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="enseignant_id" class="form-label">Enseignant <span class="text-danger">*</span></label>
                            <select class="form-select @error('enseignant_id') is-invalid @enderror"
                                    id="enseignant_id" name="enseignant_id" required>
                                <option value="">Sélectionner un enseignant</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}"
                                            {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
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
                        <div class="col-md-6 mb-3">
                            <label for="matiere_id" class="form-label">Matière <span class="text-danger">*</span></label>
                            <select class="form-select @error('matiere_id') is-invalid @enderror"
                                    id="matiere_id" name="matiere_id" required>
                                <option value="">Sélectionner une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}"
                                            {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom_matiere }}
                                        @if($matiere->coefficient)
                                            (Coef: {{ $matiere->coefficient }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="classe_id" class="form-label">Classe <span class="text-danger">*</span></label>
                            <select class="form-select @error('classe_id') is-invalid @enderror"
                                    id="classe_id" name="classe_id" required>
                                <option value="">Sélectionner une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}"
                                            {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom_classe }}
                                        @if($classe->niveau)
                                            ({{ $classe->niveau->nom }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="annee_scolaire_id" class="form-label">Année Scolaire <span class="text-danger">*</span></label>
                            <select class="form-select @error('annee_scolaire_id') is-invalid @enderror"
                                    id="annee_scolaire_id" name="annee_scolaire_id" required>
                                <option value="">Sélectionner une année</option>
                                @foreach($annees as $annee)
                                    <option value="{{ $annee->id }}"
                                            {{ old('annee_scolaire_id', $anneeActive?->id) == $annee->id ? 'selected' : '' }}>
                                        {{ $annee->nom }}
                                        @if($annee->active)
                                            (Actuelle)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('annee_scolaire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="coefficient" class="form-label">Coefficient spécifique</label>
                            <input type="number" class="form-control @error('coefficient') is-invalid @enderror"
                                   id="coefficient" name="coefficient"
                                   value="{{ old('coefficient') }}"
                                   min="0.5" max="10" step="0.5" placeholder="Ex: 2">
                            <small class="form-text text-muted">Laissez vide pour utiliser le coefficient de la matière</small>
                            @error('coefficient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.affectations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Créer l'affectation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Filtrer les matières selon l'enseignant sélectionné
    $('#enseignant_id').on('change', function() {
        const enseignantId = $(this).val();
        if (enseignantId) {
            // Ici vous pouvez ajouter une logique pour filtrer les matières
            // selon la spécialité de l'enseignant
        }
    });

    // Auto-remplir le coefficient selon la matière
    $('#matiere_id').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const text = selectedOption.text();
        const coeffMatch = text.match(/Coef: ([\d.]+)/);
        if (coeffMatch && !$('#coefficient').val()) {
            $('#coefficient').val(coeffMatch[1]);
        }
    });
});
</script>
@endpush
