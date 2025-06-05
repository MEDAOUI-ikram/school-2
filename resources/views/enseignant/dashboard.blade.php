<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Enseignant Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>مرحبا بك Enseignant!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@extends('layouts.enseignant')

@section('title', 'Tableau de Bord - Enseignant')

@section('content')
<div class="section">
    <h2>Tableau de Bord Enseignant</h2>

    <div class="grid">
        <div>
            <h3>Résumé des Classes</h3>
            <div class="info-display">
                <p>Nombre total de classes : <strong>{{ $stats['totalClasses'] }}</strong></p>
                <p>Nombre total d'étudiants : <strong>{{ $stats['totalEtudiants'] }}</strong></p>
                <a href="{{ route('enseignant.classes') }}" class="btn">Voir les classes</a>
            </div>
        </div>

        <div>
            <h3>Résumé des Matières</h3>
            <div class="info-display">
                <p>Nombre de matières : <strong>{{ $stats['totalMatieres'] }}</strong></p>
                <p>Heures par semaine : <strong>{{ $stats['heuresParSemaine'] }}</strong></p>
                <a href="{{ route('enseignant.matieres') }}" class="btn">Voir les matières</a>
            </div>
        </div>
    </div>

    <div class="teacher-summary mt-5">
        <h3>Mes Informations</h3>
        <div class="info-display">
            <p><strong>Nom :</strong> {{ $enseignant->nom }} {{ $enseignant->prenom }}</p>
            <p><strong>Email :</strong> {{ $enseignant->email }}</p>
            <p><strong>Spécialité :</strong> {{ $enseignant->specialite ?? 'Non définie' }}</p>
            <p><strong>Téléphone :</strong> {{ $enseignant->telephone ?? '-' }}</p>
            <p><strong>Date d'embauche :</strong> {{ $enseignant->date_embauche ? $enseignant->date_embauche->format('d/m/Y') : '-' }}</p>
            <a href="{{ route('enseignant.infos') }}" class="btn">Modifier mes informations</a>
        </div>
    </div>
</div>
@endsection
