
@extends('layouts.admin')

@section('title', 'Gestion des Enseignants')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-chalkboard-teacher"></i> Gestion des Enseignants
                <span class="badge bg-secondary">{{ $enseignants->total() }}</span>
            </h1>
            <a href="{{ route('admin.enseignants.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouvel Enseignant
            </a>
        </div>
    </div>
</div>

<!-- Filtres et recherche -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="fas fa-filter"></i> Filtres et Recherche</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.enseignants.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search"
                               value="{{ $search }}" placeholder="Rechercher par nom ou email...">
                        <button class="btn btn-outline-secondary" type="submit">
                            Rechercher
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="specialite" onchange="this.form.submit()">
                        <option value="">Toutes les spécialités</option>
                        @foreach($specialites as $spec)
                            <option value="{{ $spec }}" {{ $specialite == $spec ? 'selected' : '' }}>
                                {{ $spec }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    @if($search || $specialite)
                        <a href="{{ route('admin.enseignants.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Effacer
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Liste des enseignants -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Liste des Enseignants</h6>
            <small class="text-muted">
                {{ $enseignants->firstItem() ?? 0 }} - {{ $enseignants->lastItem() ?? 0 }}
                sur {{ $enseignants->total() }} résultats
            </small>
        </div>
    </div>
    <div class="card-body p-0">
        @if($enseignants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Enseignant</th>
                            <th>Email</th>
                            <th>Spécialité</th>
                            <th>Matières</th>
                            <th>Classes</th>
                            <th>Créé le</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enseignants as $enseignant)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $enseignant->nom }}</strong>
                                            @if($enseignant->telephone)
                                                <br><small class="text-muted">{{ $enseignant->telephone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $enseignant->courriel }}" class="text-decoration-none">
                                        {{ $enseignant->courriel }}
                                    </a>
                                </td>
                                <td>
                                    @if($enseignant->specialite)
                                        <span class="badge bg-info">{{ $enseignant->specialite }}</span>
                                    @else
                                        <span class="text-muted">Non définie</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-warning">
                                        {{ $enseignant->matieres_count }} matière(s)
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $enseignant->classes_count }} classe(s)
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $enseignant->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.enseignants.show', $enseignant) }}"
                                           class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.enseignants.edit', $enseignant) }}"
                                           class="btn btn-sm btn-outline-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $enseignant->id }}, '{{ addslashes($enseignant->nom) }}')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Formulaire de suppression caché -->
                                    <form id="delete-form-{{ $enseignant->id }}"
                                          action="{{ route('admin.enseignants.destroy', $enseignant) }}"
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

            <!-- Pagination -->
            @if($enseignants->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $enseignants->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                <h5>Aucun enseignant trouvé</h5>
                <p class="text-muted">
                    @if($search || $specialite)
                        Aucun résultat pour les critères sélectionnés
                    @else
                        Commencez par ajouter votre premier enseignant
                    @endif
                </p>
                <a href="{{ route('admin.enseignants.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Ajouter un Enseignant
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
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'enseignant "${nom}" ?`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush


