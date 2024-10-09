<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\FacturePesage;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\FacturePesageExporter;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Concerns\InteractsWithTable;

class ListFactures extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(FacturePesage::query())
            ->columns([
                TextColumn::make('numero')
                    ->searchable(),
                TextColumn::make('bonPesee.vehicule.plaque_immatriculation')
                    ->label("Matricule")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('bonPesee.conducteur')
                    ->label("Chauffeur")
                    ->formatStateUsing(fn($state) => $state->nom . ' ' . $state->prenoms),
                TextColumn::make('bonPesee.vehicule.entreprise')
                    ->label("Société")
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'Surcharge' => 'warning',
                        'Normal' => 'success',
                    }),
                TextColumn::make('bonPesee.numero')
                    ->label("Bon pesée")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('pv.numero')
                    ->label("PV")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('pv.montant_amendes')
                    ->label("Montant amendes")
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, '', ' ');
                    }),
                TextColumn::make('montant_total')
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, '', ' ');
                    }),
                TextColumn::make('statut')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'En attente de paiement' => 'warning',
                        'Payée' => 'success',
                    }),
                TextColumn::make('bonPesee.provenance')
                    ->label("Provenance")
                    ->searchable(),
                TextColumn::make('bonPesee.destination')
                    ->label("Destination")
                    ->searchable(),
                TextColumn::make('bonPesee.produits_transportes')
                    ->label("Produits transporté"),
                TextColumn::make('created_at')
                    ->searchable()
                    ->since()
                    ->dateTimeTooltip()
                    ->label("Date création")

            ])
            ->filters([
                //Filtrer les Factures avec surchage
                Filter::make('Avec surchage')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'Surcharge'))
                    ->toggle()
                    ->label('Avec surcharge (' . $this->getSurchargeWeightsCount() . ')'),

                //Filtrer les Factures sans surchage
                Filter::make('Sans surchage')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'Normal'))
                    ->toggle()
                    ->label('Sans surcharge (' . $this->getNoSurchargeWeightsCount() . ')'),

                //Filtrer les Factures payées
                Filter::make('Payées')
                    ->query(fn(Builder $query): Builder => $query->where('statut', 'Payée'))
                    ->toggle()
                    ->label('Payées (' . $this->getPaidFactureCount() . ')'),

                //Filtrer les Factures non payées
                Filter::make('Non payées')
                    ->query(fn(Builder $query): Builder => $query->where('statut', 'En attente de paiement'))
                    ->toggle()
                    ->label('Non payées (' . $this->getNoPaidFactureCount() . ')'),

            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                //Export
                ExportBulkAction::make()
                    ->exporter(FacturePesageExporter::class)
                    ->label('Exporter')
                    ->formats([
                        ExportFormat::Xlsx
                    ])
            ]);
    }

    // Méthode pour obtenir les Factures avec surcharges
    protected function getSurchargeWeightsCount(): int
    {
        return FacturePesage::where('type', 'Surcharge')->count();
    }

    // Méthode pour obtenir les Factures sans surcharges
    protected function getNoSurchargeWeightsCount(): int
    {
        return FacturePesage::where('type', 'Normal')->count();
    }

    // Méthode pour obtenir les Factures avec surcharges
    protected function getPaidFactureCount(): int
    {
        return FacturePesage::where('statut', 'Payée')->count();
    }

    // Méthode pour obtenir les Factures sans surcharges
    protected function getNoPaidFactureCount(): int
    {
        return FacturePesage::where('statut', 'En attente de paiement')->count();
    }

    public function render()
    {
        return view('livewire.list-factures');
    }
}
