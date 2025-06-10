 @extends('layouts.etudiant')

@section('title', 'Dashboard Étudiant')

@section('content')
<div class="row">
    <!-- Statistiques -->
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Mes Classes</h5>
                        <h2>{{ $mesClasses->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Mes Matières</h5>
                        <h2>{{ $mesMatieres->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Cours Aujourd'hui</h5>
                        <h2>{{ $coursAujourdhui ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>Heures/Semaine</h5>
                        <h2>{{ $totalHeuresSemaine ?? 0 }}h</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mes Classes -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-users"></i> Mes Classes</h5>
            </div>
            <div class="card-body">
                @if($mesClasses && $mesClasses->count() > 0)
                    @foreach($mesClasses as $classe)
                        <div class="mb-3 p-3 border rounded">
                            <h6>{{ $classe->nom }}</h6>
                            <p class="text-muted">
                                Niveau: {{ $classe->niveau->nom ?? 'Non défini' }}<br>
                                Étudiants: {{ $classe->etudiants->count() ?? 0 }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune classe assignée</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Mes Matières -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-book"></i> Mes Matières</h5>
            </div>
            <div class="card-body">
                @if($mesMatieres && $mesMatieres->count() > 0)
                    @foreach($mesMatieres as $matiere)
                        <div class="mb-2 p-2 border-bottom">
                            <strong>{{ $matiere->nom ?? $matiere->nomMatiere }}</strong>
                            @if(isset($matiere->coefficient))
                                <span class="badge bg-secondary">Coef: {{ $matiere->coefficient }}</span>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune matière disponible</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Emploi du temps -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-calendar"></i> Mon Emploi du Temps</h5>
            </div>
            <div class="card-body">
                @if($monEmploiDuTemps && $monEmploiDuTemps->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jour</th>
                                    <th>Heure</th>
                                    <th>Matière</th>
                                    <th>Enseignant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monEmploiDuTemps as $cours)
                                    <tr>
                                        <td>{{ $cours->jour ?? 'N/A' }}</td>
                                        <td>{{ $cours->heure_debut ?? 'N/A' }} - {{ $cours->heure_fin ?? 'N/A' }}</td>
                                        <td>{{ $cours->matiere->nom ?? 'N/A' }}</td>
                                        <td>{{ $cours->enseignant->nom ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Aucun cours programmé</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection