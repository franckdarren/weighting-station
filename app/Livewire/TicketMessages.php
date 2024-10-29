<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\Message;
use Livewire\Component;

class TicketMessages extends Component
{
    public $ticket;
    public $newMessage;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:2000',
        ]);

        Message::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => auth()->id(),
            'content' => $this->newMessage,
        ]);

        $this->newMessage = '';
        $this->ticket->refresh(); // Rafraîchit les messages du ticket
    }

    public function render()
    {
        return view('livewire.ticket-messages', [
            'messages' => $this->ticket->messages()->latest()->get()
        ]);
    }
}
