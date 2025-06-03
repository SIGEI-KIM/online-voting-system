<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\Election;         
use App\Models\User;   
class CandidateDashboardController extends Controller
{
    /**
     * Display the candidate's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    // Get the currently authenticated user
    $user = Auth::user();

    // Fetch the candidate's profile
    $candidateProfile = Candidate::where('user_id', $user->id)->first();

    // Fetch the applications of the user and eager load the related elections
    $applications = $user->applications()->with('election')->latest()->get();

    // Extract the applied elections from the applications
    $appliedElections = $applications->pluck('election');

    // Return the view with the fetched data
    return view('candidate.dashboard', [
        'profile' => $candidateProfile,
        'applications' => $applications,
    ]);
}
}