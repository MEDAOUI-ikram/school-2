@extends('layouts.etudiant')

@section('title', 'Mon Profil - Étudiant')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e1f5fe 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .section {
        max-width: 800px;
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 10px 25px rgba(33, 150, 243, 0.1);
        border: 1px solid #e3f2fd;
    }

    .section h2 {
        font-size: 28px;
        font-weight: 700;
        color: #1565c0;
        margin: 0 0 32px 0;
        padding-bottom: 16px;
        border-bottom: 2px solid #e3f2fd;
        display: flex;
        align-items: center;
    }

    .section h2:before {
        content: "👤";
        margin-right: 12px;
        font-size: 32px;
    }

    .profile-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-item {
        padding: 20px;
        background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
        border-radius: 12px;
        border: 1px solid #e3f2fd;
    }

    .info-label {
        font-size: 14px;
        color: #64b5f6;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .info-value {
        font-size: 18px;
        color: #1565c0;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .profile-info {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="section">
    <h2>Mon Profil</h2>

    <div class="profile-info">
        <div class="info-item">
            <div class="info-label">Nom</div>
            <div class="info-value">{{ Auth::user()->nom ?? 'Non défini' }}</div>
        </div>
        
        <div class="info-item">
            <div class="info-label">Prénom</div>
            <div class="info-value">{{ Auth::user()->prenom ?? 'Non défini' }}</div>
        </div>
        
        <div class="info-item">
            <div class="info-label">Email</div>
            <div class="info-value">{{ Auth::user()->courriel ?? Auth::user()->email ?? 'Non défini' }}</div>
        </div>
        
        <div class="info-item">
            <div class="info-label">Téléphone</div>
            <div class="info-value">{{ Auth::user()->telephone ?? 'Non défini' }}</div>
        </div>
        
        <div class="info-item">
            <div class="info-label">Date de naissance</div>
            <div class="info-value">{{ Auth::user()->date_naissance ?? 'Non définie' }}</div>
        </div>
        
        <div class="info-item">
            <div class="info-label">Classe</div>
            <div class="info-value">{{ Auth::user()->classe_id ? 'Classe ID: ' . Auth::user()->classe_id : 'Non assigné' }}</div>
        </div>
    </div>
</div>
@endsection