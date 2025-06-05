<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Interface Étudiant')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Variables CSS - Palette Blanc/Bleu Clair */
        :root {
          --primary: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
          --primary-solid: #3b82f6;
          --primary-light: #dbeafe;
          --primary-hover: #2563eb;
          --secondary: #f8fafc;
          --accent: linear-gradient(135deg, #60a5fa 0%, #93c5fd 100%);
          --accent-solid: #60a5fa;
          --text: #1e293b;
          --text-light: #64748b;
          --text-white: #ffffff;
          --background: #ffffff;
          --background-alt: #f1f5f9;
          --sidebar-bg: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
          --sidebar-text: #475569;
          --sidebar-hover: rgba(59, 130, 246, 0.1);
          --sidebar-active: rgba(59, 130, 246, 0.15);
          --border: #e2e8f0;
          --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
          --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
          --radius: 12px;
          --radius-lg: 16px;
          --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset & Base Styles */
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
          font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
          color: var(--text);
          background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
          line-height: 1.6;
          overflow-x: hidden;
        }

        /* Particles Background */
        .particles {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          pointer-events: none;
          z-index: -1;
        }

        .particle {
          position: absolute;
          width: 3px;
          height: 3px;
          background: var(--primary-solid);
          border-radius: 50%;
          opacity: 0.2;
          animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
          0%, 100% { transform: translateY(0px) rotate(0deg); }
          50% { transform: translateY(-15px) rotate(180deg); }
        }

        /* Layout */
        .app-container {
          display: flex;
          min-height: 100vh;
          position: relative;
        }

        /* Sidebar */
        .sidebar {
          width: 280px;
          background: var(--sidebar-bg);
          padding: 2rem 0;
          position: fixed;
          height: 100vh;
          left: 0;
          top: 0;
          transform: translateX(-100%);
          transition: var(--transition);
          z-index: 1000;
          box-shadow: var(--shadow-lg);
          border-right: 1px solid var(--border);
        }

        .sidebar.active {
          transform: translateX(0);
        }

        .sidebar-header {
          padding: 0 2rem 2rem;
          border-bottom: 1px solid var(--border);
          margin-bottom: 2rem;
        }

        .sidebar-header h2 {
          color: var(--primary-solid);
          font-size: 1.5rem;
          font-weight: 700;
          margin-bottom: 0.5rem;
        }

        .sidebar-header p {
          color: var(--text-light);
          font-size: 0.875rem;
        }

        .nav-menu {
          list-style: none;
          padding: 0 1rem;
        }

        .nav-item {
          margin-bottom: 0.5rem;
        }

        .nav-link {
          display: flex;
          align-items: center;
          padding: 1rem 1.5rem;
          color: var(--sidebar-text);
          text-decoration: none;
          border-radius: var(--radius);
          transition: var(--transition);
          position: relative;
          overflow: hidden;
        }

        .nav-link::before {
          content: '';
          position: absolute;
          top: 0;
          left: -100%;
          width: 100%;
          height: 100%;
          background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
          transition: var(--transition);
        }

        .nav-link:hover::before {
          left: 100%;
        }

        .nav-link:hover {
          background: var(--sidebar-hover);
          transform: translateX(5px);
          color: var(--primary-solid);
        }

        .nav-link.active {
          background: var(--sidebar-active);
          color: var(--primary-solid);
          box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
          font-weight: 600;
        }

        .nav-link i {
          margin-right: 1rem;
          font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
          flex: 1;
          margin-left: 0;
          transition: var(--transition);
        }

        .main-content.sidebar-open {
          margin-left: 280px;
        }

        /* Header */
        .header {
          background: rgba(255, 255, 255, 0.9);
          backdrop-filter: blur(10px);
          padding: 1.5rem 2rem;
          border-bottom: 1px solid var(--border);
          position: sticky;
          top: 0;
          z-index: 100;
        }

        .header-content {
          display: flex;
          justify-content: space-between;
          align-items: center;
        }

        .menu-toggle {
          background: none;
          border: none;
          font-size: 1.5rem;
          color: var(--text);
          cursor: pointer;
          padding: 0.5rem;
          border-radius: var(--radius);
          transition: var(--transition);
        }

        .menu-toggle:hover {
          background: var(--primary-light);
          color: var(--primary-solid);
        }

        .user-info {
          display: flex;
          align-items: center;
          gap: 1rem;
        }

        .user-avatar {
          width: 45px;
          height: 45px;
          border-radius: 50%;
          background: var(--primary);
          display: flex;
          align-items: center;
          justify-content: center;
          color: white;
          font-weight: 600;
          font-size: 1.1rem;
        }

        .user-details h3 {
          font-size: 1rem;
          margin-bottom: 0.25rem;
          color: var(--text);
        }

        .user-details p {
          font-size: 0.875rem;
          color: var(--text-light);
        }

        /* Content Area */
        .content-area {
          padding: 2rem;
        }

        /* Dashboard Cards */
        .dashboard-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
          gap: 1.5rem;
          margin-bottom: 2rem;
        }

        .stat-card {
          background: var(--background);
          border-radius: var(--radius-lg);
          padding: 2rem;
          box-shadow: var(--shadow);
          position: relative;
          overflow: hidden;
          transition: var(--transition);
          border: 1px solid var(--border);
        }

        .stat-card::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 3px;
          background: var(--primary);
        }

        .stat-card:hover {
          transform: translateY(-3px);
          box-shadow: var(--shadow-lg);
        }

        .stat-header {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          margin-bottom: 1rem;
        }

        .stat-icon {
          width: 50px;
          height: 50px;
          border-radius: var(--radius);
          background: var(--primary-light);
          display: flex;
          align-items: center;
          justify-content: center;
          color: var(--primary-solid);
          font-size: 1.3rem;
        }

        .stat-value {
          font-size: 2.2rem;
          font-weight: 700;
          color: var(--text);
          margin-bottom: 0.5rem;
        }

        .stat-label {
          color: var(--text-light);
          font-size: 0.875rem;
          margin-bottom: 1rem;
        }

        .stat-trend {
          display: flex;
          align-items: center;
          gap: 0.5rem;
          font-size: 0.875rem;
        }

        .trend-up {
          color: #059669;
        }

        .trend-down {
          color: #dc2626;
        }

        /* Tables */
        .table-container {
          background: var(--background);
          border-radius: var(--radius-lg);
          padding: 1.5rem;
          box-shadow: var(--shadow);
          margin-bottom: 2rem;
          border: 1px solid var(--border);
          overflow-x: auto;
        }

        .table-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 1.5rem;
        }

        .table-title {
          font-size: 1.25rem;
          font-weight: 600;
          color: var(--text);
        }

        table {
          width: 100%;
          border-collapse: collapse;
        }

        th, td {
          padding: 1rem;
          text-align: left;
          border-bottom: 1px solid var(--border);
        }

        th {
          font-weight: 600;
          color: var(--text-light);
          background-color: var(--background-alt);
          font-size: 0.875rem;
        }

        tr:hover {
          background-color: var(--primary-light);
        }

        /* Progress Bars */
        .progress-container {
          margin: 1rem 0;
        }

        .progress-label {
          display: flex;
          justify-content: space-between;
          margin-bottom: 0.5rem;
          font-size: 0.875rem;
          font-weight: 500;
        }

        .progress-bar {
          height: 6px;
          background: var(--border);
          border-radius: 3px;
          overflow: hidden;
        }

        .progress-fill {
          height: 100%;
          background: var(--primary);
          transition: width 1.5s ease;
          border-radius: 3px;
        }

        /* Buttons */
        .btn {
          display: inline-flex;
          align-items: center;
          gap: 0.5rem;
          padding: 0.75rem 1.5rem;
          border: none;
          border-radius: var(--radius);
          font-weight: 500;
          text-decoration: none;
          cursor: pointer;
          transition: var(--transition);
          font-size: 0.875rem;
        }

        .btn-primary {
          background: var(--primary);
          color: white;
        }

        .btn-primary:hover {
          transform: translateY(-1px);
          box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
          background: var(--background);
          color: var(--text);
          border: 1px solid var(--border);
        }

        .btn-secondary:hover {
          background: var(--primary-light);
          border-color: var(--primary-solid);
          color: var(--primary-solid);
        }

        /* Alerts */
        .alert {
          padding: 1rem 1.5rem;
          border-radius: var(--radius);
          margin-bottom: 1.5rem;
          border-left: 4px solid;
          font-size: 0.875rem;
        }

        .alert-success {
          background-color: #f0f9ff;
          color: #0c4a6e;
          border-left-color: #0ea5e9;
        }

        .alert-error {
          background-color: #fef2f2;
          color: #991b1b;
          border-left-color: #ef4444;
        }

        /* Content Sections */
        .content-section {
          display: none;
        }

        .content-section.active {
          display: block;
          animation: slideIn 0.4s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
          .sidebar {
            width: 100%;
          }
          
          .main-content.sidebar-open {
            margin-left: 0;
          }
          
          .content-area {
            padding: 1rem;
          }
          
          .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
          }
          
          .stat-card {
            padding: 1.5rem;
          }
          
          .user-info .user-details {
            display: none;
          }
        }

        /* Animations */
        @keyframes slideIn {
          from {
            opacity: 0;
            transform: translateY(15px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }

        .slide-in {
          animation: slideIn 0.4s ease-out;
        }

        /* Loading State */
        .loading {
          display: inline-block;
          width: 20px;
          height: 20px;
          border: 2px solid var(--border);
          border-radius: 50%;
          border-top-color: var(--primary-solid);
          animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
          to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Particles Background -->
    <div class="particles" id="particles"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-graduation-cap"></i> EduPortal</h2>
                <p>Interface Étudiant</p>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('etudiant.dashboard') }}" class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" data-section="dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            Tableau de Bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('etudiant.classes') }}" class="nav-link {{ request()->routeIs('etudiant.classes') ? 'active' : '' }}" data-section="classes">
                            <i class="fas fa-chalkboard-teacher"></i>
                            Mes Classes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('etudiant.matieres') }}" class="nav-link {{ request()->routeIs('etudiant.matieres') ? 'active' : '' }}" data-section="subjects">
                            <i class="fas fa-book"></i>
                            Mes Matières
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('etudiant.notes') }}" class="nav-link {{ request()->routeIs('etudiant.notes') ? 'active' : '' }}" data-section="grades">
                            <i class="fas fa-chart-line"></i>
                            Mes Notes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('etudiant.emploi') }}" class="nav-link {{ request()->routeIs('etudiant.emploi') ? 'active' : '' }}" data-section="schedule">
                            <i class="fas fa-calendar-alt"></i>
                            Emploi du Temps
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('etudiant.infos') }}" class="nav-link {{ request()->routeIs('etudiant.infos') ? 'active' : '' }}" data-section="profile">
                            <i class="fas fa-user-circle"></i>
                            Infos Personnelles
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->prenom ?? '', 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <h3>{{ Auth::user()->nom }} {{ Auth::user()->prenom ?? '' }}</h3>
                            <p>Étudiant - {{ Auth::user()->etudiant->niveau ?? 'Niveau non défini' }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Initialize App
        document.addEventListener('DOMContentLoaded', function() {
            initializeParticles();
            initializeSidebar();
            animateProgressBars();
        });

        // Particles Animation
        function initializeParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 6) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Sidebar Management
        function initializeSidebar() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('sidebar-open');
            });

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    closeSidebar();
                }
            });

            // Handle navigation links
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Close sidebar on mobile after navigation
                    if (window.innerWidth <= 768) {
                        setTimeout(closeSidebar, 100);
                    }
                });
            });
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.remove('active');
            mainContent.classList.remove('sidebar-open');
        }

        // Progress Bar Animation
        function animateProgressBars() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        }

        // AJAX Helper Functions
        function fetchData(url, callback) {
            fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => callback(data))
            .catch(error => console.error('Error:', error));
        }

        // Show loading state
        function showLoading(element) {
            element.innerHTML = '<div class="loading"></div>';
        }

        // Auto-refresh data every 5 minutes
        setInterval(function() {
            if (typeof refreshDashboardData === 'function') {
                refreshDashboardData();
            }
        }, 300000);

        // Responsive handling
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                sidebar.classList.add('active');
                mainContent.classList.add('sidebar-open');
            } else {
                closeSidebar();
            }
        });

        // Initialize responsive state
        if (window.innerWidth > 768) {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.add('active');
            mainContent.classList.add('sidebar-open');
        }
    </script>

    @yield('scripts')
</body>
</html>