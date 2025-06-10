

@extends('layouts.enseignant')

@section('title', 'Tableau de Bord - Enseignant')

@section('content')
    <!-- Ajouter les meta tags nécessaires dans le head -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
            cursor: pointer;
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

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
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
        .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); }

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

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 8px;
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-btn:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-1px);
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6b7280;
            cursor: pointer;
            padding: 0.25rem;
        }

        .close-btn:hover {
            color: #374151;
        }

        /* Activity Items */
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: #eff6ff;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            color: #64748b;
            font-size: 0.875rem;
        }

        /* Schedule */
        .schedule-grid {
            display: grid;
            grid-template-columns: auto repeat(5, 1fr);
            gap: 1px;
            background: #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .schedule-header {
            background: #374151;
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-align: center;
        }

        .schedule-time {
            background: #f3f4f6;
            padding: 1rem;
            font-weight: 500;
            text-align: center;
        }

        .schedule-cell {
            background: white;
            padding: 0.5rem;
            min-height: 80px;
            position: relative;
        }

        .schedule-event {
            background: #3b82f6;
            color: white;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .text-center {
            text-align: center;
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

            .schedule-grid {
                display: block;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-section">
                <i class="fas fa-chalkboard-teacher logo-icon"></i>
                <h1 class="logo-text">Espace Enseignant</h1>
            </div>
            <div class="user-section">
                <span class="user-name" id="teacherName">
                    {{ Auth::user()->nom ?? 'Enseignant' }} {{ Auth::user()->prenom ?? '' }}
                </span>
                <i class="fas fa-user-circle user-avatar" onclick="showProfile()"></i>
            </div>
        </div>
    </nav>

    <!-- Tab Navigation -->
    <div class="tab-nav">
        <div class="tab-container">
            <a class="tab-link active" onclick="showTab('dashboard')">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            <a class="tab-link" onclick="showTab('classes')">
                <i class="fas fa-users"></i>Mes Classes
            </a>
            <a class="tab-link" onclick="showTab('etudiants')">
                <i class="fas fa-user-graduate"></i>Étudiants
            </a>
            <a class="tab-link" onclick="showTab('emploi')">
                <i class="fas fa-calendar-alt"></i>Emploi du Temps
            </a>
            <a class="tab-link" onclick="showTab('notes')">
                <i class="fas fa-clipboard-list"></i>Notes
            </a>
            <a class="tab-link" onclick="showTab('profil')">
                <i class="fas fa-user-cog"></i>Mon Profil
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Dashboard Tab -->
        <div id="dashboard" class="tab-content active">
            <!-- Hero Section -->
            <section class="hero-section">
                <h2 class="hero-title">Bienvenue dans votre espace enseignant</h2>
                <!-- <p class="hero-subtitle">
                    Gérez vos classes, suivez vos étudiants, consultez votre emploi du temps et bien plus encore.
                </p> -->
            </section>

            <!-- Statistics Cards -->
            <section class="stats-grid">
                <div class="stat-card" onclick="showTab('classes')">
                    <div class="stat-header">
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="totalClasses">
                        {{ isset($stats['total_classes']) ? $stats['total_classes'] : ($classes ? $classes->count() : 0) }}
                    </div>
                    <div class="stat-label">Classes actives</div>
                </div>
                
                <div class="stat-card" onclick="showTab('etudiants')">
                    <div class="stat-header">
                        <div class="stat-icon indigo">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="totalEtudiants">
                        {{ isset($stats['total_etudiants']) ? $stats['total_etudiants'] : ($etudiants ? $etudiants->count() : 0) }}
                    </div>
                    <div class="stat-label">Étudiants inscrits</div>
                </div>
                
                <div class="stat-card" onclick="showTab('notes')">
                    <div class="stat-header">
                        <div class="stat-icon cyan">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="notesEnAttente">
                        {{ isset($stats['notes_en_attente']) ? $stats['notes_en_attente'] : ($notes ? $notes->count() : 0) }}
                    </div>
                    <div class="stat-label">Notes en attente</div>
                </div>
                
                <div class="stat-card" onclick="showTab('emploi')">
                    <div class="stat-header">
                        <div class="stat-icon sky">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="coursAujourdhui">
                        {{ isset($stats['cours_aujourdhui']) ? $stats['cours_aujourdhui'] : (isset($emploi_temps) ? collect($emploi_temps)->where('jour', now()->locale('fr')->dayName)->count() : 0) }}
                    </div>
                    <div class="stat-label">Cours aujourd'hui</div>
                </div>
            </section>

            <!-- Quick Actions -->
            <section class="content-section">
                <h3 class="section-title">
                    <i class="fas fa-bolt section-icon"></i>
                    Actions rapides
                </h3>
                <div class="quick-actions">
                    <button class="action-btn" onclick="showAddNoteModal()">
                        <i class="fas fa-plus"></i>
                        Ajouter une note
                    </button>
                    <button class="action-btn" onclick="showTab('emploi')">
                        <i class="fas fa-eye"></i>
                        Voir l'emploi du temps
                    </button>
                    <button class="action-btn" onclick="showTab('classes')">
                        <i class="fas fa-users"></i>
                        Gérer les classes
                    </button>
                    <button class="action-btn" onclick="showStats()">
                        <i class="fas fa-chart-bar"></i>
                        Statistiques
                    </button>
                </div>
            </section>

            <!-- Recent Activity -->
            <section class="content-section">
                <h3 class="section-title">
                    <i class="fas fa-clock section-icon"></i>
                    Activité récente
                </h3>
                <div class="activity-list" id="recentActivity">
                    @forelse($activities ?? [] as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="{{ $activity->icon ?? 'fas fa-info' }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity->title ?? $activity->description ?? 'Activité' }}</div>
                                <div class="activity-time">
                                    {{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : 'Récemment' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Bienvenue dans votre espace enseignant</div>
                                <div class="activity-time">Commencez à utiliser l'application pour voir vos activités</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <!-- Classes Tab -->
        <div id="classes" class="tab-content">
            <section class="content-section">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="section-title">
                        <i class="fas fa-users section-icon"></i>
                        Mes Classes
                    </h3>
                    <button class="btn" onclick="showAddClassModal()">
                        <i class="fas fa-plus"></i>
                        Nouvelle classe
                    </button>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Étudiants</th>
                            <th>Salle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="classesTable">
                        @forelse($classes ?? [] as $classe)
                            <tr>
                                <td>{{ $classe->nom ?? 'N/A' }}</td>
                                <td>{{ $classe->matiere->nom ?? $classe->matiere ?? 'N/A' }}</td>
                                <td>{{ isset($classe->etudiants) ? $classe->etudiants->count() : ($classe->etudiants_count ?? 0) }}</td>
                                <td>{{ $classe->salle ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn" style="padding: 0.5rem; margin-right: 0.5rem;" onclick="editClass({{ $classe->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-secondary" style="padding: 0.5rem;" onclick="deleteClass({{ $classe->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucune classe trouvée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>

        <!-- Étudiants Tab -->
        <div id="etudiants" class="tab-content">
            <section class="content-section">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="section-title">
                        <i class="fas fa-user-graduate section-icon"></i>
                        Liste des Étudiants
                    </h3>
                    <div style="display: flex; gap: 1rem;">
                        <select id="classFilter" class="form-input" style="width: auto;" onchange="filterStudents()">
                            <option value="">Toutes les classes</option>
                            @foreach($classes ?? [] as $classe)
                                <option value="{{ $classe->nom }}">{{ $classe->nom }}</option>
                            @endforeach
                        </select>
                        <button class="btn" onclick="showAddStudentModal()">
                            <i class="fas fa-plus"></i>
                            Nouvel étudiant
                        </button>
                    </div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nom Complet</th>
                            <th>Classe</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTable">
                        @forelse($etudiants ?? [] as $etudiant)
                            <tr data-class="{{ isset($etudiant->classe) ? $etudiant->classe->nom : ($etudiant->classe_nom ?? '') }}">
                                <td>{{ $etudiant->nom ?? 'N/A' }} {{ $etudiant->prenom ?? '' }}</td>
                                <td>{{ isset($etudiant->classe) ? $etudiant->classe->nom : ($etudiant->classe_nom ?? 'N/A') }}</td>
                                <td>{{ $etudiant->email ?? 'N/A' }}</td>
                                <td>{{ $etudiant->telephone ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn" style="padding: 0.5rem; margin-right: 0.5rem;" onclick="editStudent({{ $etudiant->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-secondary" style="padding: 0.5rem;" onclick="deleteStudent({{ $etudiant->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun étudiant trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>

        <!-- Emploi du Temps Tab -->
        <div id="emploi" class="tab-content">
            <section class="content-section">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt section-icon"></i>
                    Emploi du Temps - Semaine du {{ now()->startOfWeek()->format('d') }} au {{ now()->endOfWeek()->format('d M Y') }}
                </h3>
                <div class="schedule-grid" id="scheduleGrid">
                    <!-- Header -->
                    <div class="schedule-header">Horaire</div>
                    <div class="schedule-header">Lundi</div>
                    <div class="schedule-header">Mardi</div>
                    <div class="schedule-header">Mercredi</div>
                    <div class="schedule-header">Jeudi</div>
                    <div class="schedule-header">Vendredi</div>
                    
                    @php
                        $times = ['08:00', '10:00', '14:00', '16:00'];
                        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
                    @endphp
                    
                    @foreach($times as $time)
                        <div class="schedule-time">{{ $time }}</div>
                        @foreach($days as $day)
                            @php
                                $cours = null;
                                if(isset($emploi_temps)) {
                                    $cours = collect($emploi_temps)->first(function($c) use ($day, $time) {
                                        return ($c->jour ?? '') === $day && ($c->heure_debut ?? '') === $time;
                                    });
                                }
                            @endphp
                            <div class="schedule-cell">
                                @if($cours)
                                    <div class="schedule-event">
                                        {{ isset($cours->classe) ? $cours->classe->nom : ($cours->classe_nom ?? 'N/A') }}<br>
                                        {{ isset($cours->matiere) ? $cours->matiere->nom : ($cours->matiere_nom ?? 'N/A') }}<br>
                                        {{ $cours->salle ?? 'N/A' }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Notes Tab -->
        <div id="notes" class="tab-content">
            <section class="content-section">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="section-title">
                        <i class="fas fa-clipboard-list section-icon"></i>
                        Gestion des Notes
                    </h3>
                    <button class="btn" onclick="showAddNoteModal()">
                        <i class="fas fa-plus"></i>
                        Ajouter une note
                    </button>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Type</th>
                            <th>Note</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="notesTable">
                        @forelse($notes ?? [] as $note)
                            <tr>
                                <td>
                                    {{ isset($note->etudiant) ? $note->etudiant->nom : ($note->etudiant_nom ?? 'N/A') }} 
                                    {{ isset($note->etudiant) ? $note->etudiant->prenom : ($note->etudiant_prenom ?? '') }}
                                </td>
                                <td>
                                    {{ isset($note->etudiant->classe) ? $note->etudiant->classe->nom : ($note->classe_nom ?? 'N/A') }}
                                </td>
                                <td>{{ $note->type ?? 'N/A' }}</td>
                                <td>{{ $note->note ?? 0 }}/20</td>
                                <td>
                                    {{ isset($note->created_at) ? $note->created_at->format('d/m/Y') : (isset($note->date) ? $note->date : 'N/A') }}
                                </td>
                                <td>
                                    <button class="btn" style="padding: 0.5rem; margin-right: 0.5rem;" onclick="editNote({{ $note->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-secondary" style="padding: 0.5rem;" onclick="deleteNote({{ $note->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune note trouvée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>

        <!-- Profil Tab -->
        <div id="profil" class="tab-content">
            <section class="content-section">
                <h3 class="section-title">
                    <i class="fas fa-user-cog section-icon"></i>
                    Mon Profil
                </h3>
                <form id="profileForm" onsubmit="updateProfile(event)">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div>
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-input" id="profileNom" name="nom" value="{{ Auth::user()->nom ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Prénom</label>
                                <input type="text" class="form-input" id="profilePrenom" name="prenom" value="{{ Auth::user()->prenom ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" id="profileEmail" name="email" value="{{ Auth::user()->email ?? '' }}">
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-input" id="profilePhone" name="telephone" value="{{ Auth::user()->telephone ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Établissement</label>
                                <input type="text" class="form-input" id="profileSchool" name="etablissement" value="{{ Auth::user()->etablissement ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Spécialité</label>
                                <input type="text" class="form-input" id="profileSpecialite" name="specialite" value="{{ Auth::user()->specialite ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i>
                        Sauvegarder
                    </button>
                </form>
            </section>
        </div>
    </main>

    <!-- Add Note Modal -->
    <div id="addNoteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter une Note</h3>
                <button class="close-btn" onclick="closeModal('addNoteModal')">&times;</button>
            </div>
            <form onsubmit="addNote(event)">
                @csrf
                <div class="form-group">
                    <label class="form-label">Classe</label>
                    <select class="form-input" id="noteClass" name="classe_id" required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes ?? [] as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Étudiant</label>
                    <select class="form-input" id="noteStudent" name="etudiant_id" required>
                        <option value="">Sélectionner un étudiant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Type d'évaluation</label>
                    <select class="form-input" id="noteType" name="type" required>
                        <option value="">Sélectionner le type</option>
                        <option value="Contrôle">Contrôle</option>
                        <option value="Devoir">Devoir</option>
                        <option value="Examen">Examen</option>
                        <option value="Participation">Participation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Note (/20)</label>
                    <input type="number" class="form-input" id="noteValue" name="note" min="0" max="20" step="0.25" required>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i>
                        Enregistrer
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addNoteModal')">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Class Modal -->
    <div id="addClassModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Nouvelle Classe</h3>
                <button class="close-btn" onclick="closeModal('addClassModal')">&times;</button>
            </div>
            <form onsubmit="addClass(event)">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nom de la classe</label>
                    <input type="text" class="form-input" id="className" name="nom" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Matière</label>
                    <select class="form-input" id="classSubject" name="matiere_id" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres ?? [] as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Salle</label>
                    <input type="text" class="form-input" id="classRoom" name="salle" required>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i>
                        Créer
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addClassModal')">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Nouvel Étudiant</h3>
                <button class="close-btn" onclick="closeModal('addStudentModal')">&times;</button>
            </div>
            <form onsubmit="addStudent(event)">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-input" id="studentNom" name="nom" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Prénom</label>
                    <input type="text" class="form-input" id="studentPrenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Classe</label>
                    <select class="form-input" id="studentClass" name="classe_id" required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes ?? [] as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="studentEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" class="form-input" id="studentPhone" name="telephone">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i>
                        Ajouter
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addStudentModal')">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            // Set up CSRF token for all AJAX requests
            if (typeof $ !== 'undefined') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            }

            // Load students when class is selected in note modal
            const noteClassSelect = document.getElementById('noteClass');
            if (noteClassSelect) {
                noteClassSelect.addEventListener('change', function() {
                    loadStudentsByClass(this.value, 'noteStudent');
                });
            }
        });

        // Tab navigation
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(tab => tab.classList.remove('active'));
            
            // Remove active class from all tab links
            const tabLinks = document.querySelectorAll('.tab-link');
            tabLinks.forEach(link => link.classList.remove('active'));
            
            // Show selected tab content
            const targetTab = document.getElementById(tabName);
            if (targetTab) {
                targetTab.classList.add('active');
            }
            
            // Add active class to clicked tab link
            if (event && event.target) {
                const clickedLink = event.target.closest('.tab-link');
                if (clickedLink) {
                    clickedLink.classList.add('active');
                }
            }
        }

        // Load students by class
        function loadStudentsByClass(classeId, selectId) {
            const studentSelect = document.getElementById(selectId);
            if (!studentSelect) return;
            
            studentSelect.innerHTML = '<option value="">Sélectionner un étudiant</option>';
            
            if (classeId) {
                fetch(`/enseignant/classes/${classeId}/etudiants`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (Array.isArray(data)) {
                            data.forEach(student => {
                                const option = document.createElement('option');
                                option.value = student.id;
                                option.textContent = `${student.nom} ${student.prenom}`;
                                studentSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors du chargement des étudiants');
                    });
            }
        }

        // Modal functions
        function showAddNoteModal() {
            const modal = document.getElementById('addNoteModal');
            if (modal) modal.classList.add('active');
        }

        function showAddClassModal() {
            const modal = document.getElementById('addClassModal');
            if (modal) modal.classList.add('active');
        }

        function showAddStudentModal() {
            const modal = document.getElementById('addStudentModal');
            if (modal) modal.classList.add('active');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.remove('active');
        }

        // Add note function
        function addNote(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            
            fetch('/enseignant/notes', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Note ajoutée avec succès !');
                    closeModal('addNoteModal');
                    location.reload();
                } else {
                    alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'ajout de la note');
            });
        }

        // Add class function
        function addClass(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            
            fetch('/enseignant/classes', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Classe créée avec succès !');
                    closeModal('addClassModal');
                    location.reload();
                } else {
                    alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la création de la classe');
            });
        }

        // Add student function
        function addStudent(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            
            fetch('/enseignant/etudiants', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Étudiant ajouté avec succès !');
                    closeModal('addStudentModal');
                    location.reload();
                } else {
                    alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'ajout de l\'étudiant');
            });
        }

        // Filter students
        function filterStudents() {
            const filterValue = document.getElementById('classFilter').value;
            const rows = document.querySelectorAll('#studentsTable tr[data-class]');
            
            rows.forEach(row => {
                const classValue = row.getAttribute('data-class');
                if (!filterValue || classValue === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Edit functions
        function editClass(id) {
            window.location.href = `/enseignant/classes/${id}/edit`;
        }

        function editStudent(id) {
            window.location.href = `/enseignant/etudiants/${id}/edit`;
        }

        function editNote(id) {
            window.location.href = `/enseignant/notes/${id}/edit`;
        }

        // Delete functions
        function deleteClass(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')) {
                fetch(`/enseignant/classes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Classe supprimée avec succès !');
                        location.reload();
                    } else {
                        alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression');
                });
            }
        }

        function deleteStudent(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
                fetch(`/enseignant/etudiants/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Étudiant supprimé avec succès !');
                        location.reload();
                    } else {
                        alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression');
                });
            }
        }

        function deleteNote(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette note ?')) {
                fetch(`/enseignant/notes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Note supprimée avec succès !');
                        location.reload();
                    } else {
                        alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression');
                });
            }
        }

        // Profile functions
        function showProfile() {
            showTab('profil');
        }

        function updateProfile(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            
            fetch('/enseignant/profil', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Profil mis à jour avec succès !');
                    const teacherNameElement = document.getElementById('teacherName');
                    if (teacherNameElement && data.user) {
                        teacherNameElement.textContent = `${data.user.nom} ${data.user.prenom}`;
                    }
                } else {
                    alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la mise à jour du profil');
            });
        }

        // Stats function
        function showStats() {
            fetch('/enseignant/statistiques')
                .then(response => response.json())
                .then(data => {
                    const message = `Statistiques:\n\n` +
                        `Total étudiants: ${data.total_etudiants || 0}\n` +
                        `Total classes: ${data.total_classes || 0}\n` +
                        `Total notes: ${data.total_notes || 0}\n` +
                        `Moyenne générale: ${data.moyenne_generale || 0}/20`;
                    alert(message);
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors du chargement des statistiques');
                });
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>

    <!-- Add jQuery for AJAX if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add Font Awesome for icons if not already included -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection