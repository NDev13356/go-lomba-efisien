@extends('layouts.app')

@section('title', 'REST API Dokumentasi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        {{-- Header --}}
        <div class="text-center mb-10">
            <i class="fa-solid fa-code text-teal-500 text-4xl mb-4"></i>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">REST API Pilketos</h1>
            <p class="text-slate-500">Dokumentasi endpoint API</p>
        </div>

        {{-- Base URL --}}
        <div class="bg-teal-500 rounded-2xl p-6 text-white mb-6">
            <p class="text-white/80 text-sm">Base URL</p>
            <code class="bg-white/20 px-3 py-1 rounded text-lg">{{ url('/api') }}</code>
        </div>

        {{-- Endpoints --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 mb-6">
            <h2 class="font-bold text-slate-800 mb-4">
                <i class="fa-solid fa-list text-teal-500 mr-2"></i>Endpoints
            </h2>
            <div class="space-y-4">
                <div class="border border-slate-200 rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-lg text-sm font-bold">GET</span>
                        <code class="text-slate-700 font-mono">/api/kandidat</code>
                        <a href="{{ route('api.kandidat') }}" target="_blank"
                            class="ml-auto bg-teal-100 text-teal-600 px-4 py-2 rounded-lg text-sm">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>Test
                        </a>
                    </div>
                    <p class="text-slate-500">Daftar semua kandidat</p>
                </div>

                <div class="border border-slate-200 rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-lg text-sm font-bold">GET</span>
                        <code class="text-slate-700 font-mono">/api/hasil</code>
                        <a href="{{ route('api.hasil') }}" target="_blank"
                            class="ml-auto bg-teal-100 text-teal-600 px-4 py-2 rounded-lg text-sm">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>Test
                        </a>
                    </div>
                    <p class="text-slate-500">Hasil voting (total suara & persentase)</p>
                </div>
            </div>
        </div>

        {{-- Example Response --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200 mb-6">
            <h2 class="font-bold text-slate-800 mb-4">
                <i class="fa-solid fa-code text-teal-500 mr-2"></i>Contoh Response
            </h2>
            <div class="bg-slate-900 rounded-xl p-4 overflow-x-auto">
                <pre class="text-sm text-emerald-400"><code>{
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

        {{-- Back --}}
        <div class="text-center">
            <a href="{{ route('public.index') }}" class="text-slate-500 hover:text-teal-500">
                <i class="fa-solid fa-arrow-left mr-1"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
