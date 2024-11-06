<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\BonPeseeExporter;
use App\Models\Pv;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Concerns\InteractsWithTable;

class ListPv extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Pv::query())
            ->columns([
                TextColumn::make('numero')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('bonPesee.numero')
                    ->label('Bon pesée')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('bonPesee.plaque_immatriculation')
                    ->label('Immatriculation')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('bonPesee.entreprise')
                    ->label('Entreprise')
                    ->searchable(),

                TextColumn::make('bonPesee.produits_transportes')
                    ->label("Produit transportés")
                    ->searchable(),

                TextColumn::make('montant_amendes')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, '', ' ');
                    }),

                TextColumn::make('created_at')
                    ->searchable()
                    ->sortable()
                    ->dateTime('d-m-Y à H\hi')
                    ->dateTimeTooltip()
                    ->label("Date création")
            ])
            ->filters([])
            ->actions([
                // ...
            ])
            ->bulkActions([]);
    }

    public function render()
    {
        return view('livewire.list-pv');
    }
}
