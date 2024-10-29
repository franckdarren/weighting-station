<div>
    <!-- Affichage des messages de succès -->
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Formulaire de création/modification d'utilisateur -->
    <form wire:submit.prevent="{{ $selectedUserId ? 'updateUser' : 'createUser' }}" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" wire:model="name" id="name"
                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required />
                @error('name')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input type="text" wire:model="code" id="code"
                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required />
                @error('code')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email" id="email"
                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required />
                @error('email')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" wire:model="password" id="password"
                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    {{ $selectedUserId ? '' : 'required' }} />
                @error('password')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select wire:model="role" id="role"
                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    <option value="">Sélectionner un rôle</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                <select wire:model="status" id="status"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    <option>Choisir un statut</option>
                    <option value="Actif">Actif</option>
                    <option value="Désactivé">Désactivé</option>
                    <option value="Suspendu">Suspendu</option>
                </select>
                @error('status')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-gray-900 text-white border border-transparent rounded-md font-bold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ $selectedUserId ? 'Mettre à jour utilisateur' : 'Créer utilisateur' }}
            </button>

            @if ($selectedUserId)
                <button type="button" wire:click="resetForm"
                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white border border-transparent rounded-md font-bold text-xs uppercase tracking-widest hover:bg-red-400 focus:bg-red-400 active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Annuler
                </button>
            @endif
        </div>
    </form>

    <!-- Tableau des utilisateurs -->
    <div class="mt-8 overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nom
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Code
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Rôle
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->status }}</td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach ($user->roles as $role)
                                <span
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-[10px]">
                            <button wire:click="editUser({{ $user->id }})"
                                class="text-indigo-600 hover:text-indigo-900 text-sm">
                                Éditer
                            </button>
                            <button wire:click="deleteUser({{ $user->id }})"
                                class="text-red-600 hover:text-red-900 text-sm">
                                Supprimer
                            </button>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.addEventListener('confirm-delete', event => {
            if (confirm(event.detail.message)) {
                @this.deleteUser(event.detail.id);
            }
        });
    </script>
</div>
