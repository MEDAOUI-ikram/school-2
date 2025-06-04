<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Etudiant;
use App\Models\EmploiDuTemps;
use App\Models\Note;
use App\Models\AnneeScolaire;

class EnseignantController extends Controller
{
    public function __construct()
    {
        // Décommentez si vous utilisez l'authentification
        // $this->middleware(['auth', 'roleMid:enseignant']);
    }

    /**
     * Afficher le dashboard enseignant
     */
    public function index()
    {
        $enseignant = Auth::user(); // Supposons que l'enseignant est connecté
        
        // Si pas d'authentification, utilisez un ID fixe pour les tests
        // $enseignant = Enseignant::find(1);
        
        // Classes enseignées par cet enseignant
        $classes = Classe::where('enseignant_id', $enseignant->id)
                        ->with(['etudiants', 'matiere'])
                        ->get();

        // Matières enseignées par cet enseignant
        $matieres = Matiere::where('enseignant_id', $enseignant->id)->get();

        // Statistiques
        $stats = [
            'totalClasses' => $classes->count(),
            'totalEtudiants' => $classes->sum(function($classe) {
                return $classe->etudiants->count();
            }),
            'totalMatieres' => $matieres->count(),
            'heuresParSemaine' => $matieres->sum('heures_par_semaine') ?? 0
        ];

        return view('enseignant.dashboard', compact('enseignant', 'classes', 'matieres', 'stats'));
    }

    /**
     * Afficher les classes
     */
    public function classes()
    {
        $enseignant = Auth::user();
        // $enseignant = Enseignant::find(1); // Pour les tests
        
        $classes = Classe::where('enseignant_id', $enseignant->id)
                        ->with(['etudiants', 'matiere'])
                        ->get()
                        ->map(function($classe) {
                            return [
                                'id' => $classe->id,
                                'nomClasse' => $classe->nom_classe,
                                'niveau' => $classe->niveau,
                                'nbEtudiants' => $classe->etudiants->count(),
                                'matiere' => $classe->matiere->nom_matiere ?? 'Non définie',
                                'salle' => $classe->salle ?? 'Non définie',
                                'annee' => $classe->annee_scolaire
                            ];
                        });

        return view('enseignant.classes', compact('classes'));
    }

    /**
     * Afficher les étudiants
     */
    public function etudiants($classeId = null)
    {
        $enseignant = Auth::user();
        // $enseignant = Enseignant::find(1); // Pour les tests
        
        // Classes de l'enseignant pour le filtre
        $classes = Classe::where('enseignant_id', $enseignant->id)
                        ->select('id', 'nom_classe')
                        ->get();

        // Étudiants selon la classe sélectionnée ou tous les étudiants de l'enseignant
        $etudiantsQuery = Etudiant::whereHas('classes', function($query) use ($enseignant) {
            $query->where('enseignant_id', $enseignant->id);
        })->with(['classes', 'notes']);

        if ($classeId) {
            $etudiantsQuery->whereHas('classes', function($query) use ($classeId) {
                $query->where('classe_id', $classeId);
            });
        }

        $etudiants = $etudiantsQuery->get()->map(function($etudiant) {
            return [
                'id' => $etudiant->id,
                'nom' => $etudiant->nom . ' ' . $etudiant->prenom,
                'email' => $etudiant->email,
                'classe' => $etudiant->classes->first()->nom_classe ?? 'Non définie',
                'moyenne' => $etudiant->notes->avg('note') ?? 0
            ];
        });

        return view('enseignant.etudiants', compact('etudiants', 'classes'));
    }

    /**
     * Afficher l'emploi du temps
     */
    public function emploiDuTemps()
    {
        $enseignant = Auth::user();
        // $enseignant = Enseignant::find(1); // Pour les tests
        
        $emploiDuTemps = EmploiDuTemps::whereHas('classe', function($query) use ($enseignant) {
            $query->where('enseignant_id', $enseignant->id);
        })
        ->with(['classe', 'matiere'])
        ->orderBy('jour_semaine')
        ->orderBy('heure_debut')
        ->get();

        // Organiser par jour de la semaine
        $emploi = [];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        
        foreach ($jours as $index => $jour) {
            $emploi[$jour] = $emploiDuTemps->where('jour_semaine', $index + 1)
                                          ->map(function($cours) {
                                              return [
                                                  'heure' => $cours->heure_debut . '-' . $cours->heure_fin,
                                                  'matiere' => $cours->matiere->nom_matiere ?? 'Non définie',
                                                  'classe' => $cours->classe->nom_classe ?? 'Non définie',
                                                  'salle' => $cours->salle ?? 'Non définie'
                                              ];
                                          })->toArray();
        }

        return view('enseignant.emploi-du-temps', compact('emploi'));
    }

    /**
     * Afficher les notes
     */
    public function notes()
    {
        $enseignant = Auth::user();
        // $enseignant = Enseignant::find(1); // Pour les tests
        
        $notes = Note::whereHas('etudiant.classes', function($query) use ($enseignant) {
            $query->where('enseignant_id', $enseignant->id);
        })
        ->with(['etudiant', 'matiere', 'etudiant.classes'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($note) {
            return [
                'id' => $note->id,
                'etudiant' => $note->etudiant->nom . ' ' . $note->etudiant->prenom,
                'classe' => $note->etudiant->classes->first()->nom_classe ?? 'Non définie',
                'matiere' => $note->matiere->nom_matiere ?? 'Non définie',
                'note' => $note->note,
                'type' => $note->type_evaluation ?? 'Contrôle',
                'date' => $note->created_at->format('d/m/Y'),
                'coefficient' => $note->coefficient ?? 1
            ];
        });

        return view('enseignant.notes', compact('notes'));
    }

    /**
     * Afficher les informations personnelles
     */
    public function infos()
    {
        $enseignant = Auth::user();
        // $enseignant = Enseignant::find(1); // Pour les tests
        
        $enseignantData = [
            'id' => $enseignant->id,
            'nom' => $enseignant->nom . ' ' . $enseignant->prenom,
            'email' => $enseignant->email,
            'specialite' => $enseignant->specialite ?? 'Non définie',
            'experience' => $enseignant->experience ?? 'Non définie',
            'telephone' => $enseignant->telephone ?? '',
            'adresse' => $enseignant->adresse ?? '',
            'date_embauche' => $enseignant->date_embauche ? $enseignant->date_embauche->format('d/m/Y') : 'Non définie'
        ];

        return view('enseignant.infos', compact('enseignantData'));
    }

    /**
     * Mettre à jour les informations
     */
    public function updateInfos(Request $request)
    {
        $enseignant = Auth::user();
        // $enseignant = Enseignant::find(1); // Pour les tests
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:enseignants,email,' . $enseignant->id,
            'specialite' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500',
        ]);

        // Séparer nom et prénom si nécessaire
        $nomComplet = explode(' ', $request->nom, 2);
        
        $enseignant->update([
            'nom' => $nomComplet[0],
            'prenom' => $nomComplet[1] ?? '',
            'email' => $request->email,
            'specialite' => $request->specialite,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);

        return redirect()->route('enseignant.infos')->with('success', 'Informations modifiées avec succès!');
    }

    /**
     * Ajouter une note
     */
    public function ajouterNote(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'note' => 'required|numeric|min:0|max:20',
            'type_evaluation' => 'required|string|max:255',
            'coefficient' => 'nullable|numeric|min:0.1|max:10',
        ]);

        Note::create([
            'etudiant_id' => $request->etudiant_id,
            'matiere_id' => $request->matiere_id,
            'note' => $request->note,
            'type_evaluation' => $request->type_evaluation,
            'coefficient' => $request->coefficient ?? 1,
            'enseignant_id' => Auth::id(),
            'date_evaluation' => now(),
        ]);

        return redirect()->route('enseignant.notes')->with('success', 'Note ajoutée avec succès!');
    }

    /**
     * Modifier une note
     */
    public function modifierNote(Request $request, $noteId)
    {
        $note = Note::findOrFail($noteId);
        
        // Vérifier que l'enseignant peut modifier cette note
        if ($note->enseignant_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'type_evaluation' => 'required|string|max:255',
            'coefficient' => 'nullable|numeric|min:0.1|max:10',
        ]);

        $note->update([
            'note' => $request->note,
            'type_evaluation' => $request->type_evaluation,
            'coefficient' => $request->coefficient ?? 1,
        ]);

        return redirect()->route('enseignant.notes')->with('success', 'Note modifiée avec succès!');
    }

    /**
     * Supprimer une note
     */
    public function supprimerNote($noteId)
    {
        $note = Note::findOrFail($noteId);
        
        // Vérifier que l'enseignant peut supprimer cette note
        if ($note->enseignant_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $note->delete();

        return redirect()->route('enseignant.notes')->with('success', 'Note supprimée avec succès!');
    }

    /**
     * Obtenir les statistiques de classe
     */
    public function statistiquesClasse($classeId)
    {
        $enseignant = Auth::user();
        
        $classe = Classe::where('id', $classeId)
                       ->where('enseignant_id', $enseignant->id)
                       ->with(['etudiants.notes'])
                       ->firstOrFail();

        $statistiques = [
            'nom_classe' => $classe->nom_classe,
            'nb_etudiants' => $classe->etudiants->count(),
            'moyenne_classe' => $classe->etudiants->flatMap->notes->avg('note') ?? 0,
            'note_max' => $classe->etudiants->flatMap->notes->max('note') ?? 0,
            'note_min' => $classe->etudiants->flatMap->notes->min('note') ?? 0,
        ];

        return response()->json($statistiques);
    }
}