<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Election;
use App\Notifications\ElectionCompleted;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Already present, but good to note
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            // Log that the scheduler is running (for debugging/monitoring)
            $schedule->call(function () {
                Log::info('Scheduler running from AppServiceProvider at ' . now());
            })->everyMinute();

            // Task 1: Check and update election status from 'upcoming' to 'ongoing'
            $schedule->call(function () {
                $now = Carbon::now('UTC'); // Use UTC for consistency with database timestamps

                $upcomingElections = Election::where('status', 'upcoming')
                    ->where('start_date', '<=', $now)
                    ->get();

                foreach ($upcomingElections as $election) {
                    $election->update(['status' => 'ongoing']);
                    Log::info("Election '{$election->title}' status updated to 'ongoing'.");
                }
            })->everyMinute(); // check every minute

            // Task 2: Check and update election status from 'ongoing' to 'completed' and notify admins
            $schedule->call(function () {
                $now = Carbon::now('UTC'); // Use UTC for consistency with database timestamps
                $completedElections = Election::where('status', 'ongoing')
                    ->where('end_date', '<=', $now)
                    ->get();

                foreach ($completedElections as $election) {
                    $election->update(['status' => 'completed']);
                    Log::info("Election '{$election->title}' status updated to 'completed'.");

                    $admins = Admin::all();
                    foreach ($admins as $admin) {
                        $admin->notify(new ElectionCompleted($election));
                        Log::info("Admin '{$admin->email}' notified about completed election '{$election->title}'.");
                    }
                }
            })->everyMinute(); // check every minute
        });
    }
}