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
                        <a href="{{ route('siswa.voting') }}"
                            class="bg-white text-teal-600 px-6 py-3 rounded-full font-bold hover:bg-slate-100">
                            <i class="fa-solid fa-vote-yea mr-2"></i>Mulai Voting
                        </a>
                    @else
                        <a href="{{ route('siswa.login') }}"
                            class="bg-white text-teal-600 px-6 py-3 rounded-full font-bold hover:bg-slate-100">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i>Login & Vote
                        </a>
                    @endif
                    <a href="#hasil" class="bg-teal-700 text-white px-6 py-3 rounded-full font-bold hover:bg-teal-800">
                        <i class="fa-solid fa-chart-pie mr-2"></i>Lihat Hasil
                    </a>
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <img src="{{ asset('images/hero-image.png') }}" alt="Pilketos" class="max-w-xs md:max-w-md object-contain">
            </div>
        </div>
    </section>

    {{-- Stats & Results --}}
    <section id="hasil" class="mx-auto px-4 md:px-8 lg:px-24 py-8">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-check-to-slot text-teal-500 text-3xl"></i>
                    <div>
                        <div class="text-3xl font-bold text-slate-800">{{ $totalSuara }}</div>
                        <div class="text-slate-500">Total Suara</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-users text-teal-500 text-3xl"></i>
                    <div>
                        <div class="text-3xl font-bold text-slate-800">{{ count($kandidat) }}</div>
                        <div class="text-slate-500">Kandidat</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-trophy text-yellow-500 text-3xl"></i>
                    <div>
                        <div class="text-xl font-bold text-slate-800">
                            {{ $totalSuara > 0 ? $kandidat->sortByDesc('jumlah_suara')->first()->nama : '-' }}</div>
                        <div class="text-slate-500">Peringkat 1</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kandidat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($kandidat->sortBy('nomor_urut') as $index => $k)
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 hover:shadow-lg transition">
                    <div class="relative aspect-square bg-teal-100 overflow-hidden">
                        @if ($k->foto)
                            <img src="{{ $k->foto_url }}" class="w-full h-full object-cover" alt="{{ $k->nama }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fa-solid fa-user text-6xl text-teal-300"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white text-slate-700 text-lg font-bold">
                                {{ $index + 1 }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $k->nama }}</h3>
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-teal-600">{{ $k->jumlah_suara }}</span>
                                <span class="text-slate-500">suara</span>
                            </div>
                            <span class="text-lg font-semibold text-teal-500">{{ $k->persentase }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2.5">
                            <div class="bg-teal-500 h-2.5 rounded-full" style="width: {{ $k->persentase }}%"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200">
                    <i class="fa-solid fa-user-slash text-5xl text-slate-300 mb-4"></i>
                    <p class="text-slate-400 text-lg">Belum ada kandidat terdaftar</p>
                </div>
            @endforelse
        </div>

        {{-- Chart Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    <i class="fa-solid fa-chart-pie text-teal-500 mr-2"></i>Grafik Perolehan Suara
                </h2>
                <div class="h-80">
                    <canvas id="chart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    <i class="fa-solid fa-user-group text-teal-500 mr-2"></i>Daftar Kandidat
                </h2>
                <div class="space-y-4">
                    @forelse($kandidat->sortByDesc('jumlah_suara') as $index => $k)
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $index === 0 && $totalSuara > 0 ? 'bg-yellow-400 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="w-12 h-12 rounded-full bg-teal-100 overflow-hidden">
                                @if ($k->foto)
                                    <img src="{{ $k->foto_url }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-teal-400">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-800">{{ $k->nama }}</h3>
                                <div class="text-sm text-slate-500">{{ $k->jumlah_suara }} suara • {{ $k->persentase }}%
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-12">
                            <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                            <p>Belum ada kandidat</p>
                        </div>
                    @endforelse
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
