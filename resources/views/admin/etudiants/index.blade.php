@extends('layouts.admin')

@section('title', 'Gestion des Étudiants')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-user-graduate"></i> Gestion des Étudiants
                <span class="badge bg-secondary">{{ $etudiants->total() }}</span>
            </h1>
            <a href="{{ route('admin.etudiants.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouvel Étudiant
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
        <form method="GET" action="{{ route('admin.etudiants.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search"
                               value="{{ $search }}" placeholder="Rechercher par nom ou email...">
                        <button class="btn btn-outline-secondary" type="submit">
                            Rechercher
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="niveau" onchange="this.form.submit()">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $niv)
                            <option value="{{ $niv }}" {{ $niveau == $niv ? 'selected' : '' }}>
                                {{ $niv }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <div class="d-flex gap-2">
                        @if($search || $niveau)
                            <a href="{{ route('admin.etudiants.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Effacer
                            </a>
                        @endif
                        <button type="button" class="btn btn-outline-danger" id="bulk-delete-btn" style="display: none;">
                            <i class="fas fa-trash"></i> Supprimer sélectionnés (<span id="selected-count">0</span>)
                        </button>
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Liste des étudiants -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Liste des Étudiants</h6>
            <small class="text-muted">
                {{ $etudiants->firstItem() ?? 0 }} - {{ $etudiants->lastItem() ?? 0 }}
                sur {{ $etudiants->total() }} résultats
            </small>
        </div>
    </div>
    <div class="card-body p-0">
        @if($etudiants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Niveau</th>
                            <th>Classes</th>
                            <th>Créé le</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiants as $etudiant)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input select-item" value="{{ $etudiant->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $etudiant->nom }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $etudiant->courriel }}" class="text-decoration-none">
                                        {{ $etudiant->courriel }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $etudiant->niveau }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                       groupe {{ $etudiant->classes->count() }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $etudiant->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.etudiants.show', $etudiant) }}"
                                           class="btn btn-sm btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.etudiants.edit', $etudiant) }}"
                                           class="btn btn-sm btn-outline-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $etudiant->id }}, '{{ $etudiant->nom }}')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Formulaire de suppression caché -->
                                    <form id="delete-form-{{ $etudiant->id }}"
                                          action="{{ route('admin.etudiants.destroy', $etudiant) }}"
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
            @if($etudiants->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $etudiants->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                <h5>Aucun étudiant trouvé</h5>
                <p class="text-muted">
                    @if($search || $niveau)
                        Aucun résultat pour les critères sélectionnés
                    @else
                        Commencez par ajouter votre premier étudiant
                    @endif
                </p>
                <a href="{{ route('admin.etudiants.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Ajouter un Étudiant
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal d'export -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-download"></i> Exporter les Étudiants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Choisissez le format d'export :</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.export.users', ['type' => 'etudiants', 'format' => 'excel']) }}"
                       class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Excel (.xlsx)
                    </a>
                    <a href="{{ route('admin.export.users', ['type' => 'etudiants', 'format' => 'csv']) }}"
                       class="btn btn-info">
                        <i class="fas fa-file-csv"></i> CSV
                    </a>
                    <a href="{{ route('admin.export.users', ['type' => 'etudiants', 'format' => 'pdf']) }}"
                       class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion de la sélection multiple
    $('#select-all').change(function() {
        $('.select-item').prop('checked', this.checked);
        toggleBulkDelete();
    });

    $('.select-item').change(function() {
        const totalItems = $('.select-item').length;
        const checkedItems = $('.select-item:checked').length;

        $('#select-all').prop('checked', checkedItems === totalItems);
        $('#select-all').prop('indeterminate', checkedItems > 0 && checkedItems < totalItems);

        toggleBulkDelete();
    });

    function toggleBulkDelete() {
        const selected = $('.select-item:checked').length;
        $('#selected-count').text(selected);

        if (selected > 0) {
            $('#bulk-delete-btn').show();
        } else {
            $('#bulk-delete-btn').hide();
        }
    }

    // Suppression en masse
    $('#bulk-delete-btn').click(function() {
        const selected = $('.select-item:checked').map(function() {
            return this.value;
        }).get();

        if (selected.length > 0) {
            if (confirm(`Êtes-vous sûr de vouloir supprimer ${selected.length} étudiant(s) sélectionné(s) ?`)) {
                $.post('{{ route("admin.bulk.delete") }}', {
                    _token: '{{ csrf_token() }}',
                    type: 'etudiant',
                    ids: selected
                }).done(function(response) {
                    location.reload();
                }).fail(function() {
                    alert('Erreur lors de la suppression');
                });
            }
        }
    });
});

// Fonction de confirmation de suppression
function confirmDelete(id, nom) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'étudiant "${nom}" ?`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

