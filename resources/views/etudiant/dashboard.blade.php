 @extends('layouts.etudiant')

@section('title', 'Tableau de Bord - Étudiant')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
        min-height: 100vh;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard-header {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(59, 130, 246, 0.1);
        border: 1px solid #e0f2fe;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-icon {
        background: #dbeafe;
        padding: 12px;
        border-radius: 10px;
        color: #2563eb;
    }

    .header-text h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .header-text p {
        color: #2563eb;
        font-size: 14px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .user-avatar {
        background: #dbeafe;
        padding: 6px;
        border-radius: 50%;
        color: #2563eb;
    }

    .welcome-section {
        margin-bottom: 32px;
    }

    .welcome-section h2 {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .welcome-section p {
        color: #6b7280;
        font-size: 16px;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(59, 130, 246, 0.1);
        border: 1px solid #e0f2fe;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15);
    }

    .card-header {
        background: #f0f8ff;
        padding: 20px;
        border-bottom: 1px solid #e0f2fe;
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 18px;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 4px;
    }

    .card-description {
        color: #2563eb;
        font-size: 14px;
    }

    .card-content {
        padding: 24px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .info-row:last-of-type {
        margin-bottom: 24px;
    }

    .info-label {
        color: #6b7280;
        font-size: 14px;
    }

    .info-value {
        font-weight: 600;
        color: #1f2937;
    }

    .badge {
        background: #dbeafe;
        color: #1e40af;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-count {
        background: #dbeafe;
        color: #1e40af;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .subjects-preview {
        margin-bottom: 16px;
    }

    .subjects-preview p {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .subjects-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .subject-tag {
        background: #f0f8ff;
        color: #1e40af;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        border: 1px solid #e0f2fe;
    }

    .btn {
        width: 100%;
        background: #2563eb;
        color: white;
        border: none;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .personal-info-card {
        grid-column: 1 / -1;
    }

    .personal-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-icon {
        background: #dbeafe;
        padding: 10px;
        border-radius: 8px;
        color: #2563eb;
        flex-shrink: 0;
    }

    .info-details p:first-child {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 2px;
    }

    .info-details p:last-child {
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 16px;
        }
        
        .cards-grid {
            grid-template-columns: 1fr;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .personal-info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-title">
                <div class="header-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>Tableau de Bord</h1>
                    <p>Espace Étudiant</p>
                </div>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <span>{{ $infos['prenom'] ?? 'Étudiant' }} {{ $infos['nom'] ?? '' }}</span>
            </div>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <h2>Bienvenue, {{ $infos['prenom'] ?? 'Étudiant' }} !</h2>
        <p>Voici un aperçu de votre parcours académique</p>
    </div>

    <!-- Cards Grid -->
    <div class="cards-grid">
        <!-- Résumé Classes -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    Résumé Classes
                </div>
                <div class="card-description">Informations sur votre classe actuelle</div>
            </div>
            <div class="card-content">
                <div class="info-row">
                    <span class="info-label">Classe actuelle:</span>
                    <span class="badge">{{ $classe->nomClasse ?? 'Aucune' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Année:</span>
                    <span class="info-value">{{ $classe->annee ?? '-' }}</span>
                </div>
                <a href="{{ route('etudiant.classes') }}" class="btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    Consulter Classes
                </a>
            </div>
        </div>

        <!-- Résumé Matières -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                    </svg>
                    Résumé Matières
                </div>
                <div class="card-description">Vos matières d'étude</div>
            </div>
            <div class="card-content">
                <div class="info-row">
                    <span class="info-label">Nombre de matières:</span>
                    <span class="badge-count">{{ $matieres->count() }}</span>
                </div>
                @if($matieres->count() > 0)
                <div class="subjects-preview">
                    <p>Matières principales:</p>
                    <div class="subjects-tags">
                        @foreach($matieres->take(3) as $matiere)
                            <span class="subject-tag">{{ $matiere->nom ?? $matiere->nomMatiere ?? 'Matière' }}</span>
                        @endforeach
                        @if($matieres->count() > 3)
                            <span class="subject-tag">+{{ $matieres->count() - 3 }} autres</span>
                        @endif
                    </div>
                </div>
                @endif
                <a href="{{ route('etudiant.matieres') }}" class="btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                    </svg>
                    Consulter Matières
                </a>
            </div>
        </div>
    </div>

    <!-- Informations Personnelles -->
    <div class="card personal-info-card">
        <div class="card-header">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                Mes Informations
            </div>
            <div class="card-description">Vos informations personnelles</div>
        </div>
        <div class="card-content">
            <div class="personal-info-grid">
                @foreach($infos as $key => $value)
                    <div class="info-item">
                        <div class="info-icon">
                            @if($key === 'email')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            @elseif($key === 'telephone')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                            @elseif($key === 'adresse')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                            @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="info-details">
                            <p>{{ ucfirst($key) }}</p>
                            <p>{{ $value }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection