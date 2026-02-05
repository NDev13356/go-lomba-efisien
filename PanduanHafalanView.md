# 🧠 Panduan Hafalan View - Pilketos

> **Prinsip Utama:** Semua view itu **SAMA strukturnya**, hanya beda **isi konten**. Paham 1 = paham semua!

---

## 💡 INSIGHT #1: Semua Halaman Cuma 3 Baris Wajib

```blade
@extends('layouts.admin')              {{-- 1. PAKAI LAYOUT MANA? --}}
@section('title', 'Judul')             {{-- 2. JUDUL APA? --}}
@section('content') ... @endsection    {{-- 3. ISI APA? --}}
```

**Itu aja.** Semua halaman admin/siswa/public pakai pola ini. Gak percaya? Buka file manapun!

---

## 💡 INSIGHT #2: Card Itu Cuma 1 Class Pattern

Semua card di project ini:

```html
<div class="bg-white rounded-2xl p-6 border border-slate-200"></div>
```

**Hafal ini = bisa bikin card apapun:**

- `bg-white` = latar putih
- `rounded-2xl` = sudut bulat besar
- `p-6` = padding 1.5rem
- `border border-slate-200` = garis tipis abu

---

## 💡 INSIGHT #3: Tombol Cuma 2 Warna

| Jenis      | Class                                                           | Kapan Pakai            |
| ---------- | --------------------------------------------------------------- | ---------------------- |
| **Utama**  | `bg-teal-500 text-white hover:bg-teal-600 px-5 py-3 rounded-xl` | Tambah, Simpan, Submit |
| **Bahaya** | `text-red-500 hover:bg-red-50`                                  | Hapus, Logout          |

---

## 💡 INSIGHT #4: Input Form Selalu Sama

```html
<div class="mb-5">
    <label class="block text-sm font-semibold text-slate-700 mb-2">Label</label>
    <input
        type="text"
        name="nama"
        value="{{ old('nama', $data->nama ?? '') }}"
        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
    />
    @error('nama')
    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>
```

**Pattern inputnya:** `w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500`

---

## 💡 INSIGHT #5: Tabel Admin Selalu Pattern Ini

```html
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50 border-b">
            <tr>
                <th
                    class="px-6 py-4 text-left text-sm font-semibold text-slate-500"
                >
                    Header
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($data as $item)
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4">{{ $item->nama }}</td>
            </tr>
            @empty
            <tr>
                <td class="px-6 py-16 text-center text-slate-400">Kosong</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

---

## 💡 INSIGHT #6: Aksi Edit & Hapus Selalu Berdua

```html
<div class="flex items-center gap-2">
    {{-- EDIT: link biasa --}}
    <a
        href="{{ route('admin.xxx.edit', $item->id) }}"
        class="p-2 text-teal-500 hover:bg-teal-50 rounded-lg"
    >
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    {{-- HAPUS: form dengan DELETE method --}}
    <form
        action="{{ route('admin.xxx.destroy', $item->id) }}"
        method="POST"
        onsubmit="return confirm('Hapus?')"
    >
        @csrf @method('DELETE')
        <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</div>
```

**Kenapa hapus pakai form?** Karena HTTP DELETE butuh form, bukan link!

---

## 💡 INSIGHT #7: Form Create & Edit = 1 File, Beda Logic

```blade
{{-- JUDULNYA DINAMIS --}}
@section('title', $data ? 'Edit' : 'Tambah')

{{-- ACTIONNYA DINAMIS --}}
<form action="{{ $data ? route('admin.xxx.update', $data->id) : route('admin.xxx.store') }}" method="POST">
    @csrf
    @if($data) @method('PUT') @endif  {{-- EDIT pakai PUT --}}

    <input value="{{ old('nama', $data->nama ?? '') }}">  {{-- VALUE DINAMIS --}}

    <button>{{ $data ? 'Simpan' : 'Tambah' }}</button>  {{-- TEKS DINAMIS --}}
</form>
```

---

## 💡 INSIGHT #8: Badge Status = Warna + Icon

```html
{{-- SUKSES: Hijau --}}
<span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-lg text-sm">
    <i class="fa-solid fa-circle-check mr-1"></i>Sudah
</span>

{{-- PENDING: Abu --}}
<span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-lg text-sm">
    <i class="fa-solid fa-clock mr-1"></i>Belum
</span>
```

---

## 💡 INSIGHT #9: Alert Success = Emerald

```blade
@if (session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
    </div>
@endif
```

---

## 💡 INSIGHT #10: Empty State = Icon Besar + Teks

```html
<div class="text-center text-slate-400 py-16">
    <i class="fa-solid fa-inbox text-4xl mb-3"></i>
    <p>Tidak ada data</p>
</div>
```

---

## 📱 LAYOUT APP vs ADMIN

| Layout          | Untuk         | Fitur                               |
| --------------- | ------------- | ----------------------------------- |
| `layouts.app`   | Public, Siswa | Navbar horizontal, footer           |
| `layouts.admin` | Admin panel   | Sidebar kiri, header dengan tanggal |

---

## 🎨 WARNA YANG DIPAKAI

| Elemen    | Warna   | Class                                 |
| --------- | ------- | ------------------------------------- |
| Primary   | Teal    | `text-teal-500`, `bg-teal-500`        |
| Danger    | Red     | `text-red-500`, `bg-red-500`          |
| Success   | Emerald | `text-emerald-600`, `bg-emerald-50`   |
| Netral    | Slate   | `text-slate-500`, `bg-slate-50`       |
| Highlight | Yellow  | `text-yellow-500` (trophy, peringkat) |

---

## 🔤 ICON YANG SERING DIPAKAI

| Fungsi  | Icon                           |
| ------- | ------------------------------ |
| Tambah  | `fa-plus`                      |
| Edit    | `fa-pen-to-square`             |
| Hapus   | `fa-trash`                     |
| Kembali | `fa-arrow-left`                |
| Logout  | `fa-right-from-bracket`        |
| User    | `fa-user`                      |
| Voting  | `fa-check-to-slot`             |
| Sukses  | `fa-circle-check`              |
| Chart   | `fa-chart-bar`, `fa-chart-pie` |

---

## ⚡ SNIPPET PREFIX

Ketik di VS Code, tekan Tab:

| Prefix                  | Hasil              |
| ----------------------- | ------------------ |
| `comp.card`             | Card dasar         |
| `comp.input`            | Input dengan label |
| `comp.btn-primary`      | Tombol teal        |
| `comp.btn-danger`       | Tombol merah       |
| `layouts.admin.sidebar` | Sidebar lengkap    |
| `public.index.hero`     | Hero section       |
| `blade.forelse`         | Loop dengan empty  |

---

## 🧪 LATIHAN CEPAT

1. **Bikin halaman index:** ESC → Card → Table → Forelse → Edit/Hapus
2. **Bikin halaman form:** ESC → Card → Form → Input → Error → Button
3. **Bikin login:** Body center → Card → Error → Form → Input → Button

---

## 📌 RUMUS 1 KALIMAT

> **"Semua halaman = Layout + Card + Konten yang sama polanya"**

Paham pola = tinggal copy-paste dan ganti data!
