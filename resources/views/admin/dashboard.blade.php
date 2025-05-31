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

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_etudiants'] ?? 0 }}</h4>
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

    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_enseignants'] ?? 0 }}</h4>
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

    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_classes'] ?? 0 }}</h4>
                        <p class="mb-0">Classes</p>
                    </div>
                    <div>
                        <i class="fas fa-door-open fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info border-0">
                <span class="text-white">
                    Classes actives
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_matieres'] ?? 0 }}</h4>
                        <p class="mb-0">Matières</p>
                    </div>
                    <div>
                        <i class="fas fa-book fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-warning border-0">
                <span class="text-white">
                    Matières disponibles
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides et Import/Export -->
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
                            <a href="{{ route('admin.enseignants.index') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-list"></i> Liste Enseignants
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.etudiants.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list"></i> Liste Étudiants
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-file-import text-info"></i> Import/Export</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <button class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-upload"></i> Importer des Utilisateurs
                    </button>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.export.users', ['type' => 'enseignants']) }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-download"></i> Export Enseignants
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.export.users', ['type' => 'etudiants']) }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-download"></i> Export Étudiants
                            </a>
                        </div>
                    </div>
                    <button class="btn btn-outline-info" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer ce Dashboard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activité récente -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-clock text-warning"></i> Activité Récente</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle p-2 me-3">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <div>
                            <strong>Nouvel enseignant ajouté</strong>
                            <br>
                            <small class="text-muted">Il y a 2 heures</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle p-2 me-3">
                            <i class="fas fa-user-graduate text-white"></i>
                        </div>
                        <div>
                            <strong>5 nouveaux étudiants inscrits</strong>
                            <br>
                            <small class="text-muted">Il y a 4 heures</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle p-2 me-3">
                            <i class="fas fa-file-import text-white"></i>
                        </div>
                        <div>
                            <strong>Import de données effectué</strong>
                            <br>
                            <small class="text-muted">Hier à 14:30</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.import.users') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="fas fa-upload"></i> Importer des Utilisateurs
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type d'utilisateur <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="">Sélectionner le type...</option>
                            <option value="enseignant">Enseignant</option>
                            <option value="etudiant">Étudiant</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fichier" class="form-label">Fichier Excel/CSV <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="fichier" id="fichier" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">
                            Formats acceptés : .xlsx, .xls, .csv (Max: 2MB)
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Format requis :</strong> Le fichier doit contenir les colonnes : nom, courriel, mot_de_passe
                        @if(true) {{-- Condition pour étudiants --}}
                            , niveau (pour les étudiants)
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Importer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
    .opacity-75 {
        opacity: 0.75;
    }
</style>
@endpush





