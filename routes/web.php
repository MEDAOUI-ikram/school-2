<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClasseController;
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
    Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestion des enseignants
    Route::prefix('enseignants')->name('enseignants.')->group(function () {
        Route::get('/', [AdminController::class, 'indexEnseignants'])->name('index');
        Route::get('/create', [AdminController::class, 'createEnseignant'])->name('create');
        Route::post('/', [AdminController::class, 'storeEnseignant'])->name('store');
        Route::get('/{enseignant}', [AdminController::class, 'showEnseignant'])->name('show');
        Route::get('/{enseignant}/edit', [AdminController::class, 'editEnseignant'])->name('edit');
        Route::put('/{enseignant}', [AdminController::class, 'updateEnseignant'])->name('update');
        Route::delete('/{enseignant}', [AdminController::class, 'destroyEnseignant'])->name('destroy');
    });

    // Gestion des étudiants
    Route::prefix('etudiants')->name('etudiants.')->group(function () {
        Route::get('/', [AdminController::class, 'indexEtudiants'])->name('index');
        Route::get('/create', [AdminController::class, 'createEtudiant'])->name('create');
        Route::post('/', [AdminController::class, 'storeEtudiant'])->name('store');
        Route::get('/{etudiant}', [AdminController::class, 'showEtudiant'])->name('show');
        Route::get('/{etudiant}/edit', [AdminController::class, 'editEtudiant'])->name('edit');
        Route::put('/{etudiant}', [AdminController::class, 'updateEtudiant'])->name('update');
        Route::delete('/{etudiant}', [AdminController::class, 'destroyEtudiant'])->name('destroy');
    });

    // Gestion des matières
    Route::prefix('matieres')->name('matieres.')->group(function () {
        Route::get('/', [AdminController::class, 'indexMatieres'])->name('index');
        Route::get('/create', [AdminController::class, 'createMatiere'])->name('create');
        Route::post('/', [AdminController::class, 'storeMatiere'])->name('store');
        Route::get('/{matiere}', [AdminController::class, 'showMatiere'])->name('show');
        Route::get('/{matiere}/edit', [AdminController::class, 'editMatiere'])->name('edit');
        Route::put('/{matiere}', [AdminController::class, 'updateMatiere'])->name('update');
        Route::delete('/{matiere}', [AdminController::class, 'destroyMatiere'])->name('destroy');
    });

    // Gestion des classes
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [AdminController::class, 'indexClasses'])->name('index');
        Route::get('/create', [AdminController::class, 'createClasse'])->name('create');
        Route::post('/', [AdminController::class, 'storeClasse'])->name('store');
        Route::get('/{classe}', [AdminController::class, 'showClasse'])->name('show');
        Route::get('/{classe}/edit', [AdminController::class, 'editClasse'])->name('edit');
        Route::put('/{classe}', [AdminController::class, 'updateClasse'])->name('update');
        Route::delete('/{classe}', [AdminController::class, 'destroyClasse'])->name('destroy');
    });

    // Gestion des affectations
    Route::prefix('affectations')->name('affectations.')->group(function () {
        Route::get('/', [AdminController::class, 'indexAffectations'])->name('index');
        Route::get('/create', [AdminController::class, 'createAffectation'])->name('create');
        Route::post('/', [AdminController::class, 'storeAffectation'])->name('store');
        Route::delete('/{affectation}', [AdminController::class, 'destroyAffectation'])->name('destroy');
    });

    // Gestion des années scolaires
    Route::prefix('annees')->name('annees.')->group(function () {
        Route::get('/', [AdminController::class, 'indexAnnees'])->name('index');
        Route::get('/create', [AdminController::class, 'createAnnee'])->name('create');
        Route::get('/{annee}', [AdminController::class, 'showAnnee'])->name('show');
        Route::post('/', [AdminController::class, 'storeAnnee'])->name('store');
        Route::get('/{annee}/edit', [AdminController::class, 'editAnnee'])->name('edit');
        Route::put('/{annee}', [AdminController::class, 'updateAnnee'])->name('update');
        Route::delete('/{annee}', [AdminController::class, 'destroyAnnee'])->name('destroy');
    });

    // Rapports
    Route::prefix('rapports')->name('rapports.')->group(function () {
        Route::get('/', [AdminController::class, 'rapports'])->name('index');
        Route::get('/general', [AdminController::class, 'rapportGeneral'])->name('general');
        Route::get('/enseignants', [AdminController::class, 'rapportEnseignants'])->name('enseignants');
        Route::get('/classes', [AdminController::class, 'rapportClasses'])->name('classes');
        Route::get('/matieres', [AdminController::class, 'rapportMatieres'])->name('matieres');
    });

    // Routes utilitaires
    Route::get('/search', [AdminController::class, 'search'])->name('search');
    Route::get('/matieres-by-niveau/{niveau_id}', [AdminController::class, 'getMatieresByNiveau'])->name('matieres.by.niveau');
    Route::get('/classes-by-niveau/{niveau_id}', [AdminController::class, 'getClassesByNiveau'])->name('classes.by.niveau');
});
});

Route::middleware(['auth', 'roleMid:enseignant'])->group(function () {
    Route::get('/enseignant/dashboard', [EnseignantController::class, 'index'])->name("enseignant.dashboard");
    // Routes pour l'enseignant
Route::prefix('enseignant')->name('enseignant.')->group(function () {
    Route::get('/dashboard', [EnseignantController::class, 'index'])->name('dashboard');
    Route::get('/classes', [EnseignantController::class, 'classes'])->name('classes');
    Route::get('/etudiants', [EnseignantController::class, 'etudiants'])->name('etudiants');
    Route::get('/emploi-du-temps', [EnseignantController::class, 'emploiDuTemps'])->name('emploi-du-temps');
    Route::get('/notes', [EnseignantController::class, 'notes'])->name('notes');
    Route::get('/infos', [EnseignantController::class, 'infos'])->name('infos');
    Route::post('/infos', [EnseignantController::class, 'updateInfos'])->name('updateInfos');
});
});

Route::middleware(['auth', 'roleMid:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'index'])->name("etudiant.dashboard");
    Route::get('/etudiant/classes', [EtudiantController::class, 'classes'])->name('etudiant.classes');
    Route::get('/etudiant/matieres', [EtudiantController::class, 'matieres'])->name('etudiant.matieres');
    Route::get('/etudiant/emploi', [EtudiantController::class, 'emploiDuTemps'])->name('etudiant.emploi');
    Route::get('/etudiant/annee', [EtudiantController::class, 'anneeScolaire'])->name('etudiant.annee');
    Route::get('/etudiant/infos', [EtudiantController::class, 'infos'])->name('etudiant.infos');

});




// routes/web.php
use App\Http\Controllers\Etudiant\MatiereController;

Route::middleware(['auth'])->group(function () {
    Route::get('/etudiant/matieres', [MatiereController::class, 'index'])->name('etudiant.matieres');
});






// Routes pour l'étudiant
Route::prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/dashboard', [EtudiantController::class, 'index'])->name('dashboard');
    Route::get('/matieres', [EtudiantController::class, 'matieres'])->name('matieres');
    Route::get('/infos', [EtudiantController::class, 'infos'])->name('infos');
    Route::post('/infos', [EtudiantController::class, 'updateInfos'])->name('updateInfos');
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







