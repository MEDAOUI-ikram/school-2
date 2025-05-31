<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\Niveau;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Matiere;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = Niveau::all();
        $anneeActuelle = date('Y');

        if ($niveaux->isEmpty()) {
            $this->command->warn('Aucun niveau trouvé. Veuillez d\'abord exécuter NiveauSeeder.');
            return;
        }

        // Récupérer les niveaux par nom
        $niveauPrimaire = $niveaux->where('nom_niveau', 'Primaire')->first();
        $niveauCollege = $niveaux->where('nom_niveau', 'Collège')->first();
        $niveauLycee = $niveaux->where('nom_niveau', 'Lycée')->first();

        // Classes pour le niveau Primaire
        $classesPrimaire = [
            ['nom_classe' => 'CP-A', 'description' => 'Cours Préparatoire A'],
            ['nom_classe' => 'CP-B', 'description' => 'Cours Préparatoire B'],
            ['nom_classe' => 'CE1-A', 'description' => 'Cours Élémentaire 1 A'],
            ['nom_classe' => 'CE1-B', 'description' => 'Cours Élémentaire 1 B'],
            ['nom_classe' => 'CE2-A', 'description' => 'Cours Élémentaire 2 A'],
            ['nom_classe' => 'CE2-B', 'description' => 'Cours Élémentaire 2 B'],
            ['nom_classe' => 'CM1-A', 'description' => 'Cours Moyen 1 A'],
            ['nom_classe' => 'CM1-B', 'description' => 'Cours Moyen 1 B'],
            ['nom_classe' => 'CM2-A', 'description' => 'Cours Moyen 2 A'],
            ['nom_classe' => 'CM2-B', 'description' => 'Cours Moyen 2 B'],
        ];

        // Classes pour le niveau Collège
        $classesCollege = [
            ['nom_classe' => '6ème-A', 'description' => 'Sixième A'],
            ['nom_classe' => '6ème-B', 'description' => 'Sixième B'],
            ['nom_classe' => '5ème-A', 'description' => 'Cinquième A'],
            ['nom_classe' => '5ème-B', 'description' => 'Cinquième B'],
            ['nom_classe' => '4ème-A', 'description' => 'Quatrième A'],
            ['nom_classe' => '4ème-B', 'description' => 'Quatrième B'],
            ['nom_classe' => '3ème-A', 'description' => 'Troisième A'],
            ['nom_classe' => '3ème-B', 'description' => 'Troisième B'],
        ];

        // Classes pour le niveau Lycée
        $classesLycee = [
            ['nom_classe' => '2nde-A', 'description' => 'Seconde Générale A'],
            ['nom_classe' => '2nde-B', 'description' => 'Seconde Générale B'],
            ['nom_classe' => '1ère-S', 'description' => 'Première Scientifique'],
            ['nom_classe' => '1ère-ES', 'description' => 'Première Économique et Sociale'],
            ['nom_classe' => '1ère-L', 'description' => 'Première Littéraire'],
            ['nom_classe' => 'Tle-S', 'description' => 'Terminale Scientifique'],
            ['nom_classe' => 'Tle-ES', 'description' => 'Terminale Économique et Sociale'],
            ['nom_classe' => 'Tle-L', 'description' => 'Terminale Littéraire'],
        ];

        // Créer les classes pour chaque niveau
        $this->createClassesForNiveau($classesPrimaire, $niveauPrimaire, $anneeActuelle);
        $this->createClassesForNiveau($classesCollege, $niveauCollege, $anneeActuelle);
        $this->createClassesForNiveau($classesLycee, $niveauLycee, $anneeActuelle);
    }

    /**
     * Créer des classes pour un niveau donné
     */
    private function createClassesForNiveau($classes, $niveau, $anneeActuelle)
    {
        if (!$niveau) {
            return;
        }

        foreach ($classes as $classeData) {
            // Utiliser firstOrCreate pour éviter les doublons
            $classe = Classe::firstOrCreate(
                [
                    'nom_classe' => $classeData['nom_classe'],
                    'annee' => $anneeActuelle,
                    'niveau_id' => $niveau->id,
                ],
                [
                    'nom_classe' => $classeData['nom_classe'],
                    'annee' => $anneeActuelle,
                    'niveau_id' => $niveau->id,
                ]
            );

            // Assigner des étudiants à la classe (entre 15 et 30 étudiants par classe)
            $this->assignEtudiantsToClasse($classe, $niveau);

            // Assigner des enseignants et matières à la classe
            $this->assignEnseignantsAndMatieresToClasse($classe, $niveau);
        }

        $this->command->info("Classes créées pour le niveau {$niveau->nom_niveau} : " . count($classes));
    }

    /**
     * Assigner des étudiants à une classe
     */
    private function assignEtudiantsToClasse($classe, $niveau)
    {
        $etudiants = Etudiant::where('niveau', $niveau->nom_niveau)->take(rand(15, 30))->get();

        // Si pas assez d'étudiants, en créer de nouveaux
        if ($etudiants->count() < 15) {
            $nouveauxEtudiants = Etudiant::factory(rand(15, 30))->create([
                'niveau' => $niveau->nom_niveau
            ]);
            $etudiants = $etudiants->merge($nouveauxEtudiants);
        }

        foreach ($etudiants as $etudiant) {
            // Vérifier si l'étudiant n'est pas déjà dans cette classe
            if (!$classe->etudiants()->where('etudiant_id', $etudiant->id)->exists()) {
                $classe->etudiants()->attach($etudiant->id, [
                    'nom_groupe' => 'Groupe ' . chr(65 + rand(0, 2)), // A, B, ou C
                    'date_inscription' => now(),
                ]);
            }
        }
    }

    /**
     * Assigner des enseignants et matières à une classe
     */
    private function assignEnseignantsAndMatieresToClasse($classe, $niveau)
    {
        // Récupérer les matières pour ce niveau
        $matieres = Matiere::where('niveau_id', $niveau->id)->get();

        if ($matieres->isEmpty()) {
            return;
        }

        foreach ($matieres as $matiere) {
            // Récupérer l'enseignant de cette matière
            $enseignant = $matiere->enseignant;

            if ($enseignant) {
                // Vérifier si cette combinaison n'existe pas déjà
                $exists = \DB::table('classe_enseignant_matiere')
                    ->where('classe_id', $classe->id)
                    ->where('enseignant_id', $enseignant->id)
                    ->where('matiere_id', $matiere->id)
                    ->exists();

                if (!$exists) {
                    \DB::table('classe_enseignant_matiere')->insert([
                        'classe_id' => $classe->id,
                        'enseignant_id' => $enseignant->id,
                        'matiere_id' => $matiere->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
