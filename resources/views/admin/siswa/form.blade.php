@extends('layouts.admin')

@section('title', $siswa ? 'Edit Siswa' : 'Tambah Siswa')
@section('subtitle', $siswa ? 'Perbarui data siswa' : 'Daftarkan siswa baru')

@section('content')
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-ghost btn-sm mb-6">
        <i class="fa-solid fa-arrow-left"></i>Kembali
    </a>

    <div class="card bg-base-100 shadow-xl max-w-xl">
        <div class="card-body">
            <form action="{{ $siswa ? route('admin.siswa.update', $siswa->nisn) : route('admin.siswa.store') }}" method="POST">
                @csrf
                @if ($siswa) @method('PUT') @endif

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold">NISN</span></label>
                    <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" required
                        {{ $siswa ? 'readonly' : '' }}
                        class="input input-bordered {{ $siswa ? 'input-disabled' : '' }}" placeholder="NISN">
                    @error('nisn')<p class="text-error text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $siswa->nama ?? '') }}" required
                        class="input input-bordered" placeholder="Nama lengkap">
                    @error('nama')<p class="text-error text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold">Password {{ $siswa ? '(kosongkan jika tidak diubah)' : '' }}</span>
                    </label>
                    <input type="password" name="password" {{ $siswa ? '' : 'required' }}
                        class="input input-bordered" placeholder="Password">
                    @error('password')<p class="text-error text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    <i class="fa-solid fa-{{ $siswa ? 'floppy-disk' : 'plus' }}"></i>
                    {{ $siswa ? 'Simpan' : 'Tambah' }}
                </button>
            </form>
        </div>
    </div>
@endsection
