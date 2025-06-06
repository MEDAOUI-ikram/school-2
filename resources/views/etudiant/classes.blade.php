@extends('layouts.etudiant')

@section('title', 'Mes Classes - Étudiant')

@section('content')
<style>
    /* Nouveau design avec palette blanc/bleu clair */
    * {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(120deg, #a8edea 0%, #fed6e3 100%);
        font-family: 'Inter', 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 10px 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 1.1rem;
        margin: 0;
        font-weight: 500;
    }

    .stats-bar {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        padding: 15px 25px;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-radius: 15px;
        border: 1px solid rgba(33, 150, 243, 0.2);
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1565c0;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #64b5f6;
        font-weight: 500;
    }

    .controls-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-input {
        width: 100%;
        padding: 15px 20px 15px 50px;
        border: 2px solid #e3f2fd;
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        font-size: 16px;
        color: #1565c0;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);
    }

    .search-input:focus {
        outline: none;
        border-color: #2196f3;
        box-shadow: 0 0 0 4px rgba(33, 150, 243, 0.2);
        transform: translateY(-2px);
    }

    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: #64b5f6;
    }

    .view-toggle {
        display: flex;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 5px;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);
    }

    .toggle-btn {
        padding: 10px 20px;
        border: none;
        background: transparent;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #64b5f6;
        font-weight: 500;
    }

    .toggle-btn.active {
        background: linear-gradient(135deg, #2196f3 0%, #64b5f6 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.6;
    }

    .empty-title {
        font-size: 1.5rem;
        color: #64b5f6;
        margin: 0 0 10px 0;
        font-weight: 600;
    }

    .empty-text {
        color: #9e9e9e;
        font-size: 1rem;
    }

    /* Vue en grille */
    .classes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .class-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        border: 1px solid rgba(255, 255, 255, 0.18);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        position: relative;
    }

    .class-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(31, 38, 135, 0.5);
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
    }

    .class-name {
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0 0 8px 0;
        position: relative;
        z-index: 1;
    }

    .class-level {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .card-body {
        padding: 25px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 12px;
        background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
        border-radius: 12px;
        border: 1px solid rgba(33, 150, 243, 0.1);
    }

    .info-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2196f3 0%, #64b5f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 16px;
        color: white;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.8rem;
        color: #64b5f6;
        font-weight: 500;
        margin: 0 0 2px 0;
    }

    .info-value {
        font-size: 1rem;
        color: #1565c0;
        font-weight: 600;
        margin: 0;
    }

    .card-footer {
        padding: 20px 25px;
        background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
        border-top: 1px solid rgba(33, 150, 243, 0.1);
    }

    .view-details-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #2196f3 0%, #64b5f6 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .view-details-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(33, 150, 243, 0.4);
    }

    /* Vue en liste */
    .classes-list {
        display: none;
        flex-direction: column;
        gap: 15px;
    }

    .classes-list.active {
        display: flex;
    }

    .classes-grid.active {
        display: grid;
    }

    .list-item {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(31, 38, 135, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.18);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .list-item:hover {
        transform: translateX(10px);
        box-shadow: 0 8px 25px rgba(31, 38, 135, 0.3);
    }

    .list-content {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .list-avatar {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-right: 20px;
    }

    .list-info {
        flex: 1;
    }

    .list-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1565c0;
        margin: 0 0 5px 0;
    }

    .list-subtitle {
        font-size: 1rem;
        color: #64b5f6;
        margin: 0 0 8px 0;
    }

    .list-stats {
        display: flex;
        gap: 20px;
    }

    .list-stat {
        font-size: 0.9rem;
        color: #9e9e9e;
    }

    .list-arrow {
        font-size: 1.5rem;
        color: #64b5f6;
        transition: transform 0.3s ease;
    }

    .list-item:hover .list-arrow {
        transform: translateX(5px);
    }

    /* Modal améliorée */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(8px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .modal-overlay.active .modal-container {
        transform: scale(1);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 25px 25px 0 0;
        position: relative;
        overflow: hidden;
    }

    .modal-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
    }

    .modal-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 8px 0;
        position: relative;
        z-index: 1;
    }

    .modal-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .modal-body {
        padding: 30px;
    }

    .modal-section {
        margin-bottom: 25px;
    }

    .modal-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1565c0;
        margin: 0 0 15px 0;
        padding-bottom: 8px;
        border-bottom: 2px solid #e3f2fd;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }

    .detail-item {
        padding: 15px;
        background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
        border-radius: 12px;
        border: 1px solid rgba(33, 150, 243, 0.1);
    }

    .detail-label {
        font-size: 0.9rem;
        color: #64b5f6;
        font-weight: 500;
        margin: 0 0 5px 0;
    }

    .detail-value {
        font-size: 1.1rem;
        color: #1565c0;
        font-weight: 600;
        margin: 0;
    }

    .modal-footer {
        padding: 20px 30px;
        background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
        border-radius: 0 0 25px 25px;
        text-align: center;
    }

    .close-modal-btn {
        padding: 12px 30px;
        background: linear-gradient(135deg, #2196f3 0%, #64b5f6 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .close-modal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(33, 150, 243, 0.4);
    }

    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .class-card, .list-item {
        animation: slideInUp 0.6s ease-out forwards;
    }

    .class-card:nth-child(1), .list-item:nth-child(1) { animation-delay: 0.1s; }
    .class-card:nth-child(2), .list-item:nth-child(2) { animation-delay: 0.2s; }
    .class-card:nth-child(3), .list-item:nth-child(3) { animation-delay: 0.3s; }
    .class-card:nth-child(4), .list-item:nth-child(4) { animation-delay: 0.4s; }
    .class-card:nth-child(5), .list-item:nth-child(5) { animation-delay: 0.5s; }
    .class-card:nth-child(6), .list-item:nth-child(6) { animation-delay: 0.6s; }

    /* Responsive */
    @media (max-width: 768px) {
        .main-container {
            padding: 15px;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .controls-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-box {
            max-width: none;
        }
        
        .stats-bar {
            gap: 15px;
        }
        
        .stat-item {
            padding: 10px 15px;
        }
        
        .classes-grid {
            grid-template-columns: 1fr;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .list-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .list-avatar {
            margin-bottom: 10px;
            margin-right: 0;
        }
    }
</style>

<div class="main-container">
    <!-- En-tête de la page -->
    <div class="page-header">
        <h1 class="page-title">📚 Mes Classes</h1>
        <p class="page-subtitle">Découvrez toutes vos classes et leurs informations détaillées</p>
        
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-number">{{ isset($classes) ? count($classes) : 0 }}</span>
                <span class="stat-label">Classes</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ isset($classes) ? $classes->sum('nbEtudiants') : 0 }}</span>
                <span class="stat-label">Étudiants</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ isset($classes) ? $classes->sum('nbMatieres') : 0 }}</span>
                <span class="stat-label">Matières</span>
            </div>
        </div>
    </div>

    <!-- Contrôles -->
    <div class="controls-section">
        <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Rechercher une classe..." id="searchInput">
        </div>
        
        <div class="view-toggle">
            <button class="toggle-btn active" onclick="switchView('grid')">🔲 Grille</button>
            <button class="toggle-btn" onclick="switchView('list')">📋 Liste</button>
        </div>
    </div>

    <!-- Contenu principal -->
    @if(!isset($classes) || empty($classes) || (is_countable($classes) && count($classes) == 0))
        <div class="empty-state">
            <div class="empty-icon">📚</div>
            <h3 class="empty-title">Aucune classe disponible</h3>
            <p class="empty-text">Il n'y a actuellement aucune classe à afficher.</p>
        </div>
    @else
        <!-- Vue en grille -->
        <div class="classes-grid active" id="gridView">
            @foreach($classes as $index => $classe)
                <div class="class-card" onclick="showClassModal({{ json_encode($classe) }})">
                    <div class="card-header">
                        <h3 class="class-name">{{ $classe->nomClasse ?? 'Classe' }}</h3>
                        <p class="class-level">{{ $classe->niveau ?? 'Niveau non spécifié' }}</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon">👥</div>
                                <div class="info-content">
                                    <p class="info-label">Étudiants</p>
                                    <p class="info-value">{{ $classe->nbEtudiants ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">📚</div>
                                <div class="info-content">
                                    <p class="info-label">Matières</p>
                                    <p class="info-value">{{ $classe->nbMatieres ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">👨‍🏫</div>
                                <div class="info-content">
                                    <p class="info-label">Professeur</p>
                                    <p class="info-value">{{ Str::limit($classe->professeurPrincipal ?? 'Non assigné', 10) }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon">🏫</div>
                                <div class="info-content">
                                    <p class="info-label">Salle</p>
                                    <p class="info-value">{{ $classe->salle ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="view-details-btn">Voir les détails</button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Vue en liste -->
        <div class="classes-list" id="listView">
            @foreach($classes as $classe)
                <div class="list-item" onclick="showClassModal({{ json_encode($classe) }})">
                    <div class="list-content">
                        <div class="list-avatar">{{ substr($classe->nomClasse ?? 'C', 0, 2) }}</div>
                        <div class="list-info">
                            <h3 class="list-title">{{ $classe->nomClasse ?? 'Classe' }}</h3>
                            <p class="list-subtitle">{{ $classe->niveau ?? 'Niveau non spécifié' }}</p>
                            <div class="list-stats">
                                <span class="list-stat">👥 {{ $classe->nbEtudiants ?? 0 }} étudiants</span>
                                <span class="list-stat">📚 {{ $classe->nbMatieres ?? 0 }} matières</span>
                                <span class="list-stat">🏫 {{ $classe->salle ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="list-arrow">→</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal détaillée -->
<div class="modal-overlay" id="classModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title" id="modalClassName">Nom de la classe</h3>
            <p class="modal-subtitle" id="modalClassLevel">Niveau</p>
        </div>
        <div class="modal-body">
            <div class="modal-section">
                <h4 class="section-title">📋 Informations générales</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <p class="detail-label">Année scolaire</p>
                        <p class="detail-value" id="modalAnneeScolaire">2023-2024</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Nombre d'étudiants</p>
                        <p class="detail-value" id="modalNbEtudiants">0</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Nombre de matières</p>
                        <p class="detail-value" id="modalNbMatieres">0</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Salle principale</p>
                        <p class="detail-value" id="modalSalle">N/A</p>
                    </div>
                </div>
            </div>
            
            <div class="modal-section">
                <h4 class="section-title">👨‍🏫 Encadrement</h4>
                <div class="detail-item">
                    <p class="detail-label">Professeur principal</p>
                    <p class="detail-value" id="modalProfPrincipal">Non assigné</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="close-modal-btn" onclick="closeModal()">Fermer</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Variables globales
    let currentView = 'grid';
    
    // Fonction pour changer de vue
    function switchView(view) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const toggleBtns = document.querySelectorAll('.toggle-btn');
        
        // Réinitialiser les boutons
        toggleBtns.forEach(btn => btn.classList.remove('active'));
        
        if (view === 'grid') {
            gridView.classList.add('active');
            listView.classList.remove('active');
            toggleBtns[0].classList.add('active');
        } else {
            gridView.classList.remove('active');
            listView.classList.add('active');
            toggleBtns[1].classList.add('active');
        }
        
        currentView = view;
    }
    
    // Fonction pour afficher la modal
    function showClassModal(classe) {
        // Remplir les informations
        document.getElementById('modalClassName').textContent = classe.nomClasse || 'Classe';
        document.getElementById('modalClassLevel').textContent = classe.niveau || 'Niveau non spécifié';
        document.getElementById('modalAnneeScolaire').textContent = classe.anneeScolaire || '2023-2024';
        document.getElementById('modalNbEtudiants').textContent = classe.nbEtudiants || '0';
        document.getElementById('modalNbMatieres').textContent = classe.nbMatieres || '0';
        document.getElementById('modalSalle').textContent = classe.salle || 'Non assignée';
        document.getElementById('modalProfPrincipal').textContent = classe.professeurPrincipal || 'Non assigné';
        
        // Afficher la modal
        document.getElementById('classModal').classList.add('active');
    }
    
    // Fonction pour fermer la modal
    function closeModal() {
        document.getElementById('classModal').classList.remove('active');
    }
    
    // Fermer la modal en cliquant à l'extérieur
    document.getElementById('classModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Fonction de recherche
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const cards = document.querySelectorAll('.class-card, .list-item');
        
        cards.forEach(card => {
            const className = card.querySelector('.class-name, .list-title').textContent.toLowerCase();
            const classLevel = card.querySelector('.class-level, .list-subtitle').textContent.toLowerCase();
            
            if (className.includes(searchTerm) || classLevel.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Fermer la modal avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection