<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Routes protégées par rôle
Route::middleware(['auth', 'roleMid:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name("admin.dashboard");
        // Enseignants
    Route::get('/admin/enseignants', [AdminController::class, 'indexEnseignants'])->name('admin.enseignants.index');
    Route::get('/admin/enseignants/create', [AdminController::class, 'createEnseignant'])->name('admin.enseignants.create');
    Route::post('/admin/enseignants', [AdminController::class, 'storeEnseignant'])->name('admin.enseignants.store');
    Route::get('/admin/enseignants/{enseignant}', [AdminController::class, 'showEnseignant'])->name('admin.enseignants.show');
    Route::get('/admin/enseignants/{enseignant}/edit', [AdminController::class, 'editEnseignant'])->name('admin.enseignants.edit');
    Route::put('/admin/enseignants/{enseignant}', [AdminController::class, 'updateEnseignant'])->name('admin.enseignants.update');
    Route::delete('/admin/enseignants/{enseignant}', [AdminController::class, 'destroyEnseignant'])->name('admin.enseignants.destroy');

    // Étudiants
    Route::get('/admin/etudiants', [AdminController::class, 'indexEtudiants'])->name('admin.etudiants.index');
    Route::get('/admin/etudiants/create', [AdminController::class, 'createEtudiant'])->name('admin.etudiants.create');
    Route::post('/admin/etudiants', [AdminController::class, 'storeEtudiant'])->name('admin.etudiants.store');
    Route::get('/admin/etudiants/{etudiant}', [AdminController::class, 'showEtudiant'])->name('admin.etudiants.show');
    Route::get('/admin/etudiants/{etudiant}/edit', [AdminController::class, 'editEtudiant'])->name('admin.etudiants.edit');
    Route::put('/admin/etudiants/{etudiant}', [AdminController::class, 'updateEtudiant'])->name('admin.etudiants.update');
    Route::delete('/admin/etudiants/{etudiant}', [AdminController::class, 'destroyEtudiant'])->name('admin.etudiants.destroy');
    // Gestion des matières
    Route::prefix('matieres')->name('admin.matieres.')->group(function () {
        Route::get('/', [AdminController::class, 'indexMatieres'])->name('index');
        Route::get('/create', [AdminController::class, 'createMatiere'])->name('create');
        Route::post('/', [AdminController::class, 'storeMatiere'])->name('store');
        Route::get('/{matiere}', [AdminController::class, 'showMatiere'])->name('show');
        Route::get('/{matiere}/edit', [AdminController::class, 'editMatiere'])->name('edit');
        Route::put('/{matiere}', [AdminController::class, 'updateMatiere'])->name('update');
        Route::delete('/{matiere}', [AdminController::class, 'destroyMatiere'])->name('destroy');
    });

    // Gestion des classes
    Route::prefix('classes')->name('admin.classes.')->group(function () {
        Route::get('/', [AdminController::class, 'indexClasses'])->name('index');
        Route::get('/create', [AdminController::class, 'createClasse'])->name('create');
        Route::post('/', [AdminController::class, 'storeClasse'])->name('store');
        Route::get('/{classe}', [AdminController::class, 'showClasse'])->name('show');
        Route::get('/{classe}/edit', [AdminController::class, 'editClasse'])->name('edit');
        Route::put('/{classe}', [AdminController::class, 'updateClasse'])->name('update');
        Route::delete('/{classe}', [AdminController::class, 'destroyClasse'])->name('destroy');
    });

    // Gestion des affectations
    Route::prefix('affectations')->name('admin.affectations.')->group(function () {
        Route::get('/', [AdminController::class, 'indexAffectations'])->name('index');
        Route::get('/create', [AdminController::class, 'createAffectation'])->name('create');
        Route::post('/', [AdminController::class, 'storeAffectation'])->name('store');
        Route::delete('/{affectation}', [AdminController::class, 'destroyAffectation'])->name('destroy');
    });

    // Gestion des années scolaires
    Route::prefix('annees')->name('admin.annees.')->group(function () {
        Route::get('/', [AdminController::class, 'indexAnnees'])->name('index');
        Route::get('/create', [AdminController::class, 'createAnnee'])->name('create');
        Route::post('/', [AdminController::class, 'storeAnnee'])->name('store');
        Route::get('/{annee}/edit', [AdminController::class, 'editAnnee'])->name('edit');
        Route::put('/{annee}', [AdminController::class, 'updateAnnee'])->name('update');
        Route::delete('/{annee}', [AdminController::class, 'destroyAnnee'])->name('destroy');
    });

    // Rapports
    Route::prefix('rapports')->name('admin.rapports.')->group(function () {
        Route::get('/', [AdminController::class, 'rapports'])->name('index');
        Route::get('/general', [AdminController::class, 'rapportGeneral'])->name('general');
        Route::get('/enseignants', [AdminController::class, 'rapportEnseignants'])->name('enseignants');
        Route::get('/classes', [AdminController::class, 'rapportClasses'])->name('classes');
        Route::get('/matieres', [AdminController::class, 'rapportMatieres'])->name('matieres');
    });

    // Routes utilitaires
    Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
    Route::get('/matieres-by-niveau/{niveau_id}', [AdminController::class, 'getMatieresByNiveau'])->name('matieres.by.niveau');
    Route::get('/classes-by-niveau/{niveau_id}', [AdminController::class, 'getClassesByNiveau'])->name('classes.by.niveau');
});

Route::middleware(['auth', 'roleMid:enseignant'])->group(function () {
    Route::get('/enseignant/dashboard', [EnseignantController::class, 'index'])->name("enseignant.dashboard");
});

Route::middleware(['auth', 'roleMid:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'index'])->name("etudiant.dashboard");
    Route::get('/etudiant/classes', [EtudiantController::class, 'classes'])->name('etudiant.classes');
    Route::get('/etudiant/matieres', [EtudiantController::class, 'matieres'])->name('etudiant.matieres');
    Route::get('/etudiant/emploi', [EtudiantController::class, 'emploiDuTemps'])->name('etudiant.emploi');
    Route::get('/etudiant/annee', [EtudiantController::class, 'anneeScolaire'])->name('etudiant.annee');
    Route::get('/etudiant/infos', [EtudiantController::class, 'infos'])->name('etudiant.infos');

});













Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Route::get('verify-email', EmailVerificationPromptController::class)
    //     ->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    //     ->middleware(['signed', 'throttle:6,1'])
    //     ->name('verification.verify');

    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //     ->middleware('throttle:6,1')
        // ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__.'/auth.php';







