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
            <!-- Top Drivers Distribution -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Top 10 des conducteurs</h3>
                <div class="h-[300px]">
                    <canvas x-data="{
                        chart: null,
                        init() {
                            this.chart = new Chart(this.$el.getContext('2d'), {
                                type: 'doughnut',
                                data: @js($chartData['drivers']),
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                }
                            });
                        }
                    }" x-init="init" wire:ignore></canvas>
                </div>
            </div>

            <!-- Driver Details -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Détails des conducteurs (Top 5)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conducteur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nbr Pesées</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Permis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents (carte grise/licence/autres)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière visite</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($chartData['details']['drivers'] as $driver)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $driver['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $driver['count'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $driver['permis'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $driver['documents'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $driver['last_visit'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="bg-white rounded-lg shadow p-4 md:col-span-2">
                <h3 class="text-lg font-semibold mb-4">Activité des principaux conducteurs</h3>
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
