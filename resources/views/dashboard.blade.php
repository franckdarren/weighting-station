<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot> -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    @if(request()->routeIs('pesage'))
                        @include('dashboard.pesage')
                    @elesif(request()->routeIs('rapport'))
                        @include('dashboard.rapport')
                    @elseif(request()->routeIs('facturation'))
                        @include('dashboard.facturation')
                    @elseif(request()->routeIs('texteReglementation'))
                        @include('dashboard.texteReglementation')
                    @elseif(request()->routeIs('caisse'))
                        @include('dashboard.caisse')
                    @else
                        <x-welcome />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>