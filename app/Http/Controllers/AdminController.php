<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrateur;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Niveau;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\ClasseEnseignantMatiere;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        $stats = [
            'total_etudiants' => Etudiant::count(),
            'total_enseignants' => Enseignant::count(),
            'total_classes' => Classe::count(),
            'total_matieres' => Matiere::count(),
            'total_niveaux' => Niveau::count(),
            'total_annees' => AnneeScolaire::count(),
            'total_affectations' => ClasseEnseignantMatiere::count(),
        ];

        // Statistiques par niveau
        $statsParNiveau = Niveau::withCount(['classes', 'matieres'])->get();

        // Dernières activités
        $dernieresClasses = Classe::with('niveau')->latest()->take(5)->get();
        $dernieresMatieres = Matiere::with(['enseignant', 'niveau'])->latest()->take(5)->get();
        $dernieresAffectations = ClasseEnseignantMatiere::with(['classe', 'enseignant', 'matiere'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'statsParNiveau', 'dernieresClasses', 'dernieresMatieres', 'dernieresAffectations'));
    }

    // ========================================
    // GESTION DES ENSEIGNANTS
    // ========================================

    public function indexEnseignants(Request $request)
    {
        $search = $request->get('search', '');
        $specialite = $request->get('specialite', '');
        $query = Enseignant::query();

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhere('courriel', 'like', "%{$search}%");
        }

        if ($specialite) {
            $query->where('specialite', $specialite);
        }

        $enseignants = $query->withCount(['matieres', 'classes'])
                            ->orderBy('nom')
                            ->paginate(10);

        $specialites = Enseignant::distinct('specialite')->whereNotNull('specialite')->pluck('specialite');

        return view('admin.enseignants.index', compact('enseignants', 'search', 'specialite', 'specialites'));
    }

    public function createEnseignant()
    {
        return view('admin.enseignants.create');
    }

    public function storeEnseignant(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'courriel' => 'required|email|unique:enseignants,courriel',
            'mot_de_passe' => 'required|min:6',
            'specialite' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        $enseignant = Enseignant::create($validated);

        return redirect()->route('admin.enseignants.index')
                        ->with('success', 'Enseignant créé avec succès.');
    }

    public function showEnseignant(Enseignant $enseignant)
    {
        $enseignant->load(['matieres.niveau', 'classes.niveau']);
        $affectations = ClasseEnseignantMatiere::where('enseignant_id', $enseignant->id)
                                               ->with(['classe.niveau', 'matiere'])
                                               ->get();
        return view('admin.enseignants.show', compact('enseignant', 'affectations'));
    }

    public function editEnseignant(Enseignant $enseignant)
    {
        return view('admin.enseignants.edit', compact('enseignant'));
    }

    public function updateEnseignant(Request $request, Enseignant $enseignant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'courriel' => 'required|email|unique:enseignants,courriel,' . $enseignant->id,
            'mot_de_passe' => 'nullable|min:6|confirmed',
            'specialite' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
        ]);

        if (!empty($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $enseignant->update($validated);

        return redirect()->route('admin.enseignants.index')
                        ->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroyEnseignant(Enseignant $enseignant)
    {
        try {
            $enseignant->delete();
            return redirect()->route('admin.enseignants.index')
                            ->with('success', 'Enseignant supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.enseignants.index')
                            ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    // ========================================
    // GESTION DES ÉTUDIANTS
    // ========================================

    public function indexEtudiants(Request $request)
    {
        $search = $request->get('search', '');
        $niveau = $request->get('niveau', '');
        $classe = $request->get('classe', '');
        $query = Etudiant::query();

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhere('courriel', 'like', "%{$search}%");
        }

        if ($niveau) {
            $query->where('niveau', $niveau);
        }

        if ($classe) {
            $query->whereHas('classes', function($q) use ($classe) {
                $q->where('classes.id', $classe);
            });
        }

        $etudiants = $query->withCount('classes')
                          ->orderBy('nom')
                          ->paginate(10);

        $niveaux = Etudiant::distinct('niveau')->pluck('niveau')->toArray();
        $classes = Classe::with('niveau')->get();

        return view('admin.etudiants.index', compact('etudiants', 'search', 'niveau', 'classe', 'niveaux', 'classes'));
    }

    public function createEtudiant()
    {
        $niveaux = Niveau::all();
        return view('admin.etudiants.create', compact('niveaux'));
    }

    public function storeEtudiant(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'courriel' => 'required|email|unique:etudiants,courriel',
            'mot_de_passe' => 'required|min:6|confirmed',
            'niveau' => 'required|string',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        $etudiant = Etudiant::create($validated);

        return redirect()->route('admin.etudiants.index')
                        ->with('success', 'Étudiant créé avec succès.');
    }

    public function showEtudiant(Etudiant $etudiant)
    {
        $etudiant->load('classes.niveau');
        return view('admin.etudiants.show', compact('etudiant'));
    }

    public function editEtudiant(Etudiant $etudiant)
    {
        $niveaux = Niveau::all();
        return view('admin.etudiants.edit', compact('etudiant', 'niveaux'));
    }

    public function updateEtudiant(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'courriel' => 'required|email|unique:etudiants,courriel,' . $etudiant->id,
            'mot_de_passe' => 'nullable|min:6|confirmed',
            'niveau' => 'required|string',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
        ]);

        if (!empty($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $etudiant->update($validated);

        return redirect()->route('admin.etudiants.index')
                        ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroyEtudiant(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('admin.etudiants.index')
                        ->with('success', 'Étudiant supprimé avec succès.');
    }

    // ========================================
    // GESTION DES MATIÈRES
    // ========================================

    public function indexMatieres(Request $request)
    {
        $search = $request->get('search', '');
        $niveau_id = $request->get('niveau_id', '');
        $enseignant_id = $request->get('enseignant_id', '');

        $query = Matiere::with(['niveau', 'enseignant']);

        if ($search) {
            $query->where('nom_matiere', 'like', "%{$search}%");
        }

        if ($niveau_id) {
            $query->where('niveau_id', $niveau_id);
        }

        if ($enseignant_id) {
            $query->where('enseignant_id', $enseignant_id);
        }

        $matieres = $query->withCount('classes')->orderBy('nom_matiere')->paginate(10);
        $niveaux = Niveau::all();
        $enseignants = Enseignant::orderBy('nom')->get();

        return view('admin.matieres.index', compact('matieres', 'search', 'niveau_id', 'enseignant_id', 'niveaux', 'enseignants'));
    }

    public function createMatiere()
    {
        $niveaux = Niveau::all();
        $enseignants = Enseignant::orderBy('nom')->get();
        return view('admin.matieres.create', compact('niveaux', 'enseignants'));
    }

    public function storeMatiere(Request $request)
    {
        $validated = $request->validate([
            'nom_matiere' => 'required|string|max:255',
            'coefficient' => 'required|numeric|min:0.5|max:10',
            'niveau_id' => 'required|exists:niveaux,id',
            'enseignant_id' => 'nullable|exists:enseignants,id',
            'description' => 'nullable|string',
            'heures_par_semaine' => 'nullable|numeric|min:1|max:20',
        ]);

        $matiere = Matiere::create($validated);

        return redirect()->route('admin.matieres.index')
                        ->with('success', 'Matière créée avec succès.');
    }

    public function showMatiere(Matiere $matiere)
    {
        $matiere->load(['niveau', 'enseignant', 'classes.etudiants']);
        $affectations = ClasseEnseignantMatiere::where('matiere_id', $matiere->id)
                                               ->with(['classe.niveau', 'enseignant'])
                                               ->get();
        return view('admin.matieres.show', compact('matiere', 'affectations'));
    }

    public function editMatiere(Matiere $matiere)
    {
        $niveaux = Niveau::all();
        $enseignants = Enseignant::orderBy('nom')->get();
        return view('admin.matieres.edit', compact('matiere', 'niveaux', 'enseignants'));
    }

    public function updateMatiere(Request $request, Matiere $matiere)
    {
        $validated = $request->validate([
            'nom_matiere' => 'required|string|max:255',
            'coefficient' => 'required|numeric|min:0.5|max:10',
            'niveau_id' => 'required|exists:niveaux,id',
            'enseignant_id' => 'nullable|exists:enseignants,id',
            'description' => 'nullable|string',
            'heures_par_semaine' => 'nullable|numeric|min:1|max:20',
        ]);

        $matiere->update($validated);

        return redirect()->route('admin.matieres.index')
                        ->with('success', 'Matière mise à jour avec succès.');
    }

    public function destroyMatiere(Matiere $matiere)
    {
        try {
            $matiere->delete();
            return redirect()->route('admin.matieres.index')
                            ->with('success', 'Matière supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.matieres.index')
                            ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    // ========================================
    // GESTION DES CLASSES
    // ========================================

    public function indexClasses(Request $request)
    {
        $search = $request->get('search', '');
        $niveau_id = $request->get('niveau_id', '');
        $annee = $request->get('annee', '');

        $query = Classe::with(['niveau']);

        if ($search) {
            $query->where('nom_classe', 'like', "%{$search}%");
        }

        if ($niveau_id) {
            $query->where('niveau_id', $niveau_id);
        }

        if ($annee) {
            $query->where('annee', $annee);
        }

        $classes = $query->withCount(['etudiants', 'enseignants', 'matieres'])
                        ->orderBy('nom_classe')
                        ->paginate(10);

        $niveaux = Niveau::all();
        $annees = Classe::distinct('annee')->orderBy('annee', 'desc')->pluck('annee');

        return view('admin.classes.index', compact('classes', 'search', 'niveau_id', 'annee', 'niveaux', 'annees'));
    }

    public function createClasse()
    {
        $niveaux = Niveau::all();
        $anneesDisponibles = range(date('Y') - 2, date('Y') + 2);
        return view('admin.classes.create', compact('niveaux', 'anneesDisponibles'));
    }

    public function storeClasse(Request $request)
    {
        $validated = $request->validate([
            'nom_classe' => 'required|string|max:255',
            'niveau_id' => 'required|exists:niveaux,id',
            'annee' => 'required|integer|min:2020|max:2030',
            'capacite_max' => 'nullable|integer|min:1|max:50',
            'description' => 'nullable|string',
        ]);

        $classe = Classe::create($validated);

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Classe créée avec succès.');
    }

    public function showClasse(Classe $classe)
    {
        $classe->load(['niveau', 'etudiants', 'enseignants.matieres', 'matieres.enseignant']);
        $affectations = ClasseEnseignantMatiere::where('classe_id', $classe->id)
                                               ->with(['enseignant', 'matiere'])
                                               ->get();
        return view('admin.classes.show', compact('classe', 'affectations'));
    }

    public function editClasse(Classe $classe)
    {
        $niveaux = Niveau::all();
        $anneesDisponibles = range(date('Y') - 2, date('Y') + 2);
        return view('admin.classes.edit', compact('classe', 'niveaux', 'anneesDisponibles'));
    }

    public function updateClasse(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'nom_classe' => 'required|string|max:255',
            'niveau_id' => 'required|exists:niveaux,id',
            'annee' => 'required|integer|min:2020|max:2030',
            'capacite_max' => 'nullable|integer|min:1|max:50',
            'description' => 'nullable|string',
        ]);

        $classe->update($validated);

        return redirect()->route('admin.classes.index')
                        ->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroyClasse(Classe $classe)
    {
        try {
            $classe->delete();
            return redirect()->route('admin.classes.index')
                            ->with('success', 'Classe supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.classes.index')
                            ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    // ========================================
    // GESTION DES AFFECTATIONS
    // ========================================

    public function indexAffectations(Request $request)
    {
        $classe_id = $request->get('classe_id', '');
        $enseignant_id = $request->get('enseignant_id', '');
        $matiere_id = $request->get('matiere_id', '');

        $query = ClasseEnseignantMatiere::with(['classe.niveau', 'enseignant', 'matiere']);

        if ($classe_id) {
            $query->where('classe_id', $classe_id);
        }

        if ($enseignant_id) {
            $query->where('enseignant_id', $enseignant_id);
        }

        if ($matiere_id) {
            $query->where('matiere_id', $matiere_id);
        }

        $affectations = $query->orderBy('created_at', 'desc')->paginate(15);

        $classes = Classe::with('niveau')->orderBy('nom_classe')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $matieres = Matiere::with('niveau')->orderBy('nom_matiere')->get();

        return view('admin.affectations.index', compact('affectations', 'classe_id', 'enseignant_id', 'matiere_id', 'classes', 'enseignants', 'matieres'));
    }

    public function createAffectation()
    {
        $classes = Classe::with('niveau')->orderBy('nom_classe')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $matieres = Matiere::with('niveau')->orderBy('nom_matiere')->get();

        return view('admin.affectations.create', compact('classes', 'enseignants', 'matieres'));
    }

    public function storeAffectation(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'heures_par_semaine' => 'nullable|numeric|min:1|max:20',
            'coefficient' => 'nullable|numeric|min:0.5|max:10',
            'notes' => 'nullable|string',
        ]);

        // Vérifier si l'affectation existe déjà
        $exists = ClasseEnseignantMatiere::where([
            'classe_id' => $validated['classe_id'],
            'enseignant_id' => $validated['enseignant_id'],
            'matiere_id' => $validated['matiere_id'],
        ])->exists();

        if ($exists) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Cette affectation existe déjà.');
        }

        ClasseEnseignantMatiere::create($validated);

        return redirect()->route('admin.affectations.index')
                        ->with('success', 'Affectation créée avec succès.');
    }

    public function destroyAffectation(ClasseEnseignantMatiere $affectation)
    {
        $affectation->delete();
        return redirect()->route('admin.affectations.index')
                        ->with('success', 'Affectation supprimée avec succès.');
    }

    // ========================================
    // GESTION DES ANNÉES SCOLAIRES
    // ========================================

    public function indexAnnees()
    {
        $annees = AnneeScolaire::orderBy('date_debut', 'desc')->paginate(10);
        return view('admin.annees.index', compact('annees'));
    }

    public function createAnnee()
    {
        return view('admin.annees.create');
    }

    public function storeAnnee(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:annee_scolaires,libelle',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        AnneeScolaire::create($validated);

        return redirect()->route('admin.annees.index')
                        ->with('success', 'Année scolaire créée avec succès.');
    }

    public function editAnnee(AnneeScolaire $annee)
    {
        return view('admin.annees.edit', compact('annee'));
    }

    public function updateAnnee(Request $request, AnneeScolaire $annee)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255|unique:annee_scolaires,libelle,' . $annee->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $annee->update($validated);

        return redirect()->route('admin.annees.index')
                        ->with('success', 'Année scolaire mise à jour avec succès.');
    }

    public function destroyAnnee(AnneeScolaire $annee)
    {
        $annee->delete();
        return redirect()->route('admin.annees.index')
                        ->with('success', 'Année scolaire supprimée avec succès.');
    }

    // ========================================
    // RAPPORTS
    // ========================================

    public function rapports()
    {
        return view('admin.rapports.index');
    }

    public function rapportGeneral()
    {
        $stats = [
            'total_etudiants' => Etudiant::count(),
            'total_enseignants' => Enseignant::count(),
            'total_classes' => Classe::count(),
            'total_matieres' => Matiere::count(),
            'total_affectations' => ClasseEnseignantMatiere::count(),
            'total_niveaux' => Niveau::count(),
        ];

        $statsParNiveau = Niveau::withCount(['classes', 'matieres'])->get();
        $statsParAnnee = Classe::select('annee', DB::raw('count(*) as total'))
                              ->groupBy('annee')
                              ->orderBy('annee', 'desc')
                              ->get();

        $evolutionEtudiants = Etudiant::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                                     ->groupBy('date')
                                     ->orderBy('date', 'desc')
                                     ->take(30)
                                     ->get();

        return view('admin.rapports.general', compact('stats', 'statsParNiveau', 'statsParAnnee', 'evolutionEtudiants'));
    }

    public function rapportEnseignants()
    {
        $enseignants = Enseignant::withCount(['matieres', 'classes'])
                                ->with(['matieres.niveau', 'classes.niveau'])
                                ->orderBy('nom')
                                ->get();

        $specialites = Enseignant::select('specialite', DB::raw('count(*) as total'))
                                ->whereNotNull('specialite')
                                ->groupBy('specialite')
                                ->get();

        return view('admin.rapports.enseignants', compact('enseignants', 'specialites'));
    }

    public function rapportClasses()
    {
        $classes = Classe::withCount(['etudiants', 'enseignants', 'matieres'])
                        ->with(['niveau', 'etudiants', 'enseignants.matieres'])
                        ->orderBy('nom_classe')
                        ->get();

        $effectifsParNiveau = Classe::join('niveaux', 'classes.niveau_id', '=', 'niveaux.id')
                                   ->select('niveaux.nom_niveau', DB::raw('sum(classes.etudiants_count) as total_etudiants'))
                                   ->groupBy('niveaux.nom_niveau')
                                   ->get();

        return view('admin.rapports.classes', compact('classes', 'effectifsParNiveau'));
    }

    public function rapportMatieres()
    {
        $matieres = Matiere::withCount('classes')
                          ->with(['niveau', 'enseignant', 'classes'])
                          ->orderBy('nom_matiere')
                          ->get();

        $matieresParNiveau = Niveau::withCount('matieres')->with('matieres')->get();

        return view('admin.rapports.matieres', compact('matieres', 'matieresParNiveau'));
    }

    // ========================================
    // UTILITAIRES
    // ========================================

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query) || strlen($query) < 3) {
            return response()->json(['message' => 'La recherche doit contenir au moins 3 caractères'], 400);
        }

        $enseignants = Enseignant::where('nom', 'like', "%{$query}%")
                                ->orWhere('courriel', 'like', "%{$query}%")
                                ->take(5)
                                ->get(['id', 'nom', 'courriel']);

        $etudiants = Etudiant::where('nom', 'like', "%{$query}%")
                            ->orWhere('courriel', 'like', "%{$query}%")
                            ->take(5)
                            ->get(['id', 'nom', 'courriel', 'niveau']);

        $classes = Classe::where('nom_classe', 'like', "%{$query}%")
                        ->take(5)
                        ->get(['id', 'nom_classe']);

        $matieres = Matiere::where('nom_matiere', 'like', "%{$query}%")
                          ->take(5)
                          ->get(['id', 'nom_matiere']);

        return response()->json([
            'enseignants' => $enseignants,
            'etudiants' => $etudiants,
            'classes' => $classes,
            'matieres' => $matieres,
        ]);
    }

    // AJAX pour récupérer les matières par niveau
    public function getMatieresByNiveau($niveau_id)
    {
        $matieres = Matiere::where('niveau_id', $niveau_id)->orderBy('nom_matiere')->get();
        return response()->json($matieres);
    }

    // AJAX pour récupérer les classes par niveau
    public function getClassesByNiveau($niveau_id)
    {
        $classes = Classe::where('niveau_id', $niveau_id)->orderBy('nom_classe')->get();
        return response()->json($classes);
    }
}
