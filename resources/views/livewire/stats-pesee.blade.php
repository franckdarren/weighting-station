<div class="bg-white rounded-lg shadow-xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-[#3d8cd6] text-2xl font-semibold">Statistiques des pesées</h2>
        
        <div class="flex gap-4">
            <select wire:model.live="timeFilter" class="rounded-md border-gray-300">
                <option value="year">Par année</option>
                <option value="month">Par mois</option>
                <option value="day">Par jour</option>
            </select>

            <select wire:model.live="statusFilter" class="rounded-md border-gray-300">
                <option value="all">Toutes les pesées</option>
                <option value="Valide">Pesées valides</option>
                <option value="A reprendre">Pesées non valides</option>
            </select>

            <!-- <button 
                onclick="exportToPDF()" 
                class="px-4 py-2 bg-[#3d8cd6] text-white rounded-md hover:bg-[#2d6dad]"
            >
                Exporter en PDF
            </button> -->
        </div>
    </div>

    <div class="h-[400px]" id="chartContainer">
        <canvas 
            x-data="{ 
                init() {
                    const ctx = this.$el.getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'line',
                        data: @js($this->getChartData()),
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    });

                    this.$watch('$wire.timeFilter', () => {
                        chart.data = @js($this->getChartData());
                        chart.update();
                    });

                    this.$watch('$wire.statusFilter', () => {
                        chart.data = @js($this->getChartData());
                        chart.update();
                    });
                }
            }" 
            x-init="init"
        ></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function exportToPDF() {
    const chartContainer = document.getElementById('chartContainer');
    html2canvas(chartContainer).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jspdf.jsPDF();
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('statistiques-pesees.pdf');
    });
}
</script>
@endpush
