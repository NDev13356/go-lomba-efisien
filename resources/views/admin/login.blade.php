<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Pilketos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen font-sans flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl p-8 border border-slate-200">
            <div class="text-center mb-8">
                <i class="fa-solid fa-shield-halved text-teal-500 text-4xl mb-4"></i>
                <h1 class="text-2xl font-bold text-slate-800">Login Admin</h1>
                <p class="text-slate-400 text-sm">Masuk untuk mengakses dashboard</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl mb-6">
                    <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
                        placeholder="Username">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500"
                        placeholder="Password">
                </div>
                <button type="submit"
                    class="w-full bg-teal-500 text-white py-4 rounded-xl font-semibold hover:bg-teal-600">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk
                </button>
            </form>
        </div>
        <p class="text-center text-slate-400 text-xs mt-6">&copy; {{ date('Y') }} Pilketos</p>
    </div>
</body>

</html>
