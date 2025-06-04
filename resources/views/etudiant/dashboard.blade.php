 @extends('layouts.student')

@section('title', 'Tableau de Bord - Étudiant')

@section('content')
<div class="section">
    <h2>Tableau de Bord</h2>
    <div class="grid">
        <div>
            <h3>Résumé Classes</h3>
            <div class="info-display">
                <p>Classe actuelle: <strong>{{ $classe->nomClasse ?? 'Aucune' }}</strong></p>
                <p>Année: <strong>{{ $classe->annee ?? '-' }}</strong></p>
                <a href="{{ route('etudiant.classes') }}" class="btn">Consulter Classes</a>
            </div>
        </div>
        <div>
            <h3>Résumé Matières</h3>
            <div class="info-display">
                <p>Nombre de matières: <strong>{{ $matieres->count() }}</strong></p>
                <a href="{{ route('etudiant.matieres') }}" class="btn">Consulter Matières</a>
            </div>
        </div>
    </div>
    
    <!-- Informations personnelles résumées -->
    <div class="student-summary">
        <h3>Mes Informations</h3>
        <div class="info-display">
            @foreach($infos as $key => $value)
                <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection