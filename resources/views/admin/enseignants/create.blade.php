@extends('layouts.admin')

@section('title', 'Créer un Enseignant')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-plus"></i> Créer un Enseignant
            </h1>
            <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-user-plus"></i> Informations de l'Enseignant</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.enseignants.store') }}" method="POST" id="enseignant-form">
                    @csrf

                    <div class="mb-3">
                        <label for="nom" class="form-label">
                            Nom complet <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom') }}" required
                                   placeholder="Entrez le nom complet">
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
                                   id="courriel" name="courriel" value="{{ old('courriel') }}" required
                                   placeholder="exemple@email.com">
                        </div>
                        @error('courriel')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">
                            Mot de passe <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control @error('mot_de_passe') is-invalid @enderror"
                                   id="mot_de_passe" name="mot_de_passe" required
                                   placeholder="Minimum 6 caractères">
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('mot_de_passe')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="mot_de_passe_confirmation" class="form-label">
                            Confirmer le mot de passe <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control"
                                   id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" required
                                   placeholder="Répétez le mot de passe">
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password-confirm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Créer l'Enseignant
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
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb"></i> Conseils</h6>
                    <ul class="mb-0 small">
                        <li>Utilisez un nom complet pour faciliter l'identification</li>
                        <li>L'email sera utilisé pour la connexion</li>
                        <li>Le mot de passe doit être sécurisé</li>
                        <li>L'enseignant pourra modifier ses informations plus tard</li>
                    </ul>
                </div>

                <h6><i class="fas fa-check-circle text-success"></i> Validation</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-check text-success"></i> Le nom complet est obligatoire</li>
                    <li><i class="fas fa-check text-success"></i> L'email doit être unique dans le système</li>
                    <li><i class="fas fa-check text-success"></i> Le mot de passe doit contenir au moins 6 caractères</li>
                    <li><i class="fas fa-check text-success"></i> La confirmation du mot de passe est requise</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-cogs"></i> Prochaines étapes</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">Après la création de l'enseignant, vous pourrez :</p>
                <ul class="small">
                    <li>Assigner des matières</li>
                    <li>Attribuer des classes</li>
                    <li>Configurer l'emploi du temps</li>
                    <li>Définir les permissions</li>
                </ul>
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

        if (confirmation && password !== confirmation) {
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

        if (password !== confirmation) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas');
            return false;
        }
    });
});
</script>
@endpush
