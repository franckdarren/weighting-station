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
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\FacturePesageExporter;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Concerns\InteractsWithTable;
use Spatie\Activitylog\Models\Activity;

class ListActivites extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query()->orderBy('created_at', 'desc'))
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $state)->translatedFormat('j F Y \à H:i')),
                TextColumn::make('causer.code')
                    ->label('Utilisateur')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Action')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('Type de sujet')
                    ->query(fn($query, $state): Builder => $query->where('subject_type', $state))
                    ->label('Filtrer par type de sujet'),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public function render()
    {
        return view('livewire.list-activites');
    }
}
