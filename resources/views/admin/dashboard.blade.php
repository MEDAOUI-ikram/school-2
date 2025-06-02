@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt"></i> Dashboard Administrateur
        </h1>
    </div>
</div>

<!-- Statistiques principales -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_etudiants'] }}</h4>
                        <p class="mb-0">Étudiants</p>
                    </div>
                    <div>
                        <i class="fas fa-user-graduate fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary border-0">
                <a href="{{ route('admin.etudiants.index') }}" class="text-white text-decoration-none">
                    Voir tous <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_enseignants'] }}</h4>
                        <p class="mb-0">Enseignants</p>
                    </div>
                    <div>
                        <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success border-0">
                <a href="{{ route('admin.enseignants.index') }}" class="text-white text-decoration-none">
                    Voir tous <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_classes'] }}</h4>
                        <p class="mb-0">Classes</p>
                    </div>
                    <div>
                        <i class="fas fa-door-open fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info border-0">
                <a href="{{ route('admin.classes.index') }}" class="text-white text-decoration-none">
                    Voir toutes <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_matieres'] }}</h4>
                        <p class="mb-0">Matières</p>
                    </div>
                    <div>
                        <i class="fas fa-book fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-warning border-0">
                <a href="{{ route('admin.matieres.index') }}" class="text-white text-decoration-none">
                    Voir toutes <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card bg-secondary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_niveaux'] }}</h4>
                        <p class="mb-0">Niveaux</p>
                    </div>
                    <div>
                        <i class="fas fa-layer-group fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-secondary border-0">
                <span class="text-white">
                    Niveaux actifs
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card bg-dark text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_annees'] }}</h4>
                        <p class="mb-0">Années</p>
                    </div>
                    <div>
                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-dark border-0">
                <a href="{{ route('admin.annees.index') }}" class="text-white text-decoration-none">
                    Gérer <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides et statistiques détaillées -->
<div class="row">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-plus text-success"></i> Actions Rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.enseignants.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Ajouter un Enseignant
                    </a>
                    <a href="{{ route('admin.etudiants.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Ajouter un Étudiant
                    </a>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.matieres.create') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-book"></i> Nouvelle Matière
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.classes.create') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-door-open"></i> Nouvelle Classe
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('admin.affectations.create') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-link"></i> Nouvelle Affectation
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar text-info"></i> Statistiques par Niveau</h5>
            </div>
            <div class="card-body">
                @if($statsParNiveau->count() > 0)
                    @foreach($statsParNiveau as $niveau)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $niveau->nom_niveau }}</strong>
                            </div>
                            <div>
                                <span class="badge bg-info me-1">{{ $niveau->classes_count }} classes</span>
                                <span class="badge bg-warning">{{ $niveau->matieres_count }} matières</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune statistique disponible</p>
                @endif

                <div class="mt-3">
                    <a href="{{ route('admin.rapports.general') }}" class="btn btn-outline-info w-100">
                        <i class="fas fa-chart-line"></i> Voir le rapport complet
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activité récente -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-door-open text-info"></i> Dernières Classes Créées</h5>
            </div>
            <div class="card-body">
                @if($dernieresClasses->count() > 0)
                    @foreach($dernieresClasses as $classe)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $classe->nom_classe }}</strong>
                                <small class="text-muted d-block">{{ $classe->niveau->nom_niveau ?? 'N/A' }}</small>
                            </div>
                            <small class="text-muted">{{ $classe->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune classe récente</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-book text-warning"></i> Dernières Matières Créées</h5>
            </div>
            <div class="card-body">
                @if($dernieresMatieres->count() > 0)
                    @foreach($dernieresMatieres as $matiere)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $matiere->nom_matiere }}</strong>
                                <small class="text-muted d-block">
                                    {{ $matiere->enseignant->nom ?? 'Pas d\'enseignant' }} -
                                    {{ $matiere->niveau->nom_niveau ?? 'N/A' }}
                                </small>
                            </div>
                            <small class="text-muted">{{ $matiere->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune matière récente</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .opacity-75 {
        opacity: 0.75;
    }
</style>
@endpush

