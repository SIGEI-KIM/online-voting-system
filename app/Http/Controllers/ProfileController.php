<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;

use App\Models\Candidate;

class ProfileController extends Controller 
{
    /**
     * Display the user's general profile settings form, redirecting based on role.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->is_admin) {
            return view('profile.edit', [
                'user' => $user,
            ]);
        } elseif ($user->role === 'voter') {
            return redirect()->route('voter.profile.edit'); 
        } elseif ($user->role === 'candidate') {
            
            return redirect()->route('candidate.profile.edit'); 
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if ($user->is_admin) {
            return Redirect::route('admin.dashboard')->with('success', 'Profile updated successfully!');
        } elseif ($user->role === 'voter') {
            return Redirect::route('voter.dashboard')->with('success', 'Profile updated successfully!');
        } elseif ($user->role === 'candidate') {
            return Redirect::route('candidate.dashboard')->with('success', 'Profile updated successfully!');
        } else {
            return Redirect::route('dashboard')->with('success', 'Profile updated successfully!');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}