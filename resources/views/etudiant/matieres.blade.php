@extends('layouts.etudiant') {{-- Utilisez le layout que vous avez créé --}}

@section('title', 'Mes Matières')

@section('content')
<div class="section">
    <h2 class="text-2xl font-bold mb-4">Mes Matières</h2>

    @if($matieres->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <p>Aucune matière trouvée.</p>
            <p class="text-sm">Vérifiez que les seeders ont été exécutés avec: <code>php artisan db:seed</code></p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($matieres as $matiere)
                <div class="bg-white shadow rounded p-4 border">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ $matiere->nom ?? $matiere->nomMatiere ?? 'Matière sans nom' }}
                    </h3>
                    
                    @if(isset($matiere->coefficient))
                        <p><strong>Coefficient:</strong> {{ $matiere->coefficient }}</p>
                    @endif
                    
                    @if(isset($matiere->heures_par_semaine))
                        <p><strong>Heures/semaine:</strong> {{ $matiere->heures_par_semaine }}</p>
                    @endif
                    
                    @if(isset($matiere->classe))
                        <p><strong>Classe:</strong> {{ $matiere->classe->nom ?? $matiere->classe->nom_classe ?? 'Non attribuée' }}</p>
                    @endif
                    
                    @if(isset($matiere->code))
                        <p><strong>Code:</strong> {{ $matiere->code }}</p>
                    @endif
                    
                    <div class="mt-2 text-sm text-gray-500">
                        <p>ID: {{ $matiere->id }}</p>
                        @if(isset($matiere->created_at))
                            <p>Créé: {{ $matiere->created_at->format('d/m/Y') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4 text-sm text-gray-600">
            <p>Total: {{ $matieres->count() }} matière(s) trouvée(s)</p>
        </div>
    @endif
</div>

{{-- Debug section (à supprimer en production) --}}
@if(config('app.debug'))
    <div class="mt-8 p-4 bg-gray-100 rounded">
        <h3 class="font-bold">Debug Info:</h3>
        <pre>{{ json_encode($matieres->toArray(), JSON_PRETTY_PRINT) }}</pre>
    </div>
@endif
@endsection