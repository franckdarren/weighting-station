<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\Message;
use Livewire\Component;
use Filament\Notifications\Notification;

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

        Message::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => auth()->id(),
            'content' => $this->messageContent,
        ]);

        // Réinitialiser le contenu du message après l'ajout
        $this->messageContent = '';

        // Ajouter une notification si nécessaire
        // session()->flash('message', 'Message ajouté avec succès!');
        Notification::make()
            ->title('Message ajouté avec succès!')
            ->success()
            ->send();
    }

    public function updateStatus()
    {
        $this->ticket->status = $this->status;
        $this->ticket->save();

        // Ajouter une notification si nécessaire
        session()->flash('message', 'Statut du ticket mis à jour!');
    }

    public function render()
    {
        return view('livewire.ticket-details');
    }
}
