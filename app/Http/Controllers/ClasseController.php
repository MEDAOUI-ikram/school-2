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
    




    /**
     * Afficher la liste des classes pour les étudiants
     */
    public function index()
    {
        // Récupérer toutes les classes avec leurs statistiques
        $classes = Classe::with('etudiants') // Charger la relation pour optimiser
                        ->orderBy('annee')
                        ->orderBy('nomClasse')
                        ->get()
                        ->map(function ($classe) {
                            return [
                                'id' => $classe->id,
                                'nomClasse' => $classe->nomClasse,
                                'annee' => $classe->annee,
                                'nbEtudiants' => $classe->etudiants->count(), // Nombre réel d'étudiants
                                'capacite_max' => $classe->capacite_max ?? 30, // Capacité maximale
                            ];
                        });

        return view('etudiant.classes.index', compact('classes'));
    }

    /**
     * Afficher les classes filtrées par année
     */
    public function parAnnee($annee)
    {
        $classes = Classe::parAnnee($annee)
                        ->with('etudiants')
                        ->orderBy('nomClasse')
                        ->get()
                        ->map(function ($classe) {
                            return [
                                'id' => $classe->id,
                                'nomClasse' => $classe->nomClasse,
                                'annee' => $classe->annee,
                                'nbEtudiants' => $classe->etudiants->count(),
                                'capacite_max' => $classe->capacite_max ?? 30,
                            ];
                        });

        return view('etudiant.classes.index', compact('classes'));
    }

    /**
     * Rechercher des classes
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('search');
        $annee = $request->get('annee');

        $query = Classe::query();

        if ($searchTerm) {
            $query->where('nomClasse', 'LIKE', "%{$searchTerm}%");
        }

        if ($annee && $annee !== 'all') {
            $query->where('annee', $annee);
        }

        $classes = $query->with('etudiants')
                        ->orderBy('annee')
                        ->orderBy('nomClasse')
                        ->get()
                        ->map(function ($classe) {
                            return [
                                'id' => $classe->id,
                                'nomClasse' => $classe->nomClasse,
                                'annee' => $classe->annee,
                                'nbEtudiants' => $classe->etudiants->count(),
                                'capacite_max' => $classe->capacite_max ?? 30,
                            ];
                        });

        return response()->json($classes);
    }

    /**
     * Rejoindre une classe (si vous avez cette fonctionnalité)
     */
    public function rejoindre(Request $request, $classeId)
    {
        $classe = Classe::findOrFail($classeId);
        $etudiant = auth()->user(); // Supposant que l'étudiant est connecté

        // Vérifier si l'étudiant n'est pas déjà dans une classe
        if ($etudiant->classe_id) {
            return back()->with('error', 'Vous êtes déjà inscrit dans une classe.');
        }

        // Vérifier la capacité
        if ($classe->etudiants->count() >= ($classe->capacite_max ?? 30)) {
            return back()->with('error', 'Cette classe est complète.');
        }

        // Inscrire l'étudiant
        $etudiant->classe_id = $classe->id;
        $etudiant->save();

        return back()->with('success', 'Vous avez rejoint la classe avec succès !');
    }
}