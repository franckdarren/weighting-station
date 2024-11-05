<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Watcher\Watch;

class WatchExcelCommand extends Command
{
    protected $signature = 'excel:watch';
    protected $description = 'Watch Excel file for changes in real-time';

    public function handle()
    {
        $this->info('Watching Excel file for changes...');

        Watch::path(public_path('db_file'))
            ->onFileUpdated(function(string $path) {
                if (pathinfo($path, PATHINFO_EXTENSION) === 'xlsx') {
                    $this->info('Change detected! Waiting 30 seconds before sync...');
                    sleep(30);
                    $this->call('excel:sync');
                }
            })
            ->start();
    }
}
