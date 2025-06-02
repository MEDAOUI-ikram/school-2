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
    public function index()
    {
        $etudiant = Auth::user(); // On suppose que l'étudiant est connecté
        return view('etudiant.dashboard', compact('etudiant'));
    }

    // Voir mes classes
    public function classes()
    {
        $etudiant = Auth::user();
        $classes = $etudiant->classes; // relation : etudiant hasMany classe
        return view('etudiant.classes', compact('classes'));
    }

    // Voir mes matières
    public function matieres()
    {
        $etudiant = Auth::user();
        $matieres = $etudiant->classes->flatMap->matieres->unique('id');
        return view('etudiant.matieres', compact('matieres'));
    }

    // Emploi du temps
    public function emploiDuTemps()
    {
        $etudiant = Auth::user();
        $emploi = EmploiDuTemps::where('classe_id', $etudiant->classe_id)->get();
        return view('etudiant.emploi', compact('emploi'));
    }

    // Année scolaire en cours
    public function anneeScolaire()
    {
        $annee = AnneeScolaire::where('active', true)->first();
        return view('etudiant.annee', compact('annee'));
    }
}
