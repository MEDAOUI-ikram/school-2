@extends('layouts.etudiant')

@section('title', 'Informations Personnelles - Étudiant')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f8fbff 0%, #e8f4fd 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    .back-button {
        display: none;
    }

    .hamburger-icon {
        display: none;
    }

    .hamburger-line {
        display: none;
    }

    .back-button:hover .hamburger-line:nth-child(1) {
        display: none;
    }

    .back-button:hover .hamburger-line:nth-child(2) {
        display: none;
    }

    .back-button:hover .hamburger-line:nth-child(3) {
        display: none;
    }

    .section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(147, 197, 253, 0.2);
    }

    h2 {
        color: #1e40af;
        font-size: 2.5rem;
        margin-bottom: 30px;
        text-align: center;
        font-weight: 700;
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .info-display {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        border-left: 5px solid #3b82f6;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-display:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    }

    .info-display h4 {
        color: #1e40af;
        font-size: 1.3rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .info-display p {
        color: #1f2937;
        margin-bottom: 10px;
        font-size: 1rem;
        line-height: 1.6;
    }

    .info-display strong {
        color: #1e40af;
        font-weight: 600;
    }

    h3 {
        color: #1e40af;
        font-size: 1.8rem;
        margin: 30px 0 20px 0;
        font-weight: 600;
    }

    .modification-form {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        padding: 30px;
        border-radius: 15px;
        border: 1px solid rgba(147, 197, 253, 0.3);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        color: #1e40af;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    input, select {
        width: 100%;
        padding: 15px 18px;
        border: 2px solid #bfdbfe;
        border-radius: 12px;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.9);
        color: #1f2937;
        transition: all 0.3s ease;
        outline: none;
    }

    input:focus, select:focus {
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }

    input::placeholder {
        color: #9ca3af;
    }

    .btn {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        margin-top: 20px;
        min-width: 150px;
    }

    .btn:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .btn:active {
        transform: translateY(0);
    }

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-top: 20px;
        border-left: 5px solid;
        animation: slideIn 0.5s ease;
    }

    .alert-success {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
        border-left-color: #22c55e;
    }

    .error-message {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #dc2626;
        border-left-color: #ef4444;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        border-left: 5px solid #ef4444;
    }

    .error-list {
        margin: 0;
        padding-left: 20px;
    }

    .error-list li {
        margin-bottom: 5px;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .password-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 20px;
    }

    .section-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, #bfdbfe 50%, transparent 100%);
        margin: 30px 0;
    }

    @media (max-width: 768px) {
        .back-button {
            margin-bottom: 15px;
            padding: 10px 20px;
        }

        .section {
            padding: 25px;
            margin: 10px;
        }

        .password-group {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        h2 {
            font-size: 2rem;
        }

        .container {
            padding: 0 10px;
        }
    }
</style>

<div class="container">
    {{-- Bouton de retour au dashboard supprimé --}}

    <div class="section">
        <h2>Informations Personnelles</h2>
        
        {{-- Affichage des erreurs --}}
        @if ($errors->any())
            <div class="error-message">
                <strong>❌ Erreur :</strong>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Affichage des infos actuelles --}}
        <div class="info-display">
            <h4>📋 Informations Actuelles</h4>
            <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
            @if(Auth::user()->niveau)
                <p><strong>Niveau :</strong> {{ ucfirst(Auth::user()->niveau) }}</p>
            @endif
        </div>

        <div class="section-divider"></div>
        
        {{-- Formulaire de modification --}}
        <h3>✏️ Modifier Informations</h3>
        <form action="{{ route('etudiant.update-infos') }}" method="POST" class="modification-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom', Auth::user()->name) }}" placeholder="Entrez votre nom" required>
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Entrez votre email" required>
            </div>

            <div class="form-group">
                <label for="niveau">Niveau d'études</label>
                <select id="niveau" name="niveau" required>
                    <option value="">Sélectionnez votre niveau</option>
                    <option value="primaire" {{ old('niveau', Auth::user()->niveau) == 'primaire' ? 'selected' : '' }}>Primaire</option>
                    <option value="college" {{ old('niveau', Auth::user()->niveau) == 'college' ? 'selected' : '' }}>Collège</option>
                    <option value="lycee" {{ old('niveau', Auth::user()->niveau) == 'lycee' ? 'selected' : '' }}>Lycée</option>
                </select>
            </div>

            <div class="password-group">
                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Facultatif - Laissez vide pour ne pas changer">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmer mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le nouveau mot de passe">
                </div>
            </div>

            <button type="submit" class="btn">💾 Enregistrer les modifications</button>
        </form>

        {{-- Message de succès --}}
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif
    </div>
</div>
@endsection