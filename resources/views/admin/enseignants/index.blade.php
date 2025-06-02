```php file="resources/views/admin/etudiants/index.blade.php"
[v0-no-op-code-block-prefix]

```blade file="resources/views/admin/matieres/index.blade.php"
@extends('layouts.admin')

@section('title', 'Gestion des Matières')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-book-open"></i> Gestion des Matières
        </h1>
        <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Matière
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.matieres.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Rechercher</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search }}" placeholder="Nom de la matière...">
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
                    <label for="enseignant_id" class="form-label">Enseignant</label>
                    <select class="form-select" id="enseignant_id" name="enseignant_id">
                        <option value="">Tous les enseignants</option>
                        @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}" {{ $enseignant_id == $enseignant->id ? 'selected' : '' }}>
                                {{ $enseignant->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.matieres.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des matières -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Liste des Matières ({{ $matieres->total() }} résultats)
            </h5>
        </div>
        <div class="card-body">
            @if($matieres->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Matière</th>
                                <th>Niveau</th>
                                <th>Enseignant</th>
                                <th>Coefficient</th>
                                <th>Classes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matieres as $matiere)
                                <tr>
                                    <td>
                                        <strong>{{ $matiere->nom_matiere }}</strong>
                                        @if($matiere->description)
                                            <br><small class="text-muted">{{ Str::limit($matiere->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $matiere->niveau->nom_niveau }}</span>
                                    </td>
                                    <td>
                                        @if($matiere->enseignant)
                                            <a href="{{ route('admin.enseignants.show', $matiere->enseignant) }}" class="text-decoration-none">
                                                {{ $matiere->enseignant->nom }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non assigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $matiere->coefficient }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $matiere->classes_count ?? 0 }}</span>
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
                                            <form action="{{ route('admin.matieres.destroy', $matiere) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?')">
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
                <div class="d-flex justify-content-center">
                    {{ $matieres->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune matière trouvée</h5>
                    <p class="text-muted">Commencez par créer votre première matière.</p>
                    <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer une matière
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


