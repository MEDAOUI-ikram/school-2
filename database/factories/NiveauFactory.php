<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Niveau>
 */
class NiveauFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Utiliser une liste plus large pour éviter les conflits d'unicité
        $niveaux = [
            'Primaire',
            'Collège',
            'Lycée',
            'CP',
            'CE1',
            'CE2',
            'CM1',
            'CM2',
            '6ème',
            '5ème',
            '4ème',
            '3ème',
            '2nde',
            '1ère',

        ];

        // Ne pas utiliser unique() pour éviter les conflits
        return [
            'nom_niveau' => $this->faker->randomElement($niveaux),
        ];
    }

    /**
     * Indicate that the niveau is Primaire.
     */
    public function primaire(): static
    {
        return $this->state(fn (array $attributes) => [
            'nom_niveau' => 'Primaire',
        ]);
    }

    /**
     * Indicate that the niveau is Collège.
     */
    public function college(): static
    {
        return $this->state(fn (array $attributes) => [
            'nom_niveau' => 'Collège',
        ]);
    }

    /**
     * Indicate that the niveau is Lycée.
     */
    public function lycee(): static
    {
        return $this->state(fn (array $attributes) => [
            'nom_niveau' => 'Lycée',
        ]);
    }

    
}
