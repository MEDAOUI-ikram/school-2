<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    public function emploiDuTemps()
{
    $user = Auth::user();

    // Vérifie que la classe est bien définie
    $classe = Classe::find($user->classe_id);

    if (!$classe) {
        return redirect()->back()->withErrors('Aucune classe trouvée pour cet étudiant.');
    }

    // Récupère l'emploi du temps pour la classe
    $emploi = EmploiDuTemps::where('classe_id', $classe->id)->get();

    return view('etudiant.emploi', compact('emploi'));
}

}
