<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class AnneeScolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anneeActuelle = date('Y');

        $anneesScolaires = [
            [
                'libelle' => ($anneeActuelle - 2) . '-' . ($anneeActuelle - 1),
                'date_debut' => Carbon::create($anneeActuelle - 2, 9, 1),
                'date_fin' => Carbon::create($anneeActuelle - 1, 6, 30),
            ],
            [
                'libelle' => ($anneeActuelle - 1) . '-' . $anneeActuelle,
                'date_debut' => Carbon::create($anneeActuelle - 1, 9, 1),
                'date_fin' => Carbon::create($anneeActuelle, 6, 30),
            ],
            [
                'libelle' => $anneeActuelle . '-' . ($anneeActuelle + 1),
                'date_debut' => Carbon::create($anneeActuelle, 9, 1),
                'date_fin' => Carbon::create($anneeActuelle + 1, 6, 30),
            ],
            [
                'libelle' => ($anneeActuelle + 1) . '-' . ($anneeActuelle + 2),
                'date_debut' => Carbon::create($anneeActuelle + 1, 9, 1),
                'date_fin' => Carbon::create($anneeActuelle + 2, 6, 30),
            ],
        ];

        foreach ($anneesScolaires as $annee) {
            AnneeScolaire::create($annee);
        }
    }
}
