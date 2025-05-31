<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploiDuTemps;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;

class EmploiDuTempsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données existantes
        $classes = Classe::with(['enseignants', 'matieres'])->get();
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $heures = [
            ['08:00:00', '10:00:00'],
            ['10:15:00', '12:15:00'],
            ['14:00:00', '16:00:00'],
            ['16:15:00', '18:15:00'],
        ];

        $this->command->info('Création des emplois du temps pour ' . $classes->count() . ' classes...');

        foreach ($classes as $classe) {
            // Récupérer les assignations enseignant-matière pour cette classe
            $assignations = \DB::table('classe_enseignant_matiere')
                ->where('classe_id', $classe->id)
                ->get();

            if ($assignations->isEmpty()) {
                $this->command->warn("Aucune assignation trouvée pour la classe {$classe->nom_classe}");
                continue;
            }

            // Créer un emploi du temps pour chaque classe
            $coursParSemaine = min(8, $assignations->count() * 2); // Limiter le nombre de cours
            $coursCreated = 0;
            $creneauxUtilises = [];

            foreach ($jours as $jour) {
                if ($coursCreated >= $coursParSemaine) break;

                $heuresUtilisees = [];
                $coursParJour = rand(1, min(2, count($heures))); // Maximum 2 cours par jour

                for ($i = 0; $i < $coursParJour && $coursCreated < $coursParSemaine; $i++) {
                    // Sélectionner une heure disponible
                    $heuresDisponibles = array_diff(array_keys($heures), $heuresUtilisees);
                    if (empty($heuresDisponibles)) break;

                    $indexHeure = array_rand($heuresDisponibles);
                    $heureSelectionnee = $heures[$heuresDisponibles[$indexHeure]];
                    $heuresUtilisees[] = $heuresDisponibles[$indexHeure];

                    // Créer une clé unique pour ce créneau
                    $creneauKey = $classe->id . '-' . $jour . '-' . $heureSelectionnee[0];

                    // Vérifier si ce créneau n'est pas déjà utilisé
                    if (in_array($creneauKey, $creneauxUtilises)) {
                        continue;
                    }

                    // Sélectionner une assignation aléatoire
                    $assignation = $assignations->random();

                    // Vérifier si ce cours n'existe pas déjà
                    $existingCours = EmploiDuTemps::where([
                        'classe_id' => $classe->id,
                        'jour' => $jour,
                        'heure_debut' => $heureSelectionnee[0],
                    ])->first();

                    if (!$existingCours) {
                        EmploiDuTemps::create([
                            'classe_id' => $classe->id,
                            'matiere_id' => $assignation->matiere_id,
                            'enseignant_id' => $assignation->enseignant_id,
                            'jour' => $jour,
                            'heure_debut' => $heureSelectionnee[0],
                            'heure_fin' => $heureSelectionnee[1],
                        ]);

                        $creneauxUtilises[] = $creneauKey;
                        $coursCreated++;
                    }
                }
            }

            $this->command->info("Emploi du temps créé pour {$classe->nom_classe} : {$coursCreated} cours");
        }

        $this->command->info('Emplois du temps créés avec succès !');
        $this->command->info('Total des cours : ' . EmploiDuTemps::count());
    }
}
