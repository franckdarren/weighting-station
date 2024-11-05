<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Livewire;
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
use App\Notifications\TicketResponseNotification;

class TicketList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $isModalOpen = false; // État de la modale
    public $title = '';
    public $description = '';

    public function getUnreadNotificationsProperty()
    {
        return auth()->user()->unreadNotifications;
    }

    public function markAsRead($notificationId)
    {
        auth()->user()->notifications()->where('id', $notificationId)->update(['read_at' => now()]);

        // Rafraîchir la liste des notifications pour ne plus inclure les notifications lues
        $this->emitSelf('refreshComponent');
    }

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function table(Table $table): Table
    {
        $query = Ticket::query()->with('user');

        // Vérifier si l'utilisateur est un administrateur
        if (!auth()->user()->hasRole('Administrateur')) {
            // Si l'utilisateur n'est pas un administrateur, afficher uniquement ses propres tickets
            $query->where('user_id', auth()->id());
        }

        return $table
            ->query($query) // Utilisez la requête filtrée
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->sortable()
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'open' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'open' => 'Ouvert',
                        'in_progress' => 'En cours',
                        'resolved' => 'Résolu',
                        'closed' => 'Fermé',
                    }),
                TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date création')
                    ->dateTime('d-m-Y à H\hi'),
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
                        $message = $record->messages()->create([
                            'user_id' => auth()->id(),
                            'content' => $data['message'],
                        ]);

                        // Envoie la notification au créateur du ticket
                        $record->user->notify(new TicketResponseNotification($record, $message->content));

                        // Notification pour l'utilisateur qui a répondu (optionnelle)
                        Notification::make()
                            ->title('Réponse envoyée avec succès !')
                            ->success()
                            ->send();
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
