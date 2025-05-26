<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Election;

class UpdateElectionStatus extends Command
{
    protected $signature = 'elections:update-status';

    protected $description = 'Updates the status of elections to completed if their end date has passed.';

    public function handle()
    {
        $now = Carbon::now();

        Election::where('end_date', '<', $now)
                ->where('status', '!=', 'completed')
                ->update(['status' => 'completed']);

        $this->info('Election statuses updated successfully.');
    }
}