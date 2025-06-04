@extends('layouts.student')

@section('title', 'Mes Matières - Étudiant')

@section('content')
<div class="section">
    <h2>Mes Matières</h2>
    
    @if($matieres->isEmpty())
        <div class="info-display">
            <p>Aucune matière disponible.</p>
        </div>
    @else
        <div id="matieresList">
            @foreach($matieres as $matiere)
                <div class="list-item" onclick="consulterDetailMatiere({{ json_encode($matiere) }})">
                    <h4>{{ $matiere->nomMatiere }}</h4>
                    <p>Coefficient: {{ $matiere->coefficient }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function consulterDetailMatiere(matiere) {
        alert(`Détails de la matière: ${matiere.nomMatiere}\nCoefficient: ${matiere.coefficient}`);
    }
</script>
@endsection