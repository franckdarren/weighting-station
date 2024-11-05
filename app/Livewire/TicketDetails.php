<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\Message;
use Livewire\Component;
use Filament\Notifications\Notification;
use App\Notifications\TicketResponseNotification;

class TicketDetails extends Component
{
    public Ticket $ticket;
    public string $messageContent = '';
    public string $status;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->status = $ticket->status;
    }

    public function addMessage()
    {
        $this->validate([
            'messageContent' => 'required|string|max:255',
        ]);

        // Créer le message
        $message = Message::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => auth()->id(),
            'content' => $this->messageContent,
        ]);

        // Envoie la notification au créateur du ticket
        $this->ticket->user->notify(new TicketResponseNotification($this->ticket, $message->content));

        // Notification de succès pour l'utilisateur
        Notification::make()
            ->title('Message ajouté avec succès!')
            ->success()
            ->send();

        // Réinitialiser le contenu du message après l'ajout
        $this->messageContent = '';
    }

    public function updateStatus()
    {
        $this->ticket->status = $this->status;
        $this->ticket->save();

        // Ajouter une notification pour le créateur du ticket
        $this->ticket->user->notify(new \App\Notifications\StatusUpdatedNotification($this->ticket));

        // Notification de succès pour l'utilisateur
        Notification::make()
            ->title('Statut du ticket mis à jour!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.ticket-details');
    }
}
