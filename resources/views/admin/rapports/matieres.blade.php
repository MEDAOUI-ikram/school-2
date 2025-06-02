@extends('layouts.admin')

@section('title', 'Rapport Matières')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-book"></i> Rapport des Matières</h1>
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

<!-- Matières par niveau -->
<div class="row mb-4">
    @foreach($matieresParNiveau as $niveau)
    <div class="col-md-6 col-lg-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-layer-group"></i> {{ $niveau->nom_niveau }}</h6>
            </div>
            <div class="card-body">
                <h4 class="text-primary">{{ $niveau->matieres_count }}</h4>
                <p class="mb-2">matières disponibles</p>
                @if($niveau->matieres->count() > 0)
                    @foreach($niveau->matieres->take(3) as $matiere)
                        <small class="d-block">
                            {{ $matiere->nom_matiere }}
                            <span class="badge badge-sm bg-secondary">{{ $matiere->coefficient }}</span>
                        </small>
                    @endforeach
                    @if($niveau->matieres->count() > 3)
                        <small class="text-muted">et {{ $niveau->matieres->count() - 3 }} autres...</small>
                    @endif
                @else
                    <small class="text-muted">Aucune matière</small>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Liste détaillée -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-list"></i> Liste Détaillée des Matières</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Niveau</th>
                        <th>Enseignant</th>
                        <th>Coefficient</th>
                        <th>Heures</th>
                        <th>Classes</th>
                        <th>Étudiants</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matieres as $matiere)
                    <tr>
                        <td>
                            <strong>{{ $matiere->nom_matiere }}</strong>
                            @if($matiere->description)
                                <br><small class="text-muted">{{ Str::limit($matiere->description, 30) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($matiere->niveau)
                                <span class="badge bg-info">{{ $matiere->niveau->nom_niveau }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($matiere->enseignant)
                                {{ $matiere->enseignant->nom }}
                                @if($matiere->enseignant->specialite)
                                    <br><small class="text-muted">{{ $matiere->enseignant->specialite }}</small>
                                @endif
                            @else
                                <span class="text-muted">Non assigné</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $matiere->coefficient }}</span>
                        </td>
                        <td>
                            @if($matiere->heures_par_semaine)
                                <span class="badge bg-success">{{ $matiere->heures_par_semaine }}h</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $matiere->classes_count }}</span>
                        </td>
                        <td>
                            @php
                                $totalEtudiants = $matiere->classes->sum(function($classe) {
                                    return $classe->etudiants->count();
                                });
                            @endphp
                            <span class="badge bg-warning">{{ $totalEtudiants }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Analyse des coefficients -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-weight"></i> Répartition des Coefficients</h5>
            </div>
            <div class="card-body">
                @php
                    $coefficients = $matieres->groupBy('coefficient')->sortKeys();
                @endphp
                @foreach($coefficients as $coef => $matieresGroupe)
                <div class="row mb-2">
                    <div class="col-6">
                        <strong>Coefficient {{ $coef }}</strong>
                    </div>
                    <div class="col-6">
                        <span class="badge bg-secondary">{{ $matieresGroupe->count() }} matières</span>
                    </div>
                    <div class="col-12">
                        <div class="progress" style="height: 6px;">
                            @php
                                $maxGroup = $coefficients->map->count()->max();
                                $width = $maxGroup > 0 ? ($matieresGroupe->count() / $maxGroup) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-secondary" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-check"></i> Statut des Enseignants</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Matières assignées :</strong></td>
                        <td><span class="badge bg-success">{{ $matieres->whereNotNull('enseignant_id')->count() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Sans enseignant :</strong></td>
                        <td><span class="badge bg-warning">{{ $matieres->whereNull('enseignant_id')->count() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Moyenne coefficient :</strong></td>
                        <td>{{ round($matieres->avg('coefficient'), 1) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Heures totales/semaine :</strong></td>
                        <td>{{ $matieres->sum('heures_par_semaine') }}h</td>
                    </tr>
                </table>

                <h6 class="mt-3">Matières sans enseignant :</h6>
                @php $sansEnseignant = $matieres->whereNull('enseignant_id'); @endphp
                @if($sansEnseignant->count() > 0)
                    @foreach($sansEnseignant->take(5) as $matiere)
                        <small class="d-block text-warning">
                            {{ $matiere->nom_matiere }} ({{ $matiere->niveau->nom_niveau ?? 'N/A' }})
                        </small>
                    @endforeach
                    @if($sansEnseignant->count() > 5)
                        <small class="text-muted">et {{ $sansEnseignant->count() - 5 }} autres...</small>
                    @endif
                @else
                    <small class="text-success">Toutes les matières ont un enseignant assigné</small>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Résumé final -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-clipboard-list"></i> Résumé du Rapport Matières</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Synthèse :</h6>
                        <ul>
                            <li><strong>{{ $matieres->count() }} matières</strong> au total dans le système</li>
                            <li><strong>{{ $matieres->whereNotNull('enseignant_id')->count() }} matières assignées</strong> à un enseignant</li>
                            <li><strong>{{ $matieres->whereNull('enseignant_id')->count() }} matières</strong> sans enseignant</li>
                            <li>Coefficient moyen : <strong>{{ round($matieres->avg('coefficient'), 1) }}</strong></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Recommandations :</h6>
                        <ul>
                            @if($matieres->whereNull('enseignant_id')->count() > 0)
                                <li class="text-warning">Assigner des enseignants aux {{ $matieres->whereNull('enseignant_id')->count() }} matières non assignées</li>
                            @endif
                            @if($matieres->where('coefficient', '>', 5)->count() > 0)
                                <li class="text-info">{{ $matieres->where('coefficient', '>', 5)->count() }} matières ont un coefficient élevé (>5)</li>
                            @endif
                            <li>Volume horaire total : {{ $matieres->sum('heures_par_semaine') ?? 0 }}h/semaine</li>
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
        margin-bottom: 1rem;
    }
    .badge-sm {
        font-size: 0.65em;
    }
}
</style>
@endpush
