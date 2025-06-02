@extends('layouts.admin')

@section('title', 'Détails de la Classe')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-door-open"></i> {{ $classe->nom_classe }}</h4>
                <div>
                    @if($classe->niveau)
                        <span class="badge bg-info">{{ $classe->niveau->nom_niveau }}</span>
                    @endif
                    <span class="badge bg-secondary">{{ $classe->annee }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations générales</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nom :</strong></td>
                                <td>{{ $classe->nom_classe }}</td>
                            </tr>
                            <tr>
                                <td><strong>Niveau :</strong></td>
                                <td>
                                    @if($classe->niveau)
                                        <span class="badge bg-info">{{ $classe->niveau->nom_niveau }}</span>
                                    @else
                                        <span class="text-muted">Non défini</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Année scolaire :</strong></td>
                                <td><span class="badge bg-secondary">{{ $classe->annee }}-{{ $classe->annee + 1 }}</span></td>
                            </tr>
                            @if($classe->capacite_max)
                            <tr>
                                <td><strong>Capacité max :</strong></td>
                                <td><span class="badge bg-warning">{{ $classe->capacite_max }} places</span></td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Créée le :</strong></td>
                                <td>{{ $classe->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Étudiants inscrits :</strong></td>
                                <td><span class="badge bg-primary">{{ $classe->etudiants->count() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Enseignants :</strong></td>
                                <td><span class="badge bg-success">{{ $classe->enseignants->count() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Matières :</strong></td>
                                <td><span class="badge bg-warning">{{ $classe->matieres->count() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Affectations :</strong></td>
                                <td><span class="badge bg-info">{{ $affectations->count() }}</span></td>
                            </tr>
                            @if($classe->capacite_max)
                            <tr>
                                <td><strong>Taux de remplissage :</strong></td>
                                <td>
                                    @php
                                        $taux = ($classe->etudiants->count() / $classe->capacite_max) * 100;
                                        $badgeColor = $taux > 90 ? 'danger' : ($taux > 75 ? 'warning' : 'success');
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}">{{ round($taux) }}%</span>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($classe->description)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Description</h6>
                        <p class="text-muted">{{ $classe->description }}</p>
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <div>
                        <a href="{{ route('admin.classes.edit', $classe) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.classes.destroy', $classe) }}"
                              style="display: inline;"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">
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
        <!-- Étudiants -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="fas fa-user-graduate"></i> Étudiants ({{ $classe->etudiants->count() }})</h6>
            </div>
            <div class="card-body">
                @if($classe->etudiants->count() > 0)
                    @foreach($classe->etudiants->take(10) as $etudiant)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <a href="{{ route('admin.etudiants.show', $etudiant) }}" class="text-decoration-none">
                                {{ $etudiant->nom }}
                            </a>
                            <br><small class="text-muted">{{ $etudiant->courriel }}</small>
                        </div>
                    </div>
                    @endforeach
                    @if($classe->etudiants->count() > 10)
                    <small class="text-muted">Et {{ $classe->etudiants->count() - 10 }} autres...</small>
                    @endif
                @else
                    <p class="text-muted mb-0">Aucun étudiant inscrit.</p>
                @endif
            </div>
        </div>

        <!-- Affectations -->
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-link"></i> Affectations ({{ $affectations->count() }})</h6>
            </div>
            <div class="card-body">
                @if($affectations->count() > 0)
                    @foreach($affectations->take(5) as $affectation)
                    <div class="mb-3 p-2 border-start border-primary border-3">
                        <strong>{{ $affectation->matiere->nom_matiere }}</strong>
                        <br><small class="text-muted">Prof: {{ $affectation->enseignant->nom }}</small>
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
    </div>
</div>
@endsection
