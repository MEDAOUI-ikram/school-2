@extends('layouts.admin')

@section('title', 'Gestion des Affectations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-link"></i> Gestion des Affectations
                <span class="badge bg-secondary">{{ $affectations->total() }}</span>
            </h1>
            <a href="{{ route('admin.affectations.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouvelle Affectation
            </a>
        </div>
    </div>
</div>

&lt;!-- Filtres -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="fas fa-filter"></i> Filtres</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.affectations.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <select class="form-select" name="classe_id" onchange="this.form.submit()">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classe_id == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom_classe }} ({{ $classe->niveau->nom_niveau ?? 'N/A' }})
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
                <div class="col-md-3">
                    <select class="form-select" name="matiere_id" onchange="this.form.submit()">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}" {{ $matiere_id == $matiere->id ? 'selected' : '' }}>
                                {{ $matiere->nom_matiere }} ({{ $matiere->niveau->nom_niveau ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    @if($classe_id || $enseignant_id || $matiere_id)
                        <a href="{{ route('admin.affectations.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i> Effacer les filtres
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

&lt;!-- Liste des affectations -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Liste des Affectations</h6>
            <small class="text-muted">
                {{ $affectations->firstItem() ?? 0 }} - {{ $affectations->lastItem() ?? 0 }}
                sur {{ $affectations->total() }} résultats
            </small>
        </div>
    </div>
    <div class="card-body p-0">
        @if($affectations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Classe</th>
                            <th>Niveau</th>
                            <th>Enseignant</th>
                            <th>Matière</th>
                            <th>Coefficient</th>
                            <th>Créée le</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($affectations as $affectation)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 30px; height: 30px;">
                                            <i class="fas fa-door-open text-white small"></i>
                                        </div>
                                        <strong>{{ $affectation->classe->nom_classe }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $affectation->classe->niveau->nom_niveau ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 30px; height: 30px;">
                                            <i class="fas fa-user text-white small"></i>
                                        </div>
                                        {{ $affectation->enseignant->nom }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 30px; height: 30px;">
                                            <i class="fas fa-book text-white small"></i>
                                        </div>
                                        {{ $affectation->matiere->nom_matiere }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $affectation->matiere->coefficient }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $affectation->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete({{ $affectation->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    &lt;!-- Formulaire de suppression caché -->
                                    <form id="delete-form-{{ $affectation->id }}"
                                          action="{{ route('admin.affectations.destroy', $affectation) }}"
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
            @if($affectations->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $affectations->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-unlink fa-4x text-muted mb-3"></i>
                <h5>Aucune affectation trouvée</h5>
                <p class="text-muted">
                    @if($classe_id || $enseignant_id || $matiere_id)
                        Aucun résultat pour les critères sélectionnés
                    @else
                        Commencez par créer votre première affectation
                    @endif
                </p>
                <a href="{{ route('admin.affectations.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Créer une Affectation
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Fonction de confirmation de suppression
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette affectation ?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
