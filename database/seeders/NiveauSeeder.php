<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Niveau;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            'Primaire',
            'Collège',
            'Lycée',
        ];

        foreach ($niveaux as $niveau) {
            Niveau::create([
                'nom_niveau' => $niveau,
            ]);
        }
    }
}

