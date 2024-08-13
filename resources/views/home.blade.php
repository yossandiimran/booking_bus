@extends('admin.layouts.app')

@section('content')
<div class="page-inner">
    <div class="row">
        <div class="col-md-5 pl-5" style="display: flex; align-items:center;">
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-1"></div>

        <div class="col-md-2">
            <div class="card" style="padding:10px; margin-left: 20px;">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Bus Disewa</h3>
                    </div>
                    <div class="col-md-2">
                        <span class="fa fa-bus" style="color:orange;"></span>    
                        <h2 style="color:orange;">{{ $bus_disewa }}</h2>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-md-2">
            <div class="card" style="padding:10px;">
            <div class="row">
                    <div class="col-md-8">
                        <h3>Bus Tersedia</h3>
                    </div>
                    <div class="col-md-2">
                        <span class="fa fa-bus" style="color:green;"></span>    
                        <h2 style="color:green;">{{ $bus_ready }}</h2>
                    </div>
                </div>   
            </div>   
        </div>
        <div class="col-md-2">
            <div class="card" style="padding:10px;">
            <div class="row">
                    <div class="col-md-8">
                        <h3>Jumlah Transaksi</h3>
                    </div>
                    <div class="col-md-2">
                        <span class="fa fa-paste" style="color:purple;"></span>    
                        <h2 style="color:purple;">{{ $trx_count }}</h2>
                    </div>
                </div>   
            </div>   
        </div>
        <div class="col-md-2">
            <div class="card" style="padding:10px;">
            <div class="row">
                    <div class="col-md-8">
                        <h3>Jumlah Driver</h3>
                    </div>
                    <div class="col-md-2">
                        <span class="fa fa-user" style="color:orange;"></span>    
                        <h2 style="color:orange;">{{ $sopir_count }}</h2>
                    </div>
                </div>   
            </div>   
        </div>
        <div class="col-md-2">
            <div class="card" style="padding:10px;">
            <div class="row">
                    <div class="col-md-8">
                        <h3>Pendapatan</h3>
                        {{ formatRupiah($laba) }}
                    </div>
                    <div class="col-md-2">
                        <h3 style="color:blue">$</h3>  
                    </div>
                </div>   
            </div>   
        </div>
    </div>        
    <div class="card" style="padding:20px; margin-left: 20px; margin-right:20px;">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <canvas id="myChart2"></canvas>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6">
                <canvas id="myChart"></canvas>
            </div>
           
        </div>   
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const ctx2 = document.getElementById('myChart2').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'bar', // Chart type: bar, line, pie, etc.
        data: {
            labels: {!! json_encode($busNames) !!},
            datasets: [{
                label: 'Bus Paling Diminati',
                data: {!! json_encode($busCounts) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const myPieChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Bus Disewa', 'Bus Tersedia'],
                datasets: [{
                    data: [{{$bus_disewa}}, {{ $bus_ready }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    
    $(document).ready(function() {
        
    });
</script>
@endsection
