<?php

namespace App\Http\Controllers\Etudiant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\EmploiDuTemps;
use App\Models\AnneeScolaire;

class MatiereController extends Controller
{
    public function index()
    {
        $matieres = Matiere::all();
        return view('etudiant.matiere', compact('matieres'));
    }
}
