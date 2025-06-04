<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Enseignant')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    <h1 class="text-xl font-bold">Espace Enseignant</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm">Prof. Fatima Zahra</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Navigation Tabs -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="flex space-x-8 py-4">
                <a href="{{ route('enseignant.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('enseignant.classes') }}" 
                   class="nav-link {{ request()->routeIs('enseignant.classes') ? 'active' : '' }}">
                    <i class="fas fa-users mr-2"></i>Mes Classes
                </a>
                <a href="{{ route('enseignant.etudiants') }}" 
                   class="nav-link {{ request()->routeIs('enseignant.etudiants') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate mr-2"></i>Étudiants
                </a>
                <a href="{{ route('enseignant.emploi-du-temps') }}" 
                   class="nav-link {{ request()->routeIs('enseignant.emploi-du-temps') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt mr-2"></i>Emploi du Temps
                </a>
                <a href="{{ route('enseignant.notes') }}" 
                   class="nav-link {{ request()->routeIs('enseignant.notes') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list mr-2"></i>Notes
                </a>
                <a href="{{ route('enseignant.infos') }}" 
                   class="nav-link {{ request()->routeIs('enseignant.infos') ? 'active' : '' }}">
                    <i class="fas fa-user-cog mr-2"></i>Mes Infos
                </a>
            </nav>
        </div>
    </div>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <style>
        .nav-link {
            @apply text-gray-600 hover:text-indigo-600 px-3 py-2 font-medium text-sm rounded-md transition-colors duration-200 flex items-center;
        }
        .nav-link.active {
            @apply bg-indigo-100 text-indigo-700;
        }
    </style>
</body>
</html>