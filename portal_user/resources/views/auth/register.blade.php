<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akaun | E-Aduan KSAS UPSI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f8fafc; 
            margin: 0; 
        }
        
        .input-field { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #d6d3d1; border-radius: 8px; box-sizing: border-box; transition: 0.2s; }
        .input-field:focus { border-color: #d97706; outline: none; box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1); }
    </style>
</head>
<body>

<div class="min-h-screen flex bg-slate-50">
    <!-- Left Sidebar -->
    <div class="w-72 bg-amber-50 flex flex-col pt-8 border-r border-amber-200 shadow-sm z-10 hidden md:flex">
        <div class="px-6 mb-8 border-b border-amber-100 pb-6">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 p-2.5 bg-gradient-to-br from-amber-700 to-amber-900 border border-amber-600/70 rounded-xl shadow-md">
                    <svg class="w-7 h-7 text-amber-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-black tracking-widest text-slate-900 uppercase">E-ADUAN KSAS UPSI</h2>
                    <div class="flex items-center space-x-1 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                        <p class="text-[10px] text-amber-700 font-bold tracking-widest uppercase">Bahagian Keselamatan UPSI</p>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 px-4 space-y-2">
            <div class="flex items-center px-4 py-4 bg-amber-100 text-amber-800 rounded-lg font-bold text-sm tracking-wider border border-amber-200">
                <span class="mr-4 text-lg">📝</span> DAFTAR AKAUN
            </div>
        </nav>

        <div class="p-4 border-t border-amber-200 flex items-center space-x-3 mt-auto">
            <div class="w-9 h-9 rounded-lg bg-amber-600 flex items-center justify-center text-white font-black text-xs flex-shrink-0">
                ID
            </div>
            <div class="truncate">
                <p class="text-[9px] uppercase font-bold tracking-wider text-amber-700">Tamu:</p>
                <p class="text-xs font-bold text-amber-900">Pengawal Keselamatan</p>
            </div>
        </div>
    </div>

    <!-- Right Content -->
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-lg p-8">
                <!-- Logo & Title -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-gradient-to-br from-amber-700 to-amber-900 rounded-xl shadow-md">
                            <svg class="w-10 h-10 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-xl font-black tracking-widest text-slate-900 uppercase">Daftar Akaun</h1>
                    <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Sistem E-Aduan KSAS UPSI</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama Penuh -->
                    <div class="mb-4">
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Nama Penuh</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="Contoh: Azza Aziela"
                            class="input-field bg-slate-50 text-slate-800"
                            required
                            autofocus
                        >
                    </div>

                    <!-- No Matrik / Staff ID -->
                    <div class="mb-4">
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">No. Matrik / Staff ID</label>
                        <input 
                            type="text" 
                            name="username" 
                            value="{{ old('username') }}"
                            placeholder="Contoh: D2023xxxx"
                            class="input-field bg-slate-50 text-slate-800"
                            required
                        >
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Kata Laluan</label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="最小 8 aksara"
                            class="input-field bg-slate-50 text-slate-800"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Sahkan Kata Laluan</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            placeholder="Ulang semula kata laluan"
                            class="input-field bg-slate-50 text-slate-800"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 bg-amber-600 hover:bg-amber-700 text-white font-black text-sm tracking-widest rounded-lg shadow-md transition-all uppercase">
                        Daftar Akaun
                    </button>

                    <!-- Login Link -->
                    <div class="text-center mt-6 pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-500">
                            Sudah mendaftar? 
                            <a href="{{ route('login') }}" class="text-amber-700 hover:text-amber-900 font-bold underline">
                                Log Masuk
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">
                    © 2024 Bahagian Keselamatan KSAS UPSI
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
