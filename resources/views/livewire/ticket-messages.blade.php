// resources/views/livewire/ticket-messages.blade.php
<div>
    <h3>Messages</h3>
    <div class="messages-list">
        @foreach ($messages as $message)
            <div class="message">
                <strong>{{ $message->user->name }}</strong>:
                <p>{{ $message->content }}</p>
                <small>{{ $message->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage">
        <textarea wire:model="newMessage" placeholder="Écrire un message..." rows="3"></textarea>
        <button type="submit">Envoyer</button>
    </form>
</div>
