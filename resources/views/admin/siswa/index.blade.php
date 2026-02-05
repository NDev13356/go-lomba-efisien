@extends('layouts.admin')

@section('title', 'Kelola Siswa')
@section('subtitle', 'Tambah, edit, dan hapus data siswa')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>Tambah Siswa
        </a>
        <span class="text-sm text-base-content/60">Total: <b>{{ count($siswa) }}</b></span>
    </div>

    <div class="card bg-base-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $s)
                        <tr class="hover">
                            <td><kbd class="kbd kbd-sm">{{ $s->nisn }}</kbd></td>
                            <td class="font-semibold">{{ $s->nama }}</td>
                            <td>
                                @if ($s->pemilihan && $s->pemilihan->count() > 0)
                                    <div class="badge badge-success gap-1">
                                        <i class="fa-solid fa-circle-check"></i>Sudah voting
                                    </div>
                                @else
                                    <div class="badge badge-ghost gap-1">
                                        <i class="fa-solid fa-clock"></i>Belum voting
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.siswa.edit', $s->nisn) }}"
                                        class="btn btn-ghost btn-sm text-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $s->nisn) }}" method="POST"
                                        onsubmit="return confirm('Hapus siswa ini?')">
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
                                <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                                <p>Belum ada siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
