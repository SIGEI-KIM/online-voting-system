<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoterProfileController; // Don't forget to use this controller
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (from auth.php)
require __DIR__.'/auth.php';

// Voter routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Main dashboard route (using DashboardController)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/elections/{election}/results', [VoteController::class, 'results'])->name('votes.results');

    // Voting routes
    Route::prefix('elections/{election}')->group(function () {
        Route::get('/vote', [VoteController::class, 'create'])->name('votes.create');
        Route::post('/vote', [VoteController::class, 'store'])->name('votes.store');
    });

    // Voter past results route
    Route::get('/past-results', [VoteController::class, 'results'])->name('voter.past_results');
    Route::get('/voter/past-election/{election}/results', [ElectionController::class, 'voterPastElectionResults'])->name('voter.past.election.results');

    // Voter profile routes
    Route::get('/voter/profile', [VoterProfileController::class, 'edit'])->name('voter.profile.edit');
    Route::put('/voter/profile', [VoterProfileController::class, 'update'])->name('voter.profile.update');
    Route::put('/voter/password', [VoterProfileController::class, 'updatePassword'])->name('voter.password.update');
    Route::delete('/voter/profile', [VoterProfileController::class, 'destroy'])->name('voter.profile.destroy');

    // Profile routes (for the main /profile path - now handled by ProfileController)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/results', [ElectionController::class, 'adminShowResults'])->name('admin.results');


    // Candidates Management
    Route::get('/candidates', [CandidateController::class, 'index'])->name('admin.candidates.index');
    Route::get('/candidates/create', [CandidateController::class, 'create'])->name('admin.candidates.create');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('admin.candidates.store');
    Route::get('/candidates/{candidate}', [CandidateController::class, 'show'])->name('admin.candidates.show');
    Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('admin.candidates.edit');
    Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('admin.candidates.update');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('admin.candidates.destroy');

    // Elections Management
    Route::resource('elections', ElectionController::class)->except(['show']);

    // Election Results
     Route::get('/elections/{election}/results', [ElectionController::class, 'results'])->name('admin.elections.results');

    //Route::get('/admin/results', [AdminController::class, 'results'])->name('admin.admin_results'); // Kept this route
});