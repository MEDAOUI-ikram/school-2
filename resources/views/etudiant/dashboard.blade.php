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

@section('title', 'Tableau de Bord Étudiant')


<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-600 rounded-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tableau de Bord Étudiant</h1>
                    <p class="text-gray-600">Bienvenue, {{ $etudiant['nom'] }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="#dashboard" class="tab-link active bg-blue-100 text-blue-700 px-3 py-2 font-medium text-sm rounded-md">
                    Tableau de Bord
                </a>
                <a href="{{ route('etudiant.matieres') }}" class="tab-link text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                    Mes Matières
                </a>
                <a href="{{ route('etudiant.infos') }}" class="tab-link text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                    Mes Informations
                </a>
            </nav>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Matières</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $infos['nbMatieres'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Niveau</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $etudiant['niveau'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Matières Principales</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $matieres->where('coefficient', '>=', 4)->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matières Principales -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Mes Matières Principales</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Matières avec les coefficients les plus élevés</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($matieres->where('coefficient', '>=', 3) as $matiere)
                    <div class="p-4 border rounded-lg bg-white">
                        <h4 class="font-medium">{{ $matiere['nomMatiere'] }}</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-2">
                            Coeff. {{ $matiere['coefficient'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Répartition des coefficients -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Répartition des Coefficients</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Analyse de l'importance de vos matières</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 border rounded-lg bg-red-50">
                        <div class="text-2xl font-bold text-red-600">
                            {{ $matieres->where('coefficient', '>=', 4)->count() }}
                        </div>
                        <div class="text-sm text-red-700">Matières Majeures</div>
                        <div class="text-xs text-red-600">Coefficient ≥ 4</div>
                    </div>
                    <div class="text-center p-4 border rounded-lg bg-orange-50">
                        <div class="text-2xl font-bold text-orange-600">
                            {{ $matieres->where('coefficient', 3)->count() }}
                        </div>
                        <div class="text-sm text-orange-700">Matières Importantes</div>
                        <div class="text-xs text-orange-600">Coefficient = 3</div>
                    </div>
                    <div class="text-center p-4 border rounded-lg bg-blue-50">
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $matieres->where('coefficient', '<=', 2)->count() }}
                        </div>
                        <div class="text-sm text-blue-700">Matières Complémentaires</div>
                        <div class="text-xs text-blue-600">Coefficient ≤ 2</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tab-link.active {
    background-color: #dbeafe;
    color: #1d4ed8;
}
.tab-link:hover {
    color: #374151;
}
</style>

