<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Pilketos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200 min-h-screen font-sans flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-check-to-slot text-primary text-4xl mb-4"></i>
                    <h1 class="text-2xl font-bold">Login Siswa</h1>
                    <p class="text-base-content/60 text-sm">Masuk untuk memberikan suaramu</p>
                </div>

                @if ($errors->any())
                    <div role="alert" class="alert alert-error mb-4">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('siswa.login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">NISN</span></label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" required
                            class="input input-bordered w-full" placeholder="NISN">
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Password</span></label>
                        <input type="password" name="password" required class="input input-bordered w-full"
                            placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fa-solid fa-right-to-bracket"></i>Masuk
                    </button>
                </form>
            </div>
        </div>
        <p class="text-center text-base-content/60 text-xs mt-6">&copy; {{ date('Y') }} Pilketos</p>
    </div>
</body>

</html>
