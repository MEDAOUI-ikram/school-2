<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\EmploiDuTemps;
use App\Models\AnneeScolaire;
use App\Models\User;
class EtudiantController extends Controller
{
    // Tableau de bord étudiant
//      public function index()
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
//  }


 public function index()
{
    $user = Auth::user();

    // Récupérer la classe de l'étudiant
    $classe = Classe::find($user->classe_id);

    // Récupérer les matières associées à cette classe (via la table pivot)
    $matieres = $classe 
        ? $classe->matieres()->with('enseignants')->get()
        : collect();

    // Infos personnelles
    $infos = [
        'nom' => $user->name,
        'email' => $user->email,
        'niveau' => $user->niveau,
        'nbClasses' => Classe::count(),
        'nbMatieres' => $matieres->count()
    ];

    return view('etudiant.dashboard', compact('user', 'classe', 'matieres', 'infos'));
}

public function classes()
{
    $classes = Classe::withCount('etudiants')->get();

    return view('etudiant.classes', compact('classes'));
}

public function matieres()
{
    $user = Auth::user();

    $classe = Classe::find($user->classe_id);
    $matieres = $classe 
        ? $classe->matieres()->with('enseignants')->get()
        : collect();

    return view('etudiant.matieres', compact('matieres'));
}

public function infos()
{
    $etudiant = auth()->user(); // ou autre selon ton système d'authentification

    return view('etudiant.infos', ['infos' => $etudiant]);
}



public function updateInfos(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'niveau' => 'nullable|string|max:255',
        'password' => 'nullable|min:8|confirmed'
    ]);

    $user = Auth::user();
    $user->name = $request->nom;
    $user->email = $request->email;
    if ($request->niveau) {
        $user->niveau = $request->niveau;
    }
    if ($request->password) {
        $user->password = bcrypt($request->password);
    }
    

    $user->save();

    return redirect()->back()->with('success', 'Profil mis à jour avec succès');
}}