@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Welcome to Village, {{ auth()->user()->name }}</h1>
    </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Residence</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $residentCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->role_id == 1)
                    <div class="card-footer text-end">
                        <a href="/resident" class="text-primary small">More Info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-primary">Gender Distribution</h6>
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
        </div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('genderChart').getContext('2d');
    const genderChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: 'Gender',
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: ['#4e73df', '#f6c23e'],
                borderColor: ['#4e73df', '#f6c23e'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                datalabels: {
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: function(value, context) {
                        return value;
                    }
                }
            },
        },
        plugins: [ChartDataLabels]
    });
</script>
@endsection
