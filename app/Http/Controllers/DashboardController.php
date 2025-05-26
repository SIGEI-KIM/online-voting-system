<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $activeElections = Election::where('status', 'ongoing')->get();
        $completedElections = Election::where('status', 'completed')->get();
        $upcomingElections = Election::where('status', 'upcoming')->get();

        return view('dashboard', [
            'activeElections' => $activeElections,
            'completedElections' => $completedElections,
            'upcomingElections' => $upcomingElections,
        ]);
    }
}