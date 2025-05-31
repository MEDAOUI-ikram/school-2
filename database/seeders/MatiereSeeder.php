<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\Niveau;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enseignants = Enseignant::all();
        $niveaux = Niveau::all();

        if ($enseignants->isEmpty()) {
            $this->command->warn('Aucun enseignant trouvé. Veuillez d\'abord exécuter EnseignantSeeder.');
            return;
        }

        if ($niveaux->isEmpty()) {
            $this->command->warn('Aucun niveau trouvé. Veuillez d\'abord exécuter NiveauSeeder.');
            return;
        }

        $niveauPrimaire = $niveaux->where('nom_niveau', 'Primaire')->first();
        $niveauCollege = $niveaux->where('nom_niveau', 'Collège')->first();
        $niveauLycee = $niveaux->where('nom_niveau', 'Lycée')->first();

        // Matières communes aux trois niveaux avec progression
        $matieresCommunes = [
            // Français avec progression
            [
                'nom_matiere' => 'Français - Initiation',
                'coefficient' => 3.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Apprentissage de la lecture, écriture et expression orale',
            ],
            [
                'nom_matiere' => 'Français - Approfondissement',
                'coefficient' => 3.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Grammaire, conjugaison, littérature et expression écrite',
            ],
            [
                'nom_matiere' => 'Français - Avancé',
                'coefficient' => 3.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Analyse littéraire, dissertation et commentaire de texte',
            ],

            // Mathématiques avec progression
            [
                'nom_matiere' => 'Mathématiques - Fondamentaux',
                'coefficient' => 3.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Numération, opérations de base, géométrie simple',
            ],
            [
                'nom_matiere' => 'Mathématiques - Intermédiaire',
                'coefficient' => 3.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Algèbre, géométrie, statistiques élémentaires',
            ],
            [
                'nom_matiere' => 'Mathématiques - Avancé',
                'coefficient' => 3.5,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Fonctions, dérivées, probabilités, géométrie dans l\'espace',
            ],

            // Histoire-Géographie avec progression
            [
                'nom_matiere' => 'Découverte du monde',
                'coefficient' => 2.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Initiation à l\'histoire et à la géographie',
            ],
            [
                'nom_matiere' => 'Histoire-Géographie',
                'coefficient' => 2.5,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Histoire de l\'Antiquité à nos jours, géographie de la France et du monde',
            ],
            [
                'nom_matiere' => 'Histoire-Géographie - Approfondie',
                'coefficient' => 2.5,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Géopolitique, mondialisation, enjeux contemporains',
            ],

            // Sciences avec progression
            [
                'nom_matiere' => 'Sciences et technologie',
                'coefficient' => 2.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Découverte des phénomènes naturels et technologiques',
            ],
            [
                'nom_matiere' => 'Sciences de la vie et de la Terre',
                'coefficient' => 2.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Biologie, géologie, écologie',
            ],
            [
                'nom_matiere' => 'SVT - Spécialité',
                'coefficient' => 4.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Génétique, évolution, immunologie, géologie avancée',
            ],

            // Physique-Chimie avec progression
            [
                'nom_matiere' => 'Physique-Chimie - Initiation',
                'coefficient' => 2.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Notions fondamentales de physique et chimie',
            ],
            [
                'nom_matiere' => 'Physique-Chimie - Avancé',
                'coefficient' => 3.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Mécanique, électricité, chimie organique',
            ],

            // Langues vivantes avec progression
            [
                'nom_matiere' => 'Anglais - Initiation',
                'coefficient' => 1.5,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Premiers mots, expressions simples, chansons',
            ],
            [
                'nom_matiere' => 'Anglais - Intermédiaire',
                'coefficient' => 2.5,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Grammaire, vocabulaire, compréhension et expression',
            ],
            [
                'nom_matiere' => 'Anglais - Avancé',
                'coefficient' => 2.5,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Littérature anglophone, débats, civilisation',
            ],

            // Éducation physique avec progression
            [
                'nom_matiere' => 'Éducation physique',
                'coefficient' => 1.5,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Jeux collectifs, motricité, coordination',
            ],
            [
                'nom_matiere' => 'Éducation physique et sportive',
                'coefficient' => 1.5,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Sports collectifs, athlétisme, gymnastique',
            ],
            [
                'nom_matiere' => 'EPS',
                'coefficient' => 1.5,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Sports de compétition, évaluation des performances',
            ],

            // Arts avec progression
            [
                'nom_matiere' => 'Arts plastiques et Musique',
                'coefficient' => 1.5,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Expression artistique, chant, découverte des instruments',
            ],
            [
                'nom_matiere' => 'Arts plastiques',
                'coefficient' => 1.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Techniques artistiques, histoire de l\'art',
            ],
            [
                'nom_matiere' => 'Arts - Option',
                'coefficient' => 2.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Pratique artistique approfondie, analyse d\'œuvres',
            ],
        ];

        // Matières spécifiques au primaire
        $matieresPrimaire = [
            [
                'nom_matiere' => 'Lecture',
                'coefficient' => 3.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Apprentissage de la lecture et compréhension de textes',
            ],
            [
                'nom_matiere' => 'Écriture',
                'coefficient' => 3.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Apprentissage de l\'écriture manuscrite et production d\'écrits',
            ],
            [
                'nom_matiere' => 'Calcul',
                'coefficient' => 3.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Apprentissage des opérations de base et résolution de problèmes',
            ],
            [
                'nom_matiere' => 'Éducation morale et civique',
                'coefficient' => 1.0,
                'niveau_id' => $niveauPrimaire->id,
                'description' => 'Apprentissage des règles de vie en société',
            ],
        ];

        // Matières spécifiques au collège
        $matieresCollege = [
            [
                'nom_matiere' => 'Technologie',
                'coefficient' => 1.5,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Informatique, programmation, conception d\'objets',
            ],
            [
                'nom_matiere' => 'Espagnol',
                'coefficient' => 2.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Apprentissage de la langue espagnole',
            ],
            [
                'nom_matiere' => 'Allemand',
                'coefficient' => 2.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Apprentissage de la langue allemande',
            ],
            [
                'nom_matiere' => 'Éducation musicale',
                'coefficient' => 1.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Histoire de la musique, pratique vocale et instrumentale',
            ],
            [
                'nom_matiere' => 'Latin',
                'coefficient' => 1.0,
                'niveau_id' => $niveauCollege->id,
                'description' => 'Langue et civilisation latines',
            ],
        ];

        // Matières spécifiques au lycée
        $matieresLycee = [
            [
                'nom_matiere' => 'Philosophie',
                'coefficient' => 3.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Étude des grands courants philosophiques',
            ],
            [
                'nom_matiere' => 'Sciences économiques et sociales',
                'coefficient' => 3.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Économie, sociologie, sciences politiques',
            ],
            [
                'nom_matiere' => 'Littérature',
                'coefficient' => 2.5,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Étude approfondie des œuvres littéraires',
            ],
            [
                'nom_matiere' => 'Spécialité Mathématiques',
                'coefficient' => 4.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Mathématiques avancées pour les filières scientifiques',
            ],
            [
                'nom_matiere' => 'Spécialité Physique-Chimie',
                'coefficient' => 4.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Physique et chimie avancées',
            ],
            [
                'nom_matiere' => 'Spécialité Histoire-Géo',
                'coefficient' => 4.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Histoire et géographie approfondies',
            ],
            [
                'nom_matiere' => 'Spécialité SES',
                'coefficient' => 4.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Sciences économiques et sociales approfondies',
            ],
            [
                'nom_matiere' => 'Spécialité LLCE',
                'coefficient' => 4.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Langues, littératures et cultures étrangères',
            ],
            [
                'nom_matiere' => 'Espagnol - Avancé',
                'coefficient' => 2.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Langue et civilisation espagnoles',
            ],
            [
                'nom_matiere' => 'Allemand - Avancé',
                'coefficient' => 2.0,
                'niveau_id' => $niveauLycee->id,
                'description' => 'Langue et civilisation allemandes',
            ],
        ];

        // Fusionner toutes les matières
        $toutesLesMatieres = array_merge($matieresCommunes, $matieresPrimaire, $matieresCollege, $matieresLycee);

        // Créer les matières
        foreach ($toutesLesMatieres as $matiere) {
            // Trouver un enseignant approprié pour cette matière
            $enseignant = $this->trouverEnseignantPourMatiere($enseignants, $matiere['nom_matiere']);

            Matiere::create([
                'nom_matiere' => $matiere['nom_matiere'],
                'coefficient' => $matiere['coefficient'],
                'niveau_id' => $matiere['niveau_id'],
                'description' => $matiere['description'],
                'enseignant_id' => $enseignant->id,
            ]);
        }
    }

    /**
     * Trouver un enseignant approprié pour une matière donnée
     */
    private function trouverEnseignantPourMatiere($enseignants, $nomMatiere)
    {
        // Essayer de trouver un enseignant dont la spécialité correspond à la matière
        $specialites = [
            'Français' => ['Français', 'Lettres', 'Littérature'],
            'Mathématiques' => ['Mathématiques', 'Maths'],
            'Histoire' => ['Histoire', 'Histoire-Géographie', 'Géographie'],
            'Sciences' => ['Sciences', 'SVT', 'Biologie'],
            'Physique' => ['Physique', 'Chimie', 'Physique-Chimie'],
            'Anglais' => ['Anglais', 'Langues vivantes'],
            'Espagnol' => ['Espagnol', 'Langues vivantes'],
            'Allemand' => ['Allemand', 'Langues vivantes'],
            'Philosophie' => ['Philosophie'],
            'SES' => ['SES', 'Économie', 'Sciences économiques'],
            'Arts' => ['Arts', 'Arts plastiques', 'Musique'],
            'EPS' => ['EPS', 'Sport', 'Éducation physique'],
            'Primaire' => ['Primaire', 'Professeur des écoles'],
        ];

        // Déterminer la spécialité recherchée
        $specialiteRecherchee = null;
        foreach ($specialites as $key => $values) {
            foreach ($values as $value) {
                if (stripos($nomMatiere, $value) !== false) {
                    $specialiteRecherchee = $key;
                    break 2;
                }
            }
        }

        // Si une spécialité a été trouvée, chercher un enseignant correspondant
        if ($specialiteRecherchee) {
            foreach ($enseignants as $enseignant) {
                if (property_exists($enseignant, 'specialite') &&
                    in_array($enseignant->specialite, $specialites[$specialiteRecherchee])) {
                    return $enseignant;
                }
            }
        }

        // Si aucun enseignant spécialisé n'est trouvé, retourner un enseignant aléatoire
        return $enseignants->random();
    }
}
