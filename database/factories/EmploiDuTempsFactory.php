<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmploiDuTemps>
 */
class EmploiDuTempsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $creneaux = [
            ['08:00:00', '10:00:00'],
            ['10:15:00', '12:15:00'],
            ['14:00:00', '16:00:00'],
            ['16:15:00', '18:15:00'],
        ];

        $creneau = $this->faker->randomElement($creneaux);

        // Récupérer des IDs existants au lieu d'utiliser les factories
        $classeIds = Classe::pluck('id')->toArray();
        $matiereIds = Matiere::pluck('id')->toArray();
        $enseignantIds = Enseignant::pluck('id')->toArray();

        return [
            'classe_id' => $this->faker->randomElement($classeIds),
            'matiere_id' => $this->faker->randomElement($matiereIds),
            'enseignant_id' => $this->faker->randomElement($enseignantIds),
            'jour' => $this->faker->randomElement($jours),
            'heure_debut' => $creneau[0],
            'heure_fin' => $creneau[1],
        ];
    }

    /**
     * Indicate that the cours is in the morning.
     */
    public function morning(): static
    {
        $creneauxMatin = [
            ['08:00:00', '10:00:00'],
            ['10:15:00', '12:15:00'],
        ];

        $creneau = $this->faker->randomElement($creneauxMatin);

        return $this->state(fn (array $attributes) => [
            'heure_debut' => $creneau[0],
            'heure_fin' => $creneau[1],
        ]);
    }

    /**
     * Indicate that the cours is in the afternoon.
     */
    public function afternoon(): static
    {
        $creneauxApresMidi = [
            ['14:00:00', '16:00:00'],
            ['16:15:00', '18:15:00'],
        ];

        $creneau = $this->faker->randomElement($creneauxApresMidi);

        return $this->state(fn (array $attributes) => [
            'heure_debut' => $creneau[0],
            'heure_fin' => $creneau[1],
        ]);
    }

    /**
     * Indicate that the cours is on Monday.
     */
    public function monday(): static
    {
        return $this->state(fn (array $attributes) => [
            'jour' => 'Lundi',
        ]);
    }
}
