@extends('layouts.app')

@section('title', 'Mes Informations')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-600 rounded-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mes Informations</h1>
                    <p class="text-gray-600">Gérez vos informations personnelles</p>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="{{ route('etudiant.dashboard') }}" class="tab-link text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                    Tableau de Bord
                </a>
                <a href="{{ route('etudiant.matieres') }}" class="tab-link text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                    Mes Matières
                </a>
                <a href="#infos" class="tab-link active bg-blue-100 text-blue-700 px-3 py-2 font-medium text-sm rounded-md">
                    Mes Informations
                </a>
            </nav>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Formulaire d'informations -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md mb-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informations Personnelles</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Modifiez vos informations personnelles</p>
                </div>
                <button onclick="toggleEdit()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span id="edit-btn-text">Modifier</span>
                </button>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('etudiant.updateInfos') }}" method="POST" id="info-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <div class="mt-1 relative">
                                <div class="info-display flex items-center gap-2 p-2 border rounded-md bg-gray-50">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>{{ $etudiant['nom'] }}</span>
                                </div>
                                <input type="text" name="nom" id="nom" value="{{ $etudiant['nom'] }}" 
                                       class="info-edit hidden shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1 relative">
                                <div class="info-display flex items-center gap-2 p-2 border rounded-md bg-gray-50">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $etudiant['email'] }}</span>
                                </div>
                                <input type="email" name="email" id="email" value="{{ $etudiant['email'] }}" 
                                       class="info-edit hidden shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="niveau" class="block text-sm font-medium text-gray-700">Niveau</label>
                            <div class="mt-1 relative">
                                <div class="info-display flex items-center gap-2 p-2 border rounded-md bg-gray-50">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    </svg>
                                    <span>{{ $etudiant['niveau'] }}</span>
                                </div>
                                <input type="text" name="niveau" id="niveau" value="{{ $etudiant['niveau'] }}" 
                                       class="info-edit hidden shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>

                    <div class="info-edit hidden flex gap-2 pt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Sauvegarder les modifications
                        </button>
                        <button type="button" onclick="cancelEdit()" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistiques personnelles -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Statistiques Académiques</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 border rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">10</div>
                        <div class="text-sm text-gray-600">Matières étudiées</div>
                    </div>
                    <div class="text-center p-4 border rounded-lg">
                        <div class="text-2xl font-bold text-green-600">26</div>
                        <div class="text-sm text-gray-600">Total coefficients</div>
                    </div>
                    <div class="text-center p-4 border rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">2.6</div>
                        <div class="text-sm text-gray-600">Coeff. moyen</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEdit() {
    const displays = document.querySelectorAll('.info-display');
    const edits = document.querySelectorAll('.info-edit');
    const btnText = document.getElementById('edit-btn-text');
    
    displays.forEach(el => el.classList.toggle('hidden'));
    edits.forEach(el => el.classList.toggle('hidden'));
    
    btnText.textContent = btnText.textContent === 'Modifier' ? 'Annuler' : 'Modifier';
}

function cancelEdit() {
    const displays = document.querySelectorAll('.info-display');
    const edits = document.querySelectorAll('.info-edit');
    const btnText = document.getElementById('edit-btn-text');
    
    displays.forEach(el => el.classList.remove('hidden'));
    edits.forEach(el => el.classList.add('hidden'));
    
    btnText.textContent = 'Modifier';
}
</script>

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
