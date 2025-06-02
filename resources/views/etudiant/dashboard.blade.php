 {{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Etudiant Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>مرحبا بك Etudiant!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}




@extends('layouts.etudiant')

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
    <div class="etudiant-summary">
        <h3>Mes Informations</h3>
        <div class="info-display">
            @foreach($infos as $key => $value)
                <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
