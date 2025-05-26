<?php

namespace App\Providers;

use App\Models\Election;
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

            // Log that the scheduler is running (for testing)
            $schedule->call(function () {
                Log::info('Scheduler running from AppServiceProvider at ' . now());
            })->everyMinute();

            // Check and update election status
            $schedule->call(function () {
                $now = Carbon::now();
                DB::table('elections')
                    ->where('status', 'ongoing')
                    ->where('end_date', '<=', $now)
                    ->update(['status' => 'completed']);
            })->everyMinute();
        });
    }
}