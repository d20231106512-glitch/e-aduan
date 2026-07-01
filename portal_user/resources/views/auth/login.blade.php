<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk | E-Aduan KSAS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #0f172a; 
            margin: 0; 
        }
        
        /* Custom dark theme */
        .input-field { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #334155; border-radius: 8px; box-sizing: border-box; transition: 0.2s; background-color: #1e293b; color: #e2e8f0; }
        .input-field:focus { border-color: #f59e0b; outline: none; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1); }
    </style>
</head>
<body>

<div class="min-h-screen flex bg-slate-900">
    <!-- Left Sidebar -->
    <div class="w-72 bg-slate-800 flex flex-col pt-8 border-r border-slate-700 shadow-sm z-10 hidden md:flex">
        <div class="px-6 mb-8 border-b border-slate-700 pb-6">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 p-1.5 bg-slate-900 border border-slate-700 rounded-lg">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xs font-black tracking-widest text-white uppercase">E-ADUAN KSAS</h2>
                    <div class="flex items-center space-x-1 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                        <p class="text-[9px] text-amber-400 font-bold tracking-widest uppercase">Keselamatan</p>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 px-4 space-y-2">
            <div class="flex items-center px-4 py-4 bg-slate-700 text-white rounded-lg font-bold text-xs tracking-wider shadow-md">
                <span class="mr-3 text-base">🔐</span> LOG MASUK
            </div>
        </nav>

        <div class="p-4 border-t border-slate-700 flex items-center space-x-3 mt-auto">
            <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-amber-400 font-black text-xs flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="truncate">
                <p class="text-[8px] uppercase font-bold tracking-wider text-amber-400">Tamu:</p>
                <p class="text-xs font-bold text-white">Pengawal Keselamatan</p>
            </div>
        </div>
    </div>

    <!-- Right Content -->
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-xl p-8">
                <!-- Logo & Title -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="p-1.5 bg-slate-900 border border-slate-700 rounded-lg">
                            <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-xl font-black tracking-widest text-white uppercase">Log Masuk</h1>
                    <p class="text-xs font-bold text-amber-400 mt-1 uppercase tracking-wider">Sistem E-Aduan KSAS</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div style="background:#fff4f4;border:1px solid #fecaca;color:#b91c1c;padding:12px;border-radius:10px;margin-bottom:16px;text-align:left;font-size:12px;">
                        <ul style="margin:0;padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

<form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Login Input (No Matrik / Staff ID) -->
                    <div class="mb-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">No. Matrik / Staff ID</label>
                        <input 
                            type="text" 
                            name="login_input" 
                            value="{{ old('login_input') }}"
                            placeholder="Contoh: D2023xxxx"
                            class="input-field"
                            required
                        >
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kata Laluan</label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="••••••••"
                            class="input-field"
                            required
                        >
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 text-amber-500 border-slate-600 rounded focus:ring-amber-500 bg-slate-700">
                            <span class="text-xs text-slate-400 font-medium">Remember saya</span>
                        </label>
                        
                        <a href="{{ route('password.request') }}" class="text-xs text-amber-400 hover:text-amber-300 font-medium underline">
                            Lupa kata laluan?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-400 text-slate-900 font-black text-sm tracking-widest rounded-lg shadow-md transition-all uppercase">
                        Log Masuk
                    </button>

                    <!-- Register Link -->
                    <div class="text-center mt-6 pt-4 border-t border-slate-700">
                        <p class="text-xs text-slate-400">
                            Tiada akaun? 
                            <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 font-bold underline">
                                Daftar Akaun Baru
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">
                    © 2024 Bahagian Keselamatan KSAS
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
