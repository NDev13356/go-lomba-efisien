@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('subtitle', 'Kelola akun administrator')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.admin.create') }}" class="bg-teal-500 text-white px-5 py-3 rounded-xl hover:bg-teal-600">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Admin
        </a>
        <span class="text-sm text-slate-400">Total: <b class="text-slate-700">{{ count($admins) }}</b></span>
    </div>

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">No</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Username</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($admins as $index => $a)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-slate-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $a->username }}</td>
                        <td class="px-6 py-4">
                            @if (session('admin_id') == $a->id)
                                <span
                                    class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full text-xs font-medium">Aktif
                                    (Anda)</span>
                            @else
                                <span
                                    class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-xs font-medium">Admin</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.admin.edit', $a->id) }}"
                                    class="p-2 text-teal-500 hover:bg-teal-50 rounded-lg">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if (session('admin_id') != $a->id)
                                    <form action="{{ route('admin.admin.destroy', $a->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus admin ini?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                            <p>Belum ada admin</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
