<x-app-layout>
    <div x-data="{ openModal: {{ ($errors->any() ? 'true' : 'false') }} }" class="flex min-h-screen bg-white text-slate-800 antialiased font-sans">
        
<!-- Sidebar -->
        <aside class="w-64 bg-slate-800 flex flex-col pt-6 border-r border-slate-700 shadow-sm z-10 min-h-screen flex-shrink-0">
            <div class="px-5 mb-6 border-b border-slate-700 pb-5">
                <div class="flex items-center space-x-3">
                    <x-application-logo />
                    <div>
                        <h2 class="text-xs font-black tracking-widest text-amber-400 uppercase">E-ADUAN KSAS</h2>
                        <div class="flex items-center space-x-1 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                            <p class="text-[9px] text-amber-400 font-bold tracking-widest uppercase">Keselamatan</p>
                        </div>
                    </div>
                </div>
            </div>
            
<nav class="flex-1 px-3 space-y-2">
                <a href="{{ route('user.index') }}" class="flex items-center px-4 py-4 bg-amber-500 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">📊</span> DASHBOARD
                </a>
<button @click="openModal = true" class="w-full flex items-center px-4 py-4 bg-slate-700 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">⚡</span> KES KECEMASAN
                </button>
                <a href="{{ route('complaints.index') }}" class="flex items-center px-4 py-4 bg-slate-700 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">🗂️</span> REKOD ADUAN
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-4 bg-slate-700 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">👤</span> TETAPAN
                </a>
            </nav>

<div class="p-3 border-t border-slate-700 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-3 text-red-600 hover:text-red-700 font-black text-xs tracking-widest transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-3 text-red-500 group-hover:text-red-600 transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        LOG KELUAR
                    </button>
                </form>
            </div>

<div class="p-3 border-t border-slate-700 bg-slate-900 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-amber-400 font-black text-xs flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="truncate">
                    <p class="text-[8px] uppercase font-bold tracking-wider text-amber-400">Pengguna:</p>
                    <p class="text-xs font-bold text-amber-400 truncate">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </aside>

<!-- Main Content -->
            <main class="flex-1 p-6 md:p-10 overflow-y-auto bg-white">
                <div class="px-6 mb-8 border-b border-slate-200 pb-6">
                    <h1 class="text-xl font-black tracking-widest text-slate-900 uppercase md:text-2xl">Selamat Datang ke Sistem E-Aduan KSAS</h1>
                    <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Sistem E-Aduan Keselamatan KSAS</p>
                </div>

                <!-- Status Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                    
                    <!-- Jumlah Siasatan -->
                    <div class="bg-gradient-to-br from-violet-900 via-purple-900 to-fuchsia-900 p-4 md:p-6 rounded-2xl border border-violet-700 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-bold text-violet-400 uppercase tracking-wider">Siasatan</div>
                            <div class="text-xl">🔍</div>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-violet-400 mt-2">
                            {{ DB::table('complaints')->where('user_id', Auth::id())->whereIn('status', ['investigation', 'Investigation', 'siasatan', 'Siasatan', 'SIASATAN', 'dalam siasatan'])->count() }}
                        </div>
                        <div class="text-xs text-violet-500 mt-2 bg-violet-900 inline-block px-2 py-0.5 rounded-full">Diproses 🔄</div>
                    </div>

                    <!-- Kes Baharu -->
                    <div class="bg-gradient-to-br from-cyan-900 via-teal-900 to-emerald-900 p-4 md:p-6 rounded-2xl border border-cyan-700 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-bold text-cyan-400 uppercase tracking-wider">Kes Baharu</div>
                            <div class="text-xl">🆕</div>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-cyan-400 mt-2">
                            {{ DB::table('complaints')->where('user_id', Auth::id())->whereIn('status', ['baru', 'Baru', 'new', 'New', 'BARU'])->count() }}
                        </div>
                        <div class="text-xs text-cyan-500 mt-2 bg-cyan-900 inline-block px-2 py-0.5 rounded-full">Menunggu ⏳</div>
                    </div>

                    <!-- Kes Selesai -->
                    <div class="bg-gradient-to-br from-emerald-900 via-green-900 to-teal-900 p-4 md:p-6 rounded-2xl border border-emerald-700 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Selesai</div>
                            <div class="text-xl">✅</div>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-emerald-400 mt-2">
                            {{ DB::table('complaints')->where('user_id', Auth::id())->whereIn('status', ['selesai', 'Selesai', 'resolved', 'Resolved', 'completed', 'Completed', 'SELESAI'])->count() }}
                        </div>
                        <div class="text-xs text-emerald-500 mt-2 bg-emerald-900 inline-block px-2 py-0.5 rounded-full">Siap 🎉</div>
                    </div>

                    <!-- Jumlah Kes -->
                    <div class="bg-gradient-to-br from-slate-700 via-slate-700 to-slate-800 p-4 md:p-6 rounded-2xl border border-slate-600 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-bold text-amber-400 uppercase tracking-wider">Jumlah</div>
                            <div class="text-xl">📈</div>
                        </div>
                        <div class="text-3xl md:text-4xl font-black text-amber-400 mt-2">
                            {{ DB::table('complaints')->where('user_id', Auth::id())->count() }}
                        </div>
                        <div class="text-xs text-amber-500 mt-2 bg-slate-700 inline-block px-2 py-0.5 rounded-full">Keseluruhan 📊</div>
                    </div>

</div>
            </main>

        <!-- Modal Popup Borang Aduan Baharu -->
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-cloak x-transition>
            <div class="bg-white border border-slate-200 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden" @click.away="openModal = false">
                <div class="px-6 py-4 bg-slate-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">Borang Kenyataan Laporan</h3>
                        <p class="text-[10px] text-amber-400 uppercase font-bold">Pusat Kawalan & Keselamatan KSAS</p>
                    </div>
                    <button @click="openModal = false" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                </div>
                
                <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="p-6 space-y-4 bg-white">
                    @csrf

                    @if ($errors->any())
                        <div style="background:#fff4f4;border:1px solid #fecaca;color:#b91c1c;padding:10px;border-radius:10px;margin-bottom:12px;text-align:left;font-size:12px;">
                            <ul style="margin:0;padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Tajuk Utama Insiden</label>
                        <input type="text" name="title" required placeholder="Nyatakan subjek insiden..." class="w-full bg-slate-50 rounded-xl border-slate-200 text-slate-800 text-xs py-2.5">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Klasifikasi Kes</label>
                        <select name="category_id" required class="w-full bg-slate-50 rounded-xl border-slate-200 text-slate-700 text-xs py-2.5">
                            <option value="">-- PILIH KLASIFIKASI KES --</option>
                            <option value="Kecurian">🚨 KECURIAN</option>
                            <option value="Fasiliti">🛠️ FASILITI / KEROSAKAN</option>
                            <option value="Gangguan">⚠️ GANGGUAN</option>
                            <option value="Lain-lain">🗂️ LAIN-LAIN</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Tarikh Kejadian</label>
                            <input type="date" name="complaint_date" required class="w-full bg-slate-50 rounded-xl border-slate-200 text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Masa Kejadian</label>
                            <input type="time" name="complaint_time" required class="w-full bg-slate-50 rounded-xl border-slate-200 text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Lokasi Spesifik</label>
                        <input type="text" name="location" required placeholder="Contoh: Blok B2, Makmal Komputer" class="w-full bg-slate-50 rounded-xl border-slate-200 text-xs py-2.5">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Pernyataan Kronologi Kes</label>
                        <textarea name="description" rows="3" required placeholder="Sila berikan butiran lengkap..." class="w-full bg-slate-50 rounded-xl border-slate-200 text-xs"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Gambar Aduan / Bukti (Pilihan)</label>
                        <input type="file" name="evidence_photos[]" multiple accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="w-full bg-slate-50 rounded-xl border border-slate-200 text-slate-700 text-xs p-2.5 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-amber-400 hover:file:bg-slate-800 transition-all">
                        <p class="text-[9px] text-slate-400 mt-1 font-medium">Format dibenarkan: JPG, JPEG, PNG, WEBP (Maksimum 2MB setiap gambar)</p>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl uppercase">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-amber-400 text-xs font-black rounded-xl uppercase">Sahkan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
