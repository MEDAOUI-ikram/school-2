@extends('layouts.admin')

@section('title', 'Modifier l\'Année Scolaire')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-calendar-edit"></i> Modifier l'Année Scolaire : {{ $annee->nom }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.annees.update', $annee) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nom" class="form-label">Nom de l'année <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom', $annee->nom) }}"
                                   placeholder="Ex: 2023-2024" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_debut" class="form-label">Date de début <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror"
                                   id="date_debut" name="date_debut"
                                   value="{{ old('date_debut', $annee->date_debut->format('Y-m-d')) }}" required>
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_fin" class="form-label">Date de fin <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror"
                                   id="date_fin" name="date_fin"
                                   value="{{ old('date_fin', $annee->date_fin->format('Y-m-d')) }}" required>
                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Description optionnelle de l'année scolaire">{{ old('description', $annee->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                       {{ old('active', $annee->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Année active (année scolaire en cours)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.annees.index') }}" class="btn btn-secondary">
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
