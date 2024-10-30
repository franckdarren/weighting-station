<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class TicketList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $isModalOpen = false; // État de la modale
    public $title = '';
    public $description = '';

    public function table(Table $table): Table
    {
        return $table
            ->query(Ticket::query()
                ->with('user')) // Charger l'utilisateur associé
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'open' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'success',
                    }),
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->filters([]) // Ajoute des filtres ici si nécessaire
            ->actions([
                Action::make('voir')
                    ->label('Voir les détails')
                    ->url(fn(Ticket $record) => route('ticket-details', $record->id)), // Redirige vers la vue des détails
                Action::make('Répondre')
                    ->label('Répondre')
                    ->form([
                        Textarea::make('message')->required()->label('Votre réponse') // Modifier le champ en "message"
                    ])
                    ->action(function (Ticket $record, array $data) {
                        $record->messages()->create([ // Utiliser "messages" au lieu de "responses"
                            'user_id' => auth()->id(),
                            'content' => $data['message'], // Utiliser le nom du champ "message"
                        ]);
                        // Ajouter une notification ici, si nécessaire
                    }),
            ])

            ->bulkActions([]); // Ajoute des actions de masse si nécessaire
    }

    public function openModal()
    {
        $this->reset('title', 'description'); // Réinitialisez les champs du formulaire
        $this->isModalOpen = true;
    }

    public function createTicket()
    {
        Ticket::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'open', // Statut par défaut
        ]);

        Notification::make()
            ->title('Ticket créé avec succès!')
            ->success()
            ->send();

        $this->isModalOpen = false; // Ferme la modale après la création
    }

    public function render(): View
    {
        return view('livewire.ticket-list');
    }
}
