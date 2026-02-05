@extends('layouts.app')

@section('title', 'Voting')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        {{-- Voting --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="text-center mb-8">
                    <i class="fa-solid fa-check-to-slot text-primary text-4xl mb-4"></i>
                    <h2 class="text-2xl font-bold">Pilih Kandidat</h2>
                    <p class="text-base-content/60 mt-1">Pilih satu kandidat. Suara tidak dapat diubah.</p>
                </div>

                <form action="{{ route('siswa.vote') }}" method="POST" id="formVote">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        @foreach ($kandidat as $k)
                            <label class="cursor-pointer">
                                <input type="radio" name="id_kandidat" value="{{ $k->id_kandidat }}" class="peer hidden"
                                    required>
                                <div
                                    class="card bg-base-200 border-2 border-base-300 peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50 transition-all">
                                    <div class="card-body items-center text-center">
                                        <div class="avatar">
                                            <div class="w-20 rounded-full bg-primary/10">
                                                @if ($k->foto)
                                                    <img src="{{ asset('storage/kandidat/' . $k->foto) }}"
                                                        alt="{{ $k->nama }}">
                                                @else
                                                    <div
                                                        class="flex items-center justify-center w-full h-full text-primary/40 text-2xl">
                                                        <i class="fa-solid fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <h3 class="font-bold mt-2">{{ $k->nama }}</h3>
                                        <div class="badge badge-primary opacity-0 peer-checked:opacity-100">
                                            <i class="fa-solid fa-circle-check mr-1"></i>Dipilih
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <button type="button" onclick="confirmVote()" class="btn btn-primary w-full">
                        <i class="fa-solid fa-paper-plane"></i>Kirim Suara
                    </button>
                </form>
            </div>
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
