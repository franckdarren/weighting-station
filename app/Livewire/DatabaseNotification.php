<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DatabaseNotification extends Component
{
    public function getUnreadNotificationsProperty()
    {
        return auth()->user()->unreadNotifications;
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function render()
    {
        return view('livewire.database-notification');
    }
}
