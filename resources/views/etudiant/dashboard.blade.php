  {{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Etudiant Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>مرحبا بك Etudiant!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}




@extends('layouts.etudiant')

@section('title', 'Tableau de Bord - Étudiant')

@section('content')
<div class="section">
    <h2>Tableau de Bord</h2>
    <div class="grid">
        <div>
            <h3>Résumé Classes</h3>
            <div class="info-display">
                <p>Classe actuelle: <strong>{{ $classe->nomClasse ?? 'Aucune' }}</strong></p>
                <p>Année: <strong>{{ $classe->annee ?? '-' }}</strong></p>
                <a href="{{ route('etudiant.classes') }}" class="btn">Consulter Classes</a>
            </div>
        </div>
        <div>
            <h3>Résumé Matières</h3>
            <div class="info-display">
                <p>Nombre de matières: <strong>{{ $matieres->count() }}</strong></p>
                <a href="{{ route('etudiant.matieres') }}" class="btn">Consulter Matières</a>
            </div>
        </div>
    </div>

    <!-- Informations personnelles résumées -->
     <div class="etudiant-summary">
        <h3>Mes Informations</h3>
        <div class="info-display">
            @foreach($infos as $key => $value)
                <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection 

 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Étudiant - {{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .section h2 {
            margin-bottom: 15px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-secondary {
            background: #95a5a6;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .list-item {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .list-item:hover {
            background: #f8f9fa;
            border-color: #3498db;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .student-info {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .hidden {
            display: none;
        }

        .navigation {
            margin-bottom: 20px;
        }

        .nav-btn {
            background: #34495e;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        .nav-btn.active {
            background: #3498db;
        }

        .info-display {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }

        select {
            margin: 5px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête avec informations étudiant -->
        <div class="header">
            <div class="student-info">
                <h1>Interface Étudiant</h1>
                <p><strong>Nom:</strong> <span id="studentName">-</span></p>
                <p><strong>Email:</strong> <span id="studentEmail">-</span></p>
                <p><strong>Niveau:</strong> <span id="studentLevel">-</span></p>
            </div>
        </div>

        <!-- Navigation -->
        <div class="navigation">
            <button class="nav-btn active" onclick="showSection('dashboard')">Tableau de Bord</button>
            <button class="nav-btn" onclick="showSection('classes')">Mes Classes</button>
            <button class="nav-btn" onclick="showSection('matieres')">Mes Matières</button>
            <button class="nav-btn" onclick="showSection('infos')">Infos Personnelles</button>
        </div>

        <!-- Section Tableau de Bord -->
        <div id="dashboard" class="section">
            <h2>Tableau de Bord</h2>
            <div class="grid">
                <div>
                    <h3>Résumé Classes</h3>
                    <div id="classesSummary">
                        <p>Nombre de classes: <span id="classCount">0</span></p>
                        <button class="btn" onclick="etudiant.consulterClasses(); afficherClasses()">Consulter Classes</button>
                    </div>
                </div>
                <div>
                    <h3>Résumé Matières</h3>
                    <div id="matieresSummary">
                        <p>Nombre de matières: <span id="matterCount">0</span></p>
                        <button class="btn" onclick="etudiant.consulterMatieres(); afficherMatieres()">Consulter Matières</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Classes -->
        <div id="classes" class="section hidden">
            <h2>Mes Classes</h2>
            <button class="btn" onclick="etudiant.consulterClasses(); afficherClasses()">Actualiser Liste</button>
            <div id="classesList"></div>
        </div>

        <!-- Section Matières -->
        <div id="matieres" class="section hidden">
            <h2>Mes Matières</h2>
            <button class="btn" onclick="etudiant.consulterMatieres(); afficherMatieres()">Actualiser Liste</button>
            <div id="matieresList"></div>
        </div>

        <!-- Section Informations Personnelles -->
        <div id="infos" class="section hidden">
            <h2>Informations Personnelles</h2>
            <button class="btn" onclick="etudiant.consulterInfosPersonnelles(); afficherInfosPersonnelles()">Consulter Informations</button>
            <div id="infosDisplay"></div>
            
            <h3>Modifier Informations</h3>
            <div>
                <input type="text" id="newName" placeholder="Nouveau nom" style="margin: 5px; padding: 8px;">
                <input type="email" id="newEmail" placeholder="Nouvel email" style="margin: 5px; padding: 8px;">
                <select id="newLevel">
                    <option value="">Choisir un niveau</option>
                    <option value="Primaire">Primaire</option>
                    <option value="Collège">Collège</option>
                    <option value="Lycée">Lycée</option>
                </select>
                <br>
                <button class="btn" onclick="modifierInfos()">Modifier</button>
            </div>
        </div>
    </div>

    <script>
        // Classe Etudiant avec les nouvelles données
        class Etudiant {
            constructor(nom, email, password, niveau) {
                this.nom = nom;
                this.email = email;
                this.password = password;
                this.niveau = niveau;
                
                // Classes par niveau scolaire
                this.classes = [
                    { id: 1, nomClasse: "6ème A", annee: "2024", nbEtudiants: 28 },
                    { id: 2, nomClasse: "5ème B", annee: "2024", nbEtudiants: 30 },
                    { id: 3, nomClasse: "4ème Sciences", annee: "2024", nbEtudiants: 25 }
                ];
                
                // Matières du programme scolaire marocain
                this.matieres = [
                    { id: 1, nomMatiere: "Arabe", coefficient: 4 },
                    { id: 2, nomMatiere: "Français", coefficient: 3 },
                    { id: 3, nomMatiere: "Mathématiques", coefficient: 4 },
                    { id: 4, nomMatiere: "Anglais", coefficient: 2 },
                    { id: 5, nomMatiere: "Physique-Chimie", coefficient: 3 },
                    { id: 6, nomMatiere: "Sciences de la Vie et de la Terre (SVT)", coefficient: 3 },
                    { id: 7, nomMatiere: "Histoire-Géographie", coefficient: 2 },
                    { id: 8, nomMatiere: "Éducation Islamique", coefficient: 2 },
                    { id: 9, nomMatiere: "Éducation Physique et Sport", coefficient: 1 },
                    { id: 10, nomMatiere: "Informatique", coefficient: 2 },
                    { id: 11, nomMatiere: "Arts Plastiques", coefficient: 1 },
                    { id: 12, nomMatiere: "Philosophie", coefficient: 3 }
                ];
            }

            // Méthodes du diagramme UML
            consulterClasses() {
                console.log(`${this.nom} consulte ses classes`);
                console.log("Classes trouvées:", this.classes);
                return this.classes;
            }

            consulterMatieres() {
                console.log(`${this.nom} consulte ses matières`);
                console.log("Matières trouvées:", this.matieres);
                return this.matieres;
            }

            consulterInfosPersonnelles() {
                console.log(`${this.nom} consulte ses informations personnelles`);
                const infos = {
                    nom: this.nom,
                    email: this.email,
                    niveau: this.niveau,
                    nbClasses: this.classes.length,
                    nbMatieres: this.matieres.length
                };
                console.log("Informations:", infos);
                return infos;
            }

            // Méthodes supplémentaires pour la gestion
            modifierInfos(newNom, newEmail, newNiveau) {
                if (newNom) this.nom = newNom;
                if (newEmail) this.email = newEmail;
                if (newNiveau) this.niveau = newNiveau;
                console.log("Informations modifiées:", { nom: this.nom, email: this.email, niveau: this.niveau });
            }

            ajouterClasse(classe) {
                this.classes.push(classe);
                console.log("Classe ajoutée:", classe);
            }

            ajouterMatiere(matiere) {
                this.matieres.push(matiere);
                console.log("Matière ajoutée:", matiere);
            }
        }

        // Instance de l'étudiant avec niveau scolaire
         const etudiant = new Etudiant(
        //     "Ahmed Benali", 
        //     "ahmed.benali@ecole.ma", 
        //     "password123", 
        //     "Collège"
         );

        // Fonctions d'affichage
        function afficherInfosEtudiant() {
            document.getElementById('studentName').textContent = etudiant.nom;
            document.getElementById('studentEmail').textContent = etudiant.email;
            document.getElementById('studentLevel').textContent = etudiant.niveau;
            document.getElementById('classCount').textContent = etudiant.classes.length;
            document.getElementById('matterCount').textContent = etudiant.matieres.length;
        }

        function afficherClasses() {
            const classesList = document.getElementById('classesList');
            const classes = etudiant.consulterClasses();
            
            classesList.innerHTML = '';
            classes.forEach(classe => {
                const div = document.createElement('div');
                div.className = 'list-item';
                div.innerHTML = `
                    <h4>${classe.nomClasse}</h4>
                    <p>Année: ${classe.annee} | Étudiants: ${classe.nbEtudiants}</p>
                `;
                div.onclick = () => consulterDetailClasse(classe);
                classesList.appendChild(div);
            });
        }

        function afficherMatieres() {
            const matieresList = document.getElementById('matieresList');
            const matieres = etudiant.consulterMatieres();
            
            matieresList.innerHTML = '';
            matieres.forEach(matiere => {
                const div = document.createElement('div');
                div.className = 'list-item';
                div.innerHTML = `
                    <h4>${matiere.nomMatiere}</h4>
                    <p>Coefficient: ${matiere.coefficient}</p>
                `;
                div.onclick = () => consulterDetailMatiere(matiere);
                matieresList.appendChild(div);
            });
        }

        function afficherInfosPersonnelles() {
            const infosDisplay = document.getElementById('infosDisplay');
            const infos = etudiant.consulterInfosPersonnelles();
            
            infosDisplay.innerHTML = `
                <div class="info-display">
                    <h4>Informations Détaillées</h4>
                    <p><strong>Nom:</strong> ${infos.nom}</p>
                    <p><strong>Email:</strong> ${infos.email}</p>
                    <p><strong>Niveau:</strong> ${infos.niveau}</p>
                    <p><strong>Nombre de classes:</strong> ${infos.nbClasses}</p>
                    <p><strong>Nombre de matières:</strong> ${infos.nbMatieres}</p>
                </div>
            `;
        }

        function consulterDetailClasse(classe) {
            alert(`Détails de la classe: ${classe.nomClasse}\nAnnée: ${classe.annee}\nÉtudiants: ${classe.nbEtudiants}`);
        }

        function consulterDetailMatiere(matiere) {
            alert(`Détails de la matière: ${matiere.nomMatiere}\nCoefficient: ${matiere.coefficient}`);
        }

        function modifierInfos() {
            const newName = document.getElementById('newName').value;
            const newEmail = document.getElementById('newEmail').value;
            const newLevel = document.getElementById('newLevel').value;
            
            etudiant.modifierInfos(newName, newEmail, newLevel);
            afficherInfosEtudiant();
            
            // Réinitialiser les champs
            document.getElementById('newName').value = '';
            document.getElementById('newEmail').value = '';
            document.getElementById('newLevel').value = '';
            
            alert('Informations modifiées avec succès!');
        }

        // Navigation entre sections
        function showSection(sectionName) {
            // Masquer toutes les sections
            const sections = ['dashboard', 'classes', 'matieres', 'infos'];
            sections.forEach(section => {
                document.getElementById(section).classList.add('hidden');
            });
            
            // Afficher la section sélectionnée
            document.getElementById(sectionName).classList.remove('hidden');
            
            // Mettre à jour les boutons de navigation
            const navButtons = document.querySelectorAll('.nav-btn');
            navButtons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }

        // Initialisation
        window.onload = function() {
            afficherInfosEtudiant();
            console.log("Interface étudiant initialisée");
            console.log("Étudiant:", etudiant);
        };
    </script>
</body>
</html>