<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Hash;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des étudiants pour chaque niveau
        $this->createEtudiantsPourNiveau('Primaire', 50);
        $this->createEtudiantsPourNiveau('Collège', 60);
        $this->createEtudiantsPourNiveau('Lycée', 70);
    }

    /**
     * Créer des étudiants pour un niveau spécifique
     */
    private function createEtudiantsPourNiveau($niveau, $nombre)
    {
        // Créer quelques étudiants fixes pour ce niveau
        $etudiants = [];

        if ($niveau === 'Primaire') {
            $etudiants = [
                [
                    'nom' => 'Lucas Martin',
                    'courriel' => 'lucas.martin@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
                [
                    'nom' => 'Emma Petit',
                    'courriel' => 'emma.petit@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
                [
                    'nom' => 'Noah Dubois',
                    'courriel' => 'noah.dubois@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
            ];
        } elseif ($niveau === 'Collège') {
            $etudiants = [
                [
                    'nom' => 'Léa Bernard',
                    'courriel' => 'lea.bernard@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
                [
                    'nom' => 'Hugo Moreau',
                    'courriel' => 'hugo.moreau@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
                [
                    'nom' => 'Chloé Leroy',
                    'courriel' => 'chloe.leroy@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
            ];
        } elseif ($niveau === 'Lycée') {
            $etudiants = [
                [
                    'nom' => 'Thomas Girard',
                    'courriel' => 'thomas.girard@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
                [
                    'nom' => 'Camille Fournier',
                    'courriel' => 'camille.fournier@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
                [
                    'nom' => 'Maxime Dupont',
                    'courriel' => 'maxime.dupont@etudiant.com',
                    'mot_de_passe' => Hash::make('etudiant123'),
                ],
            ];
        }

        // Créer les étudiants fixes
        foreach ($etudiants as $etudiant) {
            Etudiant::create([
                'nom' => $etudiant['nom'],
                'courriel' => $etudiant['courriel'],
                'mot_de_passe' => $etudiant['mot_de_passe'],
                'niveau' => $niveau,
            ]);
        }

        // Créer des étudiants supplémentaires avec la factory
        Etudiant::factory($nombre - count($etudiants))->create([
            'niveau' => $niveau,
        ]);
    }
}
