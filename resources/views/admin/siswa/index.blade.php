@extends('layouts.admin')

@section('title', 'Kelola Siswa')
@section('subtitle', 'Tambah, edit, dan hapus data siswa')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.siswa.create') }}" class="bg-teal-500 text-white px-5 py-3 rounded-xl hover:bg-teal-600">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Siswa
        </a>
        <span class="text-sm text-slate-400">Total: <b class="text-slate-700">{{ count($siswa) }}</b></span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">NISN</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($siswa as $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <span
                                class="font-mono text-slate-600 bg-slate-100 px-3 py-1 rounded-lg">{{ $s->nisn }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $s->nama }}</td>
                        <td class="px-6 py-4">
                            @if ($s->pemilihan && $s->pemilihan->count() > 0)
                                <span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-circle-check mr-1"></i>Sudah voting
                                </span>
                            @else
                                <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-lg text-sm">
                                    <i class="fa-solid fa-clock mr-1"></i>Belum voting
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.siswa.edit', $s->nisn) }}"
                                    class="p-2 text-teal-500 hover:bg-teal-50 rounded-lg">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $s->nisn) }}" method="POST"
                                    onsubmit="return confirm('Hapus siswa ini?')">
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
                            <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                            <p>Belum ada siswa</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
