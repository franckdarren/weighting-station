<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BonPesee;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ListPesages extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(BonPesee::query())
            ->columns([
                TextColumn::make('numero')->searchable()->sortable(),
                TextColumn::make('produits_transportes')->searchable(),
                TextColumn::make('provenance')->searchable(),
                TextColumn::make('destination')->searchable(),
                TextColumn::make('poids')
                    ->label('Poids (en T)')
                    ->formatStateUsing(fn($state) => number_format($state / 1000, 2)),
                TextColumn::make('surchage')
                    ->label('Surchage (en T)')
                    ->formatStateUsing(fn($state) => $state == 0 ? '' : number_format($state / 1000, 2))
                    ->badge(fn($state) => $state > 0)
                    ->color(fn($state) => $state > 0 ? 'danger' : ''),
                TextColumn::make('vitesse')
                    ->label('Vitesse (en Km/h)'),

                TextColumn::make('vehicule.plaque_immatriculation')
                    ->label("Immatriculation")->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('vehicule.carte_grise')
                    ->label("Carte grise")->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('vehicule.statut')
                    ->label("Statut")->searchable()
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'Entreprise' => 'gray',
                        'Particulier' => 'success',
                        default => 'secondary',
                    }),
                TextColumn::make('vehicule.nom_proprietaire')
                    ->label("Propriétaire")->searchable(),

                TextColumn::make('conducteur_full_name')
                    ->label("Conducteur")
                    ->getStateUsing(fn($record) => optional($record->conducteur)->nom . ' ' . optional($record->conducteur)->prenoms),

                TextColumn::make('conducteur.permis_conduire')
                    ->label("Permis conduire")->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('conducteur.licence_transport')
                    ->label("Licence")->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('conducteur.nature_piece_identite')
                    ->label("Nature PI")->searchable()
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'Passeport' => 'success',
                        'Permis de conduire' => 'warning',
                        'CNI' => 'gray',
                    }),
                TextColumn::make('conducteur.numero_piece_identite')
                    ->label("Numéro PI")->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->label("Date création")

            ])
            ->filters([
                //Filtrer les pesées avec surchage
                Filter::make('surchage')
                    ->query(fn(Builder $query): Builder => $query->where('surchage', '>', 0))
                    ->toggle(),

                //Filtrer les pesées sans surchage
                Filter::make('sans surchage')
                    ->query(fn(Builder $query): Builder => $query->where('surchage', '=', 0))
                    ->toggle(),
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.list-pesages');
    }
}
