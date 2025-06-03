<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CandidatePublicProfileController extends Controller
{
    /**
     * Show the form for creating a new candidate profile.
     *
     * @return \Illuminate\View\View|RedirectResponse
     */
    public function create(): \Illuminate\View\View|RedirectResponse
    {
        $user = Auth::user();
        $approvedApplication = $user->applications()->where('status', 'approved')->first();
        $pendingApplication = $user->applications()->where('status', 'pending')->first();
        $rejectedApplication = $user->applications()->where('status', 'rejected')->first();
        $hasApplied = $user->applications()->exists();

        if ($approvedApplication) {
            $elections = \App\Models\Election::all();
            return view('candidate.profile.create', compact('elections'));
        } elseif ($pendingApplication) {
            return redirect()->route('candidate.elections')->with('info', 'Your application is currently pending. You can create your profile once it\'s approved.');
        } elseif ($rejectedApplication) {
            return redirect()->route('candidate.elections')->with('error', 'Your application was rejected. You can apply for another election.');
        } elseif (!$hasApplied) {
            return redirect()->route('candidate.apply')->with('warning', 'You need to apply for an election before creating a profile.');
        } else {
            return redirect()->route('candidate.elections')->with('info', 'Your application status is being reviewed.');
        }
    }

    /**
     * Store a newly created candidate profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'election_id' => 'required|exists:elections,id',
            'position' => 'required|string|max:255',
            'bio' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $candidateData = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'election_id' => $request->election_id,
            'position' => $request->position,
            'bio' => $request->bio,
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidate-photos', 'public');
            $candidateData['photo'] = $photoPath;
        }

        Candidate::create($candidateData);

        return redirect()->route('candidate.dashboard')->with('success', 'Profile created successfully!');
    }

    /**
     * Show the form for editing the candidate profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit(): View
    {
        $candidate = Candidate::where('user_id', Auth::id())->first();

        return view('candidate.profile.edit', [
            'candidate' => $candidate,
        ]);
    }

    /**
     * Update the candidate profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'bio' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $candidateData = [
            'bio' => $request->bio,
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidate-photos', 'public');
            $candidateData['photo'] = $photoPath;
        }

        Candidate::updateOrCreate(
            ['user_id' => Auth::id()],
            $candidateData
        );

        return redirect()->route('candidate.dashboard')->with('success', 'Profile updated successfully!');
    }
}