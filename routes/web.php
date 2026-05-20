<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EntretienController;
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
    Route::get('/candidatures',[CandidatureController::class, 'index'])->name('candidatures.index');
    Route::get('/candidatures/create',[CandidatureController::class, 'create'])->name('candidatures.create');
    Route::post('/candidatures',[CandidatureController::class, 'store'])->name('candidatures.store');
    Route::get('/candidatures/{candidature}',[CandidatureController::class, 'show'])->name('candidatures.show');
    Route::get('/candidatures/{candidature}/edit',[CandidatureController::class, 'edit'])->name('candidatures.edit');
    Route::put('/candidatures/{candidature}',[CandidatureController::class, 'update'])->name('candidatures.update');
    Route::delete('/candidatures/{candidature}',[CandidatureController::class, 'destroy'])->name('candidatures.destroy');
    Route::get('/archives',[CandidatureController::class, 'archives'])->name('candidatures.archives');
    Route::patch('/candidatures/{id}/restore',[CandidatureController::class, 'restore'])->name('candidatures.restore');
    Route::post('/candidatures/{candidature}/entretiens',[EntretienController::class,'store'])->name('entretiens.store');
    Route::get('/entretiens/{entretien}/edit',[EntretienController::class, 'edit'])->name('entretiens.edit');
    Route::put('/entretiens/{entretien}',[EntretienController::class, 'update'])->name('entretiens.update');
    Route::delete('/entretiens/{entretien}',[EntretienController::class, 'destroy'])->name('entretiens.destroy');
    Route::get('/documents/{document}/download',[DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}',[DocumentController::class, 'destroy'])->name('documents.destroy');


});

require __DIR__.'/auth.php';