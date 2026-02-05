@extends('layouts.admin')

@section('title', 'Kelola Kandidat')
@section('subtitle', 'Tambah, edit, dan hapus kandidat')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.kandidat.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>Tambah Kandidat
        </a>
        <span class="text-sm text-base-content/60">Total: <b>{{ count($kandidat) }}</b></span>
    </div>

    <div class="card bg-base-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Suara</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kandidat as $k)
                        <tr class="hover">
                            <td>
                                <div class="avatar">
                                    <div class="w-14 rounded-xl bg-primary/10">
                                        @if ($k->foto)
                                            <img src="{{ asset('storage/kandidat/' . $k->foto) }}"
                                                alt="{{ $k->nama }}">
                                        @else
                                            <div class="flex items-center justify-center w-full h-full text-primary/40">
                                                <i class="fa-solid fa-user text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="font-semibold">{{ $k->nama }}</td>
                            <td>
                                <div class="badge badge-primary">{{ $k->jumlah_suara }} suara</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.kandidat.edit', $k->id_kandidat) }}"
                                        class="btn btn-ghost btn-sm text-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.kandidat.destroy', $k->id_kandidat) }}" method="POST"
                                        onsubmit="return confirm('Hapus kandidat ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-ghost btn-sm text-error">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-base-content/60">
                                <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                                <p>Belum ada kandidat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
