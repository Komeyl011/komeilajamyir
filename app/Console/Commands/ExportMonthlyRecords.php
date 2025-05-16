<?php

namespace App\Console\Commands;

use App\Exports\ChatHistoryExport;
use App\Models\ChatHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportMonthlyRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:monthly-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export records at the first of each month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting export process...');

        // Fetch records
        $records = ChatHistory::query()->whereBetween('created_at', [Carbon::now()->subMonth()->firstOfMonth(), Carbon::now()->subMonth()->lastOfMonth()])->get();

        Excel::store(new ChatHistoryExport($records), '/monthly_chat_export/' . now()->format('Y_m_d') . '.csv', 'local');

        $this->info('Export process finished.');
    }
}
