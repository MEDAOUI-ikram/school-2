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

@section('title', 'Dashboard Enseignant')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Bienvenue, {{ $enseignant['nom'] }}</h2>
                <p class="text-gray-600">{{ $enseignant['specialite'] }} • {{ $enseignant['experience'] }} d'expérience</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Aujourd'hui</p>
                <p class="text-lg font-semibold">{{ date('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Classes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalClasses'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Étudiants</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalEtudiants'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-book text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Matières</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalMatieres'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Heures/Semaine</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['heuresParSemaine'] }}h</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mes Classes -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Mes Classes</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($classes as $classe)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-lg">{{ $classe['nomClasse'] }}</h4>
                            <p class="text-gray-600">{{ $classe['matiere'] }}</p>
                            <p class="text-sm text-gray-500">{{ $classe['nbEtudiants'] }} étudiants</p>
                        </div>
                        <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">
                            {{ $classe['niveau'] }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Matières enseignées -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Matières Enseignées</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($matieres as $matiere)
                <div class="border rounded-lg p-4">
                    <h4 class="font-semibold">{{ $matiere['nomMatiere'] }}</h4>
                    <p class="text-gray-600">{{ $matiere['niveau'] }}</p>
                    <p class="text-sm text-gray-500">{{ $matiere['heuresParSemaine'] }}h par semaine</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection