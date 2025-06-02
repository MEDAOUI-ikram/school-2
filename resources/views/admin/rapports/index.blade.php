@extends('layouts.admin')

@section('title', 'Rapports')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-chart-bar"></i> Rapports Administratifs
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Rapport Général</h5>
            </div>
            <div class="card-body">
                <p>Vue d'ensemble complète du système éducatif avec toutes les statistiques principales.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Statistiques globales</li>
                    <li><i class="fas fa-check text-success"></i> Répartition par niveau</li>
                    <li><i class="fas fa-check text-success"></i> Évolution par année</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.rapports.general') }}" class="btn btn-primary w-100">
                    <i class="fas fa-eye"></i> Voir le rapport
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-chalkboard-teacher"></i> Rapport Enseignants</h5>
            </div>
            <div class="card-body">
                <p>Analyse détaillée du corps enseignant et de leurs affectations.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Liste complète des enseignants</li>
                    <li><i class="fas fa-check text-success"></i> Charge de travail par enseignant</li>
                    <li><i class="fas fa-check text-success"></i> Spécialités et affectations</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.rapports.enseignants') }}" class="btn btn-success w-100">
                    <i class="fas fa-eye"></i> Voir le rapport
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-door-open"></i> Rapport Classes</h5>
            </div>
            <div class="card-body">
                <p>Analyse des classes, effectifs et organisation pédagogique.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Effectifs par classe</li>
                    <li><i class="fas fa-check text-success"></i> Répartition par niveau</li>
                    <li><i class="fas fa-check text-success"></i> Enseignants par classe</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.rapports.classes') }}" class="btn btn-info w-100">
                    <i class="fas fa-eye"></i> Voir le rapport
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-book"></i> Rapport Matières</h5>
            </div>
            <div class="card-body">
                <p>Vue d'ensemble des matières enseignées et de leur organisation.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Matières par niveau</li>
                    <li><i class="fas fa-check text-success"></i> Coefficients et pondération</li>
                    <li><i class="fas fa-check text-success"></i> Affectations enseignants</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.rapports.matieres') }}" class="btn btn-warning w-100">
                    <i class="fas fa-eye"></i> Voir le rapport
                </a>
            </div>
        </div>
    </div>
</div>

&lt;!-- Actions rapides -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-tools"></i> Actions Rapides</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-grid">
                            <button class="btn btn-outline-primary" onclick="window.print()">
                                <i class="fas fa-print"></i><br>
                                <small>Imprimer cette page</small>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-tachometer-alt"></i><br>
                                <small>Retour Dashboard</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="{{ route('admin.affectations.index') }}" class="btn btn-outline-info">
                                <i class="fas fa-link"></i><br>
                                <small>Voir Affectations</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-grid">
                            <a href="{{ route('admin.annees.index') }}" class="btn btn-outline-warning">
                                <i class="fas fa-calendar-alt"></i><br>
                                <small>Années Scolaires</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
