@extends('layouts.admin')

@section('title', 'Gestion des Affectations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-link"></i> Affectations Enseignants-Matières-Classes</h1>
            <a href="{{ route('admin.affectations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Affectation
            </a>
        </div>

        <!-- Filtres -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Enseignant</label>
                        <select class="form-select" name="enseignant_id">
                            <option value="">Tous les enseignants</option>
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}"
                                        {{ request('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                    {{ $enseignant->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Matière</label>
                        <select class="form-select" name="matiere_id">
                            <option value="">Toutes les matières</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}"
                                        {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom_matiere }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Classe</label>
                        <select class="form-select" name="classe_id">
                            <option value="">Toutes les classes</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                        {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Filtrer
                            </button>
                            <a href="{{ route('admin.affectations.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des affectations -->
        <div class="card">
            <div class="card-body">
                @if($affectations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Enseignant</th>
                                    <th>Matière</th>
                                    <th>Classe</th>
                                    <th>Coefficient</th>
                                    <th>Heures/Semaine</th>
                                    <th>Année</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($affectations as $affectation)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                {{ substr($affectation->enseignant->nom, 0, 1) }}
                                            </div>
                                            <div>
                                                <strong>{{ $affectation->enseignant->nom }}</strong>
                                                @if($affectation->enseignant->specialite)
                                                    <br><small class="text-muted">{{ $affectation->enseignant->specialite }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $affectation->matiere->nom_matiere }}</span>
                                        @if($affectation->matiere->coefficient)
                                            <br><small class="text-muted">Coef: {{ $affectation->matiere->coefficient }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $affectation->classe->nom_classe }}</strong>
                                        <br><small class="text-muted">{{ $affectation->classe->niveau->nom ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @if($affectation->coefficient)
                                            <span class="badge bg-warning">{{ $affectation->coefficient }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($affectation->heures_par_semaine)
                                            <span class="badge bg-success">{{ $affectation->heures_par_semaine }}h</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($affectation->anneeScolaire)
                                            {{ $affectation->anneeScolaire->nom }}
                                        @else
                                            <span class="text-muted">Non définie</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.affectations.edit', $affectation) }}"
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.affectations.destroy', $affectation) }}"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $affectations->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-link fa-3x text-muted mb-3"></i>
                        <h5>Aucune affectation trouvée</h5>
                        <p class="text-muted">Commencez par créer des affectations enseignant-matière-classe.</p>
                        <a href="{{ route('admin.affectations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Créer une affectation
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}
</style>
@endpush
