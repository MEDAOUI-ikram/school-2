@extends('layouts.admin')

@section('title', 'Gestion des Classes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-door-open"></i> Gestion des Classes
            <span class="badge bg-secondary">{{ $classes->total() }}</span>
        </h1>
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Classe
        </a>
    </div>

    <!-- Filtres et recherche -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="fas fa-filter"></i> Filtres et Recherche</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.classes.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Rechercher</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search }}" placeholder="Rechercher une classe...">
                </div>
                <div class="col-md-3">
                    <label for="niveau_id" class="form-label">Niveau</label>
                    <select class="form-select" id="niveau_id" name="niveau_id">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ $niveau_id == $niveau->id ? 'selected' : '' }}>
                                {{ $niveau->nom_niveau }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="annee" class="form-label">Année</label>
                    <select class="form-select" id="annee" name="annee">
                        <option value="">Toutes les années</option>
                        @foreach($annees as $anneeOption)
                            <option value="{{ $anneeOption }}" {{ $annee == $anneeOption ? 'selected' : '' }}>
                                {{ $anneeOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des classes -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Liste des Classes
            </h5>
        </div>
        <div class="card-body p-0">
            @if($classes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Classe</th>
                                <th>Niveau</th>
                                <th>Année</th>
                                <th>Étudiants</th>
                                <th>Enseignants</th>
                                <th>Matières</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $classe)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-2"
                                                 style="width: 35px; height: 35px;">
                                                <i class="fas fa-door-open text-white"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $classe->nom_classe }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $classe->niveau->nom_niveau ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $classe->annee }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $classe->etudiants_count }} étudiant(s)
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $classe->enseignants_count }} enseignant(s)
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            {{ $classe->matieres_count }} matière(s)
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.classes.show', $classe) }}"
                                               class="btn btn-sm btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.classes.edit', $classe) }}"
                                               class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.classes.destroy', $classe) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($classes->hasPages())
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-center">
                            {{ $classes->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-door-closed fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune classe trouvée</h5>
                    <p class="text-muted">
                        @if($search || $niveau_id || $annee)
                            Aucun résultat pour les critères sélectionnés
                        @else
                            Commencez par ajouter votre première classe
                        @endif
                    </p>
                    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter une Classe
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

