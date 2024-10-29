<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class TicketList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Ticket::query()->with('user')) // Charger l'utilisateur associé
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->filters([]) // Ajoute des filtres ici si nécessaire
            ->actions([
                // Définis les actions ici, par exemple un bouton pour voir les détails du ticket
            ])
            ->bulkActions([]); // Ajoute des actions de masse si nécessaire
    }

    public function render(): View
    {
        return view('livewire.ticket-list');
    }
}
