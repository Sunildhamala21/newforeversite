@if ($trip->duration > 1 && $canMakeChart)
    <div class="p-4 mb-20 bg-white border-2 border-gray-100 rounded-lg tds lg:p-10">
        <figure class="border border-gray-100">
            <figcaption class="mt-6 text-center">Elevation Chart</figcaption>
            <div style="overflow-x: scroll; max-width: 100%;">
                <div id="chart-wrapper">
                    <canvas id="ctx"></canvas>
                </div>
            </div>
        </figure>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const ctx = document.getElementById('ctx');

                const labels = {!! json_encode(array_column($elevations, 'place_name')) !!};
                const titles = {!! json_encode(array_column($elevations, 'title')) !!};

                const chartWrapper = document.getElementById('chart-wrapper');

                chartWrapper.style.height = '400px';
                if (labels.length > 10) {
                    chartWrapper.style.width = labels.length * 70 + 'px';
                    chartWrapper.style.maxWidth = labels.length * 70 + 'px';
                }

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Max. elevation (metres)',
                            data: {!! json_encode(array_column($elevations, 'max_altitude')) !!},
                            fill: true,
                            backgroundColor: '#1b599820',
                            borderWidth: 1,
                            borderColor: '#1b5998',
                            pointBackgroundColor: '#f3ad44',
                            pointBorderColor: '#f3ad44',
                        }]
                    },
                    options: {
                        animation: false,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 40,
                                right: 40,
                                bottom: 0
                            }
                        },
                        plugins: {
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    title: function(tooltipItem, data) {
                                        return titles[tooltipItem[0].dataIndex];
                                    },
                                    label: function(context) {
                                        return '';
                                    }
                                }
                            },
                            datalabels: {
                                color: '#1b5998',
                                align: 'top',
                                offset: 10,
                                formatter: function(value, ctx) {
                                    return ctx.chart.data.labels[ctx.dataIndex] + '\n' + value + ' m';
                                },
                            },
                            legend: {
                                display: false
                            },
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false,
                                max: 6500
                            }
                        }
                    }
                });

            });
        </script>
    @endpush
@endif
