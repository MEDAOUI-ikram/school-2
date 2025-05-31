<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Niveau;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classe>
 */
class ClasseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialites = ['INFO', 'MATH', 'PHYS', 'CHIM', 'BIO', 'ECO', 'GEST'];
        $groupes = ['A', 'B', 'C', 'D'];
        $niveauxCourts = ['Primaire',
            'Collège',
            'Lycée',];

        $niveauCourt = $this->faker->randomElement($niveauxCourts);
        $specialite = $this->faker->randomElement($specialites);
        $groupe = $this->faker->randomElement($groupes);

        return [
            'nom_classe' => $niveauCourt . '-' . $specialite . '-' . $groupe,
            'annee' => $this->faker->numberBetween(2020, 2025),
            'niveau_id' => Niveau::factory(),
        ];
    }

    /**
     * Indicate that the classe is for current year.
     */
    public function currentYear(): static
    {
        return $this->state(fn (array $attributes) => [
            'annee' => date('Y'),
        ]);
    }

    /**
     * Indicate that the classe is for informatique.
     */
    public function informatique(): static
    {
        return $this->state(fn (array $attributes) => [
            'nom_classe' => preg_replace('/-(.*?)-/', '-INFO-', $attributes['nom_classe']),
        ]);
    }
}
