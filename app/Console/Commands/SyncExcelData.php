<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\weightingData;

// Import the Data
class SyncExcelData extends Command
{
    protected $signature = 'excel:sync';
    protected $description = 'Synchronize Excel data with database';

    public function handle()
    {
        $excelFile = database_path('exemplaire_bd.xlsx');
        $lastModified = filemtime($excelFile);

        if ($lastModified > cache('last_excel_sync', 0)) {
            $spreadsheet = IOFactory::load($excelFile);
            $worksheet = $spreadsheet->getActiveSheet();

            $rows = $worksheet->toArray();
            array_shift($rows);

            foreach ($rows as $rowData) {
                // $cellIterator = $row->getCellIterator();
                // $cellIterator->setIterateOnlyExistingCells(false);

                // $rowData = [];
                // foreach ($cellIterator as $cell) {
                //     $rowData[] = $cell->getValue();
                // }

                weightingData::updateOrCreate(
                    ['id' => $rowData[0]],
                    [
                        'weighing1ID' => $rowData[1],
                        'vehicleID' => $rowData[2],
                        'plateFront' => $rowData[3],
                        'plateBack' => $rowData[4],
                        'vehicleType' => $rowData[5],
                        'vehicleTypeOrdering' => $rowData[6],
                        'date' => $this->parseCustomTime($rowData[7]),
                        'totalWeight' => (float)$rowData[8],
                        'overload' => (float)$rowData[9],
                        'companyID' => $rowData[10],
                        'companyName' => $rowData[11],
                        'materialID' => $rowData[12],
                        'materialName' => $rowData[13],
                        'scaleID' => $rowData[14],
                        'userID' => $rowData[15],
                        'sync' => (bool)$rowData[16],
                        'scaleType' => (int)$rowData[17],
                        'isDeleted' => (bool)$rowData[18],
                        'weighingDimensionId' => $rowData[19],
                        'weighingNo' => (int)$rowData[20],
                        'unetSent' => (bool)$rowData[21],
                        'totalWeightLimit' => (float)$rowData[22],
                        'totalWeightLimitTolerance' => (float)$rowData[23],
                        'emptyWeight' => (float)$rowData[24],
                        'speed' => (float)$rowData[25],
                        'isUnetSent' => (bool)$rowData[26],
                    ]
                );
            }

            cache(['last_excel_sync' => time()]);
            $this->info('Excel data synchronized successfully.');
        } else {
            $this->info('No changes detected in Excel file.');
        }
    }

    private function parseCustomTime($timeString)
    {
        $parts = explode(':', $timeString);
        $seconds = 0;
        if (count($parts) == 2) {
            $seconds = $parts[0] * 60 + floatval($parts[1]);
        } elseif (count($parts) == 3) {
            $seconds = $parts[0] * 3600 + $parts[1] * 60 + floatval($parts[2]);
        }
        return gmdate('H:i:s', (int)$seconds);
    }
}
