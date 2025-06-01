@extends('layouts.admin')

@section('title', 'Gestion des Classes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-door-open"></i> Gestion des Classes
                <span class="badge bg-secondary">{{ $classes->total() }}</span>
            </h1>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouvelle Classe
            </a>
        </div>
    </div>
</div>

&lt;!-- Filtres et recherche -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="fas fa-filter"></i> Filtres et Recherche</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.classes.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search"
                               value="{{ $search }}" placeholder="Rechercher une classe...">
                        <button class="btn btn-outline-secondary" type="submit">
                            Rechercher
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="niveau_id" onchange="this.form.submit()">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ $niveau_id == $niveau->id ? 'selected' : '' }}>
                                {{ $niveau->nom_niveau }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="annee" onchange="this.form.submit()">
                        <option value="">Toutes les années</option>
                        @foreach($annees as $an)
                            <option value="{{ $an }}" {{ $annee == $an ? 'selected' : '' }}>
                                {{ $an }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    @if($search || $niveau_id || $annee)
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Effacer
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

&lt;!-- Liste des classes -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Liste des Classes</h6>
            <small class="text-muted">
                {{ $classes->firstItem() ?? 0 }} - {{ $classes->lastItem() ?? 0 }}
                sur {{ $classes->total() }} résultats
            </small>
        </div>
    </div>
    <div class="card-body p-0">
        @if($classes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Classe</th>
                            <th>Niveau</th>
                            <th>Année</th>
                            <th>Étudiants</th>
                            <th>Enseignants</th>
                            <th>Matières</th>
                            <th>Créée le</th>
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
                                    <span class="badge bg-primary">
                                        {{ $classe->niveau->nom_niveau ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $classe->annee }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $classe->etudiants_count }} étudiant(s)
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">
                                        {{ $classe->enseignants_count }} enseignant(s)
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $classe->matieres_count }} matière(s)
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $classe->created_at->format('d/m/Y') }}
                                    </small>
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
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $classe->id }}, '{{ addslashes($classe->nom_classe) }}')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    &lt;!-- Formulaire de suppression caché -->
                                    <form id="delete-form-{{ $classe->id }}"
                                          action="{{ route('admin.classes.destroy', $classe) }}"
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            &lt;!-- Pagination -->
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
                <h5>Aucune classe trouvée</h5>
                <p class="text-muted">
                    @if($search || $niveau_id || $annee)
                        Aucun résultat pour les critères sélectionnés
                    @else
                        Commencez par ajouter votre première classe
                    @endif
                </p>
                <a href="{{ route('admin.classes.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Ajouter une Classe
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Fonction de confirmation de suppression
function confirmDelete(id, nom) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer la classe "${nom}" ?`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
