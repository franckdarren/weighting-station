<div class="p-6 bg-gray-100 rounded-lg shadow-md">
    <button wire:click="openModal"
        class="px-4 py-2 mb-5 bg-[#35648e] text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200 ease-in-out">
        Créer un ticket
    </button>

    <div class="mb-4">
        <h2 class="text-lg font-semibold mb-3">Notifications <span
                class="text-red-600">({{ $this->unreadNotifications->count() }})</span></h2>
        @foreach ($this->unreadNotifications as $notification)
            <div class="bg-white rounded-lg p-4 mb-2 shadow hover:bg-gray-100 transition duration-150 ease-in-out">
                <a href="{{ $notification->data['url'] }}" wire:click="markAsRead('{{ $notification->id }}')"
                    class="font-semibold text-blue-600 hover:underline">
                    {{ $notification->data['title'] }}
                </a>
                <p class="text-gray-600 mt-1">{{ $notification->data['message'] }}</p>
            </div>
        @endforeach
    </div>

    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md mx-auto">
                <h2 class="text-xl font-semibold mb-5">Créer un nouveau ticket</h2>
                <form wire:submit.prevent="createTicket">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" wire:model.defer="title" id="title" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model.defer="description" id="description"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white font-medium rounded-md shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 transition duration-150 ease-in-out">
                            Créer
                        </button>
                        <button type="button" wire:click="$set('isModalOpen', false)"
                            class="ml-2 px-6 py-2 bg-gray-300 text-gray-700 font-medium rounded-md shadow-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition duration-150 ease-in-out">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{ $this->table }}
    <script>
        // Utilisez setInterval pour émettre l'événement toutes les 5 secondes
        setInterval(() => {
            Livewire.emit('refreshComponent'); // Émet l'événement pour rafraîchir les données
        }, 5000); // 5000 millisecondes = 5 secondes
    </script>
</div>
