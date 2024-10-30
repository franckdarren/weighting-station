<div>
    <button wire:click="openModal"
        class="px-4 py-2 mb-3 bg-[#35648e] text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200 ease-in-out">
        Créer un ticket
    </button>

    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-1/3">
                <h2 class="text-xl font-semibold mb-5">Créer un nouveau ticket</h2>
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
</div>
