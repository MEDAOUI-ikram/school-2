@extends('layouts.admin')

@section('title', 'Détails de l\'Enseignant')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-user"></i> {{ $enseignant->nom }}
                <span class="badge bg-success">Enseignant</span>
            </h1>
            <div class="btn-group">
                <a href="{{ route('admin.enseignants.edit', $enseignant) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <button type="button" class="btn btn-outline-danger"
                        onclick="confirmDelete({{ $enseignant->id }}, '{{ $enseignant->nom }}')">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
                <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informations personnelles -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-user"></i> Informations Personnelles</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-user fa-2x text-white"></i>
                    </div>
                </div>

                <table class="table table-borderless table-sm">
                    <tr>
                        <td><strong>Nom :</strong></td>
                        <td>{{ $enseignant->nom }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email :</strong></td>
                        <td>
                            <a href="mailto:{{ $enseignant->courriel }}" class="text-decoration-none">
                                {{ $enseignant->courriel }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>ID :</strong></td>
                        <td>#{{ $enseignant->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Créé le :</strong></td>
                        <td>{{ $enseignant->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Modifié le :</strong></td>
                        <td>{{ $enseignant->updated_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                </table>

                <div class="d-grid gap-2 mt-3">
                    <a href="mailto:{{ $enseignant->courriel }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-envelope"></i> Envoyer un email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Matières enseignées -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-book"></i> Matières Enseignées</h6>
                <span class="badge bg-info">{{ $enseignant->matieres->count() }}</span>
            </div>
            <div class="card-body">
                @if($enseignant->matieres->count() > 0)
                    <div class="row">
                        @foreach($enseignant->matieres as $matiere)
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                    <div>
                                        <span class="badge bg-primary">{{ $matiere->nom }}</span>
                                        @if($matiere->code)
                                            <small class="text-muted">({{ $matiere->code }})</small>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        {{ $matiere->heures_semaine ?? 0 }}h/sem
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-plus"></i> Assigner une matière
                        </button>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-book-open fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-3">Aucune matière assignée</p>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus"></i> Assigner une matière
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Classes assignées -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-door-open"></i> Classes Assignées</h6>
                <span class="badge bg-secondary">{{ $enseignant->classes->count() }}</span>
            </div>
            <div class="card-body">
                @if($enseignant->classes->count() > 0)
                    <div class="row">
                        @foreach($enseignant->classes as $classe)
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                    <div>
                                        <span class="badge bg-secondary">{{ $classe->nom }}</span>
                                        @if($classe->niveau)
                                            <small class="text-muted">({{ $classe->niveau->nom_niveau }})</small>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        {{ $classe->etudiants_count ?? 0 }} étudiants
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-plus"></i> Assigner une classe
                        </button>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-door-closed fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-3">Aucune classe assignée</p>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-plus"></i> Assigner une classe
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistiques et emploi du temps -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Statistiques</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-3">
                        <div class="border-end">
                            <h4 class="text-primary mb-0">{{ $enseignant->matieres->count() }}</h4>
                            <small class="text-muted">Matières</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border-end">
                            <h4 class="text-success mb-0">{{ $enseignant->classes->count() }}</h4>
                            <small class="text-muted">Classes</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border-end">
                            <h4 class="text-info mb-0">{{ $enseignant->classes->sum('etudiants_count') ?? 0 }}</h4>
                            <small class="text-muted">Étudiants</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <h4 class="text-warning mb-0">{{ $enseignant->matieres->sum('heures_semaine') ?? 0 }}</h4>
                        <small class="text-muted">Heures/sem</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Charge de travail</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Heures d'enseignement</span>
                        <span class="fw-bold">{{ $enseignant->matieres->sum('heures_semaine') ?? 0 }}h/semaine</span>
                    </div>
                    <div class="progress mt-1">
                        <div class="progress-bar bg-success" style="width: {{ min(100, (($enseignant->matieres->sum('heures_semaine') ?? 0) / 35) * 100) }}%"></div>
                    </div>
                    <small class="text-muted">Maximum recommandé: 35h/semaine</small>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Classes gérées</span>
                        <span class="fw-bold">{{ $enseignant->classes->count() }} classes</span>
                    </div>
                    <div class="progress mt-1">
                        <div class="progress-bar bg-info" style="width: {{ min(100, ($enseignant->classes->count() / 8) * 100) }}%"></div>
                    </div>
                    <small class="text-muted">Maximum recommandé: 8 classes</small>
                </div>

                <div class="alert alert-{{ ($enseignant->matieres->sum('heures_semaine') ?? 0) > 35 ? 'warning' : 'success' }} py-2">
                    <i class="fas fa-{{ ($enseignant->matieres->sum('heures_semaine') ?? 0) > 35 ? 'exclamation-triangle' : 'check-circle' }}"></i>
                    {{ ($enseignant->matieres->sum('heures_semaine') ?? 0) > 35 ? 'Charge de travail élevée' : 'Charge de travail normale' }}
                </div>
            </div>
        </div>
    </div>
</div>

@if($enseignant->emploiDuTemps && $enseignant->emploiDuTemps->count() > 0)
<!-- Emploi du temps -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-calendar"></i> Emploi du Temps</h6>
                <button class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit"></i> Modifier
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Jour</th>
                                <th>Heure</th>
                                <th>Matière</th>
                                <th>Classe</th>
                                <th>Salle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enseignant->emploiDuTemps->sortBy(['jour', 'heure_debut']) as $cours)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $cours->jour }}</span>
                                    </td>
                                    <td>{{ $cours->heure_debut }} - {{ $cours->heure_fin }}</td>
                                    <td>{{ $cours->matiere->nom ?? 'N/A' }}</td>
                                    <td>{{ $cours->classe->nom ?? 'N/A' }}</td>
                                    <td>{{ $cours->salle ?? 'Non définie' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Actions rapides -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-bolt"></i> Actions Rapides</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-grid">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-book"></i><br>
                                <small>Assigner Matière</small>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-door-open"></i><br>
                                <small>Assigner Classe</small>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <button class="btn btn-outline-info">
                                <i class="fas fa-calendar"></i><br>
                                <small>Emploi du Temps</small>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="mailto:{{ $enseignant->courriel }}" class="btn btn-outline-success">
                                <i class="fas fa-envelope"></i><br>
                                <small>Contacter</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="delete-form-{{ $enseignant->id }}"
      action="{{ route('admin.enseignants.destroy', $enseignant) }}"
      method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
// Fonction de confirmation de suppression
function confirmDelete(id, nom) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'enseignant "${nom}" ?\n\nCette action supprimera également :\n- Toutes ses assignations de matières\n- Toutes ses assignations de classes\n- Son emploi du temps\n\nCette action est irréversible.`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

