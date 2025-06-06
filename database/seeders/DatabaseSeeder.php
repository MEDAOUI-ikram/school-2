<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ordre d'exécution important pour éviter les erreurs de clés étrangères
        $this->call([
            AdministrateurSeeder::class,
            NiveauSeeder::class,
            EnseignantSeeder::class,
            EtudiantSeeder::class,
            MatiereSeeder::class,
            ClasseSeeder::class,
            AnneeScolaireSeeder::class,
             EmploiDuTempsSeeder::class, // Commenté temporairement en cas de problème
        ]);

        // Essayer de créer les emplois du temps avec gestion d'erreur
        try {
            $this->call([EmploiDuTempsSeeder::class]);
            $this->command->info('Emplois du temps créés avec succès !');
        } catch (\Exception $e) {
            $this->command->warn('Erreur lors de la création des emplois du temps : ' . $e->getMessage());
            $this->command->info('Vous pouvez continuer sans les emplois du temps pour l\'instant.');
        }

        $this->command->info('Seeders principaux exécutés avec succès !');

        // Afficher un résumé
        $this->command->info('=== RÉSUMÉ DES DONNÉES CRÉÉES ===');
        $this->command->info('Administrateurs : ' . \App\Models\Administrateur::count());
        $this->command->info('Niveaux : ' . \App\Models\Niveau::count());
        $this->command->info('Enseignants : ' . \App\Models\Enseignant::count());
        $this->command->info('Étudiants : ' . \App\Models\Etudiant::count());
        $this->command->info('Matières : ' . \App\Models\Matiere::count());
        $this->command->info('Classes : ' . \App\Models\Classe::count());
        $this->command->info('Années scolaires : ' . \App\Models\AnneeScolaire::count());
        $this->command->info('Emplois du temps : ' . \App\Models\EmploiDuTemps::count());
        $this->command->info('Assignations classe-enseignant-matière : ' . \DB::table('classe_enseignant_matiere')->count());
    }
}

