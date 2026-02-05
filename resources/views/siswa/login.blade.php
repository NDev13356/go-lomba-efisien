<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Pilketos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen font-sans flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-lg">
            {{-- Header --}}
            <div class="text-center mb-8">
                <i class="fa-solid fa-check-to-slot text-teal-500 text-4xl mb-4"></i>
                <h1 class="text-2xl font-bold text-slate-800">Login Siswa</h1>
                <p class="text-slate-500 text-sm">Masuk untuk memberikan suaramu</p>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm mb-6">
                    <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('siswa.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="1234567890">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full bg-teal-500 text-white py-3 rounded-xl font-bold hover:bg-teal-600 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Masuk
                </button>
            </form>

            {{-- Back Link --}}
            <div class="text-center mt-6">
                <a href="{{ route('public.index') }}" class="text-slate-500 text-sm hover:text-teal-500">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>

            {{-- Footer --}}
            <p class="text-center text-slate-400 text-xs mt-6">&copy; {{ date('Y') }} Pilketos</p>
        </div>
    </div>
</body>

</html>
