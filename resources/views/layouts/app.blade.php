<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pilketos')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/chart.min.js') }}"></script>
</head>

<body class="bg-gray-50 min-h-screen font-sans">
    {{-- Navbar --}}
    <nav class="bg-white border-b sticky top-0 z-50">
        <div class="mx-auto px-4 md:px-8 lg:px-24 py-4 flex items-center justify-between">
            <a href="{{ route('public.index') }}" class="flex items-center gap-2">
                <i class="fa-solid fa-check-to-slot text-teal-500 text-xl"></i>
                <span class="font-bold text-lg text-gray-800">Pilketos</span>
            </a>

            {{-- Mobile Menu Button --}}
            <button id="mobileMenuBtn" class="md:hidden text-gray-600">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('public.index') }}" class="text-gray-600 hover:text-teal-500">Beranda</a>
                <a href="/#hasil" class="text-gray-600 hover:text-teal-500">Hasil</a>
                <a href="{{ route('api.docs') }}" class="text-gray-600 hover:text-teal-500">API</a>
            </div>

            {{-- Desktop Auth --}}
            <div class="hidden md:flex items-center gap-3">
                @if (session()->has('siswa_nisn'))
                    <div class="relative">
                        <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                            class="flex items-center gap-2 text-teal-500 px-4 py-2 rounded-full border border-teal-500 text-sm">
                            <i class="fa-solid fa-user"></i>
                            <span>{{ session('siswa_nama') }}</span>
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                        <div
                            class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl border shadow-lg overflow-hidden">
                            <a href="{{ route('siswa.voting') }}"
                                class="flex items-center gap-2 px-4 py-3 text-gray-700 hover:bg-teal-50 text-sm">
                                <i class="fa-solid fa-vote-yea"></i>Voting
                            </a>
                            <form action="{{ route('siswa.logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-3 text-red-500 hover:bg-red-50 text-sm">
                                    <i class="fa-solid fa-right-from-bracket"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('siswa.login') }}" class="text-gray-600 hover:text-teal-500 text-sm">Login</a>
                    <a href="{{ route('admin.login') }}"
                        class="bg-teal-500 text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-teal-600">Admin</a>
                @endif
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t px-4 py-4 space-y-3">
            <a href="{{ route('public.index') }}" class="block text-gray-600 hover:text-teal-500 py-2">Beranda</a>
            <a href="/#hasil" class="block text-gray-600 hover:text-teal-500 py-2">Hasil</a>
            <a href="{{ route('api.docs') }}" class="block text-gray-600 hover:text-teal-500 py-2">API</a>
            <hr>
            @if (session()->has('siswa_nisn'))
                <div class="text-teal-500 py-2"><i class="fa-solid fa-user mr-2"></i>{{ session('siswa_nama') }}</div>
                <a href="{{ route('siswa.voting') }}" class="block text-gray-600 hover:text-teal-500 py-2">Voting</a>
                <form action="{{ route('siswa.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 py-2"><i
                            class="fa-solid fa-right-from-bracket mr-2"></i>Logout</button>
                </form>
            @else
                <a href="{{ route('siswa.login') }}" class="block text-gray-600 hover:text-teal-500 py-2">Login
                    Siswa</a>
                <a href="{{ route('admin.login') }}"
                    class="block bg-teal-500 text-white px-4 py-2 rounded-full text-center font-bold">Admin</a>
            @endif
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer class="bg-white border-t py-6 mt-8">
        <div class="mx-auto px-4 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} Pilketos - Pemilihan Ketua OSIS
        </div>
    </footer>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-xmark');
        });

        document.addEventListener('click', function(e) {
            document.querySelectorAll('.relative > div:not(.hidden)').forEach(d => {
                if (!d.previousElementSibling.contains(e.target)) d.classList.add('hidden');
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
