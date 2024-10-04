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

            <div class="relative">
                <!-- <x-label for="email" value="{{ __('Email') }}" /> -->
                <i class="fa-regular fa-user absolute inset-y-0 left-0 pl-3 pt-3 flex items-center pointer-events-none text-white"></i>
                <x-input placeholder="Nom d'utilisateur" id="email" class="block mt-1 w-full bg-transparent text-white placeholder-[#cfcfcf] pl-8" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="relative mt-4">
                <!-- <x-label for="password" value="{{ __('Password') }}" /> -->
                <i class="fas fa-lock absolute pl-3 pt-3 flex items-center pointer-events-none text-white"></i>
                <x-input placeholder="Mot de passe" id="password" class="block mt-1 w-full bg-transparent text-white placeholder-[#cfcfcf] pl-8" type="password" name="password" required autocomplete="current-password" />
            </div>
            <div class="flex items-center justify-end mt-4">
<<<<<<< HEAD
                
=======
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
>>>>>>> dc828b2ce21382de66a07a952ffefe1e461ae472

                <x-button class="w-full shadow-md flex justify-center bg-white text-[#2148C0] hover:text-white hover:bg-[#2d699c] ">
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
