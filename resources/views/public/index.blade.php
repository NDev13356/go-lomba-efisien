@extends('layouts.app')

@section('title', 'Pilketos - Pemilihan Ketua OSIS')

@section('content')
        {{-- Chart Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fa-solid fa-chart-pie text-teal-500"></i>Grafik Perolehan Suara
                    </h2>
                    <div class="h-80">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fa-solid fa-user-group text-teal-500"></i>Daftar Kandidat
                    </h2>
                    <div class="space-y-3">
                        @forelse($kandidat->sortByDesc('jumlah_suara') as $index => $k)
                            <div class="flex items-center gap-4 p-4 bg-base-200 rounded-xl">
                                <div
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $index === 0 && $totalSuara > 0 ? 'bg-yellow-400 text-white' : 'bg-base-300' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="avatar">
                                    <div class="w-12 rounded-full bg-teal-100">
                                        @if ($k->foto)
                                            <img src="{{ $k->foto_url }}" alt="{{ $k->nama }}">
                                        @else
                                            <div class="flex items-center justify-center w-full h-full text-teal-400">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold">{{ $k->nama }}</h3>
                                    <p class="text-sm text-base-content/60">{{ $k->jumlah_suara }} suara •
                                        {{ $k->persentase }}%</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-base-content/60 py-12">
                                <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                                <p>Belum ada kandidat</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            new Chart(document.getElementById('chart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($kandidat->pluck('nama')) !!},
                    datasets: [{
                        data: {!! json_encode($kandidat->pluck('jumlah_suara')) !!},
                        backgroundColor: ['#14b8a6', '#0ea5e9', '#3b82f6', '#8b5cf6', '#ec4899'],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
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
        </script>
    @endpush
@endsection
