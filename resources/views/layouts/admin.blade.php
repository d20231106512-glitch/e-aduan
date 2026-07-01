<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Aduan Admin Portal - UPSI</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <style>
        /* Mengubah suai warna butang Intro.js supaya sepadan dengan tema portal */
        .introjs-button {
            text-shadow: none !important;
            box-shadow: none !important;
            border-radius: 4px !important;
            font-size: 12px !important;
            font-weight: bold !important;
        }

        .introjs-nextbutton {
            background-color: #2563eb !important;
            /* Warna biru-600 */
            color: white !important;
            border: 1px solid #2563eb !important;
        }

        .introjs-prevbutton {
            background-color: #e2e8f0 !important;
            color: #334155 !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <div class="w-64 bg-slate-800 text-white flex flex-col">

            <div id="tour-logo" class="flex items-center gap-2.5 p-4 border-b border-slate-700 bg-slate-900/50">
                <div class="p-1.5 bg-slate-800 border border-slate-700 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>

                <div class="leading-none">
                    <span class="text-sm font-black text-white tracking-wider block uppercase">
                        e-Aduan
                    </span>
                    <span class="text-[9px] font-bold text-amber-400 tracking-widest uppercase block mt-0.5">
                        KSAS Admin Portal
                    </span>
                </div>
            </div>

            <nav id="tour-navigation" class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Paparan Utama
                </a>

                <a href="{{ route('admin.complaints.index') }}"
                    class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.complaints.*') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Senarai Aduan
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.reports.index') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Laporan Bulanan
                </a>

                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.settings.index') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Tetapan
                </a>

                <a href="{{ route('admin.about') }}" class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.about') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    ℹ️ Mengenai Sistem
                </a>
            </nav>

            <div id="tour-logout" class="p-4 border-t border-slate-700">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 transition rounded font-medium">
                        🚪 Secure Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto p-8">

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>

</html>