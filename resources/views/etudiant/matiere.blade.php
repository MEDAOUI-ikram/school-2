@extends('layouts.app')

@section('title', 'Mes Matières')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-600 rounded-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mes Matières</h1>
                    <p class="text-gray-600">Liste complète de vos matières avec coefficients</p>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="{{ route('etudiant.dashboard') }}" class="tab-link text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                    Tableau de Bord
                </a>
                <a href="#matieres" class="tab-link active bg-blue-100 text-blue-700 px-3 py-2 font-medium text-sm rounded-md">
                    Mes Matières
                </a>
                <a href="{{ route('etudiant.infos') }}" class="tab-link text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                    Mes Informations
                </a>
            </nav>
        </div>

        <!-- Liste des matières -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Toutes mes matières</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ count($matieres) }} matières au total</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($matieres as $matiere)
                    <div class="p-4 border rounded-lg bg-white hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg 
                                    @if($matiere['coefficient'] >= 4) bg-red-100 
                                    @elseif($matiere['coefficient'] == 3) bg-orange-100 
                                    @else bg-blue-100 @endif">
                                    <svg class="h-5 w-5 
                                        @if($matiere['coefficient'] >= 4) text-red-600 
                                        @elseif($matiere['coefficient'] == 3) text-orange-600 
                                        @else text-blue-600 @endif" 
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $matiere['nomMatiere'] }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-2
                                        @if($matiere['coefficient'] >= 4) bg-red-100 text-red-800
                                        @elseif($matiere['coefficient'] >= 3) bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        Coefficient {{ $matiere['coefficient'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Statistiques -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <span class="font-medium">Total des coefficients: {{ collect($matieres)->sum('coefficient') }}</span>
                        </div>
                        <div class="text-sm text-blue-700">
                            Moyenne des coefficients: {{ number_format(collect($matieres)->avg('coefficient'), 1) }}
                        </div>
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
@endsection
