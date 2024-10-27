<div class="flex flex-col space-y-24 items-center">
    <div class="flex justify-between items-center w-full">
        <!-- Weighing Counter -->
        <div class="w-[40%]">
            <div class="bg-white rounded-lg shadow-xl p-6">
                <div class="h-40">
                    <canvas x-data="{ 
                        init() {
                            new Chart(this.$el, {
                                type: 'doughnut',
                                data: @js($weighingData),
                                options: {
                                    cutout: '80%',
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false },
                                    },
                                    elements: {
                                        center: {
                                            text: {{ $weighingCount }},
                                            color: '#3d8cd6',
                                            fontStyle: 'Bold',
                                            fontSize: 50,
                                            fontFamily: 'Arial',
                                        }
                                    }
                                },
                                plugins: [{
                                    beforeDraw: function(chart) {
                                        if (chart.config.options.elements.center) {
                                            const ctx = chart.ctx;
                                            const centerConfig = chart.config.options.elements.center;
                                            ctx.save();
                                            ctx.font = `${centerConfig.fontStyle} ${centerConfig.fontSize}px ${centerConfig.fontFamily}`;
                                            ctx.fillStyle = centerConfig.color;
                                            ctx.textAlign = 'center';
                                            ctx.textBaseline = 'middle';
                                            const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                                            const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;
                                            ctx.fillText(centerConfig.text, centerX, centerY);
                                            ctx.restore();
                                        }
                                    }
                                }]
                            });
                        }
                    }" x-init="init"></canvas>
                </div>
                <div class="text-center text-[#3d8cd6] mt-4">
                    <i class="fa-solid fa-truck mb-4 text-5xl"></i>
                    <div>Nombre de voiture pesé</div>
                </div>
            </div>
        </div>

        <!-- Invoice Counter -->
        <div class="w-[40%]">
            <div class="bg-white rounded-lg shadow-xl p-6">
                <div class="h-40">
                    <canvas x-data="{ 
                        init() {
                            new Chart(this.$el, {
                                type: 'doughnut',
                                data: @js($invoiceData),
                                options: {
                                    cutout: '80%',
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false },
                                    },
                                    elements: {
                                        center: {
                                            text: {{ $invoiceCount }},
                                            color: '#3d8cd6',
                                            fontStyle: 'Bold',
                                            fontSize: 50,
                                            fontFamily: 'Arial',
                                        }
                                    }
                                },
                                plugins: [{
                                    beforeDraw: function(chart) {
                                        if (chart.config.options.elements.center) {
                                            const ctx = chart.ctx;
                                            const centerConfig = chart.config.options.elements.center;
                                            ctx.save();
                                            ctx.font = `${centerConfig.fontStyle} ${centerConfig.fontSize}px ${centerConfig.fontFamily}`;
                                            ctx.fillStyle = centerConfig.color;
                                            ctx.textAlign = 'center';
                                            ctx.textBaseline = 'middle';
                                            const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                                            const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;
                                            ctx.fillText(centerConfig.text, centerX, centerY);
                                            ctx.restore();
                                        }
                                    }
                                }]
                            });
                        }
                    }" x-init="init"></canvas>
                </div>
                <div class="text-center text-[#3d8cd6] mt-4">
                    <i class="fa-solid fa-paste mb-4 text-5xl"></i>
                    <div>Facture Total/Jour</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Stats -->
    <div class="w-[60%]">
        <div class="bg-white rounded-lg shadow-xl p-6">
            <h2 class="text-[#3d8cd6] text-2xl font-semibold text-center mb-4">Recapitulatif global</h2>
            <div class="h-80">
                <canvas x-data="{ 
                    init() {
                        new Chart(this.$el, {
                            type: 'pie',
                            data: @js($chartData),
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    }
                }" x-init="init"></canvas>
            </div>
        </div>
    </div>
</div>