<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\View\View;

class ResultController extends Controller
{
    /**
     * Display a listing of election results (ongoing or past) for the candidate, including percentages.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $elections = Election::whereHas('candidates', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->with(['candidates' => function ($q) {
            $q->withCount('votes')->orderByDesc('votes_count');
        }])
        ->where(function ($query) {
            $query->where('end_date', '>=', now()) // Ongoing elections
                  ->orWhere('end_date', '<', now()); // Past elections
        })
        ->get();

        // Calculate percentages
        foreach ($elections as $election) {
            $totalVotes = $election->candidates->sum('votes_count');

            if ($totalVotes > 0) {
                foreach ($election->candidates as $candidate) {
                    $candidate->percentage = round(($candidate->votes_count / $totalVotes) * 100, 2);
                }
            } else {
                foreach ($election->candidates as $candidate) {
                    $candidate->percentage = 0;
                }
            }
        }

        return view('candidate.results.index', compact('elections'));
    }
}