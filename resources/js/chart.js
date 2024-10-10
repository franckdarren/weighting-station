import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {

    //Center the text in the center of the chart
    Chart.register({
        id: 'centerText',
        afterDraw: (chart) => {
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
    });

    fetch('/chart-data')
        .then(response => response.json())
        .then(data => {
            const { dataPesage, dataFacture, dataFullFacture, dataFactureBuy, dataFactureNotBuy } = data;

            // const dataPesage = 19;
            // const dataFacture = 0;
            // const dataFullFacture = 30;
            // const dataFactureBuy = 10;
            // const dataFactureNotBuy = 5;

            // circularCounter pesage
            const ctx = document.getElementById('circularCounterPesage').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [dataPesage, 100 - dataPesage],
                        backgroundColor: ['#3d8cd6', 'transparent'],
                        circumference: 360,
                        rotation: -90,
                        borderWidth: 2,
                        borderColor: '#00000019',
                        borderShadowColor: 'rgba(0, 0, 0, 0.1)',
                        borderShadowBlur: 10,
                    }]
                },
                options: {
                    cutout: '80%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            enabled: false,
                        }
                    },
                    elements: {
                        center: {
                            text: dataPesage.toString(),
                            color: '#3d8cd6',
                            fontStyle: 'Bold',
                            fontSize: 50,
                            fontFamily: 'Arial',
                            sidePadding: 20,
                            minFontSize: 20,
                            toLineHeight: 25,
                        }
                    }
                }
            });

            // circularCounter factures
            const ctx0 = document.getElementById('circularCounterFactures').getContext('2d');
            new Chart(ctx0, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [dataFacture, 100 - dataFacture],
                        backgroundColor: ['#3d8cd6', 'transparent'],
                        circumference: 360,
                        rotation: -90,
                        borderWidth: 2,
                        borderColor: '#00000019',
                        borderShadowColor: 'rgba(0, 0, 0, 0.1)',
                        borderShadowBlur: 10,
                    }]
                },
                options: {
                    cutout: '80%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            enabled: false,
                        }
                    },
                    elements: {
                        center: {
                            text: dataFacture.toString(),
                            color: '#3d8cd6',
                            fontStyle: 'Bold',
                            fontSize: 50,
                            fontFamily: 'Arial',
                            sidePadding: 20,
                            minFontSize: 20,
                            toLineHeight: 25,
                        }
                    }
                }
            });

            //pieChart counter
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Total Factures', 'Total Factures payées', 'Total Factures non-payées'],
                    datasets: [{
                        data: [dataFullFacture, dataFactureBuy, dataFactureNotBuy],
                        backgroundColor: ['#e15759', '#f28e2c', '#3ba94a', 'transparent'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            align: 'center',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                boxWidth: 10
                            }
                        }
                    },
                    layout: {
                        padding: {
                            bottom: 30
                        }
                    }
                }
            });
        })
        
});