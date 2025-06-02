<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\EmploiDuTemps;
use App\Models\AnneeScolaire;

class EtudiantController extends Controller
{
    // Tableau de bord étudiant
//     public function index()
//     {
//         $etudiant = Auth::user(); // On suppose que l'étudiant est connecté
//        $classes = $etudiant->classes ?? collect(); // en cas de null
// $matieres = $classes->flatMap->matieres->unique('id');


//         return view('etudiant.dashboard', compact('etudiant'));
//     }

//     // Voir mes classes
//     public function classes()
//     {
//         $etudiant = Auth::user();
      

//         $classes = $etudiant->classes; // relation : etudiant hasMany classe
//         return view('etudiant.classes', compact('classes'));
//     }

//     // Voir mes matières
//     public function matieres()
//     {
//         $etudiant = Auth::user();
//         $matieres = $etudiant->classes->flatMap->matieres->unique('id');
//         return view('etudiant.matieres', compact('matieres'));
//     }

//     // Emploi du temps
//     public function emploiDuTemps()
//     {
//         $etudiant = Auth::user();
//         $emploi = EmploiDuTemps::where('classe_id', $etudiant->classe_id)->get();
//         return view('etudiant.emploi', compact('emploi'));
//     }

//     // Année scolaire en cours
//     public function anneeScolaire()
//     {
//         $annee = AnneeScolaire::where('active', true)->first();
//         return view('etudiant.annee', compact('annee'));
//     }
// }


 public function index()
    {
        // Données simulées pour l'étudiant
        $etudiant = [
            'nom' => 'Ahmed Benali',
            'email' => 'ahmed.benali@ecole.ma',
            'niveau' => 'Collège'
        ];

        // Classes simulées
        $classes = collect([
            ['id' => 1, 'nomClasse' => '6ème A', 'annee' => '2024', 'nbEtudiants' => 28],
            ['id' => 2, 'nomClasse' => '5ème B', 'annee' => '2024', 'nbEtudiants' => 30],
            ['id' => 3, 'nomClasse' => '4ème Sciences', 'annee' => '2024', 'nbEtudiants' => 25]
        ]);

        // Matières simulées
        $matieres = collect([
            ['id' => 1, 'nomMatiere' => 'Arabe', 'coefficient' => 4],
            ['id' => 2, 'nomMatiere' => 'Français', 'coefficient' => 3],
            ['id' => 3, 'nomMatiere' => 'Mathématiques', 'coefficient' => 4],
            ['id' => 4, 'nomMatiere' => 'Anglais', 'coefficient' => 2],
            ['id' => 5, 'nomMatiere' => 'Physique-Chimie', 'coefficient' => 3],
            ['id' => 6, 'nomMatiere' => 'Sciences de la Vie et de la Terre (SVT)', 'coefficient' => 3],
            ['id' => 7, 'nomMatiere' => 'Histoire-Géographie', 'coefficient' => 2],
            ['id' => 8, 'nomMatiere' => 'Éducation Islamique', 'coefficient' => 2],
            ['id' => 9, 'nomMatiere' => 'Éducation Physique et Sport', 'coefficient' => 1],
            ['id' => 10, 'nomMatiere' => 'Informatique', 'coefficient' => 2]
        ]);

        // Informations personnelles
        $infos = [
            'nom' => $etudiant['nom'],
            'email' => $etudiant['email'],
            'niveau' => $etudiant['niveau'],
            'nbClasses' => $classes->count(),
            'nbMatieres' => $matieres->count()
        ];

        return view('etudiant.dashboard', compact('etudiant', 'classes', 'matieres', 'infos'));
    }

    public function classes()
    {
        $classes = collect([
            ['id' => 1, 'nomClasse' => '6ème A', 'annee' => '2024', 'nbEtudiants' => 28],
            ['id' => 2, 'nomClasse' => '5ème B', 'annee' => '2024', 'nbEtudiants' => 30],
            ['id' => 3, 'nomClasse' => '4ème Sciences', 'annee' => '2024', 'nbEtudiants' => 25]
        ]);

        return view('etudiant.classes', compact('classes'));
    }

    public function matieres()
    {
        $matieres = collect([
            ['id' => 1, 'nomMatiere' => 'Arabe', 'coefficient' => 4],
            ['id' => 2, 'nomMatiere' => 'Français', 'coefficient' => 3],
            ['id' => 3, 'nomMatiere' => 'Mathématiques', 'coefficient' => 4],
            ['id' => 4, 'nomMatiere' => 'Anglais', 'coefficient' => 2],
            ['id' => 5, 'nomMatiere' => 'Physique-Chimie', 'coefficient' => 3],
            ['id' => 6, 'nomMatiere' => 'Sciences de la Vie et de la Terre (SVT)', 'coefficient' => 3],
            ['id' => 7, 'nomMatiere' => 'Histoire-Géographie', 'coefficient' => 2],
            ['id' => 8, 'nomMatiere' => 'Éducation Islamique', 'coefficient' => 2],
            ['id' => 9, 'nomMatiere' => 'Éducation Physique et Sport', 'coefficient' => 1],
            ['id' => 10, 'nomMatiere' => 'Informatique', 'coefficient' => 2]
        ]);

        return view('etudiant.matieres', compact('matieres'));
    }

    public function infos()
    {
        $etudiant = [
            'nom' => 'Ahmed Benali',
            'email' => 'ahmed.benali@ecole.ma',
            'niveau' => 'Collège'
        ];

        return view('etudiant.infos', compact('etudiant'));
    }

    public function updateInfos(Request $request)
    {
        // Ici vous pouvez traiter la mise à jour des informations
        // Pour l'instant, on simule juste un retour
        
        return redirect()->route('etudiant.infos')->with('success', 'Informations modifiées avec succès!');
    }
}