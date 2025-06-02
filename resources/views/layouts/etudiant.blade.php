<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Interface Étudiant')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/student-interface.css') }}">
</head>
<body>
    <div class="container">
        <!-- En-tête avec informations étudiant -->
        <div class="header">
            <div class="student-info">
                <h1>Interface Étudiant</h1>
                <p><strong>Nom:</strong> {{ Auth::user()->nom }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Niveau:</strong> {{ Auth::user()->etudiant->niveau ?? 'Non défini' }}</p>
            </div>
        </div>

        <!-- Navigation -->
        <div class="navigation">
            <a href="{{ route('etudiant.dashboard') }}" class="nav-btn {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
                Tableau de Bord
            </a>
            <a href="{{ route('etudiant.classes') }}" class="nav-btn {{ request()->routeIs('etudiant.classes') ? 'active' : '' }}">
                Mes Classes
            </a>
            <a href="{{ route('etudiant.matieres') }}" class="nav-btn {{ request()->routeIs('etudiant.matieres') ? 'active' : '' }}">
                Mes Matières
            </a>
            <a href="{{ route('etudiant.infos') }}" class="nav-btn {{ request()->routeIs('etudiant.infos') ? 'active' : '' }}">
                Infos Personnelles
            </a>
        </div>

        <!-- Contenu principal -->
        @yield('content')
    </div>

    {{-- <script src="{{ asset('js/student-interface.js') }}"></script> --}}
    @yield('scripts')
</body>
</html>
