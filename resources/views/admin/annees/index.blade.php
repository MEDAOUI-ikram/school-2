@extends('layouts.admin')

@section('title', 'Gestion des Années Scolaires')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-calendar-alt"></i> Années Scolaires</h1>
            <a href="{{ route('admin.annees.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Année
            </a>
        </div>

        <!-- Filtres -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Rechercher</label>
                        <input type="text" class="form-control" name="search"
                               value="{{ request('search') }}" placeholder="Nom de l'année...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Statut</label>
                        <select class="form-select" name="statut">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('statut') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Filtrer
                            </button>
                            <a href="{{ route('admin.annees.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des années -->
        <div class="card">
            <div class="card-body">
                @if($annees->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Date Début</th>
                                    <th>Date Fin</th>
                                    <th>Statut</th>
                                    <th>Classes</th>
                                    <th>Étudiants</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($annees as $annee)
                                <tr>
                                    <td>
                                        <strong>{{ $annee->nom }}</strong>
                                        @if($annee->active)
                                            <span class="badge bg-success ms-2">Actuelle</span>
                                        @endif
                                    </td>
                                    <td>{{ $annee->date_debut->format('d/m/Y') }}</td>
                                    <td>{{ $annee->date_fin->format('d/m/Y') }}</td>
                                    <td>
                                        @if($annee->active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $annee->classes_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $annee->etudiants_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.annees.show', $annee) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.annees.edit', $annee) }}"
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(!$annee->active)
                                            <form method="POST" action="{{ route('admin.annees.destroy', $annee) }}"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette année ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $annees->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <h5>Aucune année scolaire trouvée</h5>
                        <p class="text-muted">Commencez par créer une nouvelle année scolaire.</p>
                        <a href="{{ route('admin.annees.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Créer une année
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
