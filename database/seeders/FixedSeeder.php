<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixedSeeder extends Seeder
{
    public function run()
    {
        echo "=== CRÉATION DES DONNÉES AVEC LA VRAIE STRUCTURE ===\n";
        
        // 1. Créer des utilisateurs enseignants dans la table users
        $this->createUserEnseignants();
        
        // 2. Créer des classes avec la bonne structure
        $this->createClassesCorrect();
        
        // 3. Répartir les étudiants dans les classes
        $this->redistributeStudents();
        
        // 4. Créer des notes avec les bons IDs
        $this->createNotesCorrect();
        
        echo "\n=== RÉSULTAT FINAL ===\n";
        $this->showFinalStats();
    }
    
    private function createUserEnseignants()
    {
        echo "\n--- Création des utilisateurs enseignants ---\n";
        
        // Récupérer les enseignants existants
        $enseignants = Enseignant::all();
        
        foreach ($enseignants as $enseignant) {
            // Créer un utilisateur correspondant dans la table users
            $user = User::firstOrCreate(
                ['email' => $enseignant->courriel],
                [
                    'name' => $enseignant->nom,
                    'email' => $enseignant->courriel,
                    'password' => $enseignant->mot_de_passe,
                    'role' => 'enseignant'
                ]
            );
            echo "Utilisateur enseignant créé: {$user->name} (ID: {$user->id})\n";
        }
    }
    
    private function createClassesCorrect()
    {
        echo "\n--- Création des classes avec la bonne structure ---\n";
        
        // Récupérer les utilisateurs enseignants
        $userEnseignants = User::where('role', 'enseignant')->get();
        $matieres = Matiere::all();
        
        if ($userEnseignants->isEmpty()) {
            echo "Aucun utilisateur enseignant trouvé\n";
            return;
        }
        
        if ($matieres->isEmpty()) {
            echo "Aucune matière trouvée\n";
            return;
        }
        
        $classesData = [
            ['nom' => 'CP1', 'annee' => '2024-2025'],
            ['nom' => 'CP2', 'annee' => '2024-2025'],
            ['nom' => 'CE1', 'annee' => '2024-2025'],
            ['nom' => 'CE2', 'annee' => '2024-2025'],
            ['nom' => 'CM1', 'annee' => '2024-2025'],
            ['nom' => 'CM2', 'annee' => '2024-2025']
        ];
        
        foreach ($classesData as $index => $classeData) {
            try {
                $classe = Classe::create([
                    'nom_classe' => $classeData['nom'],  // Utiliser le bon nom de colonne
                    'annee' => $classeData['annee'],     // Ajouter l'année obligatoire
                    'enseignant_id' => $userEnseignants->get($index % $userEnseignants->count())->id,
                    'niveau_id' => 1  // Supposer qu'un niveau existe
                ]);
                echo "Classe créée: {$classe->nom_classe} (ID: {$classe->id})\n";
            } catch (\Exception $e) {
                echo "Erreur classe {$classeData['nom']}: " . $e->getMessage() . "\n";
            }
        }
    }
    
    private function redistributeStudents()
    {
        echo "\n--- Répartition des étudiants dans les classes ---\n";
        
        $etudiants = Etudiant::all();
        $classes = Classe::all();
        
        if ($classes->isEmpty()) {
            echo "Aucune classe disponible pour répartir les étudiants\n";
            return;
        }
        
        echo "Répartition de {$etudiants->count()} étudiants dans {$classes->count()} classes\n";
        
        foreach ($etudiants as $index => $etudiant) {
            $classe = $classes->get($index % $classes->count());
            $etudiant->classe_id = $classe->id;
            $etudiant->save();
            
            // Afficher seulement les 10 premiers pour éviter le spam
            if ($index < 10) {
                echo "Étudiant {$etudiant->nom} → {$classe->nom_classe}\n";
            } elseif ($index == 10) {
                echo "... et " . ($etudiants->count() - 10) . " autres étudiants\n";
            }
        }
    }
    
    private function createNotesCorrect()
    {
        echo "\n--- Création des notes avec les bons IDs ---\n";
        
        // Utiliser les IDs des utilisateurs, pas des enseignants
        $userEnseignants = User::where('role', 'enseignant')->get();
        $etudiants = Etudiant::limit(20)->get(); // Limiter pour éviter trop de notes
        $matieres = Matiere::all();
        
        if ($userEnseignants->isEmpty() || $etudiants->isEmpty() || $matieres->isEmpty()) {
            echo "Données insuffisantes pour créer des notes\n";
            return;
        }
        
        $types = ['Contrôle', 'Devoir', 'Examen', 'Participation'];
        
        foreach ($etudiants as $etudiant) {
            for ($i = 0; $i < 2; $i++) {
                try {
                    $note = Note::create([
                        'etudiant_id' => $etudiant->id,
                        'enseignant_id' => $userEnseignants->random()->id, // ID de la table users
                        'matiere_id' => $matieres->random()->id,
                        'type' => $types[array_rand($types)],
                        'note' => rand(10, 20),
                        'coefficient' => 1,
                        'validated' => true,
                        'date_evaluation' => now()
                    ]);
                    echo "Note: {$note->note}/20 pour {$etudiant->nom}\n";
                } catch (\Exception $e) {
                    echo "Erreur note pour {$etudiant->nom}: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    private function showFinalStats()
    {
        echo "Étudiants: " . Etudiant::count() . "\n";
        echo "Classes: " . Classe::count() . "\n";
        echo "Matières: " . Matiere::count() . "\n";
        echo "Notes: " . Note::count() . "\n";
        echo "Enseignants (table enseignants): " . Enseignant::count() . "\n";
        echo "Utilisateurs enseignants (table users): " . User::where('role', 'enseignant')->count() . "\n";
        
        // Vérifier la répartition des étudiants
        $classes = Classe::withCount('etudiants')->get();
        echo "\nRépartition par classe:\n";
        foreach ($classes as $classe) {
            echo "- {$classe->nom_classe}: {$classe->etudiants_count} étudiants\n";
        }
    }
}