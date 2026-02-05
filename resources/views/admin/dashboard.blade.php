@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Statistik pemilihan')

@section('content')
    {{-- Stats --}}
    <div class="stats stats-vertical md:stats-horizontal shadow w-full mb-8">
        <div class="stat">
            <div class="stat-figure text-primary">
                <i class="fa-solid fa-user-tie text-3xl"></i>
            </div>
            <div class="stat-title">Total Kandidat</div>
            <div class="stat-value text-primary">{{ $totalKandidat }}</div>
        </div>
        <div class="stat">
            <div class="stat-figure text-primary">
                <i class="fa-solid fa-users text-3xl"></i>
            </div>
            <div class="stat-title">Total Siswa</div>
            <div class="stat-value text-primary">{{ $totalSiswa }}</div>
        </div>
        <div class="stat">
            <div class="stat-figure text-primary">
                <i class="fa-solid fa-check-to-slot text-3xl"></i>
            </div>
            <div class="stat-title">Suara Masuk</div>
            <div class="stat-value text-primary">{{ $totalSuara }}</div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">
                <i class="fa-solid fa-chart-bar text-primary"></i>Perolehan Suara
            </h2>
            <div class="h-72">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            new Chart(document.getElementById('chart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kandidat->pluck('nama')) !!},
                    datasets: [{
                        label: 'Suara',
                        data: {!! json_encode($kandidat->pluck('jumlah_suara')) !!},
                        backgroundColor: ['#14b8a6', '#0ea5e9', '#3b82f6', '#8b5cf6', '#ec4899'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
