<?php

namespace App\Http\Controllers;

use App\Mail\VoteConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Election;
use App\Models\Vote;
use App\Models\Candidate; 

class VoteController extends Controller
{
    public function create(Election $election)
{
    // Prevent voting if the election isn't ongoing
    if ($election->status !== 'ongoing') {
        return redirect()->route('dashboard')->with('error', 'Voting period has ended');
    }

    // We no longer redirect if the user has already voted.
    // The check will happen in the store method.

    // Eager load the candidates for the election
    $election->load('candidates');

    return view('votes.create', compact('election'));
}

    public function store(Request $request, Election $election)
{
    $validated = $request->validate([
        'candidate_id' => [
            'required',
            Rule::exists('candidates', 'id')->where('election_id', $election->id)
        ]
    ]);

    // Check if the user has already voted
    if ($election->votes()->where('user_id', auth()->id())->exists()) {
        return response()->json(['success' => false, 'message' => 'You have already voted in this election.']);
    }

    $vote = Vote::create([
        'election_id' => $election->id,
        'candidate_id' => $validated['candidate_id'],
        'user_id' => auth()->id(),
        'voted_at' => now()
    ]);

    // Retrieve the authenticated user
    $voter = auth()->user();
    $candidate = Candidate::findOrFail($validated['candidate_id']);

    // Send the confirmation email
    Mail::to($voter->email)->send(new VoteConfirmation($election->title, $candidate->name));

    return response()->json(['success' => true, 'message' => 'Your vote has been recorded!']);
}

    public function results()
{
    $pastElections = Election::with(['candidates' => function ($query) {
        $query->withCount('votes');
    }, 'votes'])
        ->where('status', 'past')
        ->get();

    return view('votes.past-results', compact('pastElections'));
}
}