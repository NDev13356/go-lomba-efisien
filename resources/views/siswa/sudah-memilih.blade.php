@extends('layouts.app')

@section('title', 'Selesai')

@section('content')
    <div class="max-w-md mx-auto px-4 py-12 text-center">
        <div class="bg-white rounded-2xl p-8 border border-slate-200">
            <i class="fa-solid fa-circle-check text-emerald-500 text-5xl mb-6"></i>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Terima Kasih!</h1>
            <p class="text-slate-500 mb-8">Suara Anda telah berhasil tercatat.</p>

            <div class="bg-teal-50 rounded-xl p-6 mb-8">
                <p class="text-sm text-slate-500 mb-3">Anda telah memilih:</p>
                <div class="flex items-center justify-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-teal-100 overflow-hidden">
                        @if ($vote->kandidat->foto)
                            <img src="{{ asset('storage/kandidat/' . $vote->kandidat->foto) }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-teal-400">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-teal-600 text-lg">{{ $vote->kandidat->nama }}</p>
                        <p class="text-slate-400 text-sm">
                            <i class="fa-solid fa-clock mr-1"></i>{{ $vote->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('public.index') }}"
                    class="flex-1 bg-teal-500 text-white py-3 rounded-xl hover:bg-teal-600">
                    <i class="fa-solid fa-chart-pie mr-1"></i>Lihat Hasil
                </a>
                <form action="{{ route('siswa.logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button class="w-full bg-slate-100 text-slate-700 py-3 rounded-xl hover:bg-slate-200">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
