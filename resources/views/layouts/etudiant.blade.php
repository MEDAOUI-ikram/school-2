<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Interface Étudiant')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #b3e5fc 50%, #81d4fa 100%);
            min-height: 100vh;
            color: #0d47a1;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* En-tête */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(3, 169, 244, 0.2);
            box-shadow: 0 4px 20px rgba(3, 169, 244, 0.1);
            padding: 20px 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .student-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .student-info h1 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0277bd 0%, #03a9f4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        .user-details {
            display: flex;
            gap: 30px;
            align-items: center;
            flex-wrap: wrap;
        }

        .user-card {
            background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%);
            padding: 15px 20px;
            border-radius: 15px;
            border: 1px solid rgba(3, 169, 244, 0.2);
            box-shadow: 0 4px 15px rgba(3, 169, 244, 0.1);
            transition: all 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(3, 169, 244, 0.2);
        }

        .user-card strong {
            color: #01579b;
            font-weight: 600;
            display: block;
            font-size: 0.85rem;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-card span {
            color: #0277bd;
            font-weight: 500;
            font-size: 1rem;
        }

        .avatar-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0277bd 0%, #03a9f4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(3, 169, 244, 0.3);
        }

        .welcome-text {
            color: #0277bd;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Navigation */
        .navigation {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 20px 30px;
            border-bottom: 1px solid rgba(3, 169, 244, 0.1);
            box-shadow: 0 2px 10px rgba(3, 169, 244, 0.05);
            position: sticky;
            top: 100px;
            z-index: 90;
        }

        .nav-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.8);
            color: #0277bd;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.95rem;
            border: 2px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .nav-btn:hover::before {
            left: 100%;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(3, 169, 244, 0.2);
            border-color: rgba(3, 169, 244, 0.3);
        }

        .nav-btn.active {
            background: linear-gradient(135deg, #0277bd 0%, #03a9f4 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(3, 169, 244, 0.4);
            transform: translateY(-1px);
        }

        .nav-btn.active:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(3, 169, 244, 0.5);
        }

        /* Icônes pour la navigation */
        .nav-btn[href*="dashboard"]::before {
            content: "🏠";
            margin-right: 5px;
        }

        .nav-btn[href*="classes"]::before {
            content: "👨‍🏫";
            margin-right: 5px;
        }

        .nav-btn[href*="matieres"]::before {
            content: "📚";
            margin-right: 5px;
        }

        .nav-btn[href*="infos"]::before {
            content: "👤";
            margin-right: 5px;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Styles pour les pages de contenu */
        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(3, 169, 244, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-height: 500px;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header, .navigation {
            animation: fadeInUp 0.6s ease-out;
        }

        .user-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .user-card:nth-child(1) { animation-delay: 0.1s; }
        .user-card:nth-child(2) { animation-delay: 0.2s; }
        .user-card:nth-child(3) { animation-delay: 0.3s; }

        .nav-btn {
            animation: fadeInUp 0.6s ease-out;
        }

        .nav-btn:nth-child(1) { animation-delay: 0.1s; }
        .nav-btn:nth-child(2) { animation-delay: 0.2s; }
        .nav-btn:nth-child(3) { animation-delay: 0.3s; }
        .nav-btn:nth-child(4) { animation-delay: 0.4s; }

        /* Indicateur de statut */
        .status-indicator {
            position: relative;
        }

        .status-indicator::after {
            content: '';
            position: absolute;
            top: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: #4caf50;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .container {
                margin: 0 10px;
            }
            
            .header {
                padding: 15px 20px;
            }
            
            .navigation {
                padding: 15px 20px;
            }
            
            .main-content {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .student-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .student-info h1 {
                font-size: 1.5rem;
            }

            .user-details {
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }

            .user-card {
                width: 100%;
                text-align: center;
            }

            .nav-container {
                flex-direction: column;
                gap: 8px;
            }

            .nav-btn {
                width: 100%;
                justify-content: center;
                padding: 15px 20px;
            }

            .main-content {
                padding: 15px;
            }

            .content-wrapper {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 10px 15px;
            }

            .navigation {
                padding: 10px 15px;
            }

            .main-content {
                padding: 10px;
            }

            .user-avatar {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }

        /* Effets de particules en arrière-plan */
        .bg-particles {
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
            background: rgba(3, 169, 244, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .particle:nth-child(1) {
            width: 20px;
            height: 20px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 15px;
            height: 15px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 25px;
            height: 25px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }

        /* Barre de progression pour le chargement */
        .loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #03a9f4, #0277bd);
            transform: scaleX(0);
            transform-origin: left;
            animation: loadingProgress 2s ease-out forwards;
            z-index: 1000;
        }

        @keyframes loadingProgress {
            to {
                transform: scaleX(1);
            }
            
        }
    </style>
</head>
<body>
    <!-- Barre de chargement -->
    <div class="loading-bar"></div>
    
    <!-- Particules d'arrière-plan -->
    <div class="bg-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    

       <!-- Navigation verticale -->
            <div class="navigation">
                <a href="{{ route('etudiant.dashboard') }}" class="nav-btn {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
                    📊 Tableau de Bord
                </a>
                <a href="{{ route('etudiant.classes') }}" class="nav-btn {{ request()->routeIs('etudiant.classes') ? 'active' : '' }}">
                    🏫 Mes Classes
                </a>
                <a href="{{ route('etudiant.matieres') }}" class="nav-btn {{ request()->routeIs('etudiant.matieres') ? 'active' : '' }}">
                    📚 Mes Matières
                </a>
                <a href="{{ route('etudiant.infos') }}" class="nav-btn {{ request()->routeIs('etudiant.infos') ? 'active' : '' }}">
                    👤 Infos Personnelles
                </a>
                <a href="{{ route('logout') }}" class="nav-btn" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    🚪 Déconnexion
                </a> 
                
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div> 



        <!-- Contenu principal -->
        <div class="main-content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Animation de la barre de chargement
        window.addEventListener('load', function() {
            setTimeout(() => {
                const loadingBar = document.querySelector('.loading-bar');
                if (loadingBar) {
                    loadingBar.style.opacity = '0';
                    setTimeout(() => loadingBar.remove(), 500);
                }
            }, 2000);
        });

        // Effet de parallaxe léger pour les particules
        window.addEventListener('scroll', function() {
            const particles = document.querySelectorAll('.particle');
            const scrolled = window.pageYOffset;
            
            particles.forEach((particle, index) => {
                const speed = 0.5 + (index * 0.1);
                particle.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Animation au survol des cartes utilisateur
        document.querySelectorAll('.user-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-2px) scale(1)';
            });
        });

        // Indicateur de connexion en temps réel
        function updateConnectionStatus() {
            const indicator = document.querySelector('.status-indicator::after');
            if (navigator.onLine) {
                document.documentElement.style.setProperty('--status-color', '#4caf50');
            } else {
                document.documentElement.style.setProperty('--status-color', '#f44336');
            }
        }

        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        updateConnectionStatus();
    </script>

    @yield('scripts')
</body>
</html>