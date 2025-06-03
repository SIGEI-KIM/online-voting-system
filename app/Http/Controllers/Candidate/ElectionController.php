<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function index()
    {
        $appliedElections = auth()->user()->applications()->with('election')->latest()->get();
        return view('candidate.elections.index', compact('appliedElections'));
    }

    public function showApplyForm()
    {
        return redirect()->route('candidate.apply.choose');
    }

    public function showApplicationForm(Request $request)
    {
        $request->validate([
            'election_id' => 'required|exists:elections,id',
        ]);
        $election = Election::findOrFail($request->election_id);
        return view('candidate.elections.apply', compact('election'));
    }

    public function chooseElection()
    {
        $hasActiveApplication = \App\Models\Application::where('candidate_id', auth()->id())
            ->whereHas('election', function ($query) {
                $query->whereIn('status', ['upcoming', 'ongoing']);
            })
            ->exists();

        $elections = Election::where('status', 'upcoming')->get();
        return view('candidate.elections.choose', compact('elections', 'hasActiveApplication'));
    }

    public function submitApplication(Request $request, Election $election)
    {
        // Validate the incoming request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => [
                'required',
                'string',
                'regex:/^\+\d+$/', 
                'min:10',          
                'max:15',          
            ],
            'passport_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:4096', // Max 4MB
            'terms' => 'required|accepted',
        ],
        [
            'full_name.required' => 'The full name field is required.',
            'full_name.max' => 'The full name cannot be longer than :max characters.',
            'id_number.required' => 'The ID number field is required.',
            'id_number.max' => 'The ID number cannot be longer than :max characters.',
            'contact_email.required' => 'The contact email field is required.',
            'contact_email.email' => 'Please enter a valid email address.',
            'contact_email.max' => 'The contact email cannot be longer than :max characters.',
            'contact_phone.required' => 'The contact phone number is required.',
            'contact_phone.regex' => 'The contact phone number must start with a country code (+ followed by digits).',
            'contact_phone.min' => 'The contact phone number must be at least :min digits long.',
            'contact_phone.max' => 'The contact phone number must not be longer than :max digits.',
            'passport_photo.required' => 'Please upload your passport photo.',
            'passport_photo.image' => 'The uploaded file must be an image.',
            'passport_photo.mimes' => 'The passport photo must be a JPEG, PNG, or JPG file.',
            'passport_photo.max' => 'The passport photo must not be larger than 2MB.',
            'document.required' => 'Please upload the supporting document.',
            'document.mimes' => 'The supporting document must be a PDF, DOC, or DOCX file.',
            'document.max' => 'The supporting document must not be larger than 4MB.',
            'terms.required' => 'You must accept the terms and conditions.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ]);

        // Check if the candidate has already applied for an ongoing or upcoming election
        $existingApplication = \App\Models\Application::where('candidate_id', auth()->id())
            ->whereHas('election', function ($query) {
                $query->whereIn('status', ['upcoming', 'ongoing']);
            })
            ->first();

        if ($existingApplication) {
            return back()->with('warning', 'You have already applied for an ongoing or upcoming election. You cannot apply for another one at this time.');
        }

        // Check if the candidate has already applied for this specific election
        if ($election->applications()->where('candidate_id', auth()->id())->exists()) {
            return back()->with('warning', 'You have already applied for this election.');
        }

        $applicationData = [
            'candidate_id' => auth()->id(),
            'election_id' => $election->id,
            'applied_at' => now(),
            'full_name' => $request->full_name,
            'id_number' => $request->id_number,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'passport_photo_path' => null,
            'document_path' => null,
            'status' => 'pending',
        ];

        // Handle passport photo upload
        if ($request->hasFile('passport_photo')) {
            $passportPhotoPath = $request->file('passport_photo')->store('passports', 'public');
            $applicationData['passport_photo_path'] = $passportPhotoPath;
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
            $applicationData['document_path'] = $documentPath;
        }

        // Create the application
        $election->applications()->create($applicationData);

        return redirect()->route('candidate.elections')->with('success', 'Your application has been submitted and is awaiting admin review.');
    }
}