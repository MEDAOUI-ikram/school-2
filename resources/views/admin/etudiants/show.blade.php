@extends('layouts.admin')

@section('title', 'Détails de l\'Étudiant')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-user-graduate"></i> {{ $etudiant->nom }}</h4>
                <div>
                    <span class="badge bg-info">{{ $etudiant->niveau }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations personnelles</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nom complet :</strong></td>
                                <td>{{ $etudiant->nom }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email :</strong></td>
                                <td>
                                    <a href="mailto:{{ $etudiant->courriel }}">{{ $etudiant->courriel }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Niveau :</strong></td>
                                <td><span class="badge bg-info">{{ $etudiant->niveau }}</span></td>
                            </tr>
                            @if($etudiant->date_naissance)
                            <tr>
                                <td><strong>Date de naissance :</strong></td>
                                <td>{{ $etudiant->date_naissance->format('d/m/Y') }} ({{ $etudiant->date_naissance->age }} ans)</td>
                            </tr>
                            @endif
                            @if($etudiant->lieu_naissance)
                            <tr>
                                <td><strong>Lieu de naissance :</strong></td>
                                <td>{{ $etudiant->lieu_naissance }}</td>
                            </tr>
                            @endif
                            @if($etudiant->telephone)
                            <tr>
                                <td><strong>Téléphone :</strong></td>
                                <td>{{ $etudiant->telephone }}</td>
                            </tr>
                            @endif
                            @if($etudiant->adresse)
                            <tr>
                                <td><strong>Adresse :</strong></td>
                                <td>{{ $etudiant->adresse }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Inscrit le :</strong></td>
                                <td>{{ $etudiant->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques académiques</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Classes inscrites :</strong></td>
                                <td><span class="badge bg-primary">{{ $etudiant->classes->count() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Année d'inscription :</strong></td>
                                <td>{{ $etudiant->created_at->format('Y') }}</td>
                            </tr>
                        </table>

                        @if($etudiant->classes->count() > 0)
                        <h6 class="mt-3">Classes actuelles</h6>
                        @foreach($etudiant->classes as $classe)
                        <div class="mb-2">
                            <span class="badge bg-secondary">{{ $classe->nom_classe }}</span>
                            @if($classe->niveau)
                                <small class="text-muted">({{ $classe->niveau->nom_niveau }})</small>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <div>
                        <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.etudiants.destroy', $etudiant) }}"
                              style="display: inline;"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">
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
        <!-- Classes -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="fas fa-door-open"></i> Classes ({{ $etudiant->classes->count() }})</h6>
            </div>
            <div class="card-body">
                @if($etudiant->classes->count() > 0)
                    @foreach($etudiant->classes as $classe)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>{{ $classe->nom_classe }}</strong>
                            <br><small class="text-muted">{{ $classe->niveau->nom_niveau ?? 'N/A' }}</small>
                        </div>
                        <span class="badge bg-info">{{ $classe->annee }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">Aucune classe assignée.</p>
                @endif
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-bolt"></i> Actions rapides</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.classes.index', ['etudiant_id' => $etudiant->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus"></i> Assigner à une classe
                    </a>
                    <a href="{{ route('admin.rapports.etudiant', $etudiant) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-chart-bar"></i> Rapport de l'étudiant
                    </a>
                    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer la fiche
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


