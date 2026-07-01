<x-app-layout>
    <div x-data="{ openModal: false }" class="flex min-h-screen bg-white antialiased font-sans">
        
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
                <a href="{{ route('user.index') }}" class="flex items-center px-4 py-4 bg-slate-700 text-amber-400 rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">📊</span> DASHBOARD
                </a>
                <button @click="openModal = true" class="w-full flex items-center px-4 py-4 bg-slate-700 text-amber-400 rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">⚡</span> KES KECEMASAN
                </button>
                <a href="{{ route('complaints.index') }}" class="flex items-center px-4 py-4 bg-slate-700 text-amber-400 rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">🗂️</span> REKOD ADUAN
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-4 bg-amber-500 text-slate-900 rounded-lg font-bold text-sm tracking-wider shadow-md">
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

<!-- ================= PANEL PROFIL (BERI RUANG ATAS) ================= -->
        <main class="flex-1 p-6 md:p-10 overflow-y-auto pt-20 md:pt-10">
            <!-- Back Button -->
            <a href="{{ route('complaints.index') }}" class="inline-flex items-center px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-bold mb-4 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                KEMBALI
            </a>
            
            <div class="mb-8 border-b border-slate-200 pb-6">
                <h1 class="text-xl font-black tracking-widest text-slate-900 uppercase md:text-2xl">Akaun & Keselamatan Pengguna</h1>
                <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Aras Keizinan: Pengadu Sah Sistem Kebajikan & Keselamatan KSAS</p>
            </div>

            <div class="max-w-4xl space-y-6">
                <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-slate-400"></div>
                    <div class="max-w-2xl text-slate-800">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-slate-900"></div>
                    <div class="max-w-2xl text-slate-800">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-red-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-red-600"></div>
                    <div class="max-w-2xl text-slate-800">
                        @include('profile.partials.delete-user-form')
                    </div>
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
                        <input type="file" name="evidence_photos[]" multiple accept=".jpg,.jpeg,.png,.webp" class="w-full bg-slate-50 rounded-xl border border-slate-200 text-slate-700 text-xs p-2.5 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-amber-400 hover:file:bg-slate-800">
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
