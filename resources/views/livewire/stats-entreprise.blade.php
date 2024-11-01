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
            <!-- Companies Distribution -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Distribution des entreprises</h3>
                <div class="h-[300px]">
                    <canvas x-data="{
                        chart: null,
                        init() {
                            this.chart = new Chart(this.$el.getContext('2d'), {
                                type: 'pie',
                                data: @js($chartData['companies']),
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                }
                            });
                        }
                    }" x-init="init" wire:ignore></canvas>
                </div>
            </div>

            <!-- Company Performance -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Performance des entreprises (Top 10)</h3>
                <div class="h-[300px]">
                    <canvas x-data="{
                        chart: null,
                        init() {
                            this.chart = new Chart(this.$el.getContext('2d'), {
                                type: 'bar',
                                data: @js($chartData['performance']),
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            type: 'linear',
                                            position: 'left',
                                        },
                                        y1: {
                                            type: 'linear',
                                            position: 'right',
                                            grid: {
                                                drawOnChartArea: false,
                                            },
                                        }
                                    }
                                }
                            });
                        }
                    }" x-init="init" wire:ignore></canvas>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="bg-white rounded-lg shadow p-4 md:col-span-2">
                <h3 class="text-lg font-semibold mb-4">Activité des principales entreprises</h3>
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
