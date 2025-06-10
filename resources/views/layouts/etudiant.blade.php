<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Interface Étudiant')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS pour un style de base -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background: linear-gradient(135deg,rgb(122, 156, 220) 0%,rgb(119, 156, 243) 100%);
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .navigation {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-icon {
        background: #dbeafe;
        padding: 12px;
        border-radius: 10px;
        color:rgb(138, 163, 217);
    }

    .header-text h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .header-text p {
        color:rgb(169, 191, 240);
        font-size: 14px;
    }
        .nav-btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color:rgb(71, 143, 206);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .nav-btn:hover, .nav-btn.active {
            background-color:rgb(72, 132, 227);
            color: white;
            text-decoration: none;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- <div class="container">
        <! En-tête avec informations étudiant -->
        <!-- <div class="header">
            <div class="student-info">
                <h1><i class="fas fa-graduation-cap"></i> Interface Étudiant</h1>
                @if(Auth::check())
                    <p><strong>Nom:</strong> {{ Auth::user()->nom ?? 'Non défini' }} {{ Auth::user()->prenom ?? '' }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->courriel ?? Auth::user()->email ?? 'Non défini' }}</p>
                    <p><strong>Classe:</strong> 
                        @if(Auth::user()->classe_id && isset($mesClasses) && $mesClasses->count() > 0)
                            {{ $mesClasses->first()->nom ?? 'Non définie' }}
                        @else
                            Non définie
                        @endif
                    </p>
                @else
                    <p>Utilisateur non connecté</p>
                @endif
            </div>
        </div> --> 

        <!-- Navigation -->
        <div class="navigation">
            <a href="{{ route('etudiant.dashboard') }}" class="nav-btn {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Tableau de Bord
            </a>
            <a href="{{ route('etudiant.classes') }}" class="nav-btn {{ request()->routeIs('etudiant.classes') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Mes Classes
            </a>
            <a href="{{ route('etudiant.matieres') }}" class="nav-btn {{ request()->routeIs('etudiant.matieres') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Mes Matières
            </a>
            <a href="{{ route('etudiant.emploi') }}" class="nav-btn {{ request()->routeIs('etudiant.emploi') ? 'active' : '' }}">
                <i class="fas fa-calendar"></i> Emploi du Temps
            </a>
            <a href="{{ route('etudiant.profil') }}" class="nav-btn {{ request()->routeIs('etudiant.profil') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Mon Profil
            </a>
        </div>

        <!-- Contenu principal -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>