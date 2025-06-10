<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrateurs = [
            [
                'nom' => 'Administrateur Principal',
                'courriel' => 'admin@ecole.com',
                'mot_de_passe' => Hash::make('admin123'),
            ],
            [
                'nom' => 'Directeur Académique',
                'courriel' => 'directeur@ecole.com',
                'mot_de_passe' => Hash::make('directeur123'),
            ],
            [
                'nom' => 'Secrétaire Général',
                'courriel' => 'secretaire@ecole.com',
                'mot_de_passe' => Hash::make('secretaire123'),
            ],
        ];

        foreach ($administrateurs as $admin) {
    Administrateur::firstOrCreate(
        ['courriel' => $admin['courriel']], // condition
        $admin // données à insérer si non existant
    );
}


        // Créer des administrateurs supplémentaires avec la factory
        Administrateur::factory(2)->create();
    }
}
