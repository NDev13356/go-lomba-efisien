@extends('layouts.admin')

@section('title', 'Kelola Kandidat')
@section('subtitle', 'Tambah, edit, dan hapus kandidat')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.kandidat.create') }}" class="bg-teal-500 text-white px-5 py-3 rounded-xl hover:bg-teal-600">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Kandidat
        </a>
        <span class="text-sm text-slate-400">Total: <b class="text-slate-700">{{ count($kandidat) }}</b></span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Foto</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Suara</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($kandidat as $k)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="w-14 h-14 rounded-xl bg-teal-100 overflow-hidden">
                                @if ($k->foto)
                                    <img src="{{ asset('storage/kandidat/' . $k->foto) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-teal-400">
                                        <i class="fa-solid fa-user text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $k->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-teal-100 text-teal-600 px-3 py-1 rounded-lg font-semibold">
                                {{ $k->jumlah_suara }} suara
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.kandidat.edit', $k->id_kandidat) }}"
                                    class="p-2 text-teal-500 hover:bg-teal-50 rounded-lg">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.kandidat.destroy', $k->id_kandidat) }}" method="POST"
                                    onsubmit="return confirm('Hapus kandidat ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                            <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                            <p>Belum ada kandidat</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
