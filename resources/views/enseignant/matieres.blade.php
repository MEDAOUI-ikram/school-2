@extends('layouts.enseignant')

@section('title', 'Mes Matières')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-0">
                        <i class="fas fa-book text-primary me-2"></i>
                        Mes Matières
                    </h2>
                    <p class="text-muted mb-0">Gérez vos matières et consultez les informations</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMatiereModal">
                    <i class="fas fa-plus me-2"></i>
                    Ajouter une matière
                </button>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $mesMatieres->count() }}</h4>
                            <p class="mb-0">Matières enseignées</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $totalClasses ?? 0 }}</h4>
                            <p class="mb-0">Classes concernées</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $totalHeures ?? 0 }}h</h4>
                            <p class="mb-0">Heures par semaine</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $totalEtudiants ?? 0 }}</h4>
                            <p class="mb-0">Étudiants au total</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('enseignant.matieres') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="niveau" class="form-label">Niveau</label>
                                <select class="form-select" id="niveau" name="niveau">
                                    <option value="">Tous les niveaux</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}" {{ request('niveau') == $niveau->id ? 'selected' : '' }}>
                                            {{ $niveau->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="coefficient" class="form-label">Coefficient</label>
                                <select class="form-select" id="coefficient" name="coefficient">
                                    <option value="">Tous les coefficients</option>
                                    <option value="1" {{ request('coefficient') == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ request('coefficient') == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ request('coefficient') == '3' ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ request('coefficient') == '4' ? 'selected' : '' }}>4</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="search" class="form-label">Rechercher</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Nom de la matière..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search me-1"></i>
                                        Filtrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des matières -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Liste de mes matières
                    </h5>
                </div>
                <div class="card-body">
                    @if($mesMatieres->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matière</th>
                                        <th>Code</th>
                                        <th>Coefficient</th>
                                        <th>Niveau</th>
                                        <th>Classes</th>
                                        <th>Étudiants</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mesMatieres as $matiere)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-book text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $matiere->nom ?? $matiere->nomMatiere }}</h6>
                                                        <small class="text-muted">{{ $matiere->description ?? 'Aucune description' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $matiere->code ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $matiere->coefficient ?? 1 }}</span>
                                            </td>
                                            <td>{{ $matiere->niveau->nom ?? 'Non défini' }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $matiere->classes_count ?? 0 }} classes</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ $matiere->etudiants_count ?? 0 }} étudiants</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" data-bs-target="#viewMatiereModal{{ $matiere->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            data-bs-toggle="modal" data-bs-target="#editMatiereModal{{ $matiere->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="{{ route('enseignant.notes.matiere', $matiere->id) }}" 
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-clipboard-list"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if(method_exists($mesMatieres, 'links'))
                            <div class="d-flex justify-content-center mt-4">
                                {{ $mesMatieres->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune matière trouvée</h5>
                            <p class="text-muted">Vous n'avez pas encore de matières assignées.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMatiereModal">
                                <i class="fas fa-plus me-2"></i>
                                Ajouter votre première matière
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter Matière -->
<div class="modal fade" id="addMatiereModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    Ajouter une matière
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.matieres.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la matière *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Code de la matière</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Ex: MATH101">
                    </div>
                    <div class="mb-3">
                        <label for="coefficient" class="form-label">Coefficient *</label>
                        <select class="form-select" id="coefficient" name="coefficient" required>
                            <option value="">Sélectionner un coefficient</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="niveau_id" class="form-label">Niveau *</label>
                        <select class="form-select" id="niveau_id" name="niveau_id" required>
                            <option value="">Sélectionner un niveau</option>
                            @foreach($niveaux as $niveau)
                                <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  placeholder="Description de la matière..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals pour voir/éditer chaque matière -->
@foreach($mesMatieres as $matiere)
    <!-- Modal Voir Matière -->
    <div class="modal fade" id="viewMatiereModal{{ $matiere->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i>
                        {{ $matiere->nom ?? $matiere->nomMatiere }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informations générales</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nom :</strong></td>
                                    <td>{{ $matiere->nom ?? $matiere->nomMatiere }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Code :</strong></td>
                                    <td>{{ $matiere->code ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Coefficient :</strong></td>
                                    <td>{{ $matiere->coefficient ?? 1 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Niveau :</strong></td>
                                    <td>{{ $matiere->niveau->nom ?? 'Non défini' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Statistiques</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Classes :</strong></td>
                                    <td>{{ $matiere->classes_count ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Étudiants :</strong></td>
                                    <td>{{ $matiere->etudiants_count ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Notes saisies :</strong></td>
                                    <td>{{ $matiere->notes_count ?? 0 }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if($matiere->description)
                        <div class="mt-3">
                            <h6>Description</h6>
                            <p class="text-muted">{{ $matiere->description }}</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a href="{{ route('enseignant.notes.matiere', $matiere->id) }}" class="btn btn-primary">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Voir les notes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Éditer Matière -->
    <div class="modal fade" id="editMatiereModal{{ $matiere->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Modifier {{ $matiere->nom ?? $matiere->nomMatiere }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('enseignant.matieres.update', $matiere->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nom{{ $matiere->id }}" class="form-label">Nom de la matière *</label>
                            <input type="text" class="form-control" id="edit_nom{{ $matiere->id }}" 
                                   name="nom" value="{{ $matiere->nom ?? $matiere->nomMatiere }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_code{{ $matiere->id }}" class="form-label">Code de la matière</label>
                            <input type="text" class="form-control" id="edit_code{{ $matiere->id }}" 
                                   name="code" value="{{ $matiere->code }}">
                        </div>
                        <div class="mb-3">
                            <label for="edit_coefficient{{ $matiere->id }}" class="form-label">Coefficient *</label>
                            <select class="form-select" id="edit_coefficient{{ $matiere->id }}" name="coefficient" required>
                                <option value="1" {{ ($matiere->coefficient ?? 1) == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ ($matiere->coefficient ?? 1) == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ ($matiere->coefficient ?? 1) == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ ($matiere->coefficient ?? 1) == 4 ? 'selected' : '' }}>4</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description{{ $matiere->id }}" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description{{ $matiere->id }}" 
                                      name="description" rows="3">{{ $matiere->description }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-génération du code de matière
    document.getElementById('nom').addEventListener('input', function() {
        const nom = this.value.toUpperCase();
        const code = nom.substring(0, 4) + '101';
        document.getElementById('code').value = code;
    });
});
</script>
@endpush