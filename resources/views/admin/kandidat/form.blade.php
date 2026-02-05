@extends('layouts.admin')

@section('title', $kandidat ? 'Edit Kandidat' : 'Tambah Kandidat')
@section('subtitle', $kandidat ? 'Perbarui data kandidat' : 'Daftarkan kandidat baru')

@section('content')
    <a href="{{ route('admin.kandidat.index') }}" class="btn btn-ghost btn-sm mb-6">
        <i class="fa-solid fa-arrow-left"></i>Kembali
    </a>

    <div class="card bg-base-100 shadow-xl max-w-xl">
        <div class="card-body">
            <form
                action="{{ $kandidat ? route('admin.kandidat.update', $kandidat->id_kandidat) : route('admin.kandidat.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($kandidat)
                    @method('PUT')
                @endif

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text font-semibold">Nama Kandidat</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $kandidat->nama ?? '') }}" required
                        class="input input-bordered" placeholder="Nama lengkap">
                    @error('nama')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control mb-6">
                    <label class="label"><span class="label-text font-semibold">Foto Kandidat</span></label>
                    @if ($kandidat && $kandidat->foto)
                        <div class="flex items-center gap-4 mb-3">
                            <div class="avatar">
                                <div class="w-20 rounded-xl">
                                    <img src="{{ asset('storage/kandidat/' . $kandidat->foto) }}" alt="Foto saat ini">
                                </div>
                            </div>
                            <span class="text-base-content/60 text-sm">Foto saat ini</span>
                        </div>
                    @endif
                    <input type="file" name="foto" accept="image/*" class="file-input file-input-bordered w-full">
                    @error('foto')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    <i class="fa-solid fa-{{ $kandidat ? 'floppy-disk' : 'plus' }}"></i>
                    {{ $kandidat ? 'Simpan' : 'Tambah' }}
                </button>
            </form>
        </div>
    </div>
@endsection
