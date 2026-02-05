@extends('layouts.app')

@section('title', 'Selesai')

@section('content')
    <div class="max-w-md mx-auto px-4 py-12 text-center">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body items-center">
                <i class="fa-solid fa-circle-check text-success text-5xl mb-4"></i>
                <h1 class="card-title text-2xl">Terima Kasih!</h1>
                <p class="text-base-content/60 text-sm">Suara Anda telah berhasil tercatat.</p>

                <div class="bg-primary/10 rounded-xl p-6 my-6 w-full">
                    <p class="text-sm text-base-content/60 mb-3">Anda telah memilih:</p>
                    <div class="flex items-center justify-center gap-4">
                        <div class="avatar">
                            <div class="w-14 rounded-full bg-primary/10">
                                @if ($vote->kandidat->foto)
                                    <img src="{{ asset('storage/kandidat/' . $vote->kandidat->foto) }}"
                                        alt="{{ $vote->kandidat->nama }}">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-primary/40">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-primary text-lg">{{ $vote->kandidat->nama }}</p>
                            <p class="text-base-content/60 text-sm">
                                <i class="fa-solid fa-clock mr-1"></i>{{ $vote->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 w-full">
                    <a href="{{ route('public.index') }}" class="btn btn-primary flex-1">
                        <i class="fa-solid fa-chart-pie"></i>Lihat Hasil
                    </a>
                    <form action="{{ route('siswa.logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button class="btn btn-ghost w-full">
                            <i class="fa-solid fa-right-from-bracket"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
