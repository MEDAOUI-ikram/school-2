@extends('layouts.etudiant')

@section('title', 'Mes Matières - Étudiant')

@section('content')
<style>
    /* Styles avec palette blanc/bleu clair */
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e1f5fe 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .section {
        max-width: 800px;
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 10px 25px rgba(33, 150, 243, 0.1);
        border: 1px solid #e3f2fd;
    }

    .section h2 {
        font-size: 28px;
        font-weight: 700;
        color: #1565c0;
        margin: 0 0 32px 0;
        padding-bottom: 16px;
        border-bottom: 2px solid #e3f2fd;
        text-shadow: 0 2px 4px rgba(33, 150, 243, 0.1);
        display: flex;
        align-items: center;
    }

    .section h2:before {
        content: "📚";
        margin-right: 12px;
        font-size: 32px;
    }

    .info-display {
        text-align: center;
        padding: 48px 24px;
        background-color: #f8fafc;
        border-radius: 12px;
        border: 2px dashed #bbdefb;
    }

    .info-display p {
        font-size: 18px;
        color: #64b5f6;
        margin: 0;
        font-weight: 500;
    }

    #matieresList {
        display: grid;
        gap: 16px;
    }

    .list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background-color: #fafafa;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e3f2fd;
        box-shadow: 0 2px 8px rgba(33, 150, 243, 0.08);
        position: relative;
    }

    .list-item:hover {
        background-color: #e3f2fd;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(33, 150, 243, 0.15);
    }

    .list-item:after {
        content: "→";
        font-size: 24px;
        color: #64b5f6;
        font-weight: bold;
        margin-left: 16px;
    }

    .list-item h4 {
        font-size: 20px;
        font-weight: 600;
        color: #1565c0;
        margin: 0 0 8px 0;
    }

    .list-item p {
        margin: 0;
        background-color: #e3f2fd;
        padding: 6px 12px;
        border-radius: 20px;
        width: fit-content;
        font-size: 14px;
        color: #1976d2;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .list-item p:before {
        content: "🏆";
        margin-right: 6px;
        font-size: 14px;
    }

    /* Animation d'apparition */
    .list-item {
        animation: slideIn 0.5s ease-out forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    .list-item:nth-child(1) { animation-delay: 0.1s; }
    .list-item:nth-child(2) { animation-delay: 0.2s; }
    .list-item:nth-child(3) { animation-delay: 0.3s; }
    .list-item:nth-child(4) { animation-delay: 0.4s; }
    .list-item:nth-child(5) { animation-delay: 0.5s; }
    .list-item:nth-child(6) { animation-delay: 0.6s; }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Style pour la modal/alert personnalisée */
    .custom-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(33, 150, 243, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: #ffffff;
        padding: 32px;
        border-radius: 16px;
        border: 2px solid #e3f2fd;
        box-shadow: 0 20px 40px rgba(33, 150, 243, 0.2);
        max-width: 400px;
        width: 90%;
    }

    .modal-title {
        color: #1565c0;
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 20px 0;
        text-align: center;
    }

    .modal-field {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
        padding: 12px 16px;
        background-color: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e3f2fd;
    }

    .modal-label {
        color: #1976d2;
        font-weight: bold;
        margin-right: 12px;
        min-width: 100px;
    }

    .modal-value {
        color: #1565c0;
        font-size: 16px;
        font-weight: 500;
    }

    .close-btn {
        background-color: #2196f3;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        margin-top: 20px;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .close-btn:hover {
        background-color: #1976d2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .section {
            margin: 10px;
            padding: 20px;
        }
        
        .section h2 {
            font-size: 24px;
        }
        
        .list-item {
            padding: 16px;
        }
        
        .list-item h4 {
            font-size: 18px;
        }
    }
</style>

<div class="section">
    <h2>Mes Matières</h2>

    @if($matieres->isEmpty())
        <div class="info-display">
           
        </div>
    @else
        <div id="matieresList">
            @foreach($matieres as $matiere)
                <div class="list-item" onclick="consulterDetailMatiere({{ json_encode($matiere) }})">
                    <div>
                        <h4>{{ $matiere->nomMatiere }}</h4>
                        <p>Coefficient: {{ $matiere->coefficient }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal personnalisée -->
<div id="customModal" class="custom-modal" style="display: none;">
    <div class="modal-content">
        <h3 class="modal-title">Détails de la matière</h3>
        <div id="modalBody"></div>
        <button class="close-btn" onclick="closeModal()">Fermer</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function consulterDetailMatiere(matiere) {
        // Créer le contenu de la modal
        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = `
            <div class="modal-field">
                <span class="modal-label">Matière:</span>
                <span class="modal-value">${matiere.nomMatiere}</span>
            </div>
            <div class="modal-field">
                <span class="modal-label">Coefficient:</span>
                <span class="modal-value">${matiere.coefficient}</span>
            </div>
        `;
        
        // Afficher la modal
        document.getElementById('customModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('customModal').style.display = 'none';
    }
    
    // Fermer la modal en cliquant à l'extérieur
    document.getElementById('customModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection