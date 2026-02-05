@extends('layouts.admin')

@section('title', $siswa ? 'Edit Siswa' : 'Tambah Siswa')
@section('subtitle', $siswa ? 'Perbarui data siswa' : 'Daftarkan siswa baru')

@section('content')
    <a href="{{ route('admin.siswa.index') }}" class="text-slate-500 hover:text-teal-500 mb-6 inline-block">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
    </a>

    <div class="bg-white rounded-2xl p-8 border border-slate-200 max-w-xl">
        <form action="{{ $siswa ? route('admin.siswa.update', $siswa->nisn) : route('admin.siswa.store') }}" method="POST">
            @csrf
            @if ($siswa)
                @method('PUT')
            @endif

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" required
                    {{ $siswa ? 'readonly' : '' }}
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 {{ $siswa ? 'bg-slate-50' : '' }}"
                    placeholder="NISN">
                @error('nisn')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $siswa->nama ?? '') }}" required
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
                    placeholder="Nama lengkap">
                @error('nama')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Password {{ $siswa ? '(kosongkan jika tidak diubah)' : '' }}
                </label>
                <input type="password" name="password" {{ $siswa ? '' : 'required' }}
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
                    placeholder="Password">
                @error('password')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-teal-500 text-white py-4 rounded-xl font-semibold hover:bg-teal-600">
                <i class="fa-solid fa-{{ $siswa ? 'floppy-disk' : 'plus' }} mr-2"></i>{{ $siswa ? 'Simpan' : 'Tambah' }}
            </button>
        </form>
    </div>
@endsection
