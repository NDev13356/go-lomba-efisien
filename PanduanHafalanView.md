# 📚 Panduan Hafalan View & Kode - Pilketos

## 🎯 Bagian 1: Hafalan Syntax Blade

### Template Dasar (WAJIB HAFAL!)

```blade
{{-- 1. EXTEND LAYOUT --}}
@extends('layouts.admin')    {{-- Halaman admin --}}
@extends('layouts.app')      {{-- Halaman umum --}}

{{-- 2. SECTION JUDUL --}}
@section('title', 'Judul Halaman')

{{-- 3. KONTEN --}}
@section('content')
    {{-- isi konten di sini --}}
@endsection
```

### Jembatan Keledai: **"ESC"** = Extends → Section → Content

---

## � Blade Directive Utama

### Tabel Hafalan Cepat

| Directive                     | Fungsi             | Ingat Dengan                        |
| ----------------------------- | ------------------ | ----------------------------------- |
| `{{ $var }}`                  | Tampilkan data     | Kurung kurawal = **Keluarkan** data |
| `{{-- komentar --}}`          | Komentar           | Dua strip = **Sembunyi**            |
| `@if @else @endif`            | Kondisi            | **Kalau-Lain-Selesai**              |
| `@foreach @endforeach`        | Looping            | **Untuk setiap-Selesai**            |
| `@forelse @empty @endforelse` | Loop + Empty state | **Foreach** + **Kosong**            |
| `@csrf`                       | Token keamanan     | **Cross Site Request Forgery**      |
| `@method('PUT')`              | Fake method        | **PUT/DELETE** untuk form           |
| `@error @enderror`            | Pesan error        | Tampilkan **kesalahan**             |

---

## 📝 Pola Kode Form (CRUD)

### Struktur Form Universal

```blade
{{-- POLA FORM: Ingat "FAM" = Form-Action-Method --}}
<form action="{{ route('admin.entitas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($edit) @method('PUT') @endif

    {{-- INPUT FIELD --}}
    <input type="text" name="nama" value="{{ old('nama', $data->nama ?? '') }}">

    {{-- ERROR --}}
    @error('nama')
        <p class="text-red-500">{{ $message }}</p>
    @enderror

    <button type="submit">Simpan</button>
</form>
```

### Jembatan Keledai Form: **"FAM-CIO"**

- **F**orm action route
- **A**ction = store/update
- **M**ethod = POST
- **C**SRF token
- **I**nput dengan old()
- **O**ld error handling

---

## 📊 Pola Halaman Index (Daftar/Tabel)

```blade
{{-- POLA INDEX: Ingat "TAF" = Tabel-Aksi-Forelse --}}

{{-- 1. TOMBOL TAMBAH --}}
<a href="{{ route('admin.entitas.create') }}">
    <i class="fa-solid fa-plus"></i> Tambah
</a>

{{-- 2. TABEL --}}
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>
                    {{-- Edit --}}
                    <a href="{{ route('admin.entitas.edit', $item->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    {{-- Hapus --}}
                    <form action="{{ route('admin.entitas.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
```

### Jembatan Keledai Index: **"TAF-EH"**

- **T**ombol tambah
- **A**mbil data loop
- **F**orelse untuk data
- **E**dit link
- **H**apus form

---

## 🎨 Hafalan Tailwind CSS

### Pola Warna (Tema Biru-Teal)

| Elemen       | Class                                                 | Ingat Dengan               |
| ------------ | ----------------------------------------------------- | -------------------------- |
| Tombol utama | `bg-linear-to-r from-blue-500 to-teal-500 text-white` | **Gradien Biru-Teal**      |
| Tombol edit  | `text-teal-500 hover:bg-teal-50`                      | **Hijau untuk hijau (go)** |
| Tombol hapus | `text-red-500 hover:bg-red-50`                        | **Merah untuk bahaya**     |
| Background   | `bg-slate-50` atau `bg-white`                         | **Abu terang**             |
| Border       | `border border-slate-200`                             | **Garis halus**            |

### Layout Cepat

| Tujuan             | Class                           | Singkatan                   |
| ------------------ | ------------------------------- | --------------------------- |
| Flexbox horizontal | `flex items-center gap-2`       | **FIG** = Flex-Items-Gap    |
| Grid 3 kolom       | `grid grid-cols-3 gap-4`        | **GGG** = Grid-GridCols-Gap |
| Padding all        | `p-4` atau `px-6 py-4`          | **P** = Padding             |
| Margin all         | `m-4` atau `mb-6`               | **M** = Margin              |
| Rounded            | `rounded-xl` atau `rounded-2xl` | **R** = Rounded             |
| Shadow             | `shadow-sm` atau `shadow-lg`    | **S** = Shadow              |

### Pola Card/Container

```html
<!-- POLA CARD: "BWR-PS" = Bg-White-Rounded-Padding-Shadow -->
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
    <!-- konten -->
</div>
```

---

## � Pola Route & Asset

### Route Helper

```blade
{{-- INGAT: route('nama.route') --}}
route('admin.kandidat.index')    {{-- Daftar --}}
route('admin.kandidat.create')   {{-- Form tambah --}}
route('admin.kandidat.store')    {{-- Simpan baru --}}
route('admin.kandidat.edit', $id)   {{-- Form edit --}}
route('admin.kandidat.update', $id) {{-- Update data --}}
route('admin.kandidat.destroy', $id){{-- Hapus data --}}
```

### Jembatan Keledai Route: **"ICSEUD"**

- **I**ndex = daftar
- **C**reate = form tambah
- **S**tore = simpan baru
- **E**dit = form edit
- **U**pdate = simpan edit
- **D**estroy = hapus

### Asset & Storage

```blade
{{-- Asset statis (public/) --}}
{{ asset('js/chart.min.js') }}
{{ asset('images/logo.png') }}

{{-- Storage (storage/app/public/) --}}
{{ asset('storage/kandidat/' . $k->foto) }}
```

---

## 🎯 Pola Login Page

```blade
{{-- POLA LOGIN: "FEL" = Form-Error-Link --}}

{{-- 1. ERROR MESSAGE --}}
@if ($errors->any())
    <div class="bg-red-50 text-red-600">
        {{ $errors->first() }}
    </div>
@endif

{{-- 2. FORM --}}
<form action="{{ route('siswa.login.post') }}" method="POST">
    @csrf
    <input type="text" name="nisn" value="{{ old('nisn') }}">
    <input type="password" name="password">
    <button type="submit">Masuk</button>
</form>

{{-- 3. KEMBALI --}}
<a href="{{ route('public.index') }}">Kembali</a>
```

---

## 🧩 FontAwesome Icons Umum

| Icon | Class                            | Fungsi      |
| ---- | -------------------------------- | ----------- |
| ➕   | `fa-solid fa-plus`               | Tambah      |
| ✏️   | `fa-solid fa-pen-to-square`      | Edit        |
| 🗑️   | `fa-solid fa-trash`              | Hapus       |
| 👤   | `fa-solid fa-user`               | User/Profil |
| 🔐   | `fa-solid fa-lock`               | Password    |
| 📧   | `fa-solid fa-envelope`           | Email       |
| ✅   | `fa-solid fa-check`              | Sukses      |
| ❌   | `fa-solid fa-xmark`              | Tutup/Batal |
| 🗳️   | `fa-solid fa-check-to-slot`      | Voting      |
| ↩️   | `fa-solid fa-arrow-left`         | Kembali     |
| 🚪   | `fa-solid fa-right-from-bracket` | Logout      |

---

## ⚡ Cheatsheet Kilat

### Template Index (Copy-Paste)

```blade
@extends('layouts.admin')
@section('title', 'Kelola [Entitas]')
@section('content')
    <a href="{{ route('admin.[entitas].create') }}">Tambah</a>
    <table>
        @forelse ($data as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>
                    <a href="{{ route('admin.[entitas].edit', $item->id) }}">Edit</a>
                    <form action="{{ route('admin.[entitas].destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button>Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td>Kosong</td></tr>
        @endforelse
    </table>
@endsection
```

### Template Form (Copy-Paste)

```blade
@extends('layouts.admin')
@section('title', $data ? 'Edit' : 'Tambah')
@section('content')
    <form action="{{ $data ? route('admin.[entitas].update', $data->id) : route('admin.[entitas].store') }}" method="POST">
        @csrf
        @if($data) @method('PUT') @endif

        <input name="nama" value="{{ old('nama', $data->nama ?? '') }}">
        @error('nama') <span>{{ $message }}</span> @enderror

        <button>{{ $data ? 'Simpan' : 'Tambah' }}</button>
    </form>
@endsection
```

---

## 📌 Ringkasan Mnemonik

| Untuk         | Mnemonic    | Arti                                   |
| ------------- | ----------- | -------------------------------------- |
| Struktur View | **ESC**     | Extends-Section-Content                |
| Pola Form     | **FAM-CIO** | Form-Action-Method-Csrf-Input-Old      |
| Pola Index    | **TAF-EH**  | Tombol-Ambil-Forelse-Edit-Hapus        |
| Pola Card     | **BWR-PS**  | Bg-White-Rounded-Padding-Shadow        |
| Route CRUD    | **ICSEUD**  | Index-Create-Store-Edit-Update-Destroy |
| Flexbox       | **FIG**     | Flex-Items-Gap                         |

---

**💡 Tips Utama:**

1. **Ketik berulang-ulang** - Praktek langsung lebih efektif dari membaca
2. **Fokus pada pola** - Semua halaman CRUD punya struktur mirip
3. **Gunakan snippet** - Save template yang sering dipakai
4. **Pahami konsep** - Jangan hanya hafal, pahami fungsinya
