@extends('layouts.app')

@section('title', 'REST API Dokumentasi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        {{-- Header --}}
        <div class="text-center mb-10">
            <i class="fa-solid fa-code text-primary text-4xl mb-4"></i>
            <h1 class="text-3xl font-bold mb-2">REST API Pilketos</h1>
            <p class="text-base-content/60">Dokumentasi endpoint API</p>
        </div>

        {{-- Base URL --}}
        <div class="alert alert-info mb-6">
            <span class="text-sm opacity-80">Base URL</span>
            <kbd class="kbd">{{ url('/api') }}</kbd>
        </div>

        {{-- Endpoints --}}
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="fa-solid fa-list text-primary"></i>Endpoints
                </h2>
                <div class="space-y-4">
                    <div class="border border-base-300 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="badge badge-success">GET</div>
                            <kbd class="kbd kbd-sm">/api/kandidat</kbd>
                            <a href="{{ route('api.kandidat') }}" target="_blank" class="btn btn-ghost btn-sm ml-auto">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>Test
                            </a>
                        </div>
                        <p class="text-base-content/60">Daftar semua kandidat</p>
                    </div>

                    <div class="border border-base-300 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="badge badge-success">GET</div>
                            <kbd class="kbd kbd-sm">/api/hasil</kbd>
                            <a href="{{ route('api.hasil') }}" target="_blank" class="btn btn-ghost btn-sm ml-auto">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>Test
                            </a>
                        </div>
                        <p class="text-base-content/60">Hasil voting (total suara & persentase)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Example Response --}}
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="fa-solid fa-code text-primary"></i>Contoh Response
                </h2>
                <div class="mockup-code">
                    <pre><code>{
  "success": true,
  "data": [
    {
      "id_kandidat": 1,
      "nama": "Ahmad Fauzi",
      "jumlah_suara": 25,
      "persentase": 45.5
    }
  ],
  "total_suara": 55
}</code></pre>
                </div>
            </div>
        </div>

        {{-- Back --}}
        <div class="text-center">
            <a href="{{ route('public.index') }}" class="btn btn-ghost">
                <i class="fa-solid fa-arrow-left"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
