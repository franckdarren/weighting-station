<div class="relative">
    <!-- Icône de notification avec un badge indiquant le nombre de notifications non lues -->
    <button class="relative" wire:click="$toggle('showNotifications')">
        <span class="icon">
            🛎️ <!-- Remplacez par l'icône de votre choix -->
        </span>
        @if ($this->unreadNotifications->count() > 0)
            <span class="badge">{{ $this->unreadNotifications->count() }}</span>
        @endif
    </button>

    <!-- Liste des notifications -->
    @if ($showNotifications)
        <div class="absolute bg-white shadow-lg rounded-lg p-4">
            @forelse ($this->unreadNotifications as $notification)
                <div class="notification-item">
                    <a href="{{ $notification->data['url'] }}" wire:click="markAsRead('{{ $notification->id }}')">
                        {{ $notification->data['title'] }} - {{ $notification->data['message'] }}
                    </a>
                </div>
            @empty
                <div>Aucune nouvelle notification</div>
            @endforelse
        </div>
    @endif
</div>
