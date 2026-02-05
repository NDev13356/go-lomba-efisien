@extends('layouts.admin')

@section('title', $kandidat ? 'Edit Kandidat' : 'Tambah Kandidat')
@section('subtitle', $kandidat ? 'Perbarui data kandidat' : 'Daftarkan kandidat baru')

@section('content')
    <a href="{{ route('admin.kandidat.index') }}" class="text-slate-500 hover:text-teal-500 mb-6 inline-block">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
    </a>

    <div class="bg-white rounded-2xl p-8 border border-slate-200 max-w-xl">
        <form
            action="{{ $kandidat ? route('admin.kandidat.update', $kandidat->id_kandidat) : route('admin.kandidat.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if ($kandidat)
                @method('PUT')
            @endif

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kandidat</label>
                <input type="text" name="nama" value="{{ old('nama', $kandidat->nama ?? '') }}" required
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
                    placeholder="Nama lengkap">
                @error('nama')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Kandidat</label>
                @if ($kandidat && $kandidat->foto)
                    <div class="mb-4 flex items-center gap-4">
                        <img src="{{ asset('storage/kandidat/' . $kandidat->foto) }}"
                            class="w-20 h-20 rounded-xl object-cover">
                        <span class="text-slate-400 text-sm">Foto saat ini</span>
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*"
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-100 file:text-teal-600">
                @error('foto')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-teal-500 text-white py-4 rounded-xl font-semibold hover:bg-teal-600">
                <i
                    class="fa-solid fa-{{ $kandidat ? 'floppy-disk' : 'plus' }} mr-2"></i>{{ $kandidat ? 'Simpan' : 'Tambah' }}
            </button>
        </form>
    </div>
@endsection
