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
                <a href="{{ route('user.index') }}" class="flex items-center px-4 py-4 bg-slate-700 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">📊</span> DASHBOARD
                </a>
                <button @click="openModal = true" class="w-full flex items-center px-4 py-4 bg-slate-700 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">⚡</span> KES KECEMASAN
                </button>
                <a href="{{ route('complaints.index') }}" class="flex items-center px-4 py-4 bg-amber-500 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">🗂️</span> REKOD ADUAN
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-4 bg-slate-700 text-white rounded-lg font-bold text-sm tracking-wider shadow-md">
                    <span class="mr-3 text-lg">👤</span> TETAPAN
                </a>
            </nav>

            <div class="p-3 border-t border-slate-700 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-black text-xs tracking-widest transition-all shadow-sm group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 mr-3 text-white group-hover:text-white transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
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
        <main class="flex-1 p-6 md:p-10 overflow-y-auto">
            @if (session('success'))
                <div style="background:#ecfdf5;border:1px solid #34d399;color:#065f46;padding:10px 12px;border-radius:10px;margin-bottom:12px;font-size:12px;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:10px 12px;border-radius:10px;margin-bottom:12px;font-size:12px;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4 border-b border-slate-200 pb-6">
                <div>
                    <h1 class="text-xl font-black tracking-widest text-slate-900 uppercase md:text-2xl">Pangkalan Data Kronologi Laporan</h1>
                    <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Senarai sulit & rasmi aduan yang telah dikemukakan oleh anda</p>
                </div>

<button @click="openModal = true" class="w-full lg:w-auto px-6 py-4 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold tracking-wider rounded-xl shadow-md border border-amber-400 transition-all flex items-center justify-center uppercase">
                    🚨 Failkan Aduan Baharu
                </button>
            </div>


            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-200">
                                <th class="py-4 px-6">Klasifikasi / Ringkasan Isu</th>
                                <th class="py-4 px-6">Kategori Siasatan</th>
                                <th class="py-4 px-6">Masa & Tarikh Log</th>
                                <th class="py-4 px-6">Geolokasi / Tempat</th>
                                <th class="py-4 px-6 text-center">Status Operasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-slate-100 text-slate-700 font-semibold">
                            @php
                                $user_complaints = DB::table('complaints')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
                            @endphp
                            @forelse($user_complaints as $complaint)
                                <tr class="hover:bg-slate-50/60 transition-colors">
<td class="py-4 px-6">
                                        <div class="flex flex-col space-y-2">
                                            <!-- Gambar dalam box berborder -->
                                            <div class="w-20 h-20 rounded-lg overflow-hidden border-2 border-slate-200 shadow-sm bg-slate-50 flex items-center justify-center">
                                                @if(!empty($complaint->evidence_url) && (str_starts_with($complaint->evidence_url, 'http://') || str_starts_with($complaint->evidence_url, 'https://')))
                                                    <a href="{{ $complaint->evidence_url }}" target="_blank">
                                                        <img src="{{ $complaint->evidence_url }}" alt="Bukti" class="w-full h-full object-cover hover:scale-110 transition-transform">
                                                    </a>
                                                @elseif(!empty($complaint->evidence_photos))
                                                    @php
                                                        $photos = is_array($complaint->evidence_photos)
                                                            ? $complaint->evidence_photos
                                                            : json_decode($complaint->evidence_photos, true);
                                                        $photosOk = is_array($photos) && count($photos) > 0;
                                                    @endphp

                                                    @if($photosOk)
                                                        @php
                                                            $firstPhoto = (string) $photos[0];
                                                            $isAbsolute = str_starts_with($firstPhoto, 'http://') || str_starts_with($firstPhoto, 'https://');
                                                            $supabaseBase = rtrim((string) config('services.supabase.url'), '/');
                                                            $bucket = (string) config('services.supabase.storage_bucket', 'evidence');
                                                            $firstPhotoUrl = $isAbsolute
                                                                ? $firstPhoto
                                                                : ($supabaseBase . '/storage/v1/object/public/' . $bucket . '/' . ltrim($firstPhoto, '/'));
                                                        @endphp
                                                        <a href="{{ $firstPhotoUrl }}" target="_blank">
                                                            <img src="{{ $firstPhotoUrl }}" alt="Bukti" class="w-full h-full object-cover hover:scale-110 transition-transform">
                                                        </a>
                                                    @elseif(!empty($complaint->evidence_photo))
                                                        @php
                                                            $singlePhoto = (string) $complaint->evidence_photo;
                                                            $singleAbsolute = str_starts_with($singlePhoto, 'http://') || str_starts_with($singlePhoto, 'https://');
                                                            $supabaseBase = rtrim((string) config('services.supabase.url'), '/');
                                                            $bucket = (string) config('services.supabase.storage_bucket', 'evidence');
                                                            $singlePhotoUrl = $singleAbsolute
                                                                ? $singlePhoto
                                                                : ($supabaseBase . '/storage/v1/object/public/' . $bucket . '/' . ltrim($singlePhoto, '/'));
                                                        @endphp
                                                        <a href="{{ $singlePhotoUrl }}" target="_blank">
                                                            <img src="{{ $singlePhotoUrl }}" alt="Bukti" class="w-full h-full object-cover hover:scale-110 transition-transform">
                                                        </a>
                                                    @else
                                                        <span class="text-xl">📷</span>
                                                    @endif
                                                @elseif(!empty($complaint->evidence_photo))
                                                    @php
                                                        $singlePhoto = (string) $complaint->evidence_photo;
                                                        $singleAbsolute = str_starts_with($singlePhoto, 'http://') || str_starts_with($singlePhoto, 'https://');
                                                        $supabaseBase = rtrim((string) config('services.supabase.url'), '/');
                                                        $bucket = (string) config('services.supabase.storage_bucket', 'evidence');
                                                        $singlePhotoUrl = $singleAbsolute
                                                            ? $singlePhoto
                                                            : ($supabaseBase . '/storage/v1/object/public/' . $bucket . '/' . ltrim($singlePhoto, '/'));
                                                    @endphp
                                                    <a href="{{ $singlePhotoUrl }}" target="_blank">
                                                        <img src="{{ $singlePhotoUrl }}" alt="Bukti" class="w-full h-full object-cover hover:scale-110 transition-transform">
                                                    </a>

                                                @else
                                                    <span class="text-2xl">📷</span>
                                                @endif
                                            </div>
                                            <!-- Info di bawah gambar -->
                                            <div>
                                                <div class="font-bold text-slate-900 text-sm tracking-wide">{{ $complaint->title }}</div>
                                                <div class="text-xs text-slate-400 line-clamp-2 mt-0.5 font-normal">{{ $complaint->description }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-800 text-[10px] font-black rounded border border-slate-200 uppercase tracking-wider">{{ $complaint->category_id }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-[11px] text-slate-600">
                                        <div class="font-mono">📅 {{ date('d-m-Y', strtotime($complaint->complaint_date)) }}</div>
                                        <div class="text-slate-400 font-mono mt-0.5">⏰ {{ date('H:i', strtotime($complaint->complaint_time)) }}</div>
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 font-medium">📍 {{ $complaint->location }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if(in_array(strtolower($complaint->status), ['baru', 'new']))
                                            <span class="inline-flex items-center px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-[10px] font-extrabold uppercase border border-blue-200 tracking-widest">● BARU</span>
                                        @elseif(in_array(strtolower($complaint->status), ['pending', 'dalam proses', 'in progress', 'proses']))
                                            <span class="inline-flex items-center px-2.5 py-1 rounded bg-amber-50 text-amber-700 text-[10px] font-extrabold uppercase border border-amber-200 tracking-widest">● PROSES</span>
                                        @elseif(in_array(strtolower($complaint->status), ['investigation', 'siasatan']))
                                            <span class="inline-flex items-center px-2.5 py-1 rounded bg-purple-50 text-purple-700 text-[10px] font-extrabold uppercase border border-purple-200 tracking-widest">● SIASATAN</span>
                                        @elseif(in_array(strtolower($complaint->status), ['selesai', 'resolved', 'completed']))
                                            <span class="inline-flex items-center px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 text-[10px] font-extrabold uppercase border border-emerald-200 tracking-widest">✓ SELESAI</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded bg-slate-50 text-slate-600 text-[10px] font-extrabold uppercase border border-slate-200 tracking-widest">{{ strtoupper($complaint->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        <div class="text-3xl mb-2">⚠️</div>
                                        <div class="text-xs font-bold uppercase tracking-widest">Tiada Fail Laporan Berdaftar</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

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
