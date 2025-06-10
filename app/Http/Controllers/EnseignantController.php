<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Note;
use App\Models\Matiere;
use App\Models\User;
use Carbon\Carbon;

class EnseignantController extends Controller
{
    public function dashboard()
    {
        try {
            // Récupérer les données avec les bonnes relations
            $classes = Classe::with(['etudiants'])->get();
            $etudiants = Etudiant::with(['classe'])->get();
            $notes = Note::with(['etudiant.classe'])->get();
            $matieres = Matiere::all();
            
            // Calculer les statistiques
            $stats = [
                'total_classes' => $classes->count(),
                'total_etudiants' => $etudiants->count(),
                'notes_en_attente' => $notes->where('validated', false)->count(),
                'cours_aujourdhui' => 0 // À adapter selon votre emploi du temps
            ];
            
            // Activités récentes
            $activities = collect([
                (object)[
                    'title' => "Données chargées: {$classes->count()} classes, {$etudiants->count()} étudiants",
                    'icon' => 'fas fa-info',
                    'created_at' => Carbon::now()
                ]
            ]);
            
            return view('enseignant.dashboard', compact(
                'classes', 
                'etudiants', 
                'notes', 
                'matieres', 
                'stats', 
                'activities'
            ));
            
        } catch (\Exception $e) {
            return view('enseignant.dashboard', [
                'classes' => collect(),
                'etudiants' => collect(),
                'notes' => collect(),
                'matieres' => collect(),
                'stats' => ['total_classes' => 0, 'total_etudiants' => 0, 'notes_en_attente' => 0, 'cours_aujourdhui' => 0],
                'activities' => collect([
                    (object)[
                        'title' => 'Erreur: ' . $e->getMessage(),
                        'icon' => 'fas fa-exclamation-triangle',
                        'created_at' => Carbon::now()
                    ]
                ])
            ]);
        }
    }
    
    public function storeClasse(Request $request)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'salle' => 'nullable|string|max:255'
            ]);
            
            $classe = Classe::create([
                'nom_classe' => $request->nom,  // Utiliser le bon nom de colonne
                'annee' => '2024-2025',         // Valeur par défaut pour l'année
                'enseignant_id' => Auth::id(),
                'niveau_id' => 1                // Valeur par défaut
            ]);
            
            return response()->json(['success' => true, 'message' => 'Classe créée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function storeNote(Request $request)
    {
        try {
            $request->validate([
                'etudiant_id' => 'required|exists:etudiants,id',
                'type' => 'required|string|max:255',
                'note' => 'required|numeric|min:0|max:20'
            ]);
            
            $note = Note::create([
                'etudiant_id' => $request->etudiant_id,
                'enseignant_id' => Auth::id(), // ID de la table users
                'matiere_id' => Matiere::first()->id ?? 1, // Prendre une matière par défaut
                'type' => $request->type,
                'note' => $request->note,
                'coefficient' => 1,
                'validated' => true,
                'date_evaluation' => now()
            ]);
            
            return response()->json(['success' => true, 'message' => 'Note ajoutée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    // Autres méthodes...
    public function getStudentsByClass($classeId)
    {
        try {
            $etudiants = Etudiant::where('classe_id', $classeId)->get();
            return response()->json($etudiants);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }
}