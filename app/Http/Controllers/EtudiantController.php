<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    /**
     * Afficher le dashboard étudiant
     */
    public function index()
    {
        return view("etudiant.dashboard");
    }

    /**
     * Mettre à jour les informations de l'étudiant
     */
    public function updateInfos(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'niveau' => 'required|in:primaire,college,lycee'
        ]);

        $user = Auth::user();
        $user->update([
            'nom' => $request->nom,
            'email' => $request->email
        ]);

        $user->etudiant->update([
            'niveau' => $request->niveau
        ]);

        return redirect()->route('etudiant.infos')->with('success', 'Informations mises à jour avec succès');
    }
}
