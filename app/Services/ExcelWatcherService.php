<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Events\ExcelFileChanged;

class ExcelWatcherService
{
    public function watchExcelFile()
    {
        $excelFile = database_path('../public/db_file/bon-pesees.xlsx');
        $lastModified = filemtime($excelFile);
        $lastKnownModified = cache('last_excel_modified');

        if ($lastModified !== $lastKnownModified) {
            $this->handleFileChange();
            cache(['last_excel_modified' => $lastModified]);
        }
    }

    private function handleFileChange()
    {
        \Artisan::call('excel:sync');
        activity()
            ->withProperties(['time' => now()])
            ->log('Excel file synchronized automatically');
    }
}
