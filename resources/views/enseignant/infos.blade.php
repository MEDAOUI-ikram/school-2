@extends('layouts.enseignant')

@section('title', 'Mon Profil')

@section('content')
<section class="content-section">
    <h3 class="section-title">
        <i class="fas fa-user-cog section-icon"></i>
        Mon Profil
    </h3>
    
    <form action="{{ route('enseignant.update-infos') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <div class="form-group">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="nom" class="form-input" value="{{ $enseignantData['nom'] }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ $enseignantData['email'] }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" name="telephone" class="form-input" value="{{ $enseignantData['telephone'] }}">
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label class="form-label">Spécialité</label>
                    <input type="text" name="specialite" class="form-input" value="{{ $enseignantData['specialite'] }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <textarea name="adresse" class="form-input" rows="3">{{ $enseignantData['adresse'] }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Date d'embauche</label>
                    <input type="text" class="form-input" value="{{ $enseignantData['date_embauche'] }}" readonly>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn">
            <i class="fas fa-save"></i>
            Sauvegarder
        </button>
    </form>
</section>
@endsection
