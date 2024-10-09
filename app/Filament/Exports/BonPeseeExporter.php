<?php

namespace App\Filament\Exports;

use App\Models\BonPesee;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

final class BonPeseeExporter extends Exporter
{
    protected static ?string $model = BonPesee::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('numero'),
            ExportColumn::make('produits_transportes'),
            ExportColumn::make('provenance'),
            ExportColumn::make('destination'),
            ExportColumn::make('lineaire_parcouru'),
            ExportColumn::make('lineaire_restant'),
            ExportColumn::make('poids'),
            ExportColumn::make('surchage'),
            ExportColumn::make('vitesse'),
            ExportColumn::make('vehicule_id'),
            ExportColumn::make('conducteur_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Votre exportation des pesages est terminée et ' . number_format($export->successful_rows) . ' ' . str('lignes')->plural($export->successful_rows) . ' ont été exportées.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
