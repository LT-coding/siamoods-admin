<?php

namespace App\Console\Commands;

use App\Services\OldDataMigration\MigrateData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class CopyDataFromOldDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Copy Data From Old DB';

    private MigrateData $service;


    public function __construct(MigrateData $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            Artisan::call('migrate:fresh');
            $this->service->migrateData();
        } catch (\Exception $e) {
            Log::debug($e->getFile() . ' - ' . $e->getLine() . ' - ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
