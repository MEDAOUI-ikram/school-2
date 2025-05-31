@extends('layouts.admin')

@section('title', 'Modifier un Enseignant')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-edit"></i> Modifier l'Enseignant
            </h1>
            <div class="btn-group">
                <a href="{{ route('admin.enseignants.show', $enseignant) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Voir
                </a>
                <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="fas fa-user-edit"></i> Modifier les informations de {{ $enseignant->nom }}
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.enseignants.update', $enseignant) }}" method="POST" id="enseignant-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nom" class="form-label">
                            Nom complet <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom', $enseignant->nom) }}" required>
                        </div>
                        @error('nom')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="courriel" class="form-label">
                            Adresse email <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control @error('courriel') is-invalid @enderror"
                                   id="courriel" name="courriel" value="{{ old('courriel', $enseignant->courriel) }}" required>
                        </div>
                        @error('courriel')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="specialite" class="form-label">
                            Spécialité
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                            <input type="text" class="form-control @error('specialite') is-invalid @enderror"
                                   id="specialite" name="specialite" value="{{ old('specialite', $enseignant->specialite) }}"
                                   placeholder="Ex: Mathématiques, Français, etc.">
                        </div>
                        @error('specialite')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Modification du mot de passe :</strong>
                        Laissez les champs vides pour conserver le mot de passe actuel.
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">
                            Nouveau mot de passe
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control @error('mot_de_passe') is-invalid @enderror"
                                   id="mot_de_passe" name="mot_de_passe"
                                   placeholder="Laissez vide pour conserver l'actuel">
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Minimum 6 caractères si vous souhaitez le modifier</div>
                        @error('mot_de_passe')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="mot_de_passe_confirmation" class="form-label">
                            Confirmer le nouveau mot de passe
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control"
                                   id="mot_de_passe_confirmation" name="mot_de_passe_confirmation"
                                   placeholder="Confirmez le nouveau mot de passe">
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password-confirm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </button>
                        <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">
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
                <p><strong>Créé le :</strong> {{ $enseignant->created_at->format('d/m/Y à H:i') }}</p>
                <p><strong>Modifié le :</strong> {{ $enseignant->updated_at->format('d/m/Y à H:i') }}</p>
                <p><strong>ID :</strong> #{{ $enseignant->id }}</p>

                <hr>

                <h6><i class="fas fa-chart-bar"></i> Statistiques</h6>
                <p><strong>Matières :</strong>
                    <span class="badge bg-info">{{ $enseignant->matieres ? $enseignant->matieres->count() : 0 }}</span>
                </p>
                <p><strong>Classes :</strong>
                    <span class="badge bg-secondary">{{ $enseignant->classes ? $enseignant->classes->count() : 0 }}</span>
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-shield-alt"></i> Sécurité</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info small">
                    <i class="fas fa-info-circle"></i>
                    <strong>Conseils de sécurité :</strong>
                    <ul class="mb-0 mt-2">
                        <li>Utilisez un mot de passe fort</li>
                        <li>Mélangez lettres, chiffres et symboles</li>
                        <li>Évitez les informations personnelles</li>
                    </ul>
                </div>

                <button type="button" class="btn btn-outline-warning btn-sm w-100" onclick="generatePassword()">
                    <i class="fas fa-random"></i> Générer un mot de passe
                </button>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-history"></i> Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.enseignants.show', $enseignant) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye"></i> Voir le profil complet
                    </a>
                    <button type="button" class="btn btn-outline-danger btn-sm"
                            onclick="confirmDelete({{ $enseignant->id }}, '{{ addslashes($enseignant->nom) }}')">
                        <i class="fas fa-trash"></i> Supprimer cet enseignant
                    </button>
                </div>

                <!-- Formulaire de suppression caché -->
                <form id="delete-form-{{ $enseignant->id }}"
                      action="{{ route('admin.enseignants.destroy', $enseignant) }}"
                      method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#toggle-password').click(function() {
        const passwordField = $('#mot_de_passe');
        const icon = $(this).find('i');

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#toggle-password-confirm').click(function() {
        const passwordField = $('#mot_de_passe_confirmation');
        const icon = $(this).find('i');

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Validation en temps réel
    $('#mot_de_passe_confirmation').on('input', function() {
        const password = $('#mot_de_passe').val();
        const confirmation = $(this).val();

        if (password && confirmation && password !== confirmation) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Les mots de passe ne correspondent pas</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    // Validation du formulaire
    $('#enseignant-form').on('submit', function(e) {
        const password = $('#mot_de_passe').val();
        const confirmation = $('#mot_de_passe_confirmation').val();

        if (password && password !== confirmation) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas');
            return false;
        }
    });
});

// Générer un mot de passe aléatoire
function generatePassword() {
    const length = 12;
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    let password = "";

    for (let i = 0; i < length; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }

    $('#mot_de_passe').val(password);
    $('#mot_de_passe_confirmation').val(password);

    // Afficher temporairement le mot de passe
    $('#mot_de_passe').attr('type', 'text');
    $('#mot_de_passe_confirmation').attr('type', 'text');

    setTimeout(function() {
        $('#mot_de_passe').attr('type', 'password');
        $('#mot_de_passe_confirmation').attr('type', 'password');
    }, 3000);

    alert('Mot de passe généré ! Il sera masqué dans 3 secondes.');
}

// Fonction de confirmation de suppression
function confirmDelete(id, nom) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'enseignant "${nom}" ?\n\nCette action est irréversible.`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush


