@extends('layouts.student')

@section('title', 'Mes Classes - Étudiant')

@section('content')
<div class="section">
    <h2>Mes Classes</h2>
    
    @if($classes->isEmpty())
        <div class="info-display">
            <p>Aucune classe assignée pour le moment.</p>
        </div>
    @else
        <div id="classesList">
            @foreach($classes as $classe)
                <div class="list-item" onclick="consulterDetailClasse({{ json_encode($classe) }})">
                    <h4>{{ $classe->nomClasse }}</h4>
                    <p>Année: {{ $classe->annee }} | Niveau: {{ $classe->niveau }}</p>
                    <p>Nombre d'étudiants: {{ $classe->etudiants->count() }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function consulterDetailClasse(classe) {
        alert(`Détails de la classe: ${classe.nomClasse}\nAnnée: ${classe.annee}\nNiveau: ${classe.niveau}`);
    }
</script>
@endsection