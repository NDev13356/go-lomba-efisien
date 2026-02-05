@extends('layouts.admin')

@section('title', $admin ? 'Edit Admin' : 'Tambah Admin')
@section('subtitle', $admin ? 'Perbarui data admin' : 'Daftarkan admin baru')

@section('content')
    <a href="{{ route('admin.admin.index') }}" class="btn btn-ghost btn-sm mb-6">
        <i class="fa-solid fa-arrow-left"></i>Kembali
    </a>

    <div class="card bg-base-100 shadow-xl max-w-xl">
        <div class="card-body">
            <form action="{{ $admin ? route('admin.admin.update', $admin->id) : route('admin.admin.store') }}" method="POST">
                @csrf
                @if ($admin)
                    @method('PUT')
                @endif

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold">Username</span></label>
                    <input type="text" name="username" value="{{ old('username', $admin->username ?? '') }}" required
                        class="input input-bordered" placeholder="Username">
                    @error('username')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold">Password
                            {{ $admin ? '(kosongkan jika tidak diubah)' : '' }}</span>
                    </label>
                    <input type="password" name="password" {{ $admin ? '' : 'required' }} class="input input-bordered"
                        placeholder="Password">
                    @error('password')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    <i class="fa-solid fa-{{ $admin ? 'floppy-disk' : 'plus' }}"></i>
                    {{ $admin ? 'Simpan' : 'Tambah' }}
                </button>
            </form>
        </div>
    </div>
@endsection
