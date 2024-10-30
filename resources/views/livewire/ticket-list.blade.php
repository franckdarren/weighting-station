<div>
    <button wire:click="openModal"
        class="px-4 py-2 mb-3 bg-[#35648e] text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200 ease-in-out">
        Créer un ticket
    </button>

    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-1/3">
                <h2 class="text-xl font-semibold">Créer un nouveau ticket</h2>
                <form wire:submit.prevent="createTicket">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium">Titre</label>
                        <input type="text" wire:model.defer="title" id="title" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <textarea wire:model.defer="description" id="description"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-success">Créer</button>
                        <button type="button" wire:click="$set('isModalOpen', false)"
                            class="ml-2 btn btn-secondary">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    {{ $this->table }}
</div>
