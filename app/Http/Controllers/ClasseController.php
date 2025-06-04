<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\EmploiDuTemps;
use App\Models\AnneeScolaire;

class ClasseController extends Controller
{
    





    // Afficher la liste de toutes les classes
    public function index()
    {
        $classes = Classe::all();
        return view('etudiant.classes', compact('classes'));
    }

    // Afficher les détails d'une classe (optionnel)
    public function show($id)
    {
        $classe = Classe::findOrFail($id);
        return view('etudiant.classe_details', compact('classe'));
    }
}


