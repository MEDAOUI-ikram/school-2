@extends('layouts.enseignant')

@section('title', 'Mes Classes')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-0">
                        <i class="fas fa-users text-primary me-2"></i>
                        Mes Classes
                    </h2>
                    <p class="text-muted mb-0">Gérez vos classes et consultez les informations des étudiants</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importStudentsModal">
                        <i class="fas fa-upload me-2"></i>
                        Importer étudiants
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClasseModal">
                        <i class="fas fa-plus me-2"></i>
                        Nouvelle classe
                    </button>
                </div>
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
                            <h4 class="mb-0">{{ $mesClasses->count() }}</h4>
                            <p class="mb-0">Classes enseignées</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
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
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $moyenneGenerale ?? 0 }}/20</h4>
                            <p class="mb-0">Moyenne générale</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x opacity-75"></i>
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
                            <h4 class="mb-0">{{ $coursParSemaine ?? 0 }}h</h4>
                            <p class="mb-0">Cours par semaine</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
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
                    <form method="GET" action="{{ route('enseignant.classes') }}">
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
                                <label for="annee" class="form-label">Année scolaire</label>
                                <select class="form-select" id="annee" name="annee">
                                    <option value="">Toutes les années</option>
                                    <option value="2024-2025" {{ request('annee') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                                    <option value="2023-2024" {{ request('annee') == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="search" class="form-label">Rechercher</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Nom de la classe..." value="{{ request('search') }}">
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

    <!-- Liste des classes -->
    <div class="row">
        @if($mesClasses->count() > 0)
            @foreach($mesClasses as $classe)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-users me-2"></i>
                                    {{ $classe->nom ?? $classe->nomClasse }}
                                </h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                               data-bs-target="#viewClasseModal{{ $classe->id }}">
                                                <i class="fas fa-eye me-2"></i>Voir détails
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                               data-bs-target="#editClasseModal{{ $classe->id }}">
                                                <i class="fas fa-edit me-2"></i>Modifier
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('enseignant.notes.classe', $classe->id) }}">
                                                <i class="fas fa-clipboard-list me-2"></i>Saisir notes
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('enseignant.absences.classe', $classe->id) }}">
                                                <i class="fas fa-calendar-times me-2"></i>Gérer absences
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h4 class="text-primary mb-0">{{ $classe->nbEtudiants ?? 0 }}</h4>
                                        <small class="text-muted">Étudiants</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h4 class="text-success mb-0">{{ $classe->nbMatieres ?? 0 }}</h4>
                                        <small class="text-muted">Matières</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-info mb-0">{{ $classe->moyenne ?? 0 }}/20</h4>
                                    <small class="text-muted">Moyenne</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">
                                        <i class="fas fa-layer-group me-1"></i>
                                        Niveau: {{ $classe->niveau ?? 'Non défini' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">
                                        <i class="fas fa-chalkboard-teacher me-1"></i>
                                        Prof. principal: {{ $classe->professeurPrincipal ?? 'Non assigné' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">
                                        <i class="fas fa-door-open me-1"></i>
                                        Salle: {{ $classe->salle ?? 'Non définie' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        Année: {{ $classe->anneeScolaire ?? '2024-2025' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-fill" 
                                        data-bs-toggle="modal" data-bs-target="#studentsModal{{ $classe->id }}">
                                    <i class="fas fa-users me-1"></i>
                                    Étudiants
                                </button>
                                <button class="btn btn-sm btn-outline-success flex-fill"
                                        data-bs-toggle="modal" data-bs-target="#notesModal{{ $classe->id }}">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    Notes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune classe trouvée</h5>
                        <p class="text-muted">Vous n'avez pas encore de classes assignées.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClasseModal">
                            <i class="fas fa-plus me-2"></i>
                            Créer votre première classe
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if(method_exists($mesClasses, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $mesClasses->links() }}
        </div>
    @endif
</div>

<!-- Modal Ajouter Classe -->
<div class="modal fade" id="addClasseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    Créer une nouvelle classe
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.classes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom de la classe *</label>
                                <input type="text" class="form-control" id="nom" name="nom" required 
                                       placeholder="Ex: L2 Informatique A">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="niveau_id" class="form-label">Niveau *</label>
                                <select class="form-select" id="niveau_id" name="niveau_id" required>
                                    <option value="">Sélectionner un niveau</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="salle" class="form-label">Salle principale</label>
                                <input type="text" class="form-control" id="salle" name="salle" 
                                       placeholder="Ex: A101">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="annee_scolaire" class="form-label">Année scolaire *</label>
                                <select class="form-select" id="annee_scolaire" name="annee_scolaire" required>
                                    <option value="2024-2025" selected>2024-2025</option>
                                    <option value="2025-2026">2025-2026</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" 
                                          placeholder="Description de la classe..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Créer la classe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Importer Étudiants -->
<div class="modal fade" id="importStudentsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload me-2"></i>
                    Importer des étudiants
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="classe_id" class="form-label">Classe de destination *</label>
                        <select class="form-select" id="classe_id" name="classe_id" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($mesClasses as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->nom ?? $classe->nomClasse }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier CSV/Excel *</label>
                        <input type="file" class="form-control" id="file" name="file" 
                               accept=".csv,.xlsx,.xls" required>
                        <div class="form-text">
                            Format accepté: CSV, Excel (.xlsx, .xls)<br>
                            Colonnes requises: nom, prenom, email
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Format du fichier:</strong><br>
                        Première ligne: nom, prenom, email, telephone (optionnel)<br>
                        Exemple: Dupont, Marie, marie.dupont@email.com, 0123456789
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>
                        Importer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals pour chaque classe -->
@foreach($mesClasses as $classe)
    <!-- Modal Voir Détails Classe -->
    <div class="modal fade" id="viewClasseModal{{ $classe->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-users me-2"></i>
                        {{ $classe->nom ?? $classe->nomClasse }} - Détails
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Informations générales</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nom :</strong></td>
                                    <td>{{ $classe->nom ?? $classe->nomClasse }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Niveau :</strong></td>
                                    <td>{{ $classe->niveau ?? 'Non défini' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Salle :</strong></td>
                                    <td>{{ $classe->salle ?? 'Non définie' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Année :</strong></td>
                                    <td>{{ $classe->anneeScolaire ?? '2024-2025' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h6>Statistiques</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Étudiants :</strong></td>
                                    <td>{{ $classe->nbEtudiants ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Matières :</strong></td>
                                    <td>{{ $classe->nbMatieres ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Moyenne :</strong></td>
                                    <td>{{ $classe->moyenne ?? 0 }}/20</td>
                                </tr>
                                <tr>
                                    <td><strong>Taux présence :</strong></td>
                                    <td>{{ $classe->tauxPresence ?? 95 }}%</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h6>Actions rapides</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('enseignant.notes.classe', $classe->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-clipboard-list me-2"></i>Saisir notes
                                </a>
                                <a href="{{ route('enseignant.absences.classe', $classe->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-calendar-times me-2"></i>Gérer absences
                                </a>
                                <button class="btn btn-outline-info btn-sm" onclick="exportClass({{ $classe->id }})">
                                    <i class="fas fa-download me-2"></i>Exporter données
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Étudiants -->
    <div class="modal fade" id="studentsModal{{ $classe->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Étudiants - {{ $classe->nom ?? $classe->nomClasse }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Moyenne</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Données d'exemple - à remplacer par les vraies données -->
                                <tr>
                                    <td>Dupont</td>
                                    <td>Marie</td>
                                    <td>marie.dupont@email.com</td>
                                    <td><span class="badge bg-success">15.2/20</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Martin</td>
                                    <td>Thomas</td>
                                    <td>thomas.martin@email.com</td>
                                    <td><span class="badge bg-warning">12.8/20</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Ajouter étudiant
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('scripts')
<script>
function exportClass(classeId) {
    // Fonction pour exporter les données de la classe
    window.location.href = `/enseignant/classes/${classeId}/export`;
}

document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes au survol
    document.querySelectorAll('.hover-shadow').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-header.bg-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}
</style>
@endpush