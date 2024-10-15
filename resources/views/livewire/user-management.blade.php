<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    {{-- Formulaire de création d'utilisateur --}}
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <form wire:submit.prevent="createUser" class="space-y-6">
            @csrf

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="name" wire:model="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" wire:model="email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" id="password" wire:model="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Code utilisateur</label>
                    <input type="text" id="code" wire:model="code"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select id="role" wire:model="role"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Sélectionnez un rôle</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-gray-900 text-white border border-transparent rounded-md font-bold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    Créer utilisateur
                </button>
            </div>
        </form>
    </div>

    {{-- Tableau des utilisateurs --}}
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-8 p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code
                        utilisateur</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôles
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach ($user->roles as $role)
                                <span
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
