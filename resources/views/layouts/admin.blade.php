<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Aduan Admin Portal - UPSI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <div class="w-64 bg-slate-800 text-white flex flex-col">
            <div class="p-5 font-bold text-lg border-b border-slate-700 text-center">
                eAduan Admin (KSAS)
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.complaints.index') }}"
                    class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.complaints.*') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Complaints
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.reports.index') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Monthly Reports
                </a>

                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 rounded transition {{ request()->routeIs('admin.settings.index') ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:bg-slate-700 hover:text-white' }}">
                    Global Settings
                </a>
            </nav>
            <div class="p-4 border-t border-slate-700">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 transition rounded font-medium">
                        🚪 Secure Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto p-8">
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>

</html>