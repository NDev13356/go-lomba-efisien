@extends('layouts.admin')

@section('title', $admin ? 'Edit Admin' : 'Tambah Admin')
@section('subtitle', $admin ? 'Perbarui data admin' : 'Daftarkan admin baru')

@section('content')
    <a href="{{ route('admin.admin.index') }}" class="text-slate-500 hover:text-teal-500 mb-6 inline-block">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
    </a>

    <div class="bg-white rounded-2xl p-8 border border-slate-200 max-w-xl">
        <form action="{{ $admin ? route('admin.admin.update', $admin->id) : route('admin.admin.store') }}" method="POST">
            @csrf
            @if ($admin)
                @method('PUT')
            @endif

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $admin->username ?? '') }}" required
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
                    placeholder="Username">
                @error('username')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Password {{ $admin ? '(kosongkan jika tidak diubah)' : '' }}
                </label>
                <input type="password" name="password" {{ $admin ? '' : 'required' }}
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
                    placeholder="Password">
                @error('password')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-teal-500 text-white py-4 rounded-xl font-semibold hover:bg-teal-600">
                <i class="fa-solid fa-{{ $admin ? 'floppy-disk' : 'plus' }} mr-2"></i>{{ $admin ? 'Simpan' : 'Tambah' }}
            </button>
        </form>
    </div>
@endsection
