<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Laravel\Sanctum\PersonalAccessToken;

class DeleteOldTokens implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        PersonalAccessToken::where('expires_at', '<', now())->chunk(100, function ($records) {
            foreach ($records as $record) {
                $record->delete();
            }
        });
    }
}
