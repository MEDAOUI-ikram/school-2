<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excellence Académique - Système de Gestion Scolaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            background-size: 300% 300%;
            animation: gradientShift 8s ease infinite;
        }

        .gradient-secondary {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }

        .gradient-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            80%, 100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-glow {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.6);
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <!-- Floating Elements -->
    <div class="fixed top-20 left-10 w-20 h-20 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full opacity-20 floating"></div>
    <div class="fixed top-40 right-20 w-16 h-16 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full opacity-20 floating" style="animation-delay: -1s;"></div>
    <div class="fixed bottom-20 left-20 w-12 h-12 bg-gradient-to-r from-green-400 to-blue-400 rounded-full opacity-20 floating" style="animation-delay: -2s;"></div>

    <!-- Header -->
    <header class="gradient-primary shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="glass-effect rounded-full p-4 pulse-ring"></div>
                        <div class="absolute inset-0 bg-white rounded-full p-4 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-purple-600 text-3xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-white text-3xl font-bold tracking-tight">Excellence Académique</h1>
                        <p class="text-blue-100 text-sm font-medium">Institut Supérieur de Formation</p>
                    </div>
                </div>
                <button onclick="showLogin()" class="glass-effect text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-purple-600 transition-all duration-300 btn-glow">
                    <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="gradient-primary py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-5xl md:text-7xl font-bold text-white mb-8 leading-tight">
                    L'Excellence à Votre
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-400">
                        Portée
                    </span>
                </h2>
                <p class="text-xl md:text-2xl text-blue-100 mb-12 max-w-2xl mx-auto font-light leading-relaxed">
                    Découvrez notre plateforme de gestion scolaire nouvelle génération, conçue pour transformer l'expérience éducative
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="showLogin()" class="glass-effect text-white px-10 py-4 rounded-full font-bold text-lg transition-all duration-300 btn-glow hover:scale-105">
                        <i class="fas fa-rocket mr-2"></i>Accéder au système
                    </button>
                    <button class="border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-purple-600 transition-all duration-300">
                        <i class="fas fa-play mr-2"></i>Découvrir
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Access Cards -->
    <section class="py-24 bg-white relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-4xl md:text-5xl font-bold text-gradient mb-6">
                    Choisissez Votre Profil
                </h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Accédez à votre espace personnalisé selon votre rôle dans l'établissement
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 max-w-5xl mx-auto">
                <!-- Professeur Card -->
                <div class="card-hover gradient-card rounded-3xl p-10 border border-gray-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full -translate-y-16 translate-x-16 opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-xl">
                            <i class="fas fa-chalkboard-teacher text-3xl text-white"></i>
                        </div>
                        <h4 class="text-3xl font-bold text-gray-800 mb-4 text-center">Professeur</h4>
                        <p class="text-gray-600 mb-8 text-center text-lg">Interface dédiée à l'enseignement et au suivi pédagogique</p>

                        <div class="grid grid-cols-2 gap-4 mb-10">
                            <div class="flex items-center text-gray-700 p-3 bg-green-50 rounded-xl">
                                <i class="fas fa-users text-green-500 mr-3 text-lg"></i>
                                <span class="font-medium">Mes Classes</span>
                            </div>
                            <div class="flex items-center text-gray-700 p-3 bg-green-50 rounded-xl">
                                <i class="fas fa-book text-green-500 mr-3 text-lg"></i>
                                <span class="font-medium">Matières</span>
                            </div>
                            <div class="flex items-center text-gray-700 p-3 bg-green-50 rounded-xl">
                                <i class="fas fa-calendar text-green-500 mr-3 text-lg"></i>
                                <span class="font-medium">Planning</span>
                            </div>

                        </div>

                        <button onclick="selectRole('teacher')" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-2xl font-bold text-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-arrow-right mr-2"></i>Accès Professeur
                        </button>
                    </div>
                </div>

                <!-- Étudiant Card -->
                <div class="card-hover gradient-card rounded-3xl p-10 border border-gray-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full -translate-y-16 translate-x-16 opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-xl">
                            <i class="fas fa-user-graduate text-3xl text-white"></i>
                        </div>
                        <h4 class="text-3xl font-bold text-gray-800 mb-4 text-center">Étudiant</h4>
                        <p class="text-gray-600 mb-8 text-center text-lg">Espace personnel pour suivre votre parcours académique</p>

                        <div class="grid grid-cols-2 gap-4 mb-10">
                            <div class="flex items-center text-gray-700 p-3 bg-blue-50 rounded-xl">
                                <i class="fas fa-user text-blue-500 mr-3 text-lg"></i>
                                <span class="font-medium">Mon Profil</span>
                            </div>
                            <div class="flex items-center text-gray-700 p-3 bg-blue-50 rounded-xl">
                                <i class="fas fa-users text-blue-500 mr-3 text-lg"></i>
                                <span class="font-medium">Ma Classe</span>
                            </div>
                            <div class="flex items-center text-gray-700 p-3 bg-blue-50 rounded-xl">
                                <i class="fas fa-book-open text-blue-500 mr-3 text-lg"></i>
                                <span class="font-medium">Cours</span>
                            </div>
                            <div class="flex items-center text-gray-700 p-3 bg-blue-50 rounded-xl">
                                <i class="fas fa-calendar-check text-blue-500 mr-3 text-lg"></i>
                                <span class="font-medium">Emploi du temps</span>
                            </div>
                        </div>

                        <button onclick="selectRole('student')" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-4 rounded-2xl font-bold text-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-arrow-right mr-2"></i>Accès Étudiant
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 gradient-secondary">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-4xl md:text-5xl font-bold text-gradient mb-6">
                    Fonctionnalités Premium
                </h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Découvrez tous les outils intégrés pour une gestion scolaire optimale
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="gradient-card rounded-2xl p-8 text-center card-hover group">
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-alt text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Emplois du temps</h4>
                    <p class="text-gray-600 leading-relaxed">Planification intelligente et gestion automatisée des créneaux horaires</p>
                </div>

                <div class="gradient-card rounded-2xl p-8 text-center card-hover group">
                    <div class="bg-gradient-to-br from-green-500 to-teal-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Gestion des groupes</h4>
                    <p class="text-gray-600 leading-relaxed">Organisation flexible et suivi personnalisé des groupes d'étudiants</p>
                </div>

                <div class="gradient-card rounded-2xl p-8 text-center card-hover group">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Analytics avancés</h4>
                    <p class="text-gray-600 leading-relaxed">Tableaux de bord et rapports détaillés pour le suivi académique</p>
                </div>

                <div class="gradient-card rounded-2xl p-8 text-center card-hover group">
                    <div class="bg-gradient-to-br from-orange-500 to-red-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bell text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Notifications</h4>
                    <p class="text-gray-600 leading-relaxed">Système d'alertes en temps réel pour tous les événements importants</p>
                </div>

                <div class="gradient-card rounded-2xl p-8 text-center card-hover group">
                    <div class="bg-gradient-to-br from-cyan-500 to-blue-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mobile-alt text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Multi-plateforme</h4>
                    <p class="text-gray-600 leading-relaxed">Accès fluide depuis tous vos appareils, partout et à tout moment</p>
                </div>

                <div class="gradient-card rounded-2xl p-8 text-center card-hover group">
                    <div class="bg-gradient-to-br from-yellow-500 to-orange-500 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Sécurité renforcée</h4>
                    <p class="text-gray-600 leading-relaxed">Protection des données avec les standards de sécurité les plus élevés</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 modal-backdrop flex items-center justify-center z-50 hidden">
        <div class="gradient-card rounded-3xl p-10 m-4 max-w-md w-full shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="text-center mb-8">
                <div class="bg-gradient-to-br from-purple-500 to-pink-500 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gradient mb-2">Connexion</h3>
                <p class="text-gray-600 font-medium">Excellence Académique</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse Email</label>
                    <input type="email" name="email" required
                           class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                    <input type="password" name="password" required
                           class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300">
                </div>

                <div id="roleSelection" class="hidden">
                     <x-input-label for="role" :value="__('Rôle')" />
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Profil d'accès</label>
                    <select id="role" name="role" class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300">
                         <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                    </select>
                     <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-3 w-4 h-4 text-purple-600 rounded">
                    <label class="text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white p-4 rounded-xl font-bold text-lg hover:from-purple-600 hover:to-pink-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                </button>
            </form>

            <button onclick="hideLogin()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 text-2xl transition-colors duration-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-900 to-indigo-900 opacity-50"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="flex items-center justify-center space-x-4 mb-8">
                <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl p-4">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-bold">Excellence Académique</span>
                    <p class="text-purple-200 text-sm">Institut Supérieur de Formation</p>
                </div>
            </div>
            <p class="text-gray-300 mb-4 text-lg">Système de Gestion Scolaire Nouvelle Génération</p>
            <div class="flex justify-center space-x-6 mb-8">
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-facebook text-2xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-twitter text-2xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-linkedin text-2xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-instagram text-2xl"></i>
                </a>
            </div>
            <p class="text-gray-400 text-sm">&copy; 2025 Excellence Académique - Tous droits réservés</p>
        </div>
    </footer>

    <script>
        let selectedRole = null;

        function showLogin() {
            const modal = document.getElementById('loginModal');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            if (selectedRole) {
                document.getElementById('roleSelection').classList.remove('hidden');
                document.querySelector('select[name="role"]').value = selectedRole;
            }
        }

        function hideLogin() {
            const modal = document.getElementById('loginModal');
            const content = document.getElementById('modalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function selectRole(role) {
            selectedRole = role;
            showLogin();
        }

        // Close modal when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) hideLogin();
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') hideLogin();
        });

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
