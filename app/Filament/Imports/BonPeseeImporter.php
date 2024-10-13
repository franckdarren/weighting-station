<?php

namespace App\Filament\Imports;

use App\Models\BonPesee;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BonPeseeImporter extends Importer
{
    protected static ?string $model = BonPesee::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('numero')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('produits_transportes')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('provenance')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('destination')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('lineaire_parcouru')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('lineaire_restant')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('poids')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('surchage')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('vitesse')
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }

                    $state = preg_replace('/[^0-9.]/', '', $state);
                    $state = floatval($state);

                    return round($state, precision: 2);
                }),
            ImportColumn::make('poids_E1')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('poids_E2')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('poids_E3')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('poids_E4')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('poids_E5')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('poids_E6')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('vehicule_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('conducteur_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?BonPesee
    {
        // return BonPesee::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new BonPesee();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your bon pesee import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
