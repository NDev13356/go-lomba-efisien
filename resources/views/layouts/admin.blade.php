<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Pilketos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/chart.min.js') }}"></script>
</head>

<body class="bg-base-200 min-h-screen font-sans">
    <div class="drawer lg:drawer-open">
        <input id="sidebar" type="checkbox" class="drawer-toggle" />

        {{-- Page Content --}}
        <div class="drawer-content">
            {{-- Mobile Header --}}
            <div class="navbar bg-base-100 border-b lg:hidden">
                <div class="navbar-start">
                    <label for="sidebar" class="btn btn-ghost drawer-button">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </label>
                </div>
                <div class="navbar-center">
                    <span class="font-bold">Admin Panel</span>
                </div>
                <div class="navbar-end"></div>
            </div>

            {{-- Main Content --}}
            <main class="p-4 md:p-8">
                <h1 class="text-2xl font-bold">@yield('title')</h1>
                <p class="text-base-content/60 text-sm mb-8">@yield('subtitle', 'Panel administrasi')</p>

                @if (session('success'))
                    <div role="alert" class="alert alert-success mb-6">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        {{-- Sidebar --}}
        <div class="drawer-side z-50">
            <label for="sidebar" class="drawer-overlay"></label>
            <aside class="bg-base-100 min-h-screen w-64 border-r flex flex-col">
                {{-- Logo --}}
                <div class="p-6 border-b">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-primary text-2xl"></i>
                        <span class="font-bold text-lg">Admin Panel</span>
                    </div>
                </div>

                {{-- Menu --}}
                <ul class="menu p-4 flex-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-home"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kandidat.index') }}"
                            class="{{ request()->routeIs('admin.kandidat.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-tie"></i>Kandidat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.siswa.index') }}"
                            class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users"></i>Siswa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.admin.index') }}"
                            class="{{ request()->routeIs('admin.admin.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-shield"></i>Admin
                        </a>
                    </li>
                </ul>

                {{-- Footer --}}
                <div class="p-4 border-t">
                    <a href="{{ route('public.index') }}" target="_blank" class="btn btn-ghost btn-sm w-full mb-2">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>Lihat Website
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-error w-full">
                            <i class="fa-solid fa-right-from-bracket"></i>Logout
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
