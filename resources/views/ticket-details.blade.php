{{-- Détail ticket --}}
<x-app-layout>
    <div class="px-[5%] my-10">
        <div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow-lg rounded-lg">
            <div class="border-b pb-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Ticket #{{ $ticket->id }} - {{ $ticket->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $ticket->description }}</p>
                <span
                    class="inline-block px-3 py-1 mt-4 text-sm font-semibold 
                             rounded-full {{ $ticket->status === 'open'
                                 ? 'bg-blue-100 text-blue-600'
                                 : ($ticket->status === 'in_progress'
                                     ? 'bg-yellow-100 text-yellow-600'
                                     : ($ticket->status === 'resolved'
                                         ? 'bg-green-100 text-green-600'
                                         : 'bg-gray-100 text-gray-600')) }}">
                    Status: {{ ucfirst($ticket->status) }}
                </span>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Messages</h2>
            @if ($ticket->messages && $ticket->messages->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($ticket->messages as $message)
                        <div class="p-4 border rounded-lg bg-gray-50">
                            <p class="text-gray-800">{{ $message->content }}</p>
                            <div class="text-sm text-gray-500 mt-2">
                                par <span class="font-semibold">{{ $message->user->name }}</span>
                                le {{ $message->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 italic">Aucun message pour ce ticket.</p>
            @endif
        </div>


    </div>
</x-app-layout>
