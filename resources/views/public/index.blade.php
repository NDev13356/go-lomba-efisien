@extends('layouts.app')

@section('title', 'Pilketos - Pemilihan Ketua OSIS')

@section('content')
    {{-- Hero Section --}}
    <section class="relative">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/bg-hero.png') }}');">
        </div>
        <div class="absolute inset-0 bg-teal-900/80"></div>
        <div
            class="relative mx-auto px-4 md:px-8 lg:px-24 py-12 md:py-16 flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-4">
                    Pilih <span class="text-yellow-300">Pemimpin</span> untuk OSIS Kita
                </h1>
                <p class="text-white/80 mb-6 max-w-lg mx-auto md:mx-0">
                    Gunakan hak suaramu untuk menentukan ketua OSIS yang akan membawa perubahan positif bagi sekolah kita.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                    @if (session()->has('siswa_nisn'))
                        <a href="{{ route('siswa.voting') }}" class="btn btn-neutral">
                            <i class="fa-solid fa-vote-yea"></i>Mulai Voting
                        </a>
                    @else
                        <a href="{{ route('siswa.login') }}" class="btn btn-neutral">
                            <i class="fa-solid fa-right-to-bracket"></i>Login & Vote
                        </a>
                    @endif
                    <a href="#hasil" class="btn btn-outline border-white text-white hover:bg-white hover:text-teal-900">
                        <i class="fa-solid fa-chart-pie"></i>Lihat Hasil
                    </a>
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <img src="{{ asset('images/hero-image.png') }}" alt="Pilketos" class="max-w-xs md:max-w-md object-contain">
            </div>
        </div>
    </section>

    {{-- Stats & Results --}}
    <section id="hasil" class="container mx-auto px-4 md:px-8 lg:px-24 py-8">
        {{-- Stats Cards --}}
        <div class="stats stats-vertical md:stats-horizontal shadow w-full mb-8">
            <div class="stat">
                <div class="stat-figure text-teal-500">
                    <i class="fa-solid fa-check-to-slot text-3xl"></i>
                </div>
                <div class="stat-title">Total Suara</div>
                <div class="stat-value text-teal-500">{{ $totalSuara }}</div>
            </div>
            <div class="stat">
                <div class="stat-figure text-teal-500">
                    <i class="fa-solid fa-users text-3xl"></i>
                </div>
                <div class="stat-title">Kandidat</div>
                <div class="stat-value text-teal-500">{{ count($kandidat) }}</div>
            </div>
            <div class="stat">
                <div class="stat-figure text-yellow-500">
                    <i class="fa-solid fa-trophy text-3xl"></i>
                </div>
                <div class="stat-title">Peringkat 1</div>
                <div class="stat-value text-yellow-500 text-xl">
                    {{ $totalSuara > 0 ? $kandidat->sortByDesc('jumlah_suara')->first()->nama : '-' }}
                </div>
            </div>
        </div>

        {{-- Kandidat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($kandidat->sortBy('nomor_urut') as $index => $k)
                <div class="card bg-base-100 shadow-xl">
                    <figure class="aspect-square bg-teal-100">
                        @if ($k->foto)
                            <img src="{{ $k->foto_url }}" class="w-full h-full object-cover" alt="{{ $k->nama }}">
                        @else
                            <i class="fa-solid fa-user text-6xl text-teal-300"></i>
                        @endif
                    </figure>
                    <div class="absolute top-4 left-4">
                        <div class="badge badge-neutral badge-lg font-bold">{{ $index + 1 }}</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $k->nama }}</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-teal-600">{{ $k->jumlah_suara }}</span>
                                <span class="text-base-content/60">suara</span>
                            </div>
                            <span class="text-lg font-semibold text-teal-500">{{ $k->persentase }}%</span>
                        </div>
                        <progress class="progress progress-primary" value="{{ $k->persentase }}" max="100"></progress>
                    </div>
                </div>
            @empty
                <div class="col-span-full card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center py-12">
                        <i class="fa-solid fa-user-slash text-5xl text-base-content/30 mb-4"></i>
                        <p class="text-base-content/60 text-lg">Belum ada kandidat terdaftar</p>
                    </div>
                </div>
            @endforelse
        </div>

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
