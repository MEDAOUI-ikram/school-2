<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\Niveau;
use Illuminate\Support\Facades\Schema;

class ClasseSeeder extends Seeder
{
    public function run()
    {
        // Vérifier quelles colonnes existent dans la table classes
        $columns = Schema::getColumnListing('classes');
        
        echo "Colonnes disponibles dans la table classes: " . implode(', ', $columns) . "\n";
        
        // Récupérer les données nécessaires
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();
        $niveaux = Niveau::all();
        
        if ($enseignants->count() > 0 && $matieres->count() > 0) {
            
            // Déterminer le nom de la colonne pour le nom de la classe
            $nomColumn = 'nom';
            if (in_array('nom_classe', $columns)) {
                $nomColumn = 'nom_classe';
            } elseif (in_array('libelle', $columns)) {
                $nomColumn = 'libelle';
            } elseif (in_array('designation', $columns)) {
                $nomColumn = 'designation';
            }
            
            // Créer les données de base pour les classes
            $classesData = [
                [
                    $nomColumn => 'CP1',
                    'matiere_id' => $matieres->first()->id,
                    'enseignant_id' => $enseignants->first()->id,
                ],
                [
                    $nomColumn => 'CP2',
                    'matiere_id' => $matieres->skip(1)->first()->id ?? $matieres->first()->id,
                    'enseignant_id' => $enseignants->skip(1)->first()->id ?? $enseignants->first()->id,
                ],
                [
                    $nomColumn => 'CE1',
                    'matiere_id' => $matieres->first()->id,
                    'enseignant_id' => $enseignants->first()->id,
                ],
                [
                    $nomColumn => 'CE2',
                    'matiere_id' => $matieres->skip(1)->first()->id ?? $matieres->first()->id,
                    'enseignant_id' => $enseignants->skip(1)->first()->id ?? $enseignants->first()->id,
                ]
            ];
            
            // Ajouter les colonnes optionnelles si elles existent
            foreach ($classesData as &$classeData) {
                if (in_array('salle', $columns)) {
                    $classeData['salle'] = 'Salle ' . rand(101, 110);
                }
                
                if (in_array('niveau_id', $columns) && $niveaux->count() > 0) {
                    $classeData['niveau_id'] = $niveaux->random()->id;
                }
                
                if (in_array('capacite', $columns)) {
                    $classeData['capacite'] = rand(20, 35);
                }
                
                if (in_array('description', $columns)) {
                    $classeData['description'] = 'Classe de ' . $classeData[$nomColumn];
                }
            }
            
            // Créer les classes
            foreach ($classesData as $classeData) {
                try {
                    $classe = Classe::create($classeData);
                    echo "Classe créée: " . $classe->{$nomColumn} . "\n";
                } catch (\Exception $e) {
                    echo "Erreur lors de la création de la classe: " . $e->getMessage() . "\n";
                }
            }
            
            // Associer des étudiants aux classes si ils existent
            $etudiants = Etudiant::all();
            $classes = Classe::all();
            
            if ($etudiants->count() > 0 && $classes->count() > 0) {
                foreach ($etudiants as $index => $etudiant) {
                    $classe = $classes->get($index % $classes->count());
                    $etudiant->classe_id = $classe->id;
                    $etudiant->save();
                }
            }
        } else {
            echo "Pas assez d'enseignants ou de matières pour créer des classes.\n";
        }
    }
}