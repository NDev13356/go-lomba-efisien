@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Statistik pemilihan')

@section('content')
    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-slate-200">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-user-tie text-teal-500 text-3xl"></i>
                <div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalKandidat }}</div>
                    <div class="text-slate-400 text-sm">Total Kandidat</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-200">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-users text-teal-500 text-3xl"></i>
                <div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalSiswa }}</div>
                    <div class="text-slate-400 text-sm">Total Siswa</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-200">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-check-to-slot text-teal-500 text-3xl"></i>
                <div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalSuara }}</div>
                    <div class="text-slate-400 text-sm">Suara Masuk</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <h2 class="font-bold text-slate-800 mb-6">
            <i class="fa-solid fa-chart-bar text-teal-500 mr-2"></i>Perolehan Suara
        </h2>
        <div class="h-72">
            <canvas id="chart"></canvas>
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
