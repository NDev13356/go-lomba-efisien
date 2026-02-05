@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('subtitle', 'Kelola akun administrator')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.admin.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>Tambah Admin
        </a>
        <span class="text-sm text-base-content/60">Total: <b>{{ count($admins) }}</b></span>
    </div>

    @if (session('error'))
        <div role="alert" class="alert alert-error mb-6">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $index => $a)
                        <tr class="hover">
                            <td>{{ $index + 1 }}</td>
                            <td class="font-semibold">{{ $a->username }}</td>
                            <td>
                                @if (session('admin_id') == $a->id)
                                    <div class="badge badge-success gap-1">Aktif (Anda)</div>
                                @else
                                    <div class="badge badge-ghost">Admin</div>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.admin.edit', $a->id) }}"
                                        class="btn btn-ghost btn-sm text-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if (session('admin_id') != $a->id)
                                        <form action="{{ route('admin.admin.destroy', $a->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus admin ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-ghost btn-sm text-error">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-base-content/60">
                                <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                                <p>Belum ada admin</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
