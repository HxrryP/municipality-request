<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MarkUsersInactive extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'users:mark-inactive';

    /**
     * The console command description.
     */
    protected $description = 'Mark users as inactive if they have been idle for more than 5 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('status', true)
            ->where('last_active_at', '<', now()->subMinutes(5))
            ->update(['status' => false]);

        $this->info("Updated {$users} users to inactive.");
    }
}
