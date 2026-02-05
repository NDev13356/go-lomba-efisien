# Panduan Lomba - Pemilihan Ketua OSIS (Pilketos)

## Daftar Isi

1. [Struktur Project](#struktur-project)
2. [Urutan Pembuatan](#urutan-pembuatan)
3. [Database & Model](#database--model)
4. [Routes](#routes)
5. [Controller](#controller)
6. [Views](#views)
    - [Setup FontAwesome](#instalasi-fontawesome-via-npm-tanpa-cdn)
    - [Setup Chart.js](#setup-chartjs-untuk-grafik-dashboard)
7. [Perintah Penting](#perintah-penting)

---

## Struktur Project

```
pilketos/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Controllers Admin (terpisah)
│   │   │   │   ├── AdminController.php   # CRUD akun admin
│   │   │   │   ├── AuthController.php    # Login/Logout admin
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── KandidatController.php
│   │   │   │   └── SiswaController.php
│   │   │   ├── ApiController.php         # REST API (Laravel API routes)
│   │   │   ├── PublicController.php      # Halaman publik + API web
│   │   │   └── Siswa/                     # Controllers Siswa (terpisah)
│   │   │       ├── AuthController.php    # Login/Logout siswa
│   │   │       └── VotingController.php  # Voting siswa
│   │   └── Middleware/                    # Middleware
│   │       ├── AdminMiddleware.php       # Proteksi route admin
│   │       └── SiswaMiddleware.php       # Proteksi route siswa
│   └── Models/
│       ├── Admin.php
│       ├── Kandidat.php
│       ├── Siswa.php
│       └── Pemilihan.php
├── bootstrap/
│   └── app.php                           # Registrasi middleware alias
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php            # Layout publik (responsive)
│   │   └── admin.blade.php          # Layout admin (responsive)
│   ├── public/
│   │   ├── index.blade.php          # Landing page + hasil
│   │   └── api-docs.blade.php       # Dokumentasi API
│   ├── siswa/
│   │   ├── login.blade.php
│   │   ├── voting.blade.php
│   │   └── sudah-memilih.blade.php
│   └── admin/
│       ├── login.blade.php
│       ├── dashboard.blade.php
│       ├── admin/                    # Kelola Admin
│       │   ├── index.blade.php
│       │   └── form.blade.php
│       ├── kandidat/
│       │   ├── index.blade.php
│       │   └── form.blade.php
│       └── siswa/
│           ├── index.blade.php
│           └── form.blade.php
├── routes/
│   ├── web.php                      # Routes web
│   └── api.php                      # Routes API Laravel
└── public/js/chart.min.js
```

---

## Urutan Pembuatan

### Step 1: Buat Project Laravel

```bash
composer create-project laravel/laravel pilketos
cd pilketos
npm install
npm install @fortawesome/fontawesome-free
```

### Step 2: Buat Database

- Buat database di MySQL: `pilketos`
- Edit `.env`:

```env
DB_DATABASE=pilketos
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Buat Migrations

```bash
php artisan make:migration create_admins_table
php artisan make:migration create_kandidat_table
php artisan make:migration create_siswa_table
php artisan make:migration create_pemilihan_table
```

### Step 4: Buat Models

```bash
php artisan make:model Admin
php artisan make:model Kandidat
php artisan make:model Siswa
php artisan make:model Pemilihan
```

### Step 5: Buat Controllers

```bash
# Admin controllers (folder terpisah)
php artisan make:controller Admin/AdminController
php artisan make:controller Admin/AuthController
php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/KandidatController
php artisan make:controller Admin/SiswaController

# Other controllers
php artisan make:controller PublicController
php artisan make:controller SiswaController
php artisan make:controller ApiController
```

### Step 5b: Buat Middleware (PENTING!)

```bash
php artisan make:middleware AdminMiddleware
php artisan make:middleware SiswaMiddleware
```

### Step 6: Buat Views (folder & file)

### Step 7: Storage Link

```bash
php artisan storage:link
```

### Step 8: Migrate & Seed

```bash
php artisan migrate
php artisan db:seed
```

### Step 9: Jalankan

```bash
npm run dev
php artisan serve
```

---

## Database & Model

### Migration: admins

```php
Schema::create('admins', function (Blueprint $table) {
    $table->id();
    $table->string('username')->unique();
    $table->string('password');
    $table->timestamps();
});
```

### Migration: kandidat

```php
Schema::create('kandidat', function (Blueprint $table) {
    $table->id('id_kandidat');
    $table->string('nama');
    $table->string('foto')->nullable();
    $table->timestamps();
});
```

### Migration: siswa

```php
Schema::create('siswa', function (Blueprint $table) {
    $table->string('nisn')->primary();
    $table->string('nama');
    $table->string('password');
    $table->timestamps();
});
```

### Migration: pemilihan

```php
Schema::create('pemilihan', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_kandidat');
    $table->string('nisn');
    $table->foreign('id_kandidat')->references('id_kandidat')->on('kandidat')->onDelete('cascade');
    $table->foreign('nisn')->references('nisn')->on('siswa')->onDelete('cascade');
    $table->unique('nisn'); // Siswa hanya bisa memilih sekali
    $table->timestamps();
});
```

### Model: Admin.php

```php
class Admin extends Model {
    protected $fillable = ['username', 'password'];
}
```

### Model: Kandidat.php

```php
class Kandidat extends Model {
    protected $table = 'kandidat';
    protected $primaryKey = 'id_kandidat';
    protected $fillable = ['nama', 'foto'];

    public function pemilihan() {
        return $this->hasMany(Pemilihan::class, 'id_kandidat', 'id_kandidat');
    }
}
```

### Model: Siswa.php

```php
class Siswa extends Model {
    protected $table = 'siswa';
    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nisn', 'nama', 'password'];

    public function pemilihan() {
        return $this->hasOne(Pemilihan::class, 'nisn', 'nisn');
    }
}
```

### Model: Pemilihan.php

```php
class Pemilihan extends Model {
    protected $table = 'pemilihan';
    protected $fillable = ['nisn', 'id_kandidat'];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }

    public function kandidat() {
        return $this->belongsTo(Kandidat::class, 'id_kandidat', 'id_kandidat');
    }
}
```

---

## Routes

### routes/web.php (Dengan Middleware Group)

```php
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KandidatController as AdminKandidatController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Siswa\AuthController as SiswaAuthController;
use App\Http\Controllers\Siswa\VotingController as SiswaVotingController;

// PUBLIC
Route::get('/', [PublicController::class, 'index'])->name('public.index');

// PUBLIC REST API (via web routes)
Route::prefix('api')->group(function () {
    Route::get('/kandidat', [PublicController::class, 'apiKandidat'])->name('api.kandidat');
    Route::get('/hasil', [PublicController::class, 'apiHasil'])->name('api.hasil');
});
Route::get('/api-docs', [PublicController::class, 'apiDocs'])->name('api.docs');

// SISWA (Dengan Middleware)
Route::prefix('siswa')->group(function () {
    // Auth (tanpa middleware)
    Route::get('/login', [SiswaAuthController::class, 'showLogin'])->name('siswa.login');
    Route::post('/login', [SiswaAuthController::class, 'login'])->name('siswa.login.post');

    // Protected (dengan middleware)
    Route::middleware('siswa')->group(function () {
        Route::get('/voting', [SiswaVotingController::class, 'showVoting'])->name('siswa.voting');
        Route::post('/vote', [SiswaVotingController::class, 'vote'])->name('siswa.vote');
        Route::post('/logout', [SiswaAuthController::class, 'logout'])->name('siswa.logout');
    });
});

// ADMIN (Dengan Middleware)
Route::prefix('admin')->group(function () {
    // Auth (tanpa middleware)
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

    // Protected (dengan middleware)
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD Kandidat
        Route::get('/kandidat', [AdminKandidatController::class, 'index'])->name('admin.kandidat.index');
        Route::get('/kandidat/create', [AdminKandidatController::class, 'create'])->name('admin.kandidat.create');
        Route::post('/kandidat', [AdminKandidatController::class, 'store'])->name('admin.kandidat.store');
        Route::get('/kandidat/{id}/edit', [AdminKandidatController::class, 'edit'])->name('admin.kandidat.edit');
        Route::put('/kandidat/{id}', [AdminKandidatController::class, 'update'])->name('admin.kandidat.update');
        Route::delete('/kandidat/{id}', [AdminKandidatController::class, 'destroy'])->name('admin.kandidat.destroy');

        // CRUD Siswa
        Route::get('/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa.index');
        Route::get('/siswa/create', [AdminSiswaController::class, 'create'])->name('admin.siswa.create');
        Route::post('/siswa', [AdminSiswaController::class, 'store'])->name('admin.siswa.store');
        Route::get('/siswa/{nisn}/edit', [AdminSiswaController::class, 'edit'])->name('admin.siswa.edit');
        Route::put('/siswa/{nisn}', [AdminSiswaController::class, 'update'])->name('admin.siswa.update');
        Route::delete('/siswa/{nisn}', [AdminSiswaController::class, 'destroy'])->name('admin.siswa.destroy');

        // CRUD Admin
        Route::get('/akun', [AdminAdminController::class, 'index'])->name('admin.admin.index');
        Route::get('/akun/create', [AdminAdminController::class, 'create'])->name('admin.admin.create');
        Route::post('/akun', [AdminAdminController::class, 'store'])->name('admin.admin.store');
        Route::get('/akun/{id}/edit', [AdminAdminController::class, 'edit'])->name('admin.admin.edit');
        Route::put('/akun/{id}', [AdminAdminController::class, 'update'])->name('admin.admin.update');
        Route::delete('/akun/{id}', [AdminAdminController::class, 'destroy'])->name('admin.admin.destroy');
    });
});
```

**REST API Endpoints (Public Access):**
| Endpoint | Method | Deskripsi |
|----------|--------|-----------|
| `/api/kandidat` | GET | Daftar semua kandidat |
| `/api/hasil` | GET | Hasil voting dengan jumlah suara |
| `/api/rekap` | GET | Rekap voting (via Laravel API routes) |

---

## Middleware (PENTING!)

Middleware adalah fitur Laravel untuk memproteksi route secara terpusat. Dengan middleware, kita tidak perlu menambahkan `if (!session()->has('admin_id'))` di setiap method controller.

### AdminMiddleware.php

```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return $next($request);
    }
}
```

### SiswaMiddleware.php

```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('siswa_nisn')) {
            return redirect()->route('siswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return $next($request);
    }
}
```

### Registrasi Middleware (bootstrap/app.php)

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

### Keuntungan Middleware

| Aspek         | Tanpa Middleware          | Dengan Middleware    |
| ------------- | ------------------------- | -------------------- |
| Kode          | Duplikat di setiap method | Satu tempat saja     |
| Maintenance   | Ubah di banyak tempat     | Ubah di satu tempat  |
| Keamanan      | Risiko lupa menambahkan   | Otomatis terlindungi |
| Best Practice | ❌                        | ✅                   |

---

## Controller

### Admin/AuthController.php

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        if (session()->has('admin_id')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function login(Request $request) {
        $admin = Admin::where('username', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id, 'admin_username' => $admin->username]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['login' => 'Username atau password salah']);
    }

    public function logout() {
        session()->forget(['admin_id', 'admin_username']);
        return redirect()->route('admin.login');
    }
}
```

### Admin/DashboardController.php (Dengan Middleware)

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\Pemilihan;
use App\Models\Siswa;

class DashboardController extends Controller
{
    // Tidak perlu session check manual karena sudah ditangani middleware!

    public function index() {
        $kandidat = Kandidat::withCount('pemilihan as jumlah_suara')->get();
        $totalSuara = Pemilihan::count();
        $totalSiswa = Siswa::count();
        $totalKandidat = Kandidat::count();

        // Calculate percentages
        $kandidat->transform(function ($item) use ($totalSuara) {
            $item->persentase = $totalSuara > 0
                ? round(($item->jumlah_suara / $totalSuara) * 100, 2) : 0;
            return $item;
        });

        return view('admin.dashboard', compact('kandidat', 'totalSuara', 'totalSiswa', 'totalKandidat'));
    }
}
```

### Admin/KandidatController.php (CRUD dengan Middleware)

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KandidatController extends Controller
{
    // Semua method tidak perlu session check karena sudah ditangani middleware!

    public function index() {
        $kandidat = Kandidat::withCount('pemilihan as jumlah_suara')->get();
        return view('admin.kandidat.index', compact('kandidat'));
    }

    public function create() {
        return view('admin.kandidat.form', ['kandidat' => null]);
    }

    public function store(Request $request) {
        $request->validate(['nama' => 'required', 'foto' => 'nullable|image|max:2048']);

        $data = ['nama' => $request->nama];
        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            Storage::disk('public')->putFileAs('kandidat', $request->file('foto'), $filename);
            $data['foto'] = $filename;
        }
        Kandidat::create($data);
        return redirect()->route('admin.kandidat.index')->with('success', 'Kandidat berhasil ditambahkan');
    }

    public function edit($id) {
        $kandidat = Kandidat::findOrFail($id);
        return view('admin.kandidat.form', compact('kandidat'));
    }

    public function update(Request $request, $id) {
        $kandidat = Kandidat::findOrFail($id);
        $kandidat->nama = $request->nama;

        if ($request->hasFile('foto')) {
            if ($kandidat->foto) Storage::disk('public')->delete('kandidat/' . $kandidat->foto);
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            Storage::disk('public')->putFileAs('kandidat', $request->file('foto'), $filename);
            $kandidat->foto = $filename;
        }
        $kandidat->save();
        return redirect()->route('admin.kandidat.index')->with('success', 'Kandidat berhasil diperbarui');
    }

    public function destroy($id) {
        $kandidat = Kandidat::findOrFail($id);
        if ($kandidat->foto) Storage::disk('public')->delete('kandidat/' . $kandidat->foto);
        $kandidat->delete();
        return redirect()->route('admin.kandidat.index')->with('success', 'Kandidat berhasil dihapus');
    }
}
```

### Admin/SiswaController.php (CRUD)

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index() {
        if (!session()->has('admin_id')) return redirect()->route('admin.login');
        $siswa = Siswa::with('pemilihan.kandidat')->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create() {
        if (!session()->has('admin_id')) return redirect()->route('admin.login');
        return view('admin.siswa.form', ['siswa' => null]);
    }

    public function store(Request $request) {
        if (!session()->has('admin_id')) return redirect()->route('admin.login');
        $request->validate(['nisn' => 'required|unique:siswa', 'nama' => 'required', 'password' => 'required']);
        Siswa::create([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit($nisn) {
        if (!session()->has('admin_id')) return redirect()->route('admin.login');
        $siswa = Siswa::findOrFail($nisn);
        return view('admin.siswa.form', compact('siswa'));
    }

    public function update(Request $request, $nisn) {
        if (!session()->has('admin_id')) return redirect()->route('admin.login');
        $siswa = Siswa::findOrFail($nisn);
        $siswa->nama = $request->nama;
        if ($request->filled('password')) $siswa->password = Hash::make($request->password);
        $siswa->save();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui');
    }

    public function destroy($nisn) {
        if (!session()->has('admin_id')) return redirect()->route('admin.login');
        Siswa::findOrFail($nisn)->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}
```

### Siswa/AuthController.php (Login/Logout)

```php
<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        if (session()->has('siswa_nisn')) return redirect()->route('siswa.voting');
        return view('siswa.login');
    }

    public function login(Request $request) {
        $siswa = Siswa::find($request->nisn);
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            session(['siswa_nisn' => $siswa->nisn, 'siswa_nama' => $siswa->nama]);
            return redirect()->route('siswa.voting');
        }
        return back()->withErrors(['login' => 'NISN atau password salah']);
    }

    public function logout() {
        session()->forget(['siswa_nisn', 'siswa_nama']);
        return redirect()->route('siswa.login');
    }
}
```

### Siswa/VotingController.php (Voting dengan Middleware)

```php
<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\Pemilihan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    // Tidak perlu session check karena sudah ditangani middleware!

    public function showVoting() {
        $siswa = Siswa::find(session('siswa_nisn'));

        if ($siswa->hasVoted()) {
            $vote = $siswa->pemilihan()->with('kandidat')->first();
            return view('siswa.sudah-memilih', compact('siswa', 'vote'));
        }

        $kandidat = Kandidat::all();
        return view('siswa.voting', compact('siswa', 'kandidat'));
    }

    public function vote(Request $request) {
        $request->validate(['id_kandidat' => 'required|exists:kandidat,id_kandidat']);

        $siswa = Siswa::find(session('siswa_nisn'));
        if ($siswa->hasVoted()) {
            return back()->withErrors(['vote' => 'Anda sudah memilih']);
        }

        Pemilihan::create([
            'nisn' => $siswa->nisn,
            'id_kandidat' => $request->id_kandidat
        ]);
        return redirect()->route('siswa.voting')->with('success', 'Suara berhasil tercatat!');
    }
}
```

---

## Views

### Instalasi FontAwesome (via npm, tanpa CDN)

```bash
npm install @fortawesome/fontawesome-free
```

Di `resources/css/app.css`, import fontawesome:

```css
@import "@fortawesome/fontawesome-free/css/all.min.css";
```

### Setup Chart.js (untuk Grafik Dashboard)

Chart.js digunakan untuk menampilkan grafik/diagram hasil voting di dashboard admin dan halaman publik.

#### Langkah 1: Download Chart.js

Download file Chart.js dari CDN dan simpan ke folder `public/js/`:

1. **Buka browser** dan download dari: `https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js`
2. **Simpan file** ke: `public/js/chart.min.js`

Atau gunakan perintah curl/wget:

```bash
# Windows PowerShell
Invoke-WebRequest -Uri "https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" -OutFile "public/js/chart.min.js"

# Linux/Mac
curl -o public/js/chart.min.js https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js
```

#### Langkah 2: Include di Layout/View

Tambahkan script tag di layout atau view yang membutuhkan chart:

```html
<script src="{{ asset('js/chart.min.js') }}"></script>
```

#### Langkah 3: Contoh Penggunaan (Dashboard)

```blade
{{-- Canvas untuk Chart --}}
<canvas id="votingChart"></canvas>

{{-- Script Chart --}}
<script>
    new Chart(document.getElementById('votingChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($kandidat->pluck('nama')) !!},
            datasets: [{
                label: 'Suara',
                data: {!! json_encode($kandidat->pluck('jumlah_suara')) !!},
                backgroundColor: ['#3b82f6', '#14b8a6', '#0ea5e9', '#2dd4bf', '#06b6d4'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
```

#### Tipe Chart yang Tersedia

| Tipe       | Deskripsi     | Penggunaan         |
| ---------- | ------------- | ------------------ |
| `bar`      | Grafik batang | Perbandingan suara |
| `doughnut` | Grafik donut  | Persentase suara   |
| `pie`      | Grafik pie    | Distribusi suara   |
| `line`     | Grafik garis  | Tren waktu         |

#### Contoh Doughnut Chart (Halaman Publik)

```javascript
new Chart(document.getElementById('hasilChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($kandidat->pluck('nama')) !!},
        datasets: [{
            data: {!! json_encode($kandidat->pluck('jumlah_suara')) !!},
            backgroundColor: ['#3b82f6', '#14b8a6', '#0ea5e9', '#2dd4bf'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        cutout: '60%',
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
```

### Layout Head (wajib ada di semua layout)

```html
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet"
/>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="{{ asset('js/chart.min.js') }}"></script>
```

### FontAwesome Icons yang Dipakai

| Icon     | Class                            | Keterangan    |
| -------- | -------------------------------- | ------------- |
| Home     | `fa-solid fa-home`               | Dashboard     |
| User     | `fa-solid fa-user`               | Siswa/Profile |
| Users    | `fa-solid fa-users`              | Kelola Siswa  |
| User Tie | `fa-solid fa-user-tie`           | Kandidat      |
| Shield   | `fa-solid fa-shield-halved`      | Admin         |
| Vote     | `fa-solid fa-check-to-slot`      | Voting        |
| Chart    | `fa-solid fa-chart-pie`          | Grafik        |
| Login    | `fa-solid fa-right-to-bracket`   | Login         |
| Logout   | `fa-solid fa-right-from-bracket` | Logout        |
| Edit     | `fa-solid fa-pen-to-square`      | Edit          |
| Delete   | `fa-solid fa-trash`              | Hapus         |
| Add      | `fa-solid fa-plus`               | Tambah        |
| Save     | `fa-solid fa-floppy-disk`        | Simpan        |
| Trophy   | `fa-solid fa-trophy`             | Peringkat 1   |
| Crown    | `fa-solid fa-crown`              | Pemenang      |
| Check    | `fa-solid fa-circle-check`       | Sukses        |
| Error    | `fa-solid fa-circle-exclamation` | Error         |
| Back     | `fa-solid fa-arrow-left`         | Kembali       |
| Lock     | `fa-solid fa-lock`               | Password      |
| ID Card  | `fa-solid fa-id-card`            | NISN          |

### Warna yang Dipakai

```css
/* Primary (Blue Theme) */
blue-500: #3b82f6       /* Warna utama */
indigo-500: #6366f1     /* Warna sekunder/gradient */
sky-500: #0ea5e9        /* Warna aksen */
slate-800: #1e293b      /* Teks gelap */

/* Gradient Buttons */
from-blue-500 to-indigo-500

/* Border */
border-slate-200

/* Background */
gray-50, slate-100
blue-100, indigo-100    /* Aksen background */

/* Text */
gray-800 (heading)
gray-500 (secondary)
gray-400 (tertiary)
blue-500, blue-600      /* Aksen teks */
```

---

## Perintah Penting

### Instalasi

```bash
composer create-project laravel/laravel pilketos
cd pilketos
npm install
npm install @fortawesome/fontawesome-free
```

### Development

```bash
npm run dev          # Terminal 1
php artisan serve    # Terminal 2
```

### Database

```bash
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed
```

### Storage

```bash
php artisan storage:link
```

### Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Tips Lomba

### Urutan Pembuatan (WAJIB HAFAL!)

```
1. Project     → composer create-project laravel/laravel pilketos
2. .env        → DB_DATABASE=pilketos
3. Migrations  → php artisan make:migration create_xxx_table
4. Models      → php artisan make:model Xxx
5. Controllers → php artisan make:controller Admin/XxxController
6. Routes      → Edit routes/web.php
7. Views       → Buat folder & file blade
8. Storage     → php artisan storage:link
9. Migrate     → php artisan migrate --seed
10. Run        → npm run dev + php artisan serve
```

### Checklist Saat Lomba

- [ ] Buat database MySQL `pilketos`
- [ ] Edit `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- [ ] Buat 4 migrations (admins, kandidat, siswa, pemilihan)
- [ ] Buat 4 models dengan relasi
- [ ] Buat controllers (Admin/, Public, Siswa)
- [ ] Setup routes di `web.php`
- [ ] Install FontAwesome: `npm install @fortawesome/fontawesome-free`
- [ ] Download Chart.js ke `public/js/chart.min.js`
- [ ] Jalankan `php artisan storage:link`
- [ ] Buat semua views
- [ ] Test login admin & siswa
- [ ] Test CRUD kandidat & siswa
- [ ] Test voting
- [ ] Test API endpoints

---

## Cheat Sheet (Copy-Paste)

### Middleware Pattern (LEBIH BAIK!)

Dengan middleware, tidak perlu session check di controller:

```php
// Di routes/web.php:
Route::middleware('admin')->group(function () {
    // Semua route di sini sudah terlindungi!
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Di controller, langsung kode utama saja:
public function index() {
    return view('admin.dashboard');
}
```

### Session Check Lama (TIDAK DIREKOMENDASIKAN)

```php
// Cara lama - duplikat di setiap method
if (!session()->has('admin_id')) return redirect()->route('admin.login');
```

### Upload Foto Pattern

```php
if ($request->hasFile('foto')) {
    $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
    Storage::disk('public')->putFileAs('kandidat', $request->file('foto'), $filename);
    $data['foto'] = $filename;
}
```

### Delete Foto Pattern

```php
if ($kandidat->foto) {
    Storage::disk('public')->delete('kandidat/' . $kandidat->foto);
}
```

### Login Pattern

```php
$user = Model::where('username', $request->username)->first();
if ($user && Hash::check($request->password, $user->password)) {
    session(['user_id' => $user->id]);
    return redirect()->route('dashboard');
}
return back()->withErrors(['login' => 'Username atau password salah']);
```

### Logout Pattern

```php
session()->forget(['user_id', 'user_name']);
return redirect()->route('login');
```

### CRUD Pattern (Hafal 1, Copy-Paste Semua)

```php
// INDEX
public function index() {
    $data = Model::all();
    return view('xxx.index', compact('data'));
}

// CREATE
public function create() {
    return view('xxx.form', ['item' => null]);
}

// STORE
public function store(Request $request) {
    $request->validate(['nama' => 'required']);
    Model::create($request->all());
    return redirect()->route('xxx.index')->with('success', 'Berhasil ditambahkan');
}

// EDIT
public function edit($id) {
    $item = Model::findOrFail($id);
    return view('xxx.form', compact('item'));
}

// UPDATE
public function update(Request $request, $id) {
    $item = Model::findOrFail($id);
    $item->update($request->all());
    return redirect()->route('xxx.index')->with('success', 'Berhasil diperbarui');
}

// DESTROY
public function destroy($id) {
    Model::findOrFail($id)->delete();
    return redirect()->route('xxx.index')->with('success', 'Berhasil dihapus');
}
```

### Model Relation Patterns

```php
// One to Many (Kandidat -> Pemilihan)
public function pemilihan() {
    return $this->hasMany(Pemilihan::class, 'id_kandidat', 'id_kandidat');
}

// Many to One (Pemilihan -> Kandidat)
public function kandidat() {
    return $this->belongsTo(Kandidat::class, 'id_kandidat', 'id_kandidat');
}

// With Count (Dashboard)
$kandidat = Kandidat::withCount('pemilihan as jumlah_suara')->get();
```

### app.css Import

```css
@import "tailwindcss";
@import "@fortawesome/fontawesome-free/css/all.min.css";

body {
    font-family: "Poppins", sans-serif;
}
```

### Layout Head Template

```html
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet"
/>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="{{ asset('js/chart.min.js') }}"></script>
```

---

## Yang Sering Lupa!

| Problem                  | Solusi                                           |
| ------------------------ | ------------------------------------------------ |
| Gambar tidak muncul      | Jalankan `php artisan storage:link`              |
| FontAwesome tidak muncul | Cek import di `app.css`                          |
| Chart tidak muncul       | Download `chart.min.js` ke `public/js/`          |
| Session tidak jalan      | Cek `session()->has()` dan `session()->forget()` |
| Route tidak ketemu       | Jalankan `php artisan route:clear`               |
| NISN tidak bisa update   | Primary key string, bukan auto-increment         |

---

## Rekomendasi Latihan

### Sebelum Lomba (H-3 sampai H-1)

1. **Latihan Full Build** - Buat project dari nol TANPA lihat panduan (target: < 2 jam)
2. **Fokus Migration & Model** - Ini bagian paling rawan lupa
3. **Hapal 1 CRUD Controller** - Yang lain tinggal copy-paste, ganti nama
4. **Hapal 1 Form View** - Pattern-nya sama semua

### Saat Lomba

1. **Baca soal dengan teliti** - Catat requirement yang diminta
2. **Setup dulu** - Project, .env, npm install
3. **Database first** - Migrations → Models → Seeders
4. **Backend next** - Controllers → Routes
5. **Views terakhir** - Layout → Pages
6. **Test setiap langkah** - Jangan numpuk error!

### Prioritas Jika Waktu Mepet

1. ✅ Login Admin & Siswa (wajib ada)
2. ✅ CRUD Kandidat (wajib ada)
3. ✅ Voting & Hasil (wajib ada)
4. ⭕ CRUD Siswa (nice to have)
5. ⭕ API Endpoints (nice to have)
6. ⭕ UI Polish (kalau sempat)

---

## Akun Default

| Role  | Username/NISN | Password |
| ----- | ------------- | -------- |
| Admin | admin         | admin    |
| Siswa | 12345         | siswa    |

---

## Quick Reference: File Locations

```
Controllers Admin:
├── app/Http/Controllers/Admin/AdminController.php
├── app/Http/Controllers/Admin/AuthController.php
├── app/Http/Controllers/Admin/DashboardController.php
├── app/Http/Controllers/Admin/KandidatController.php
└── app/Http/Controllers/Admin/SiswaController.php

Controllers Siswa:
├── app/Http/Controllers/Siswa/AuthController.php
└── app/Http/Controllers/Siswa/VotingController.php

Controllers Lainnya:
└── app/Http/Controllers/PublicController.php

Middleware (BARU!):
├── app/Http/Middleware/AdminMiddleware.php
└── app/Http/Middleware/SiswaMiddleware.php

Models:
├── app/Models/Admin.php
├── app/Models/Kandidat.php
├── app/Models/Siswa.php
└── app/Models/Pemilihan.php

Views:
├── resources/views/layouts/app.blade.php
├── resources/views/layouts/admin.blade.php
├── resources/views/public/index.blade.php
├── resources/views/siswa/login.blade.php
├── resources/views/siswa/voting.blade.php
├── resources/views/admin/login.blade.php
├── resources/views/admin/dashboard.blade.php
├── resources/views/admin/admin/index.blade.php
├── resources/views/admin/admin/form.blade.php
├── resources/views/admin/kandidat/index.blade.php
├── resources/views/admin/kandidat/form.blade.php
├── resources/views/admin/siswa/index.blade.php
└── resources/views/admin/siswa/form.blade.php

Routes:
└── routes/web.php

Config (untuk middleware):
└── bootstrap/app.php
```

---

**Semangat! Kamu pasti bisa! 💪🎯**
