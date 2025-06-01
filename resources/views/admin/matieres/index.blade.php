@extends('layouts.admin')

@section('title', 'Gestion des Matières')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-book"></i> Gestion des Matières
                <span class="badge bg-secondary">{{ $matieres->total() }}</span>
            </h1>
            <a href="{{ route('admin.matieres.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouvelle Matière
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
        <form method="GET" action="{{ route('admin.matieres.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search"
                               value="{{ $search }}" placeholder="Rechercher une matière...">
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
                    <select class="form-select" name="enseignant_id" onchange="this.form.submit()">
                        <option value="">Tous les enseignants</option>
                        @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}" {{ $enseignant_id == $enseignant->id ? 'selected' : '' }}>
                                {{ $enseignant->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    @if($search || $niveau_id || $enseignant_id)
                        <a href="{{ route('admin.matieres.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Effacer
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Liste des matières -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Liste des Matières</h6>
            <small class="text-muted">
                {{ $matieres->firstItem() ?? 0 }} - {{ $matieres->lastItem() ?? 0 }}
                sur {{ $matieres->total() }} résultats
            </small>
        </div>
    </div>
    <div class="card-body p-0">
        @if($matieres->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Matière</th>
                            <th>Niveau</th>
                            <th>Enseignant</th>
                            <th>Coefficient</th>
                            <th>Classes</th>
                            <th>Créée le</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matieres as $matiere)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-book text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $matiere->nom_matiere }}</strong>
                                            @if($matiere->description)
                                                <small class="text-muted d-block">{{ Str::limit($matiere->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $matiere->niveau->nom_niveau ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($matiere->enseignant)
                                        <span class="badge bg-success">
                                            {{ $matiere->enseignant->nom }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Non assigné</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $matiere->coefficient }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $matiere->classes->count() }} classe(s)
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $matiere->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.matieres.show', $matiere) }}"
                                           class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.matieres.edit', $matiere) }}"
                                           class="btn btn-sm btn-outline-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $matiere->id }}, '{{ addslashes($matiere->nom_matiere) }}')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Formulaire de suppression caché -->
                                    <form id="delete-form-{{ $matiere->id }}"
                                          action="{{ route('admin.matieres.destroy', $matiere) }}"
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
            @if($matieres->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $matieres->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                <h5>Aucune matière trouvée</h5>
                <p class="text-muted">
                    @if($search || $niveau_id || $enseignant_id)
                        Aucun résultat pour les critères sélectionnés
                    @else
                        Commencez par ajouter votre première matière
                    @endif
                </p>
                <a href="{{ route('admin.matieres.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Ajouter une Matière
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
    if (confirm(`Êtes-vous sûr de vouloir supprimer la matière "${nom}" ?`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

```blade file="resources/views/admin/matieres/create.blade.php"
@extends('layouts.admin')

@section('title', 'Créer une Matière')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-plus"></i> Créer une Matière
            </h1>
            <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-book-open"></i> Informations de la Matière</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.matieres.store') }}" method="POST" id="matiere-form">
                    @csrf

                    <div class="mb-3">
                        <label for="nom_matiere" class="form-label">
                            Nom de la matière <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <input type="text" class="form-control @error('nom_matiere') is-invalid @enderror"
                                   id="nom_matiere" name="nom_matiere" value="{{ old('nom_matiere') }}" required
                                   placeholder="Ex: Mathématiques, Français...">
                        </div>
                        @error('nom_matiere')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="niveau_id" class="form-label">
                                    Niveau <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                    <select class="form-select @error('niveau_id') is-invalid @enderror"
                                            id="niveau_id" name="niveau_id" required>
                                        <option value="">Sélectionner un niveau</option>
                                        @foreach($niveaux as $niveau)
                                            <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                                                {{ $niveau->nom_niveau }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('niveau_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="coefficient" class="form-label">
                                    Coefficient <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                                    <input type="number" step="0.5" min="0.5" max="10"
                                           class="form-control @error('coefficient') is-invalid @enderror"
                                           id="coefficient" name="coefficient" value="{{ old('coefficient', 1) }}" required>
                                </div>
                                @error('coefficient')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="enseignant_id" class="form-label">
                            Enseignant assigné
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                            <select class="form-select @error('enseignant_id') is-invalid @enderror"
                                    id="enseignant_id" name="enseignant_id">
                                <option value="">Aucun enseignant (à assigner plus tard)</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->nom }}
                                        @if($enseignant->specialite)
                                            ({{ $enseignant->specialite }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('enseignant_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Description optionnelle de la matière...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Créer la Matière
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </button>
                        <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informations</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb"></i> Conseils</h6>
                    <ul class="mb-0 small">
                        <li>Choisissez un nom clair et précis</li>
                        <li>Le coefficient influence le calcul des moyennes</li>
                        <li>Vous pouvez assigner un enseignant maintenant ou plus tard</li>
                        <li>La description aide à identifier la matière</li>
                    </ul>
                </div>

                <h6><i class="fas fa-check-circle text-success"></i> Validation</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-check text-success"></i> Le nom de la matière est obligatoire</li>
                    <li><i class="fas fa-check text-success"></i> Le niveau doit être sélectionné</li>
                    <li><i class="fas fa-check text-success"></i> Le coefficient doit être entre 0.5 et 10</li>
                    <li><i class="fas fa-check text-success"></i> L'enseignant est optionnel</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-cogs"></i> Prochaines étapes</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">Après la création de la matière, vous pourrez :</p>
                <ul class="small">
                    <li>L'assigner à des classes</li>
                    <li>Modifier l'enseignant responsable</li>
                    <li>Créer l'emploi du temps</li>
                    <li>Gérer les évaluations</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
