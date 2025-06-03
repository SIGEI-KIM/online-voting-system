<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail; 
use App\Mail\ApplicationStatusUpdated; 

class ApplicationController extends Controller
{
    /**
     * Display a listing of the applications.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $applications = Application::with(['candidate', 'election'])->latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Display the specified application.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\View\View
     */
    public function show(Application $application): View
    {
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\View\View
     */
    public function edit(Application $application): View
    {
        return view('admin.applications.edit', compact('application'));
    }

    /**
     * Update the specified application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Application $application): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Store the old status before updating
        $oldStatus = $application->status;
        $newStatus = $request->status;

        // Update the application status
        $application->update(['status' => $newStatus]);

        // Send email notification only if the status changed to approved or rejected
        // And if the candidate has an email address
        if (($newStatus === 'approved' || $newStatus === 'rejected') && $application->contact_email) {
            Mail::to($application->contact_email)->send(new ApplicationStatusUpdated($application));
        }

        return redirect()->route('admin.applications.index')->with('success', 'Application status updated successfully and candidate notified.');
    }
}