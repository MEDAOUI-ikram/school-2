<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Enseignant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DiagnosticSeeder extends Seeder
{
    public function run()
    {
        echo "=== DIAGNOSTIC DES TABLES ===\n";
        
        // 1. Diagnostic de toutes les tables
        $tables = ['classes', 'etudiants', 'matieres', 'enseignants', 'notes'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                echo "\nTable '{$table}' existe avec les colonnes:\n";
                echo "- " . implode("\n- ", $columns) . "\n";
                
                $count = DB::table($table)->count();
                echo "Nombre d'enregistrements: {$count}\n";
            } else {
                echo "\nTable '{$table}' n'existe PAS\n";
            }
        }
        
        echo "\n=== CRÉATION DES DONNÉES ===\n";
        
        // 2. Créer des matières d'abord
        $this->createMatieres();
        
        // 3. Créer des enseignants
        $this->createEnseignants();
        
        // 4. Créer des classes avec la bonne structure
        $this->createClasses();
        
        // 5. Associer les étudiants aux classes
        $this->assignStudentsToClasses();
        
        // 6. Créer des notes
        $this->createNotes();
        
        echo "\n=== DIAGNOSTIC FINAL ===\n";
        $this->finalDiagnostic();
    }
    
    private function createMatieres()
    {
        echo "\n--- Création des matières ---\n";
        
        if (!Schema::hasTable('matieres')) {
            echo "Table 'matieres' n'existe pas\n";
            return;
        }
        
        $columns = Schema::getColumnListing('matieres');
        echo "Colonnes matières: " . implode(', ', $columns) . "\n";
        
        $nomColumn = $this->findNameColumn($columns);
        
        $matieresData = ['Mathématiques', 'Français', 'Sciences', 'Histoire', 'Géographie'];
        
        foreach ($matieresData as $nom) {
            try {
                $data = [$nomColumn => $nom];
                
                // Ajouter d'autres colonnes si elles existent
                if (in_array('description', $columns)) {
                    $data['description'] = "Cours de {$nom}";
                }
                if (in_array('code', $columns)) {
                    $data['code'] = strtoupper(substr($nom, 0, 3));
                }
                if (in_array('niveau_id', $columns)) {
                    $data['niveau_id'] = 1; // Supposer qu'un niveau existe
                }
                
                $matiere = Matiere::firstOrCreate([$nomColumn => $nom], $data);
                echo "Matière: {$matiere->{$nomColumn}}\n";
            } catch (\Exception $e) {
                echo "Erreur matière {$nom}: " . $e->getMessage() . "\n";
            }
        }
    }
    
    private function createEnseignants()
    {
        echo "\n--- Création des enseignants ---\n";
        
        if (!Schema::hasTable('enseignants')) {
            echo "Table 'enseignants' n'existe pas\n";
            return;
        }
        
        $columns = Schema::getColumnListing('enseignants');
        echo "Colonnes enseignants: " . implode(', ', $columns) . "\n";
        
        $nomColumn = $this->findNameColumn($columns);
        $emailColumn = $this->findEmailColumn($columns);
        $passwordColumn = $this->findPasswordColumn($columns);
        
        $enseignantsData = [
            ['nom' => 'M. Dupont', 'email' => 'dupont@ecole.com'],
            ['nom' => 'Mme Martin', 'email' => 'martin@ecole.com'],
            ['nom' => 'M. Bernard', 'email' => 'bernard@ecole.com']
        ];
        
        foreach ($enseignantsData as $enseignantData) {
            try {
                $data = [
                    $nomColumn => $enseignantData['nom'],
                    $emailColumn => $enseignantData['email'],
                    $passwordColumn => Hash::make('password')
                ];
                
                // Ajouter d'autres colonnes si elles existent
                if (in_array('specialite', $columns)) {
                    $data['specialite'] = 'Primaire';
                }
                if (in_array('telephone', $columns)) {
                    $data['telephone'] = '0123456789';
                }
                
                $enseignant = Enseignant::firstOrCreate([$emailColumn => $enseignantData['email']], $data);
                echo "Enseignant: {$enseignant->{$nomColumn}}\n";
            } catch (\Exception $e) {
                echo "Erreur enseignant {$enseignantData['nom']}: " . $e->getMessage() . "\n";
            }
        }
    }
    
    private function createClasses()
    {
        echo "\n--- Création des classes ---\n";
        
        if (!Schema::hasTable('classes')) {
            echo "Table 'classes' n'existe pas\n";
            return;
        }
        
        $columns = Schema::getColumnListing('classes');
        echo "Colonnes classes: " . implode(', ', $columns) . "\n";
        
        $nomColumn = $this->findNameColumn($columns);
        
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        
        if ($matieres->isEmpty() || $enseignants->isEmpty()) {
            echo "Pas assez de matières ou d'enseignants\n";
            return;
        }
        
        $classesData = ['CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2'];
        
        foreach ($classesData as $index => $nomClasse) {
            try {
                $data = [
                    $nomColumn => $nomClasse,
                ];
                
                // Ajouter les colonnes obligatoires si elles existent
                if (in_array('matiere_id', $columns)) {
                    $data['matiere_id'] = $matieres->get($index % $matieres->count())->id;
                }
                if (in_array('enseignant_id', $columns)) {
                    $data['enseignant_id'] = $enseignants->get($index % $enseignants->count())->id;
                }
                if (in_array('salle', $columns)) {
                    $data['salle'] = 'Salle ' . (101 + $index);
                }
                if (in_array('niveau_id', $columns)) {
                    $data['niveau_id'] = 1;
                }
                if (in_array('capacite', $columns)) {
                    $data['capacite'] = 25;
                }
                if (in_array('description', $columns)) {
                    $data['description'] = "Classe de {$nomClasse}";
                }
                
                $classe = Classe::create($data);
                echo "Classe créée: {$classe->{$nomColumn}}\n";
            } catch (\Exception $e) {
                echo "Erreur classe {$nomClasse}: " . $e->getMessage() . "\n";
                echo "Données tentées: " . json_encode($data) . "\n";
            }
        }
    }
    
    private function assignStudentsToClasses()
    {
        echo "\n--- Association étudiants-classes ---\n";
        
        $etudiants = Etudiant::all();
        $classes = Classe::all();
        
        if ($etudiants->isEmpty() || $classes->isEmpty()) {
            echo "Pas d'étudiants ou de classes à associer\n";
            return;
        }
        
        foreach ($etudiants as $index => $etudiant) {
            $classe = $classes->get($index % $classes->count());
            $etudiant->classe_id = $classe->id;
            $etudiant->save();
            echo "Étudiant {$etudiant->nom} {$etudiant->prenom} → Classe {$classe->id}\n";
        }
    }
    
    private function createNotes()
    {
        echo "\n--- Création des notes ---\n";
        
        if (!Schema::hasTable('notes')) {
            echo "Table 'notes' n'existe pas\n";
            return;
        }
        
        $etudiants = Etudiant::all();
        $enseignants = Enseignant::all();
        
        if ($etudiants->isEmpty() || $enseignants->isEmpty()) {
            echo "Pas d'étudiants ou d'enseignants pour créer des notes\n";
            return;
        }
        
        $types = ['Contrôle', 'Devoir', 'Examen', 'Participation'];
        
        foreach ($etudiants->take(10) as $etudiant) {
            for ($i = 0; $i < 2; $i++) {
                try {
                    $note = Note::create([
                        'etudiant_id' => $etudiant->id,
                        'enseignant_id' => $enseignants->random()->id,
                        'type' => $types[array_rand($types)],
                        'note' => rand(10, 20)
                    ]);
                    echo "Note: {$note->note}/20 pour {$etudiant->nom}\n";
                } catch (\Exception $e) {
                    echo "Erreur note: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    private function finalDiagnostic()
    {
        echo "Étudiants: " . Etudiant::count() . "\n";
        echo "Classes: " . Classe::count() . "\n";
        echo "Matières: " . Matiere::count() . "\n";
        echo "Notes: " . Note::count() . "\n";
        echo "Enseignants: " . Enseignant::count() . "\n";
    }
    
    private function findNameColumn($columns)
    {
        $possibleNames = ['nom', 'nom_classe', 'libelle', 'designation', 'name', 'title'];
        foreach ($possibleNames as $name) {
            if (in_array($name, $columns)) {
                return $name;
            }
        }
        return 'nom'; // Par défaut
    }
    
    private function findEmailColumn($columns)
    {
        $possibleEmails = ['email', 'courriel', 'mail', 'e_mail'];
        foreach ($possibleEmails as $email) {
            if (in_array($email, $columns)) {
                return $email;
            }
        }
        return 'email'; // Par défaut
    }
    
    private function findPasswordColumn($columns)
    {
        $possiblePasswords = ['password', 'mot_de_passe', 'mdp', 'pass'];
        foreach ($possiblePasswords as $password) {
            if (in_array($password, $columns)) {
                return $password;
            }
        }
        return 'password'; // Par défaut
    }
}