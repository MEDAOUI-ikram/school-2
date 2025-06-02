@extends('layouts.admin')

@section('title', 'Rapport Enseignants')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-chalkboard-teacher"></i> Rapport des Enseignants</h1>
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

<!-- Statistiques spécialités -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-users"></i> Répartition par Spécialité</h5>
            </div>
            <div class="card-body">
                @if($specialites->count() > 0)
                    @foreach($specialites as $specialite)
                    <div class="row mb-3">
                        <div class="col-8">
                            <strong>{{ $specialite->specialite }}</strong>
                        </div>
                        <div class="col-4 text-end">
                            <span class="badge bg-success">{{ $specialite->total }}</span>
                        </div>
                        <div class="col-12">
                            <div class="progress" style="height: 6px;">
                                @php
                                    $maxSpec = $specialites->max('total');
                                    $width = $maxSpec > 0 ? ($specialite->total / $maxSpec) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-success" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune spécialité définie</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statistiques Générales</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Total enseignants :</strong></td>
                        <td><span class="badge bg-primary">{{ $enseignants->count() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Avec spécialité :</strong></td>
                        <td><span class="badge bg-success">{{ $enseignants->whereNotNull('specialite')->count() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Sans spécialité :</strong></td>
                        <td><span class="badge bg-warning">{{ $enseignants->whereNull('specialite')->count() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Moyenne matières/enseignant :</strong></td>
                        <td>
                            @if($enseignants->count() > 0)
                                {{ round($enseignants->sum('matieres_count') / $enseignants->count(), 1) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Moyenne classes/enseignant :</strong></td>
                        <td>
                            @if($enseignants->count() > 0)
                                {{ round($enseignants->sum('classes_count') / $enseignants->count(), 1) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Liste détaillée -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-list"></i> Liste Détaillée des Enseignants</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Spécialité</th>
                        <th>Matières</th>
                        <th>Classes</th>
                        <th>Charge</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enseignants as $enseignant)
                    <tr>
                        <td>
                            <strong>{{ $enseignant->nom }}</strong>
                            @if($enseignant->telephone)
                                <br><small class="text-muted">{{ $enseignant->telephone }}</small>
                            @endif
                        </td>
                        <td>{{ $enseignant->courriel }}</td>
                        <td>
                            @if($enseignant->specialite)
                                <span class="badge bg-info">{{ $enseignant->specialite }}</span>
                            @else
                                <span class="text-muted">Non définie</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-warning">{{ $enseignant->matieres_count }}</span>
                            @if($enseignant->matieres->count() > 0)
                                <br>
                                @foreach($enseignant->matieres->take(3) as $matiere)
                                    <small class="text-muted">{{ $matiere->nom_matiere }}</small>
                                    @if(!$loop->last && $loop->index < 2), @endif
                                @endforeach
                                @if($enseignant->matieres->count() > 3)
                                    <small class="text-muted">...</small>
                                @endif
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $enseignant->classes_count }}</span>
                        </td>
                        <td>
                            @php
                                $charge = $enseignant->matieres_count + $enseignant->classes_count;
                                $badgeColor = $charge > 10 ? 'danger' : ($charge > 5 ? 'warning' : 'success');
                            @endphp
                            <span class="badge bg-{{ $badgeColor }}">
                                {{ $charge }} points
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Analyse de charge -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-balance-scale"></i> Analyse de la Charge de Travail</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="text-success">Charge Légère (≤ 5 points)</h6>
                        @php $leger = $enseignants->filter(function($e) { return ($e->matieres_count + $e->classes_count) <= 5; }); @endphp
                        <p><strong>{{ $leger->count() }}</strong> enseignants</p>
                        @foreach($leger->take(3) as $enseignant)
                            <small class="d-block">{{ $enseignant->nom }}</small>
                        @endforeach
                        @if($leger->count() > 3)
                            <small class="text-muted">et {{ $leger->count() - 3 }} autres...</small>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-warning">Charge Modérée (6-10 points)</h6>
                        @php $moderee = $enseignants->filter(function($e) { $charge = $e->matieres_count + $e->classes_count; return $charge > 5 && $charge <= 10; }); @endphp
                        <p><strong>{{ $moderee->count() }}</strong> enseignants</p>
                        @foreach($moderee->take(3) as $enseignant)
                            <small class="d-block">{{ $enseignant->nom }}</small>
                        @endforeach
                        @if($moderee->count() > 3)
                            <small class="text-muted">et {{ $moderee->count() - 3 }} autres...</small>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-danger">Charge Élevée (> 10 points)</h6>
                        @php $elevee = $enseignants->filter(function($e) { return ($e->matieres_count + $e->classes_count) > 10; }); @endphp
                        <p><strong>{{ $elevee->count() }}</strong> enseignants</p>
                        @foreach($elevee->take(3) as $enseignant)
                            <small class="d-block">{{ $enseignant->nom }}</small>
                        @endforeach
                        @if($elevee->count() > 3)
                            <small class="text-muted">et {{ $elevee->count() - 3 }} autres...</small>
                        @endif
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
        margin-bottom: 1rem;
    }
}
</style>
@endpush
