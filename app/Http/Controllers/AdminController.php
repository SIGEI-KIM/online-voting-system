<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard()
    {
        $now = now();

        $stats = [
            'elections' => Election::count(),
            'ongoingElections' => Election::where('start_date', '<=', $now)
                                       ->where('end_date', '>=', $now)
                                       ->count(),
            'candidates' => Candidate::count(),
            'votes' => Vote::count(),
            'users' => User::where('role', 'voter')->count(),
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
public function showVoteDetails(): View
{
    $votes = Vote::with(['user', 'candidate', 'election'])->latest()->paginate(15);
    return view('admin.votes.index', compact('votes'));
}
}