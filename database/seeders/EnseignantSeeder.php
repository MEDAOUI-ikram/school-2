<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use Illuminate\Support\Facades\Hash;

class EnseignantSeeder extends Seeder
{
    public function run()
    {
        // Vérifier si l'email existe déjà avant d'insérer
        if (!Enseignant::where('courriel', 'martin@ecole.com')->exists()) {
            Enseignant::create([
                'nom' => 'M. Martin',
                'courriel' => 'martin@ecole.com',
                'mot_de_passe' => Hash::make('password'),
                'specialite' => 'Primaire'
            ]);
        }

        if (!Enseignant::where('courriel', 'bernard@ecole.com')->exists()) {
            Enseignant::create([
                'nom' => 'Mme Bernard',
                'courriel' => 'bernard@ecole.com',
                'mot_de_passe' => Hash::make('password'),
                'specialite' => 'Primaire'
            ]);
        }

        // Ajoutez d'autres enseignants avec des vérifications similaires
    }
}