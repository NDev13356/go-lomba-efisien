<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Pilketos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/chart.min.js') }}"></script>
</head>

<body class="bg-slate-50 min-h-screen font-sans">
    <div class="flex">
        {{-- Mobile Header --}}
        <div
            class="lg:hidden fixed top-0 left-0 right-0 bg-white border-b z-40 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-teal-500 text-xl"></i>
                <span class="font-bold text-slate-800">Admin</span>
            </div>
            <button id="sidebarToggle" class="text-slate-600">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        {{-- Overlay --}}
        <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside id="sidebar"
            class="w-64 bg-white min-h-screen fixed border-r z-50 transform -translate-x-full lg:translate-x-0 transition-transform">
            <div class="p-6 border-b">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-teal-500 text-2xl"></i>
                    <span class="font-bold text-lg text-slate-800">Admin Panel</span>
                </div>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-teal-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.kandidat.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.kandidat.*') ? 'bg-teal-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-user-tie w-5"></i>
                    <span>Kandidat</span>
                </a>
                <a href="{{ route('admin.siswa.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.siswa.*') ? 'bg-teal-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-users w-5"></i>
                    <span>Siswa</span>
                </a>
                <a href="{{ route('admin.admin.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.admin.*') ? 'bg-teal-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-user-shield w-5"></i>
                    <span>Admin</span>
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t bg-slate-50">
                <a href="{{ route('public.index') }}" target="_blank"
                    class="block text-center text-slate-500 hover:text-teal-500 py-2 text-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>Lihat Website
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="w-full bg-red-500 text-white py-3 rounded-xl hover:bg-red-600">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <main class="lg:ml-64 flex-1 p-4 md:p-8 pt-20 lg:pt-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">@yield('title')</h1>
                    <p class="text-slate-400 text-sm">@yield('subtitle', 'Panel administrasi')</p>
                </div>
                <p class="text-sm text-slate-400 hidden md:block">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6">
                    <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
    @stack('scripts')
</body>

</html>
