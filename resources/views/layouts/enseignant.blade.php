<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Enseignant - Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #334155;
            min-height: 100vh;
        }

        /* Navigation Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            color: #3b82f6;
            font-size: 1.875rem;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-name {
            font-weight: 500;
            color: #475569;
        }

        .user-avatar {
            color: #3b82f6;
            font-size: 1.875rem;
            cursor: pointer;
        }

        /* Tab Navigation */
        .tab-nav {
            background: white;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            position: sticky;
            top: 4rem;
            z-index: 40;
        }

        .tab-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            gap: 2rem;
            overflow-x: auto;
        }

        .tab-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 0;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .tab-link:hover {
            color: #3b82f6;
        }

        .tab-link.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(148, 163, 184, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .stat-icon.indigo { background: linear-gradient(135deg, #6366f1, #4338ca); }
        .stat-icon.cyan { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .stat-icon.sky { background: linear-gradient(135deg, #0ea5e9, #0284c7); }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #64748b;
            font-weight: 500;
        }

        /* Content Sections */
        .content-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(148, 163, 184, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            color: #3b82f6;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .data-table th,
        .data-table td {
            text-align: left;
            padding: 1rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        }

        .data-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }

        .data-table tr:hover {
            background: #f8fafc;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6b7280;
        }

        .btn-secondary:hover {
            background: #374151;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .tab-container {
                gap: 1rem;
            }
            
            .nav-container {
                padding: 0 1rem;
            }
            
            .main-content {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <!-- <nav class="navbar">
        <div class="nav-container">
            <div class="logo-section">
                <i class="fas fa-chalkboard-teacher logo-icon"></i>
                <h1 class="logo-text">Espace Enseignant</h1>
            </div>
            <div class="user-section">
                <span class="user-name">{{ $enseignant->nom ?? 'Enseignant' }} {{ $enseignant->prenom ?? '' }}</span>
                <i class="fas fa-user-circle user-avatar"></i>
            </div>
        </div>
    </nav> -->

    <!-- Tab Navigation -->
    <!-- <div class="tab-nav">
        <div class="tab-container">
            <a href="{{ route('enseignant.dashboard') }}" class="tab-link {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            <a href="{{ route('enseignant.classes') }}" class="tab-link {{ request()->routeIs('enseignant.classes') ? 'active' : '' }}">
                <i class="fas fa-users"></i>Mes Classes
            </a>
            <a href="{{ route('enseignant.etudiants') }}" class="tab-link {{ request()->routeIs('enseignant.etudiants') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i>Étudiants
            </a>
            <a href="{{ route('enseignant.emploi-du-temps') }}" class="tab-link {{ request()->routeIs('enseignant.emploi-du-temps') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>Emploi du Temps
            </a>
           
            <a href="{{ route('enseignant.infos') }}" class="tab-link {{ request()->routeIs('enseignant.infos') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>Mon Profil
            </a>
        </div>
    </div> -->

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Configuration CSRF pour AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
