// Configuration CSRF pour les requêtes AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Configuration des en-têtes AJAX
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Fonction pour les requêtes AJAX
    window.makeAjaxRequest = function(url, method = 'GET', data = {}) {
        return fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: method !== 'GET' ? JSON.stringify(data) : null
        });
    };
    
    // Animation pour les éléments de liste
    const listItems = document.querySelectorAll('.list-item');
    listItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Notification toast
    window.showNotification = function(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.textContent = message;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '1000';
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    };
    
    console.log('Interface étudiant initialisée');
});

// Fonctions globales pour les détails
function consulterDetailClasse(classe) {
    const details = `
        Nom de la classe: ${classe.nomClasse}
        Année: ${classe.annee}
        Niveau: ${classe.niveau}
        Nombre d'étudiants: ${classe.etudiants_count || 'Non défini'}
    `;
    alert(details);
}

function consulterDetailMatiere(matiere) {
    const details = `
        Matière: ${matiere.nomMatiere}
        Coefficient: ${matiere.coefficient}
    `;
    alert(details);
}