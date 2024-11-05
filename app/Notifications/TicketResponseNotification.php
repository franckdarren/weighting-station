<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketResponseNotification extends Notification
{
    use Queueable;

    protected $ticket;
    protected $messageContent;

    public function __construct(Ticket $ticket, string $messageContent)
    {
        $this->ticket = $ticket;
        $this->messageContent = $messageContent;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => "Nouvelle réponse sur le ticket #{$this->ticket->id}",
            'message' => $this->messageContent,
            'url' => route('ticket-details', ['ticket' => $this->ticket->id]),
        ];
    }
}
