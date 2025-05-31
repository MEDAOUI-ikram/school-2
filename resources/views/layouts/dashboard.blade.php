<!-- resources/views/layouts/dashboard.blade.php -->
<x-app-layout>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card {
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .dashboard-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .title-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.75rem;
            margin-right: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .content-wrapper {
            position: relative;
            overflow: hidden;
        }

        .content-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            border-radius: 50%;
            z-index: 0;
        }

        .content-inner {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem 0;
            }

            .dashboard-card {
                margin: 0 1rem;
            }
        }
    </style>

    <x-slot name="header">
        <div class="dashboard-header py-4">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <div class="title-icon">
                                <i class="bi bi-speedometer2 fs-4"></i>
                            </div>
                            <div>
                                <h1 class="h3 mb-0 fw-bold">
                                    {{ $title ?? 'Dashboard' }}
                                </h1>
                                <p class="mb-0 opacity-75">
                                    <small>Bienvenue dans votre espace de gestion</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                <i class="bi bi-clock me-1"></i>
                                {{ date('d/m/Y H:i') }}
                            </div>
                            <button class="btn btn-outline-light btn-sm rounded-pill">
                                <i class="bi bi-bell"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-11">
                    <!-- Stats Row (optionnel) -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row g-4">
                                <div class="col-md-3 col-sm-6">
                                    <div class="card dashboard-card border-0 h-100">
                                        <div class="card-body text-center">
                                            <div class="text-primary mb-2">
                                                <i class="bi bi-graph-up-arrow fs-1"></i>
                                            </div>
                                            <h6 class="card-title text-muted">Performance</h6>
                                            <h4 class="text-primary fw-bold">98.5%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card dashboard-card border-0 h-100">
                                        <div class="card-body text-center">
                                            <div class="text-success mb-2">
                                                <i class="bi bi-people-fill fs-1"></i>
                                            </div>
                                            <h6 class="card-title text-muted">Utilisateurs</h6>
                                            <h4 class="text-success fw-bold">1,234</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card dashboard-card border-0 h-100">
                                        <div class="card-body text-center">
                                            <div class="text-warning mb-2">
                                                <i class="bi bi-bar-chart-fill fs-1"></i>
                                            </div>
                                            <h6 class="card-title text-muted">Revenus</h6>
                                            <h4 class="text-warning fw-bold">€45.2K</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card dashboard-card border-0 h-100">
                                        <div class="card-body text-center">
                                            <div class="text-info mb-2">
                                                <i class="bi bi-trophy-fill fs-1"></i>
                                            </div>
                                            <h6 class="card-title text-muted">Objectifs</h6>
                                            <h4 class="text-info fw-bold">87%</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Card -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card dashboard-card border-0">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0 fw-bold text-dark">
                                            <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>
                                            Contenu Principal
                                        </h5>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-pill"
                                                    type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Voir</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Modifier</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body content-wrapper">
                                    <div class="content-inner">
                                        {{ $slot }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer (optionnel) -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <p class="text-muted small mb-0">
                                <i class="bi bi-heart-fill text-danger me-1"></i>
                                Développé avec passion • {{ date('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Animation on Load -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation d'apparition des cartes
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</x-app-layout>
