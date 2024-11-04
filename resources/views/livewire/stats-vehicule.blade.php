<div class="p-6 space-y-6">
    <!-- Date Range Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date début</label>
                <input type="date" wire:model.live="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date fin</label>
                <input type="date" wire:model.live="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>
    </div>

    @if(isset($chartData['noData']))
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-xl text-gray-600">Aucune donnée trouvée pour la période sélectionnée</p>
        </div>
    @else
        <!-- Charts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Vehicle Weight Distribution -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Top 5 - Poids total transporté par véhicule</h3>
                <div class="h-[300px]">
                    <canvas x-data="{
                        chart: null,
                        init() {
                            this.chart = new Chart(this.$el.getContext('2d'), {
                                type: 'bar',
                                data: @js($chartData['weights']),
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    indexAxis: 'y'
                                }
                            });
                        }
                    }" x-init="init" wire:ignore></canvas>
                </div>
            </div>

            <!-- Vehicle Details -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Détails des véhicules (Top 5)</h3>
                <div class="overflow-y-auto max-h-[300px]">
                    @foreach($chartData['topVehicles'] as $plate => $data)
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="font-semibold text-lg text-blue-600">{{ $plate }}</h4>
                            <p class="text-sm text-gray-600">Nombre de pesées: {{ $data['count'] }}</p>
                            <p class="text-sm text-gray-600 mb-2">Poids total: {{ number_format($data['total_weight'], 2) }} kg</p>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-700">Historique des conducteurs:</p>
                                <div class="mt-1 space-y-1">
                                    @foreach($data['drivers'] as $record)
                                        <div class="text-sm text-gray-600 flex justify-between">
                                            <span>{{ $record['name'] }}</span>
                                            <span>{{ $record['date'] }} - {{ number_format($record['weight'], 2) }} kg</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="bg-white rounded-lg shadow p-4 md:col-span-2">
                <h3 class="text-lg font-semibold mb-4">Activité des véhicules (Top 5)</h3>
                <div class="h-[300px]">
                    <canvas x-data="{
                        chart: null,
                        init() {
                            this.chart = new Chart(this.$el.getContext('2d'), {
                                type: 'line',
                                data: @js($chartData['timeline']),
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    interaction: {
                                        mode: 'index',
                                        intersect: false,
                                    }
                                }
                            });
                        }
                    }" x-init="init" wire:ignore></canvas>
                </div>
            </div>
        </div>
    @endif
</div>
