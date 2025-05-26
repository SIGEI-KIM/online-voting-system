<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Carbon;

class ElectionController extends Controller
{
    public function voterPastElectionResults(Election $election)
{
    // Eager load candidates with their vote counts
    $election->load(['candidates' => function ($query) {
        $query->withCount('votes');
    }]);

    // Calculate the total votes for the election
    $totalVotes = $election->candidates->sum('votes_count');

    // Find the winner
    $winner = $election->candidates->sortByDesc('votes_count')->first();

    return view('votes.past-election-results', compact('election', 'totalVotes', 'winner'));
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $elections = Election::all();
        return view('admin.elections.index', compact('elections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.elections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        // Create a new Election model instance
        $election = new Election();
        $election->title = $request->title;
        $election->description = $request->description;
        $election->start_date = $request->start_date;
        $election->end_date = $request->end_date;
        $election->status = $request->status;
        $election->save();

        // Redirect to the admin dashboard with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Election created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Election $election)
    {
        return view('admin.elections.show', compact('election'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Election $election)
    {
        return view('admin.elections.edit', compact('election'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Election $election)
{
    // Validate the incoming request data
    $request->validate([
        'title' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'status' => 'required|in:pending,ongoing,completed',
    ]);

    // Update the Election model instance
    $election->title = $request->title;
    $election->start_date = $request->start_date;
    $election->end_date = $request->end_date;
    $election->status = $request->status;
    $election->save();

    // Redirect to the elections index page with a success message
    return redirect()->route('elections.index')->with('success', __('Election updated successfully.'));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Election $election)
{
    $election->delete();
    return redirect()->route('elections.index')->with('success', __('Election deleted successfully.'));
}

    /**
     * Display ongoing and past election results for admin.
     */
    public function adminShowResults()
{
    // Fetch ongoing elections with candidates and their vote counts
    $ongoingElections = Election::with(['candidates' => function ($query) {
        $query->withCount('votes');
    }])
        ->where('status', 'ongoing')
        ->get();

    // Fetch past elections (those marked as 'completed') with candidates and their vote counts
    $pastElections = Election::with(['candidates' => function ($query) {
        $query->withCount('votes');
    }])
        ->where('status', 'completed') // Assuming you're using 'completed'
        ->get();

    // Get the total number of ongoing elections
    $ongoingElectionCount = Election::where('status', 'ongoing')->count();

    // Get the total votes cast today
    $today = Carbon::today();
    $votesToday = Vote::whereDate('created_at', $today)->count();

    return view('admin.results', compact('ongoingElections', 'pastElections', 'ongoingElectionCount', 'votesToday'));
}
}