<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - E-Arsip Desa Bojongloa</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            margin: 0;
        }

        #app-sidebar {
            width: 16rem;
            min-width: 16rem;
            height: 100%;
        }

        .app-main {
            min-height: 0;
            height: 100%;
            overflow-y: auto;
            background-color: #f8fafc;
        }

        .app-content-inner {
            padding: 0 2rem 2rem;
        }

        .sidebar-open {
            transform: translateX(0) !important;
        }
    </style>
</head>
<body class="bg-[#EAFBFA] text-slate-800 font-sans antialiased">
    <button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 z-50 w-11 h-11 rounded-xl bg-white shadow-sm border border-slate-100 flex items-center justify-center">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6h16M4 12h16M4 18h16" stroke="#0F172A" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>

    <div class="flex h-screen w-full overflow-hidden">
        <aside id="app-sidebar" class="w-64 flex-shrink-0 h-full border-r bg-white fixed inset-y-0 left-0 z-40 transform -translate-x-full transition-transform duration-200 md:translate-x-0 md:static md:relative md:h-full flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100">
                <p class="text-lg font-bold leading-tight text-slate-900">E-Arsip</p>
                <p class="text-xs text-slate-500">Desa Bojongloa</p>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                @php($isDashboard = request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ $isDashboard ? 'bg-slate-50 text-slate-900 shadow-sm border border-slate-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                    <span>Dashboard</span>
                </a>

                @php($isArsip = request()->routeIs('arsip.*'))
                <a href="{{ route('arsip.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ $isArsip ? 'bg-slate-50 text-slate-900 shadow-sm border border-slate-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                    <span>Folder</span>
                </a>

                @php($isKategori = request()->routeIs('kategori.*'))
                <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ $isKategori ? 'bg-slate-50 text-slate-900 shadow-sm border border-slate-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                    <span>Documents</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 border border-transparent">
                    <span>Email</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 border border-transparent">
                    <span>Settings</span>
                </a>
            </nav>

            <div class="px-4 pb-4 mt-auto">
                <div class="rounded-2xl bg-slate-50 border border-slate-100 px-3 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 text-white flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr((auth()->user()->name ?? 'U'),0,1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-slate-500 truncate">Profile</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 border border-slate-100 transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 min-h-0 bg-gray-50">
            <main class="app-main">
                <div class="app-content-inner">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        (function() {
            const btn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('app-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (!btn || !sidebar) return;

            const openSidebar = () => {
                sidebar.classList.add('sidebar-open');
            };

            const closeSidebar = () => {
                sidebar.classList.remove('sidebar-open');
            };

            btn.addEventListener('click', openSidebar);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeSidebar();
            });
        })();
    </script>
</body>
</html>
