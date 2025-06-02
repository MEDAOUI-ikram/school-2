@extends('layouts.admin')

@section('title', 'Détails de l\'Année Scolaire')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-calendar-alt"></i> {{ $annee->nom }}</h4>
                <div>
                    @if($annee->active)
                        <span class="badge bg-success">Année Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations générales</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nom :</strong></td>
                                <td>{{ $annee->nom }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date de début :</strong></td>
                                <td>{{ $annee->date_debut->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date de fin :</strong></td>
                                <td>{{ $annee->date_fin->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Durée :</strong></td>
                                <td>{{ $annee->date_debut->diffInDays($annee->date_fin) }} jours</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Classes :</strong></td>
                                <td><span class="badge bg-info">{{ $annee->classes->count() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Étudiants :</strong></td>
                                <td><span class="badge bg-primary">{{ $annee->etudiants->count() }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Enseignants :</strong></td>
                                <td><span class="badge bg-success">{{ $annee->enseignants->count() }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($annee->description)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Description</h6>
                        <p class="text-muted">{{ $annee->description }}</p>
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.annees.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <div>
                        <a href="{{ route('admin.annees.edit', $annee) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        @if(!$annee->active)
                        <form method="POST" action="{{ route('admin.annees.destroy', $annee) }}"
                              style="display: inline;"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette année ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Classes de cette année -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="fas fa-door-open"></i> Classes ({{ $annee->classes->count() }})</h6>
            </div>
            <div class="card-body">
                @if($annee->classes->count() > 0)
                    @foreach($annee->classes->take(5) as $classe)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $classe->nom_classe }}</span>
                        <span class="badge bg-info">{{ $classe->etudiants->count() }} élèves</span>
                    </div>
                    @endforeach
                    @if($annee->classes->count() > 5)
                    <small class="text-muted">Et {{ $annee->classes->count() - 5 }} autres...</small>
                    @endif
                @else
                    <p class="text-muted mb-0">Aucune classe pour cette année.</p>
                @endif
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-bolt"></i> Actions rapides</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.classes.create', ['annee_id' => $annee->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajouter une classe
                    </a>
                    <a href="{{ route('admin.rapports.annee', $annee) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-chart-bar"></i> Rapport de l'année
                    </a>
                    @if($annee->active)
                    <button class="btn btn-outline-warning btn-sm" onclick="toggleActive({{ $annee->id }})">
                        <i class="fas fa-pause"></i> Désactiver
                    </button>
                    @else
                    <button class="btn btn-outline-success btn-sm" onclick="toggleActive({{ $annee->id }})">
                        <i class="fas fa-play"></i> Activer
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleActive(anneeId) {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de cette année ?')) {
        $.post('{{ route("admin.annees.toggle", ":id") }}'.replace(':id', anneeId), {
            _token: '{{ csrf_token() }}'
        }).done(function(response) {
            location.reload();
        }).fail(function() {
            alert('Erreur lors du changement de statut');
        });
    }
}
</script>
@endpush
