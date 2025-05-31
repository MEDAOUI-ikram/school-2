@extends('layouts.admin')

@section('title', 'Détails de l\'Étudiant')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-user-graduate"></i> {{ $etudiant->nom }}
            </h1>
            <div class="btn-group">
                <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-user"></i> Informations Personnelles</h6>
            </div>
            <div class="card-body">
                <p><strong>Nom :</strong> {{ $etudiant->nom }}</p>
                <p><strong>Email :</strong> {{ $etudiant->courriel }}</p>
                <p><strong>Niveau :</strong>
                    <span class="badge bg-info">{{ $etudiant->niveau }}</span>
                </p>
                <p><strong>Créé le :</strong> {{ $etudiant->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Modifié le :</strong> {{ $etudiant->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>


</div>

@endsection

