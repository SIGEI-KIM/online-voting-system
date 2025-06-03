<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View|RedirectResponse
    // {
    //     if ($request->user()->is_admin) {
    //         return view('profile.edit', [
    //             'user' => $request->user(),
    //         ]);
    //     } else {
    //         return redirect()->route('voter.profile.edit');
    //     }
    // }

    public function edit(Request $request): View|RedirectResponse
{
    if ($request->user()->is_admin) {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    } elseif ($request->user()->role === 'voter') {
        return redirect()->route('voter.profile.edit');
    } elseif ($request->user()->role === 'candidate') {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    } else {
        return redirect()->route('dashboard');
    }
}


    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     if ($request->user()->is_admin) {
    //         return Redirect::route('admin.dashboard')->with('success', 'Profile updated successfully!');
    //     } else {
    //         return Redirect::route('voter.profile.edit')->with('success', 'Profile updated successfully!');
    //     }
    // }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if ($request->user()->is_admin) {
            return Redirect::route('admin.dashboard')->with('success', 'Profile updated successfully!');
        } elseif ($request->user()->role === 'voter') {
            return Redirect::route('voter.dashboard')->with('success', 'Profile updated successfully!');
        } elseif ($request->user()->role === 'candidate') {
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