<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrateur;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Niveau;
use App\Models\Matiere;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EnseignantsExport;
use App\Exports\EtudiantsExport;
use App\Imports\EnseignantsImport;
use App\Imports\EtudiantsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EnseignantsExportSimple;
use App\Exports\EtudiantsExportSimple;
use App\Imports\EnseignantsImportSimple;
use App\Imports\EtudiantsImportSimple;

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
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function indexEnseignants(Request $request)
    {
        $search = $request->get('search', '');
        $query = Enseignant::query();

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhere('courriel', 'like', "%{$search}%");
        }

        $enseignants = $query->withCount(['matieres', 'classes'])
                            ->orderBy('nom')
                            ->paginate(10);

        return view('admin.enseignants.index', compact('enseignants', 'search'));
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
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        $enseignant = Enseignant::create($validated);

        return redirect()->route('admin.enseignants.index')
                        ->with('success', 'Enseignant créé avec succès.');
    }

    public function showEnseignant(Enseignant $enseignant)
    {
        $enseignant->load(['matieres', 'classes']);
        return view('admin.enseignants.show', compact('enseignant'));
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

    public function indexEtudiants(Request $request)
    {
        $search = $request->get('search', '');
        $niveau = $request->get('niveau', '');
        $query = Etudiant::query();

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhere('courriel', 'like', "%{$search}%");
        }

        if ($niveau) {
            $query->where('niveau', $niveau);
        }

        $etudiants = $query->withCount('classes')
                          ->orderBy('nom')
                          ->paginate(10);

        $niveaux = Etudiant::distinct('niveau')->pluck('niveau')->toArray();

        return view('admin.etudiants.index', compact('etudiants', 'search', 'niveau', 'niveaux'));
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
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        $etudiant = Etudiant::create($validated);

        return redirect()->route('admin.etudiants.index')
                        ->with('success', 'Étudiant créé avec succès.');
    }

    public function showEtudiant(Etudiant $etudiant)
    {
        $etudiant->load('classes');
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

        return response()->json([
            'enseignants' => $enseignants,
            'etudiants' => $etudiants,
            'classes' => $classes,
        ]);
    }

    // ========================================
    // FONCTIONNALITÉS EXPORT
    // ========================================

    public function exportUsers(Request $request)
    {
        $type = $request->get('type', 'enseignants');
        $format = $request->get('format', 'excel');

        try {
            if ($type === 'enseignants') {
                return $this->exportEnseignants($format);
            } elseif ($type === 'etudiants') {
                return $this->exportEtudiants($format);
            }

            return response()->json(['error' => 'Type non supporté'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de l\'export : ' . $e->getMessage()], 500);
        }
    }

    private function exportEnseignants($format)
    {
        $filename = 'enseignants_' . date('Y-m-d_H-i-s');

        switch ($format) {
            case 'excel':
                return Excel::download(new EnseignantsExportSimple, $filename . '.xlsx');
            case 'csv':
                return Excel::download(new EnseignantsExportSimple, $filename . '.csv');
            case 'pdf':
                return $this->exportEnseignantsPDF();
            default:
                return Excel::download(new EnseignantsExportSimple, $filename . '.xlsx');
        }
    }

    private function exportEtudiants($format)
    {
        $filename = 'etudiants_' . date('Y-m-d_H-i-s');

        switch ($format) {
            case 'excel':
                return Excel::download(new EtudiantsExportSimple, $filename . '.xlsx');
            case 'csv':
                return Excel::download(new EtudiantsExportSimple, $filename . '.csv');
            case 'pdf':
                return $this->exportEtudiantsPDF();
            default:
                return Excel::download(new EtudiantsExportSimple, $filename . '.xlsx');
        }
    }

    private function exportEnseignantsPDF()
    {
        $enseignants = Enseignant::with('matieres')->orderBy('nom')->get();
        $pdf = Pdf::loadView('admin.exports.enseignants-pdf', compact('enseignants'));
        return $pdf->download('enseignants_' . date('Y-m-d') . '.pdf');
    }

    private function exportEtudiantsPDF()
    {
        $etudiants = Etudiant::with('classes')->orderBy('nom')->get();
        $pdf = Pdf::loadView('admin.exports.etudiants-pdf', compact('etudiants'));
        return $pdf->download('etudiants_' . date('Y-m-d') . '.pdf');
    }

    // ========================================
    // FONCTIONNALITÉS IMPORT
    // ========================================

    public function importUsers(Request $request)
    {
        $request->validate([
            'type' => 'required|in:enseignant,etudiant',
            'fichier' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $type = $request->type;
            $file = $request->file('fichier');

            if ($type === 'enseignant') {
                $import = new EnseignantsImportSimple();
                Excel::import($import, $file);
                $message = "Import réussi : {$import->getRowCount()} enseignants importés";
            } else {
                $import = new EtudiantsImportSimple();
                Excel::import($import, $file);
                $message = "Import réussi : {$import->getRowCount()} étudiants importés";
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'import : ' . $e->getMessage());
        }
    }

    public function downloadTemplate(Request $request)
    {
        $type = $request->get('type', 'enseignant');

        if ($type === 'enseignant') {
            return $this->downloadEnseignantTemplate();
        } else {
            return $this->downloadEtudiantTemplate();
        }
    }

    private function downloadEnseignantTemplate()
    {
        $headers = [
            ['nom', 'courriel', 'specialite', 'mot_de_passe'],
            ['Prof. Dupont', 'dupont@exemple.com', 'Mathématiques', 'motdepasse123'],
            ['Mme Martin', 'martin@exemple.com', 'Français', 'motdepasse123'],
        ];

        return $this->createCSVResponse($headers, 'template_enseignants.csv');
    }

    private function downloadEtudiantTemplate()
    {
        $headers = [
            ['nom', 'courriel', 'niveau', 'mot_de_passe'],
            ['Jean Dupont', 'jean.dupont@exemple.com', 'Primaire', 'motdepasse123'],
            ['Marie Martin', 'marie.martin@exemple.com', 'Collège', 'motdepasse123'],
        ];

        return $this->createCSVResponse($headers, 'template_etudiants.csv');
    }

    private function createCSVResponse($data, $filename)
    {
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ========================================
    // FONCTIONNALITÉS BULK DELETE
    // ========================================

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'type' => 'required|in:enseignant,etudiant',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:' . ($request->type === 'enseignant' ? 'enseignants' : 'etudiants') . ',id',
        ]);

        try {
            $type = $request->type;
            $ids = $request->ids;
            $count = 0;

            DB::beginTransaction();

            if ($type === 'enseignant') {
                $count = Enseignant::whereIn('id', $ids)->count();
                Enseignant::whereIn('id', $ids)->delete();
            } elseif ($type === 'etudiant') {
                $count = Etudiant::whereIn('id', $ids)->count();
                Etudiant::whereIn('id', $ids)->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$count} " . ($type === 'enseignant' ? 'enseignants' : 'étudiants') . " supprimés avec succès"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'type' => 'required|in:enseignant,etudiant',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        try {
            $action = $request->action;
            $type = $request->type;
            $ids = $request->ids;
            $count = 0;

            DB::beginTransaction();

            switch ($action) {
                case 'delete':
                    return $this->bulkDelete($request);

                case 'activate':
                case 'deactivate':
                    // Placeholder pour activation/désactivation
                    $status = $action === 'activate' ? 1 : 0;
                    if ($type === 'enseignant') {
                        $count = Enseignant::whereIn('id', $ids)->update(['actif' => $status]);
                    } else {
                        $count = Etudiant::whereIn('id', $ids)->update(['actif' => $status]);
                    }
                    break;
            }

            DB::commit();

            $actionText = [
                'activate' => 'activés',
                'deactivate' => 'désactivés',
                'delete' => 'supprimés'
            ];

            return response()->json([
                'success' => true,
                'message' => "{$count} " . ($type === 'enseignant' ? 'enseignants' : 'étudiants') . " {$actionText[$action]} avec succès"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'action : ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'type' => 'required|in:enseignant,etudiant',
            'id' => 'required|integer',
        ]);

        try {
            $type = $request->type;
            $id = $request->id;

            if ($type === 'enseignant') {
                $user = Enseignant::findOrFail($id);
            } else {
                $user = Etudiant::findOrFail($id);
            }

            $user->actif = !($user->actif ?? true);
            $user->save();

            return response()->json([
                'success' => true,
                'status' => $user->actif,
                'message' => 'Statut mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de statut : ' . $e->getMessage()
            ], 500);
        }
    }
}


