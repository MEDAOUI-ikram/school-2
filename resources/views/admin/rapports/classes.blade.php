@extends('layouts.admin')

@section('title', 'Rapport Classes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-door-open"></i> Rapport des Classes</h1>
            <div>
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimer
                </button>
                <a href="{{ route('admin.rapports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques générales -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-pie"></i> Effectifs par Niveau</h5>
            </div>
            <div class="card-body">
                @if($effectifsParNiveau->count() > 0)
                    @foreach($effectifsParNiveau as $effectif)
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>{{ $effectif->nom_niveau }}</strong>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end">
                                <span class="badge bg-primary">{{ $effectif->total_etudiants }} étudiants</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress" style="height: 8px;">
                                @php
                                    $maxEffectif = $effectifsParNiveau->max('total_etudiants');
                                    $width = $maxEffectif > 0 ? ($effectif->total_etudiants / $maxEffectif) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-primary" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune donnée disponible</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-calculator"></i> Statistiques</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Total classes :</strong></td>
                        <td><span class="badge bg-info">{{ $classes->count() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Total étudiants :</strong></td>
                        <td><span class="badge bg-primary">{{ $classes->sum('etudiants_count') }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Moyenne/classe :</strong></td>
                        <td>
                            @if($classes->count() > 0)
                                {{ round($classes->sum('etudiants_count') / $classes->count(), 1) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Classe la plus peuplée :</strong></td>
                        <td>{{ $classes->max('etudiants_count') ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td><strong>Classe la moins peuplée :</strong></td>
                        <td>{{ $classes->min('etudiants_count') ?? 0 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Liste détaillée des classes -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-list"></i> Liste Détaillée des Classes</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Classe</th>
                        <th>Niveau</th>
                        <th>Année</th>
                        <th>Étudiants</th>
                        <th>Enseignants</th>
                        <th>Matières</th>
                        <th>Taux</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $classe)
                    <tr>
                        <td>
                            <strong>{{ $classe->nom_classe }}</strong>
                            @if($classe->description)
                                <br><small class="text-muted">{{ Str::limit($classe->description, 30) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($classe->niveau)
                                <span class="badge bg-info">{{ $classe->niveau->nom_niveau }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $classe->annee }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $classe->etudiants_count }}</span>
                            @if($classe->capacite_max)
                                <br><small class="text-muted">/ {{ $classe->capacite_max }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $classe->enseignants_count }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning">{{ $classe->matieres_count }}</span>
                        </td>
                        <td>
                            @if($classe->capacite_max)
                                @php
                                    $taux = ($classe->etudiants_count / $classe->capacite_max) * 100;
                                    $badgeColor = $taux > 90 ? 'danger' : ($taux > 75 ? 'warning' : 'success');
                                @endphp
                                <span class="badge bg-{{ $badgeColor }}">{{ round($taux) }}%</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Analyse des classes -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6><i class="fas fa-thumbs-up"></i> Classes Optimales</h6>
            </div>
            <div class="card-body">
                @php
                    $optimales = $classes->filter(function($classe) {
                        if (!$classe->capacite_max) return false;
                        $taux = ($classe->etudiants_count / $classe->capacite_max) * 100;
                        return $taux >= 70 && $taux <= 90;
                    });
                @endphp
                <h4 class="text-success">{{ $optimales->count() }}</h4>
                <p class="mb-0">Taux de remplissage entre 70% et 90%</p>
                @foreach($optimales->take(3) as $classe)
                    <small class="d-block">{{ $classe->nom_classe }}</small>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h6><i class="fas fa-exclamation-triangle"></i> Classes Sous-peuplées</h6>
            </div>
            <div class="card-body">
                @php
                    $souspeuplees = $classes->filter(function($classe) {
                        if (!$classe->capacite_max) return false;
                        $taux = ($classe->etudiants_count / $classe->capacite_max) * 100;
                        return $taux < 70;
                    });
                @endphp
                <h4 class="text-warning">{{ $souspeuplees->count() }}</h4>
                <p class="mb-0">Taux de remplissage < 70%</p>
                @foreach($souspeuplees->take(3) as $classe)
                    <small class="d-block">{{ $classe->nom_classe }}</small>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h6><i class="fas fa-users"></i> Classes Surpeuplées</h6>
            </div>
            <div class="card-body">
                @php
                    $surpeuplees = $classes->filter(function($classe) {
                        if (!$classe->capacite_max) return false;
                        $taux = ($classe->etudiants_count / $classe->capacite_max) * 100;
                        return $taux > 90;
                    });
                @endphp
                <h4 class="text-danger">{{ $surpeuplees->count() }}</h4>
                <p class="mb-0">Taux de remplissage > 90%</p>
                @foreach($surpeuplees->take(3) as $classe)
                    <small class="d-block">{{ $classe->nom_classe }}</small>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .btn, .card-footer, .navbar, .sidebar {
        display: none !important;
    }
    .card {
        border: 1px solid #000 !important;
        page-break-inside: avoid;
        margin-bottom: 1rem;
    }
}
</style>
@endpush
