@extends('layouts.student') {{-- Ou layouts.enseignant si tu en as un spécifique --}}

@section('title', 'Mes Matières')

@section('content')
<div class="section">
    <h2 class="text-2xl font-bold mb-4">Mes Matières</h2>

    @if($matieres->isEmpty())
        <p>Aucune matière trouvée.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($matieres as $matiere)
                <div class="bg-white shadow rounded p-4">
                    <h3 class="text-xl font-semibold">{{ $matiere->nom_matiere }}</h3>
                    <p><strong>Heures/semaine:</strong> {{ $matiere->heures_par_semaine }}</p>
                    <p><strong>Classe:</strong> {{ $matiere->classe->nom_classe ?? 'Non attribuée' }}</p>
                    <p><strong>Code:</strong> {{ $matiere->code ?? 'N/A' }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
