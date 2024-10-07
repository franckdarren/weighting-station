<button type="button" class="relative">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" viewBox="0 0 20 20" fill="white">
        <path
            d="M10 2a6 6 0 00-6 6v4.293l-.707.707A1 1 0 004 15h12a1 1 0 00.707-1.707L16 12.293V8a6 6 0 00-6-6zM8 18a2 2 0 104 0H8z" />
    </svg>

    @if ($unreadNotificationsCount > 0)
        <span
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
            {{ $unreadNotificationsCount }}
        </span>
    @endif
</button>
