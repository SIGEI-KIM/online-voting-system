<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View; 

class UserController extends Controller
{
    public function index()
    {
        $voters = User::where('role', 'voter')
                      ->orderBy('created_at')
                      ->take(10)
                      ->get()
                      ->map(function ($user) {
                          $user->has_voted = $user->votes()->exists();
                          return $user;
                      });

        $candidates = User::whereHas('applications')
                          ->get()
                          ->map(function ($user) {
                              $latestApplication = $user->applications()->latest()->first();
                              $user->application_status = $latestApplication ? $latestApplication->status : 'N/A';
                              return $user;
                          })
                          ->sortBy('created_at')
                          ->take(10)
                          ->values();

        return view('admin.users.index', compact('voters', 'candidates'));
    }

    public function showCandidatesWithApplications(): View
{
    $applicationsByElection = Application::with(['candidate', 'election'])
        ->orderBy('election_id')
        ->get()
        ->groupBy('election.title');

    return view('candidate.index', compact('applicationsByElection'));
}
}