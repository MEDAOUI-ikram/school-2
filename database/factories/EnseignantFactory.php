<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enseignant>
 */
class EnseignantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefixes = ['Prof.', 'Dr.', 'M.', 'Mme'];
        $prefix = $this->faker->randomElement($prefixes);

        $specialites = [
            'Français', 'Mathématiques', 'Histoire-Géographie', 'SVT', 'Physique-Chimie',
            'Anglais', 'Espagnol', 'Allemand', 'Philosophie', 'SES', 'Arts plastiques',
            'Musique', 'EPS', 'Technologie', 'Primaire'
        ];

        return [
            'nom' => $prefix . ' ' . $this->faker->name(),
            'courriel' => $this->faker->unique()->safeEmail(),
            'mot_de_passe' => Hash::make('enseignant123'),
            'specialite' => $this->faker->randomElement($specialites),
        ];
    }

    /**
     * Indicate that the enseignant is a professor.
     */
    public function professor(): static
    {
        return $this->state(fn (array $attributes) => [
            'nom' => 'Prof. ' . $this->faker->name(),
        ]);
    }

    /**
     * Indicate that the enseignant is a doctor.
     */
    public function doctor(): static
    {
        return $this->state(fn (array $attributes) => [
            'nom' => 'Dr. ' . $this->faker->name(),
        ]);
    }

    /**
     * Indicate that the enseignant is specialized in a specific subject.
     */
    public function specializedIn(string $specialite): static
    {
        return $this->state(fn (array $attributes) => [
            'specialite' => $specialite,
        ]);
    }
}
