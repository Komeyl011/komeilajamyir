<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteOldTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:delete-old-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old access tokens from the personal access tokens table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
