@extends('layouts.admin')

@section('title', 'Rapport Général')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-chart-line"></i> Rapport Général du Système</h1>
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
    <div class="col-md-2">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total_etudiants'] }}</h3>
                <p class="mb-0">Étudiants</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total_enseignants'] }}</h3>
                <p class="mb-0">Enseignants</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total_classes'] }}</h3>
                <p class="mb-0">Classes</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total_matieres'] }}</h3>
                <p class="mb-0">Matières</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total_niveaux'] }}</h3>
                <p class="mb-0">Niveaux</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-dark text-white text-center">
            <div class="card-body">
                <h3>{{ $stats['total_affectations'] }}</h3>
                <p class="mb-0">Affectations</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Répartition par niveau -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-layer-group"></i> Répartition par Niveau</h5>
            </div>
            <div class="card-body">
                @if($statsParNiveau->count() > 0)
                    @foreach($statsParNiveau as $niveau)
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>{{ $niveau->nom_niveau }}</strong>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end">
                                <span class="badge bg-info me-1">{{ $niveau->classes_count }} classes</span>
                                <span class="badge bg-warning">{{ $niveau->matieres_count }} matières</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress" style="height: 6px;">
                                @php
                                    $maxClasses = $statsParNiveau->max('classes_count');
                                    $width = $maxClasses > 0 ? ($niveau->classes_count / $maxClasses) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-info" style="width: {{ $width }}%"></div>
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

    <!-- Évolution par année -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt"></i> Classes par Année Scolaire</h5>
            </div>
            <div class="card-body">
                @if($statsParAnnee->count() > 0)
                    @foreach($statsParAnnee as $stat)
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>{{ $stat->annee }}-{{ $stat->annee + 1 }}</strong>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end">
                                <span class="badge bg-secondary">{{ $stat->total }} classes</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress" style="height: 6px;">
                                @php
                                    $maxTotal = $statsParAnnee->max('total');
                                    $width = $maxTotal > 0 ? ($stat->total / $maxTotal) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-secondary" style="width: {{ $width }}%"></div>
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
</div>

<!-- Évolution des inscriptions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-area"></i> Évolution des Inscriptions (30 derniers jours)</h5>
            </div>
            <div class="card-body">
                @if($evolutionEtudiants->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Nouvelles inscriptions</th>
                                    <th>Évolution</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($evolutionEtudiants->take(10) as $evolution)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($evolution->date)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $evolution->total }}</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            @php
                                                $maxInscriptions = $evolutionEtudiants->max('total');
                                                $width = $maxInscriptions > 0 ? ($evolution->total / $maxInscriptions) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-primary" style="width: {{ $width }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Aucune inscription récente</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Résumé -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-file-alt"></i> Résumé du Rapport</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Points clés :</h6>
                        <ul>
                            <li>Total de <strong>{{ $stats['total_etudiants'] }} étudiants</strong> répartis dans {{ $stats['total_classes'] }} classes</li>
                            <li><strong>{{ $stats['total_enseignants'] }} enseignants</strong> pour {{ $stats['total_matieres'] }} matières</li>
                            <li><strong>{{ $stats['total_affectations'] }} affectations</strong> enseignant-matière-classe</li>
                            <li>Système organisé en <strong>{{ $stats['total_niveaux'] }} niveaux</strong> différents</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Recommandations :</h6>
                        <ul>
                            @if($stats['total_enseignants'] > 0)
                                <li>Ratio moyen : {{ round($stats['total_etudiants'] / $stats['total_enseignants']) }} étudiants/enseignant</li>
                            @endif
                            @if($stats['total_classes'] > 0)
                                <li>Effectif moyen : {{ round($stats['total_etudiants'] / $stats['total_classes']) }} étudiants/classe</li>
                            @endif
                            <li>Rapport généré le {{ now()->format('d/m/Y à H:i') }}</li>
                        </ul>
                    </div>
                </div>
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
    }
}
</style>
@endpush
