<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $niveaux = [
            'Primaire',
            'Collège',
            'Lycée',
        ];

        return [
            'nom' => $this->faker->name(),
            'courriel' => $this->faker->unique()->safeEmail(),
            'mot_de_passe' => Hash::make('etudiant123'),
            'niveau' => $this->faker->randomElement($niveaux),
        ];
    }

    /**
     * Indicate that the etudiant is in Primaire.
     */
    public function primaire(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau' => 'Primaire',
        ]);
    }

    /**
     * Indicate that the etudiant is in Collège.
     */
    public function college(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau' => 'Collège',
        ]);
    }

    /**
     * Indicate that the etudiant is in Lycée.
     */
    public function lycee(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau' => 'Lycée',
        ]);
    }
}
