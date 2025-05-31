<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Enseignant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matiere>
 */
class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $matieres = [
    // Niveau Primaire
    'Français (primaire)',
    'Mathématiques (primaire)',
    'Sciences (primaire)',
    'Histoire-Géographie (primaire)',
    'Éducation civique (primaire)',
    'Arts plastiques (primaire)',
    'Éducation physique (primaire)',

    // Niveau Collège
    'Français (collège)',
    'Mathématiques (collège)',
    'Sciences de la vie et de la terre (collège)',
    'Physique-Chimie (collège)',
    'Histoire-Géographie (collège)',
    'Technologie (collège)',
    'Langue vivante 1 (collège)',

    // Niveau Lycée
    'Français (lycée)',
    'Philosophie (lycée)',
    'Mathématiques (lycée)',
    'Physique-Chimie (lycée)',
    'Sciences économiques et sociales (lycée)',
    'Sciences de la vie et de la terre (lycée)',
    'Langue vivante 2 (lycée)',
    'Histoire-Géographie (lycée)',
    'Spécialité Numérique et Sciences Informatiques (lycée)'
]
;

        return [
            'nom_matiere' => $this->faker->unique()->randomElement($matieres),
            'coefficient' => $this->faker->randomFloat(1, 1.0, 4.0),
            'enseignant_id' => Enseignant::factory(),
        ];
    }

    /**
     * Indicate that the matiere has a high coefficient.
     */
    public function highCoefficient(): static
    {
        return $this->state(fn (array $attributes) => [
            'coefficient' => $this->faker->randomFloat(1, 3.0, 4.0),
        ]);
    }

    /**
     * Indicate that the matiere has a low coefficient.
     */
    public function lowCoefficient(): static
    {
        return $this->state(fn (array $attributes) => [
            'coefficient' => $this->faker->randomFloat(1, 1.0, 2.0),
        ]);
    }
}
