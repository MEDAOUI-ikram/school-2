<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnneeScolaire>
 */
class AnneeScolaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anneeDebut = $this->faker->numberBetween(2020, 2025);
        $anneeFin = $anneeDebut + 1;

        return [
            'libelle' => $anneeDebut . '-' . $anneeFin,
            'date_debut' => Carbon::create($anneeDebut, 9, 1),
            'date_fin' => Carbon::create($anneeFin, 6, 30),
        ];
    }

    /**
     * Indicate that the annee scolaire is current.
     */
    public function current(): static
    {
        $anneeActuelle = date('Y');

        return $this->state(fn (array $attributes) => [
            'libelle' => $anneeActuelle . '-' . ($anneeActuelle + 1),
            'date_debut' => Carbon::create($anneeActuelle, 9, 1),
            'date_fin' => Carbon::create($anneeActuelle + 1, 6, 30),
        ]);
    }

    /**
     * Indicate that the annee scolaire is past.
     */
    public function past(): static
    {
        $anneePasse = date('Y') - 1;

        return $this->state(fn (array $attributes) => [
            'libelle' => ($anneePasse - 1) . '-' . $anneePasse,
            'date_debut' => Carbon::create($anneePasse - 1, 9, 1),
            'date_fin' => Carbon::create($anneePasse, 6, 30),
        ]);
    }
}
