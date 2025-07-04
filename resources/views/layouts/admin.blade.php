<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Système Éducatif</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
        }
        .nav-link.active {
            background-color: #007bff;
            color: white !important;
        }
        .table th {
            border-top: none;
            font-weight: 600;
        }
        .badge {
            font-size: 0.75em;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-graduation-cap"></i> Admin Panel
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.enseignants.*') || request()->routeIs('admin.etudiants.*') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-users"></i> Utilisateurs
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.enseignants.index') }}">
                                <i class="fas fa-chalkboard-teacher"></i> Enseignants
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.etudiants.index') }}">
                                <i class="fas fa-user-graduate"></i> Étudiants
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.matieres.*') || request()->routeIs('admin.classes.*') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-book"></i> Pédagogie
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.matieres.index') }}">
                                <i class="fas fa-book-open"></i> Matières
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.classes.index') }}">
                                <i class="fas fa-door-open"></i> Classes
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.affectations.*') ? 'active' : '' }}"
                           href="{{ route('admin.affectations.index') }}">
                            <i class="fas fa-link"></i> Affectations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.annees.*') ? 'active' : '' }}"
                           href="{{ route('admin.annees.index') }}">
                            <i class="fas fa-calendar-alt"></i> Années
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.rapports.*') ? 'active' : '' }}"
                           href="{{ route('admin.rapports.index') }}">
                            <i class="fas fa-chart-bar"></i> Rapports
                        </a>
                    </li>
                </ul>

                <!-- Recherche globale -->
                <form class="d-flex me-3" id="global-search-form">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Rechercher..." id="global-search">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <div>{{ Auth::user()->name }}</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-cog"></i> Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item"  href=""><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



  <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>


    <!-- Contenu principal -->
    <div class="container-fluid mt-4">
        <!-- Messages flash -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Erreurs de validation :</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Configuration CSRF pour AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Recherche globale
        $('#global-search-form').on('submit', function(e) {
            e.preventDefault();
            const query = $('#global-search').val();
            if (query.length > 2) {
                $.get('{{ route("admin.search") }}', { q: query })
                    .done(function(data) {
                        console.log('Résultats de recherche:', data);
                    })
                    .fail(function() {
                        console.log('Erreur lors de la recherche');
                    });
            }
        });

        // Auto-hide alerts après 5 secondes
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
