<?php

namespace App\Providers;

use App\Models\Admin; 
use App\Models\Election;
use App\Notifications\ElectionCompleted;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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

            // Log that the scheduler is running
            $schedule->call(function () {
                Log::info('Scheduler running from AppServiceProvider at ' . now());
            })->everyMinute();

            // Check and update election status and notify admins
            $schedule->call(function () {
                $now = Carbon::now('UTC');
                $completedElections = Election::where('status', 'ongoing')
                    ->where('end_date', '<=', $now)
                    ->get();

                foreach ($completedElections as $election) {
                    $election->update(['status' => 'completed']);
                    $admins = Admin::all(); // Or however you fetch your admins
                    foreach ($admins as $admin) {
                        $admin->notify(new ElectionCompleted($election));
                    }
                }
            })->everyMinute();
        });
    }
}