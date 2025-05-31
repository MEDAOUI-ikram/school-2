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
     // Routes utilitaires
     Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
   // Routes Export/Import/Bulk
    Route::post('/import-users', [AdminController::class, 'importUsers'])->name('admin.import.users');
    Route::get('/export-users', [AdminController::class, 'exportUsers'])->name('admin.export.users');
    Route::get('/download-template', [AdminController::class, 'downloadTemplate'])->name('admin.download.template');
    Route::post('/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admin.bulk.delete');
    Route::post('/bulk-action', [AdminController::class, 'bulkAction'])->name('admin.bulk.action');
    Route::post('/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggle.status');


});

Route::middleware(['auth', 'roleMid:enseignant'])->group(function () {
    Route::get('/enseignant/dashboard', [EnseignantController::class, 'index'])->name("enseignant.dashboard");
});

Route::middleware(['auth', 'roleMid:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'index'])->name("etudiant.dashboard");
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







