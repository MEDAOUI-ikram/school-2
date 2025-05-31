<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use Illuminate\Support\Facades\Hash;

class EnseignantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enseignants = [
            // Enseignants du primaire
            [
                'nom' => 'Mme Dupont',
                'courriel' => 'dupont@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Primaire',
            ],
            [
                'nom' => 'M. Martin',
                'courriel' => 'martin@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Primaire',
            ],
            [
                'nom' => 'Mme Bernard',
                'courriel' => 'bernard@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Primaire',
            ],
            [
                'nom' => 'M. Petit',
                'courriel' => 'petit@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Primaire',
            ],

            // Enseignants du collège et lycée - Français
            [
                'nom' => 'Prof. Leroy',
                'courriel' => 'leroy@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Français',
            ],
            [
                'nom' => 'Mme Roux',
                'courriel' => 'roux@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Lettres',
            ],

            // Enseignants du collège et lycée - Mathématiques
            [
                'nom' => 'Dr. Moreau',
                'courriel' => 'moreau@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Mathématiques',
            ],
            [
                'nom' => 'Prof. Blanc',
                'courriel' => 'blanc@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Mathématiques',
            ],

            // Enseignants du collège et lycée - Histoire-Géographie
            [
                'nom' => 'Prof. Fournier',
                'courriel' => 'fournier@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Histoire-Géographie',
            ],
            [
                'nom' => 'M. Lambert',
                'courriel' => 'lambert@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Histoire-Géographie',
            ],

            // Enseignants du collège et lycée - Langues
            [
                'nom' => 'M. Girard',
                'courriel' => 'girard@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Anglais',
            ],
            [
                'nom' => 'Mme Lopez',
                'courriel' => 'lopez@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Espagnol',
            ],
            [
                'nom' => 'M. Muller',
                'courriel' => 'muller@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Allemand',
            ],

            // Enseignants du collège et lycée - Sciences
            [
                'nom' => 'Mme Bonnet',
                'courriel' => 'bonnet@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'SVT',
            ],
            [
                'nom' => 'Dr. Rousseau',
                'courriel' => 'rousseau@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Physique-Chimie',
            ],
            [
                'nom' => 'Dr. Guerin',
                'courriel' => 'guerin@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'SVT',
            ],

            // Enseignants du lycée - Spécialités
            [
                'nom' => 'Prof. Legrand',
                'courriel' => 'legrand@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Philosophie',
            ],
            [
                'nom' => 'Mme Garnier',
                'courriel' => 'garnier@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Littérature',
            ],
            [
                'nom' => 'M. Faure',
                'courriel' => 'faure@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'SES',
            ],

            // Enseignants pour les matières artistiques et sportives
            [
                'nom' => 'M. Mercier',
                'courriel' => 'mercier@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Arts plastiques',
            ],
            [
                'nom' => 'Mme Dubois',
                'courriel' => 'dubois@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'Musique',
            ],
            [
                'nom' => 'M. Lefebvre',
                'courriel' => 'lefebvre@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'EPS',
            ],
            [
                'nom' => 'Mme Perrin',
                'courriel' => 'perrin@ecole.com',
                'mot_de_passe' => Hash::make('enseignant123'),
                'specialite' => 'EPS',
            ],
        ];

        foreach ($enseignants as $enseignant) {
            Enseignant::create([
                'nom' => $enseignant['nom'],
                'courriel' => $enseignant['courriel'],
                'mot_de_passe' => $enseignant['mot_de_passe'],
                'specialite' => $enseignant['specialite'],
            ]);
        }

        // Créer des enseignants supplémentaires avec la factory
        Enseignant::factory(5)->create();
    }
}
