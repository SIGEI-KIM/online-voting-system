<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Candidate\CandidateDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Candidate\CandidatePublicProfileController;
use App\Http\Controllers\VoterProfileController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Voter routes
Route::middleware(['auth', 'verified', 'role:voter'])->prefix('voter')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('voter.dashboard');
    Route::get('/elections/{election}/results', [VoteController::class, 'results'])->name('votes.results');
    Route::prefix('elections/{election}')->group(function () {
        Route::get('/vote', [VoteController::class, 'create'])->name('votes.create');
        Route::post('/vote', [VoteController::class, 'store'])->name('votes.store');
    });

    Route::get('/past-results', [VoteController::class, 'results'])->name('voter.past_results');
    Route::get('/voter/past-election/{election}/results', [ElectionController::class, 'voterPastElectionResults'])->name('voter.past.election.results');
    Route::get('/voter/profile', [VoterProfileController::class, 'edit'])->name('voter.profile.edit');
    Route::put('/voter/profile', [VoterProfileController::class, 'update'])->name('voter.profile.update');
    Route::put('/voter/password', [VoterProfileController::class, 'updatePassword'])->name('voter.password.update');
    Route::delete('/voter/profile', [VoterProfileController::class, 'destroy'])->name('voter.profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:candidate'])->prefix('candidate')->group(function () {
    Route::get('/dashboard', [CandidateDashboardController::class, 'index'])->name('candidate.dashboard');
    Route::get('/elections', [\App\Http\Controllers\Candidate\ElectionController::class, 'index'])->name('candidate.elections');

    Route::get('/profile/create', [CandidatePublicProfileController::class, 'create'])->name('candidate.profile.create');
    Route::post('/profile', [CandidatePublicProfileController::class, 'store'])->name('candidate.profile.store');
    Route::get('/profile/edit', [CandidatePublicProfileController::class, 'edit'])->name('candidate.profile.edit');
    Route::put('/profile', [CandidatePublicProfileController::class, 'update'])->name('candidate.profile.update');

    Route::get('/results', [\App\Http\Controllers\Candidate\ResultController::class, 'index'])->name('candidate.results');
    Route::get('/apply-election', [\App\Http\Controllers\Candidate\ElectionController::class, 'showApplyForm'])->name('candidate.apply');
    Route::post('/apply-election/{election}', [\App\Http\Controllers\Candidate\ElectionController::class, 'storeApplication'])->name('candidate.apply.store');
    Route::get('/apply-election/form', [\App\Http\Controllers\Candidate\ElectionController::class, 'showApplicationForm'])->name('candidate.apply.get-form');

    Route::get('/apply-election/choose', [\App\Http\Controllers\Candidate\ElectionController::class, 'chooseElection'])->name('candidate.apply.choose');
    Route::post('/apply-election/{election}/submit', [\App\Http\Controllers\Candidate\ElectionController::class, 'submitApplication'])->name('candidate.apply.submit');
    
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/results', [ElectionController::class, 'adminShowResults'])->name('admin.results');
    Route::resource('elections', ElectionController::class)->except(['show']);
    Route::get('/elections/{election}/results', [ElectionController::class, 'results'])->name('admin.elections.results');

    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/candidates', [UserController::class, 'showCandidatesWithApplications'])->name('admin.candidates.index');

    Route::get('/votes', [AdminController::class, 'showVoteDetails'])->name('admin.votes.index');

    // Application routes
    Route::get('/applications', [ApplicationController::class, 'index'])->name('admin.applications.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('admin.applications.show');
    Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('admin.applications.edit');
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('admin.applications.update');
});

// Generic profile routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});