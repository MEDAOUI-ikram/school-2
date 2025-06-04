@extends('layouts.admin')

@section('title', 'Créer une Classe')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-door-open"></i> Créer une Nouvelle Classe</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.classes.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom_classe" class="form-label">Nom de la classe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom_classe') is-invalid @enderror"
                                   id="nom_classe" name="nom_classe" value="{{ old('nom_classe') }}"
                                   placeholder="Ex: 6ème A" required>
                            @error('nom_classe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="niveau_id" class="form-label">Niveau <span class="text-danger">*</span></label>
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

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="annee" class="form-label">Année scolaire <span class="text-danger">*</span></label>
                            <select class="form-select @error('annee') is-invalid @enderror"
                                    id="annee" name="annee" required>
                                <option value="">Sélectionner une année</option>
                                @foreach($anneesDisponibles as $anneeOption)
                                    <option value="{{ $anneeOption }}"
                                            {{ old('annee', date('Y')) == $anneeOption ? 'selected' : '' }}>
                                        {{ $anneeOption }}-{{ $anneeOption + 1 }}
                                    </option>
                                @endforeach
                            </select>
                            @error('annee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacite_max" class="form-label">Capacité maximale</label>
                            <input type="number" class="form-control @error('capacite_max') is-invalid @enderror"
                                   id="capacite_max" name="capacite_max"
                                   value="{{ old('capacite_max', 30) }}"
                                   min="1" max="50" placeholder="Ex: 30">
                            @error('capacite_max')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Description optionnelle de la classe">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Créer la classe
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
    // Auto-générer le nom de classe basé sur le niveau
    $('#niveau_id').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const niveauText = selectedOption.text();
        if (niveauText && !$('#nom_classe').val()) {
            $('#nom_classe').val(niveauText + ' A');
        }
    });
});
</script>
@endpush
