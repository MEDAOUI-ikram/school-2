@extends('layouts.admin')

@section('title', 'Détails de la Matière')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-book"></i> {{ $matiere->nom_matiere }}</h4>
                <div>
                    <span class="badge bg-warning">Coef: {{ $matiere->coefficient }}</span>
                    @if($matiere->niveau)
                        <span class="badge bg-info">{{ $matiere->niveau->nom_niveau }}</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations générales</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nom :</strong></td>
                                <td>{{ $matiere->nom_matiere }}</td>
                            </tr>
                            <tr>
                                <td><strong>Coefficient :</strong></td>
                                <td><span class="badge bg-secondary">{{ $matiere->coefficient }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Niveau :</strong></td>
                                <td>
                                    @if($matiere->niveau)
                                        <span class="badge bg-info">{{ $matiere->niveau->nom_niveau }}</span>
                                    @else
                                        <span class="text-muted">Non défini</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Enseignant :</strong></td>
                                <td>
                                    @if($matiere->enseignant)
                                        <a href="{{ route('admin.enseignants.show', $matiere->enseignant) }}">
                                            {{ $matiere->enseignant->nom }}
                                        </a>
                                    @else
                                        <span class="text-muted">Non assigné</span>
                                    @endif
                                </td>
                            </tr>
                            @if($matiere->heures_par_semaine)
                            <tr>
                                <td><strong>Heures/semaine :</strong></td>
                                <td><span class="badge bg-success">{{ $matiere->heures_par_semaine }}h</span></td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Créée le :</strong></td>
                                <td>{{ $matiere->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Classes :</strong></td>
                                <td><span class="badge bg-primary">{{ $matiere->classes->count() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Étudiants :</strong></td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $matiere->classes->sum(function($classe) { return $classe->etudiants->count(); }) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Affectations :</strong></td>
                                <td><span class="badge bg-warning">{{ $affectations->count() }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($matiere->description)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Description</h6>
                        <p class="text-muted">{{ $matiere->description }}</p>
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <div>
                        <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.matieres.destroy', $matiere) }}"
                              style="display: inline;"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Affectations -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="fas fa-link"></i> Affectations ({{ $affectations->count() }})</h6>
            </div>
            <div class="card-body">
                @if($affectations->count() > 0)
                    @foreach($affectations->take(5) as $affectation)
                    <div class="mb-3 p-2 border-start border-warning border-3">
                        <strong>{{ $affectation->enseignant->nom }}</strong>
                        <br><small class="text-muted">Classe: {{ $affectation->classe->nom_classe }}</small>
                        @if($affectation->heures_par_semaine)
                            <br><small class="text-info">{{ $affectation->heures_par_semaine }}h/semaine</small>
                        @endif
                    </div>
                    @endforeach
                    @if($affectations->count() > 5)
                    <small class="text-muted">Et {{ $affectations->count() - 5 }} autres...</small>
                    @endif
                @else
                    <p class="text-muted mb-0">Aucune affectation.</p>
                @endif
            </div>
        </div>

        <!-- Classes -->
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-door-open"></i> Classes ({{ $matiere->classes->count() }})</h6>
            </div>
            <div class="card-body">
                @if($matiere->classes->count() > 0)
                    @foreach($matiere->classes->take(5) as $classe)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>{{ $classe->nom_classe }}</strong>
                            <br><small class="text-muted">{{ $classe->niveau->nom_niveau ?? 'N/A' }}</small>
                        </div>
                        <span class="badge bg-info">{{ $classe->etudiants->count() }} élèves</span>
                    </div>
                    @endforeach
                    @if($matiere->classes->count() > 5)
                    <small class="text-muted">Et {{ $matiere->classes->count() - 5 }} autres...</small>
                    @endif
                @else
                    <p class="text-muted mb-0">Aucune classe assignée.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
