@extends('layouts.app')

@section('title', 'Voting')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-user text-teal-500 text-2xl"></i>
                    <div>
                        <h1 class="font-bold text-slate-800">{{ $siswa->nama }}</h1>
                        <p class="text-slate-500 text-sm">NISN: {{ $siswa->nisn }}</p>
                    </div>
                </div>
                <form action="{{ route('siswa.logout') }}" method="POST">
                    @csrf
                    <button class="text-red-500 hover:bg-red-50 px-4 py-2 rounded-lg">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- Voting --}}
        <div class="bg-white rounded-2xl p-8 border border-slate-200">
            <div class="text-center mb-8">
                <i class="fa-solid fa-check-to-slot text-teal-500 text-4xl mb-4"></i>
                <h2 class="text-2xl font-bold text-slate-800">Pilih Kandidat</h2>
                <p class="text-slate-500 mt-1">Pilih satu kandidat. Suara tidak dapat diubah.</p>
            </div>

            <form action="{{ route('siswa.vote') }}" method="POST" id="formVote">
                @csrf
                <div class="grid grid-cols-3 gap-6 mb-8">
                    @foreach ($kandidat as $k)
                        <label class="cursor-pointer group">
                            <input type="radio" name="id_kandidat" value="{{ $k->id_kandidat }}" class="peer hidden"
                                required>
                            <div
                                class="p-4 bg-slate-50 border-2 border-slate-200 rounded-2xl peer-checked:border-teal-500 peer-checked:bg-teal-50 hover:border-teal-300 text-center">
                                <div class="w-20 h-20 mx-auto rounded-full bg-teal-100 mb-4 overflow-hidden">
                                    @if ($k->foto)
                                        <img src="{{ asset('storage/kandidat/' . $k->foto) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-teal-400 text-2xl">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-slate-800 mb-2">{{ $k->nama }}</h3>
                                <div class="opacity-0 peer-checked:opacity-100">
                                    <span class="bg-teal-500 text-white px-3 py-1 rounded-full text-sm">
                                        <i class="fa-solid fa-circle-check mr-1"></i>Dipilih
                                    </span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <button type="button" onclick="confirmVote()"
                    class="w-full bg-teal-500 text-white py-4 rounded-xl font-medium hover:bg-teal-600">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Kirim Suara
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmVote() {
                if (!document.querySelector('input[name="id_kandidat"]:checked')) {
                    alert('Pilih kandidat terlebih dahulu!');
                    return;
                }
                if (confirm('Yakin dengan pilihan Anda? Suara tidak dapat diubah.')) {
                    document.getElementById('formVote').submit();
                }
            }
        </script>
    @endpush
@endsection
