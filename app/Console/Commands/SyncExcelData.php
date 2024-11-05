<?php

namespace App\Console\Commands;

use App\Models\BonPesee;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SyncExcelData extends Command
{
    protected $signature = 'excel:sync';
    protected $description = 'Synchronize Excel data with database';

    public function handle()
    {
        try {
            $excelFile = public_path('db_file/bon-pesees.xlsx');
            
            if (!file_exists($excelFile)) {
                $this->error('Excel file not found at: ' . $excelFile);
                return;
            }

            $spreadsheet = IOFactory::load($excelFile);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows); // Remove header row

            $count = 0;
            foreach ($rows as $rowData) {
                if (empty($rowData[0])) continue; // Skip empty rows

                BonPesee::updateOrCreate(
                    ['numero' => $rowData[1]], // Use numero as unique identifier
                    [
                        'vitesse' => $rowData[2],
                        'plaque_immatriculation' => $rowData[3],
                        'entreprise' => $rowData[4],
                        'produits_transportes' => $rowData[5],
                        'description' => $rowData[6],
                        'poids' => $rowData[7],
                        'surchage' => $rowData[8],
                        'poids_E1' => (float)$rowData[9],
                        'poids_E2' => (float)$rowData[10],
                        'poids_E3' => (float)$rowData[11],
                        'poids_E4' => (float)$rowData[12],
                        'poids_E5' => (float)$rowData[13],
                        'poids_E6' => (float)$rowData[14],
                        'poids_E7' => (float)$rowData[15],
                        'created_at' => $rowData[16],
                        'updated_at' => now(),
                    ]
                );
                $count++;
            }

            $this->info("Synchronized $count records successfully.");
            
        } catch (\Exception $e) {
            $this->error('Error during synchronization: ' . $e->getMessage());
        }
    }
}
