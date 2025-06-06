

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Espace Enseignant - Dashboard</title>
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
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-section">
                <i class="fas fa-chalkboard-teacher logo-icon"></i>
                <h1 class="logo-text">Espace Enseignant</h1>
            </div>
            <div class="user-section">
                <span class="user-name" id="teacherName">Prof. Fatima Zahra</span>
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
                <p class="hero-subtitle">
                    Gérez vos classes, suivez vos étudiants, consultez votre emploi du temps et bien plus encore.
                </p>
            </section>

            <!-- Statistics Cards -->
            <section class="stats-grid">
                <div class="stat-card" onclick="showTab('classes')">
                    <div class="stat-header">
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="totalClasses">8</div>
                    <div class="stat-label">Classes actives</div>
                </div>
                
                <div class="stat-card" onclick="showTab('etudiants')">
                    <div class="stat-header">
                        <div class="stat-icon indigo">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="totalEtudiants">187</div>
                    <div class="stat-label">Étudiants inscrits</div>
                </div>
                
                <div class="stat-card" onclick="showTab('notes')">
                    <div class="stat-header">
                        <div class="stat-icon cyan">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="notesEnAttente">12</div>
                    <div class="stat-label">Notes en attente</div>
                </div>
                
                <div class="stat-card" onclick="showTab('emploi')">
                    <div class="stat-header">
                        <div class="stat-icon sky">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="stat-value" id="coursAujourdhui">3</div>
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
                    <!-- Activities will be populated by JavaScript -->
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
                        <!-- Classes will be populated by JavaScript -->
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
                        <!-- Students will be populated by JavaScript -->
                    </tbody>
                </table>
            </section>
        </div>

        <!-- Emploi du Temps Tab -->
        <div id="emploi" class="tab-content">
            <section class="content-section">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt section-icon"></i>
                    Emploi du Temps - Semaine du 3 au 7 Juin 2025
                </h3>
                <div class="schedule-grid" id="scheduleGrid">
                    <!-- Schedule will be populated by JavaScript -->
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
                        <!-- Notes will be populated by JavaScript -->
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
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div>
                        <div class="form-group">
                            <label class="form-label">Nom complet</label>
                            <input type="text" class="form-input" id="profileName" value="Prof. Fatima Zahra Benali">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" id="profileEmail" value="f.benali@ecole.ma">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-input" id="profilePhone" value="+212 6 12 34 56 78">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label class="form-label">Matières enseignées</label>
                            <input type="text" class="form-input" id="profileSubjects" value="Mathématiques, Physique">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Établissement</label>
                            <input type="text" class="form-input" id="profileSchool" value="Lycée Hassan II">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Années d'expérience</label>
                            <input type="number" class="form-input" id="profileExperience" value="12">
                        </div>
                    </div>
                </div>
                <button class="btn" onclick="updateProfile()">
                    <i class="fas fa-save"></i>
                    Sauvegarder
                </button>
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
                <div class="form-group">
                    <label class="form-label">Classe</label>
                    <select class="form-input" id="noteClass" required>
                        <option value="">Sélectionner une classe</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Étudiant</label>
                    <select class="form-input" id="noteStudent" required>
                        <option value="">Sélectionner un étudiant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Type d'évaluation</label>
                    <select class="form-input" id="noteType" required>
                        <option value="">Sélectionner le type</option>
                        <option value="Contrôle">Contrôle</option>
                        <option value="Devoir">Devoir</option>
                        <option value="Examen">Examen</option>
                        <option value="Participation">Participation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Note (/20)</label>
                    <input type="number" class="form-input" id="noteValue" min="0" max="20" step="0.25" required>
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
                <div class="form-group">
                    <label class="form-label">Nom de la classe</label>
                    <input type="text" class="form-input" id="className" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Matière</label>
                    <input type="text" class="form-input" id="classSubject" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Salle</label>
                    <input type="text" class="form-input" id="classRoom" required>
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
                <div class="form-group">
                    <label class="form-label">Nom complet</label>
                    <input type="text" class="form-input" id="studentName" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Classe</label>
                    <select class="form-input" id="studentClass" required>
                        <option value="">Sélectionner une classe</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="studentEmail" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" class="form-input" id="studentPhone">
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
        // Database simulation
        let database = {
            teacher: {
                name: "Prof. Fatima Zahra Benali",
                email: "f.benali@ecole.ma",
                phone: "+212 6 12 34 56 78",
                subjects: "Mathématiques, Physique",
                school: "Lycée Hassan II",
                experience: 12
            },
            classes: [
                { id: 1, name: "2ème A", subject: "Mathématiques", room: "A101", students: 28 },
                { id: 2, name: "1ère B", subject: "Mathématiques", room: "A102", students: 25 },
                { id: 3, name: "2ème C", subject: "Physique", room: "B201", students: 30 },
                { id: 4, name: "1ère A", subject: "Physique", room: "B202", students: 22 },
                { id: 5, name: "3ème A", subject: "Mathématiques", room: "A103", students: 26 },
                { id: 6, name: "3ème B", subject: "Physique", room: "B203", students: 24 },
                { id: 7, name: "2ème B", subject: "Mathématiques", room: "A104", students: 27 },
                { id: 8, name: "1ère C", subject: "Physique", room: "B204", students: 23 }
            ],
            students: [
                { id: 1, name: "Ahmed Ben Salem", class: "2ème A", email: "ahmed.salem@email.com", phone: "+212 6 11 22 33 44" },
                { id: 2, name: "Fatima El Amrani", class: "2ème A", email: "fatima.amrani@email.com", phone: "+212 6 22 33 44 55" },
                { id: 3, name: "Youssef Alami", class: "1ère B", email: "youssef.alami@email.com", phone: "+212 6 33 44 55 66" },
                { id: 4, name: "Aicha Bennani", class: "2ème C", email: "aicha.bennani@email.com", phone: "+212 6 44 55 66 77" },
                { id: 5, name: "Omar Fassi", class: "1ère A", email: "omar.fassi@email.com", phone: "+212 6 55 66 77 88" },
                { id: 6, name: "Salma Tazi", class: "3ème A", email: "salma.tazi@email.com", phone: "+212 6 66 77 88 99" },
                { id: 7, name: "Khalid Mansouri", class: "3ème B", email: "khalid.mansouri@email.com", phone: "+212 6 77 88 99 00" },
                { id: 8, name: "Nadia Chraibi", class: "2ème B", email: "nadia.chraibi@email.com", phone: "+212 6 88 99 00 11" },
                { id: 9, name: "Hassan Alaoui", class: "1ère C", email: "hassan.alaoui@email.com", phone: "+212 6 99 00 11 22" },
                { id: 10, name: "Zineb Idrissi", class: "2ème A", email: "zineb.idrissi@email.com", phone: "+212 6 00 11 22 33" }
            ],
            notes: [
                { id: 1, student: "Ahmed Ben Salem", class: "2ème A", type: "Contrôle", note: 16.5, date: "2025-06-05" },
                { id: 2, student: "Fatima El Amrani", class: "2ème A", type: "Devoir", note: 18, date: "2025-06-04" },
                { id: 3, student: "Youssef Alami", class: "1ère B", type: "Examen", note: 14, date: "2025-06-03" },
                { id: 4, student: "Aicha Bennani", class: "2ème C", type: "Contrôle", note: 15.5, date: "2025-06-05" },
                { id: 5, student: "Omar Fassi", class: "1ère A", type: "Participation", note: 17, date: "2025-06-06" },
                { id: 6, student: "Salma Tazi", class: "3ème A", type: "Devoir", note: 19, date: "2025-06-04" },
                { id: 7, student: "Khalid Mansouri", class: "3ème B", type: "Examen", note: 13.5, date: "2025-06-02" },
                { id: 8, student: "Nadia Chraibi", class: "2ème B", type: "Contrôle", note: 16, date: "2025-06-05" }
            ],
            schedule: [
                { day: "Lundi", time: "08:00", class: "2ème A", subject: "Mathématiques", room: "A101" },
                { day: "Lundi", time: "10:00", class: "1ère B", subject: "Mathématiques", room: "A102" },
                { day: "Lundi", time: "14:00", class: "2ème C", subject: "Physique", room: "B201" },
                { day: "Mardi", time: "08:00", class: "1ère A", subject: "Physique", room: "B202" },
                { day: "Mardi", time: "10:00", class: "3ème A", subject: "Mathématiques", room: "A103" },
                { day: "Mardi", time: "14:00", class: "3ème B", subject: "Physique", room: "B203" },
                { day: "Mercredi", time: "08:00", class: "2ème B", subject: "Mathématiques", room: "A104" },
                { day: "Mercredi", time: "10:00", class: "1ère C", subject: "Physique", room: "B204" },
                { day: "Jeudi", time: "08:00", class: "2ème A", subject: "Mathématiques", room: "A101" },
                { day: "Jeudi", time: "10:00", class: "1ère B", subject: "Mathématiques", room: "A102" },
                { day: "Vendredi", time: "08:00", class: "2ème C", subject: "Physique", room: "B201" },
                { day: "Vendredi", time: "10:00", class: "1ère A", subject: "Physique", room: "B202" }
            ],
            activities: [
                { icon: "fas fa-plus", title: "Nouvelle note ajoutée pour Ahmed Ben Salem", time: "Il y a 2 heures", type: "note" },
                { icon: "fas fa-user-plus", title: "Nouvel étudiant inscrit : Zineb Idrissi", time: "Il y a 5 heures", type: "student" },
                { icon: "fas fa-calendar", title: "Emploi du temps mis à jour", time: "Hier à 14:30", type: "schedule" },
                { icon: "fas fa-check", title: "Évaluation complétée pour 3ème A", time: "Il y a 2 jours", type: "evaluation" },
                { icon: "fas fa-bell", title: "Rappel: Réunion pédagogique demain", time: "Il y a 3 jours", type: "reminder" }
            ]
        };

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            updateDashboardStats();
            loadRecentActivity();
            loadClasses();
            loadStudents();
            loadNotes();
            loadSchedule();
            populateClassSelects();
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
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked tab link
            event.target.closest('.tab-link').classList.add('active');
        }

        // Update dashboard statistics
        function updateDashboardStats() {
            document.getElementById('totalClasses').textContent = database.classes.length;
            document.getElementById('totalEtudiants').textContent = database.students.length;
            document.getElementById('notesEnAttente').textContent = database.notes.filter(n => !n.validated).length;
            
            // Count today's courses
            const today = new Date().toLocaleDateString('fr-FR', { weekday: 'long' });
            const todayCourses = database.schedule.filter(s => s.day.toLowerCase() === today.toLowerCase());
            document.getElementById('coursAujourdhui').textContent = todayCourses.length;
        }

        // Load recent activity
        function loadRecentActivity() {
            const activityContainer = document.getElementById('recentActivity');
            activityContainer.innerHTML = '';
            
            database.activities.forEach(activity => {
                const activityItem = document.createElement('div');
                activityItem.className = 'activity-item';
                activityItem.innerHTML = `
                    <div class="activity-icon">
                        <i class="${activity.icon}"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">${activity.title}</div>
                        <div class="activity-time">${activity.time}</div>
                    </div>
                `;
                activityContainer.appendChild(activityItem);
            });
        }

        // Load classes table
        function loadClasses() {
            const classesTable = document.getElementById('classesTable');
            classesTable.innerHTML = '';
            
            database.classes.forEach(cls => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${cls.name}</td>
                    <td>${cls.subject}</td>
                    <td>${cls.students}</td>
                    <td>${cls.room}</td>
                    <td>
                        <button class="btn" style="padding: 0.5rem; margin-right: 0.5rem;" onclick="editClass(${cls.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-secondary" style="padding: 0.5rem;" onclick="deleteClass(${cls.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                classesTable.appendChild(row);
            });
        }

        // Load students table
        function loadStudents() {
            const studentsTable = document.getElementById('studentsTable');
            studentsTable.innerHTML = '';
            
            database.students.forEach(student => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${student.name}</td>
                    <td>${student.class}</td>
                    <td>${student.email}</td>
                    <td>${student.phone}</td>
                    <td>
                        <button class="btn" style="padding: 0.5rem; margin-right: 0.5rem;" onclick="editStudent(${student.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-secondary" style="padding: 0.5rem;" onclick="deleteStudent(${student.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                studentsTable.appendChild(row);
            });
        }

        // Load notes table
        function loadNotes() {
            const notesTable = document.getElementById('notesTable');
            notesTable.innerHTML = '';
            
            database.notes.forEach(note => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${note.student}</td>
                    <td>${note.class}</td>
                    <td>${note.type}</td>
                    <td>${note.note}/20</td>
                    <td>${new Date(note.date).toLocaleDateString('fr-FR')}</td>
                    <td>
                        <button class="btn" style="padding: 0.5rem; margin-right: 0.5rem;" onclick="editNote(${note.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-secondary" style="padding: 0.5rem;" onclick="deleteNote(${note.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                notesTable.appendChild(row);
            });
        }

        // Load schedule
        function loadSchedule() {
            const scheduleGrid = document.getElementById('scheduleGrid');
            scheduleGrid.innerHTML = '';
            
            const times = ['08:00', '10:00', '14:00', '16:00'];
            const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
            
            // Header
            scheduleGrid.innerHTML = '<div class="schedule-header">Horaire</div>';
            days.forEach(day => {
                scheduleGrid.innerHTML += `<div class="schedule-header">${day}</div>`;
            });
            
            // Time slots
            times.forEach(time => {
                scheduleGrid.innerHTML += `<div class="schedule-time">${time}</div>`;
                days.forEach(day => {
                    const event = database.schedule.find(s => s.day === day && s.time === time);
                    const cellContent = event ? 
                        `<div class="schedule-event">${event.class}<br>${event.subject}<br>${event.room}</div>` : '';
                    scheduleGrid.innerHTML += `<div class="schedule-cell">${cellContent}</div>`;
                });
            });
        }

        // Populate class selects
        function populateClassSelects() {
            const selects = ['noteClass', 'studentClass', 'classFilter'];
            selects.forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    // Keep the first option and clear the rest
                    const firstOption = select.firstElementChild;
                    select.innerHTML = '';
                    if (firstOption) select.appendChild(firstOption);
                    
                    database.classes.forEach(cls => {
                        const option = document.createElement('option');
                        option.value = cls.name;
                        option.textContent = cls.name;
                        select.appendChild(option);
                    });
                }
            });
            
            // Update student select when class is selected
            document.getElementById('noteClass').addEventListener('change', function() {
                const studentSelect = document.getElementById('noteStudent');
                studentSelect.innerHTML = '<option value="">Sélectionner un étudiant</option>';
                
                if (this.value) {
                    const studentsInClass = database.students.filter(s => s.class === this.value);
                    studentsInClass.forEach(student => {
                        const option = document.createElement('option');
                        option.value = student.name;
                        option.textContent = student.name;
                        studentSelect.appendChild(option);
                    });
                }
            });
        }

        // Modal functions
        function showAddNoteModal() {
            document.getElementById('addNoteModal').classList.add('active');
        }

        function showAddClassModal() {
            document.getElementById('addClassModal').classList.add('active');
        }

        function showAddStudentModal() {
            document.getElementById('addStudentModal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Add note function
        function addNote(event) {
            event.preventDefault();
            
            const newNote = {
                id: database.notes.length + 1,
                student: document.getElementById('noteStudent').value,
                class: document.getElementById('noteClass').value,
                type: document.getElementById('noteType').value,
                note: parseFloat(document.getElementById('noteValue').value),
                date: new Date().toISOString().split('T')[0]
            };
            
            database.notes.push(newNote);
            
            // Add to recent activity
            database.activities.unshift({
                icon: "fas fa-plus",
                title: `Nouvelle note ajoutée pour ${newNote.student}`,
                time: "À l'instant",
                type: "note"
            });
            
            loadNotes();
            loadRecentActivity();
            updateDashboardStats();
            closeModal('addNoteModal');
            
            // Reset form
            event.target.reset();
            
            alert('Note ajoutée avec succès !');
        }

        // Add class function
        function addClass(event) {
            event.preventDefault();
            
            const newClass = {
                id: database.classes.length + 1,
                name: document.getElementById('className').value,
                subject: document.getElementById('classSubject').value,
                room: document.getElementById('classRoom').value,
                students: 0
            };
            
            database.classes.push(newClass);
            
            // Add to recent activity
            database.activities.unshift({
                icon: "fas fa-plus",
                title: `Nouvelle classe créée : ${newClass.name}`,
                time: "À l'instant",
                type: "class"
            });
            
            loadClasses();
            loadRecentActivity();
            updateDashboardStats();
            populateClassSelects();
            closeModal('addClassModal');
            
            // Reset form
            event.target.reset();
            
            alert('Classe créée avec succès !');
        }

        // Add student function
        function addStudent(event) {
            event.preventDefault();
            
            const newStudent = {
                id: database.students.length + 1,
                name: document.getElementById('studentName').value,
                class: document.getElementById('studentClass').value,
                email: document.getElementById('studentEmail').value,
                phone: document.getElementById('studentPhone').value
            };
            
            database.students.push(newStudent);
            
            // Update class student count
            const classObj = database.classes.find(c => c.name === newStudent.class);
            if (classObj) {
                classObj.students++;
            }
            
            // Add to recent activity
            database.activities.unshift({
                icon: "fas fa-user-plus",
                title: `Nouvel étudiant inscrit : ${newStudent.name}`,
                time: "À l'instant",
                type: "student"
            });
            
            loadStudents();
            loadClasses();
            loadRecentActivity();
            updateDashboardStats();
            closeModal('addStudentModal');
            
            // Reset form
            event.target.reset();
            
            alert('Étudiant ajouté avec succès !');
        }

        // Filter students
        function filterStudents() {
            const filterValue = document.getElementById('classFilter').value;
            const rows = document.querySelectorAll('#studentsTable tr');
            
            rows.forEach(row => {
                if (!filterValue || row.cells[1].textContent === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Edit functions (placeholders)
        function editClass(id) {
            alert(`Édition de la classe ID: ${id} (Fonctionnalité à implémenter)`);
        }

        function editStudent(id) {
            alert(`Édition de l'étudiant ID: ${id} (Fonctionnalité à implémenter)`);
        }

        function editNote(id) {
            alert(`Édition de la note ID: ${id} (Fonctionnalité à implémenter)`);
        }

        // Delete functions
        function deleteClass(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')) {
                database.classes = database.classes.filter(c => c.id !== id);
                loadClasses();
                updateDashboardStats();
                populateClassSelects();
                alert('Classe supprimée avec succès !');
            }
        }

        function deleteStudent(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
                const student = database.students.find(s => s.id === id);
                if (student) {
                    // Update class student count
                    const classObj = database.classes.find(c => c.name === student.class);
                    if (classObj) {
                        classObj.students--;
                    }
                }
                database.students = database.students.filter(s => s.id !== id);
                loadStudents();
                loadClasses();
                updateDashboardStats();
                alert('Étudiant supprimé avec succès !');
            }
        }

        function deleteNote(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette note ?')) {
                database.notes = database.notes.filter(n => n.id !== id);
                loadNotes();
                updateDashboardStats();
                alert('Note supprimée avec succès !');
            }
        }

        // Profile functions
        function showProfile() {
            showTab('profil');
        }

        function updateProfile() {
            database.teacher.name = document.getElementById('profileName').value;
            database.teacher.email = document.getElementById('profileEmail').value;
            database.teacher.phone = document.getElementById('profilePhone').value;
            database.teacher.subjects = document.getElementById('profileSubjects').value;
            database.teacher.school = document.getElementById('profileSchool').value;
            database.teacher.experience = parseInt(document.getElementById('profileExperience').value);
            
            // Update navbar
            document.getElementById('teacherName').textContent = database.teacher.name;
            
            alert('Profil mis à jour avec succès !');
        }

        // Stats function
        function showStats() {
            const totalStudents = database.students.length;
            const totalClasses = database.classes.length;
            const totalNotes = database.notes.length;
            const avgNote = database.notes.reduce((sum, note) => sum + note.note, 0) / database.notes.length;
            
            alert(`Statistiques:\n\nTotal étudiants: ${totalStudents}\nTotal classes: ${totalClasses}\nTotal notes: ${totalNotes}\nMoyenne générale: ${avgNote.toFixed(2)}/20`);
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