<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pilketos')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/chart.min.js') }}"></script>
</head>

<body class="bg-base-200 min-h-screen font-sans">
    {{-- Navbar --}}
    <div class="navbar bg-base-100 border-b sticky top-0 z-50 px-4 md:px-8 lg:px-24">
        <div class="navbar-start">
            <a href="{{ route('public.index') }}" class="flex items-center gap-2">
                <i class="fa-solid fa-check-to-slot text-primary text-xl"></i>
                <span class="font-bold text-lg">Pilketos</span>
            </a>
        </div>

        {{-- Mobile Menu --}}
        <div class="navbar-end lg:hidden">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost">
                    <i class="fa-solid fa-bars text-xl"></i>
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-10 w-52 p-2 shadow mt-3">
                    <li><a href="{{ route('public.index') }}">Beranda</a></li>
                    <li><a href="/#hasil">Hasil</a></li>
                    <li><a href="{{ route('api.docs') }}">API</a></li>
                    <li class="divider"></li>
                    @if (session()->has('siswa_nisn'))
                        <li class="menu-title">{{ session('siswa_nama') }}</li>
                        <li><a href="{{ route('siswa.voting') }}">Voting</a></li>
                        <li>
                            <form action="{{ route('siswa.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-error">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('siswa.login') }}">Login Siswa</a></li>
                        <li><a href="{{ route('admin.login') }}" class="text-primary font-bold">Admin</a></li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Desktop Nav --}}
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('public.index') }}">Beranda</a></li>
                <li><a href="/#hasil">Hasil</a></li>
                <li><a href="{{ route('api.docs') }}">API</a></li>
            </ul>
        </div>

        {{-- Desktop Auth --}}
        <div class="navbar-end hidden lg:flex gap-2">
            @if (session()->has('siswa_nisn'))
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-outline btn-primary">
                        <i class="fa-solid fa-user"></i>
                        {{ session('siswa_nama') }}
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-10 w-44 p-2 shadow mt-3">
                        <li><a href="{{ route('siswa.voting') }}"><i class="fa-solid fa-vote-yea"></i>Voting</a></li>
                        <li>
                            <form action="{{ route('siswa.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-error"><i
                                        class="fa-solid fa-right-from-bracket"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('siswa.login') }}" class="btn btn-ghost">Login</a>
                <a href="{{ route('admin.login') }}" class="btn btn-primary">Admin</a>
            @endif
        </div>
    </div>

    <main>@yield('content')</main>

    <footer class="footer footer-center bg-base-100 border-t p-6 mt-8">
        <p class="text-base-content/60">&copy; {{ date('Y') }} Pilketos - Pemilihan Ketua OSIS</p>
    </footer>

    @stack('scripts')
</body>

</html>
