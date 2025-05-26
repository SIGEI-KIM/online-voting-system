<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'elections' => Election::count(),
            'candidates' => Candidate::count(),
            'votes' => Vote::count(),
            'users' => User::count()
        ];

        $recentElections = Election::orderBy('created_at', 'desc')->limit(5)->get();
        $recentCandidates = Candidate::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentElections', 'recentCandidates'));
    }

    public function results()
{
    $elections = Election::with(['candidates' => function ($query) {
        $query->withCount('votes');
    }])
        ->orderBy('end_date', 'desc')
        ->get();


    return view('admin.results', compact('elections'));
}
}