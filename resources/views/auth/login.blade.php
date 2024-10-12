<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="relative flex items-center">
                <!-- <x-label for="email" value="{{ __('Email') }}" /> -->
                 
                <svg class="absolute pl-2" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="white" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/></svg>
                <x-input placeholder="Nom d'utilisateur" id="email" class="block mt-1 w-full bg-transparent text-white placeholder-[#cfcfcf] pl-8" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="relative flex items-center mt-4">
                <!-- <x-label for="password" value="{{ __('Password') }}" /> -->
                <svg class="absolute pl-2" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="white" d="M12 17a2 2 0 0 1-2-2c0-1.11.89-2 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2m6 3V10H6v10zm0-12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10c0-1.11.89-2 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3"/></svg>
                <x-input placeholder="Mot de passe" id="password" class="block mt-1 w-full bg-transparent text-white placeholder-[#cfcfcf] pl-8" type="password" name="password" required autocomplete="current-password" />
            </div>
            <div class="flex items-center justify-end mt-8">
                <!-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif -->

                <x-button class="w-full shadow-md flex justify-center   hover:text-white hover:bg-[#2d699c] ">
                    {{ __('Se connecter') }}
                </x-button>
            </div>

            <div class="flex justify-between mt-4">
                <label for="remember_me" class="flex  items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-white">{{ __('Se souvenir de moi') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié?') }}
                    </a>
                @endif
            </div>

            
        </form>
    </x-authentication-card>
</x-guest-layout>
