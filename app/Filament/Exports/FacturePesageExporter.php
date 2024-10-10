<?php

namespace App\Filament\Exports;

use App\Models\FacturePesage;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class FacturePesageExporter extends Exporter
{
    protected static ?string $model = FacturePesage::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('numero'),
            ExportColumn::make('type'),
            ExportColumn::make('forfait_usage'),
            ExportColumn::make('montant_total'),
            ExportColumn::make('statut'),
            ExportColumn::make('bon_pesee_id'),
            ExportColumn::make('pv_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Votre exportation des factures est terminée et ' . number_format($export->successful_rows) . ' ' . str('lignes')->plural($export->successful_rows) . ' ont été exportées.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
