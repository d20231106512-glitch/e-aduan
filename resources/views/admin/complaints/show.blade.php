@extends('layouts.admin')

@section('content')
<style>
    /* ==========================================
       🖥️ 1. GAYA KHUSUS UNTUK PAPARAN SKRIN UTAMA
       (Menyembunyikan jadual PDF daripada skrin urus kes)
       ========================================== */
    .print-only-table {
        display: none !important;
    }

    /* ==========================================
       🖨️ 2. GAYA PREMIUM APBILA DICETAK (PRINT MODE FIX)
       ========================================== */
    @media print {

        /* 1. Sembunyikan SEMUA elemen layout asal termasuk wrapper screen */
        aside,
        .sidebar,
        nav,
        button,
        a,
        form,
        .no-print,
        [role="navigation"],
        .screen-view {
            display: none !important;
        }

        /* 2. Rapatkan ruang atas kertas (Selesaikan masalah kosong di atas) */
        html,
        body {
            background-color: #ffffff !important;
            color: #000000 !important;
            font-family: Arial, sans-serif !important;
            width: 100% !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            /* Buang padding bawaan body */
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Paksa semua container untuk bermula dari atas sekali */
        div,
        main,
        section {
            overflow: visible !important;
            position: relative !important;
            display: block !important;
            width: 100% !important;
            margin-top: 0 !important;
            /* Paksa rapat ke atas */
            padding-top: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }

        /* 3. Laraskan kedudukan Kepala Surat Rasmi Cetakan */
        .print-header {
            display: block !important;
            border-bottom: 3px double #000000 !important;
            padding-top: 5mm !important;
            /* Berikan sedikit ruang kemas dari bucu kertas */
            padding-bottom: 5mm !important;
            margin-top: 0 !important;
            margin-bottom: 15px !important;
            text-align: center !important;
        }

        /* 4. AKTIFKAN JADUAL RASMI */
        .print-only-table {
            display: table !important;
            visibility: visible !important;
            opacity: 1 !important;
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 0 !important;
            table-layout: fixed !important;
        }

        .print-only-table tr {
            page-break-inside: avoid !important;
        }

        .print-only-table th,
        .print-only-table td {
            border: 1px solid #000000 !important;
            padding: 8px 10px !important;
            /* Sedikit rapat untuk memenuhkan ruang */
            text-align: left !important;
            vertical-align: middle !important;
            font-size: 11pt !important;
            word-wrap: break-word !important;
        }

        .print-only-table th {
            background-color: #f2f2f2 !important;
            width: 25% !important;
            font-weight: bold !important;
        }

        /* Kawalan Gambar Di Dalam Jadual */
        .print-img {
            max-height: 75mm !important;
            /* Besarkan sedikit saiz gambar untuk memenuhkan halaman */
            max-width: 100% !important;
            display: block !important;
            margin: 5px 0 !important;
            object-fit: contain !important;
        }

        /* Blok Tandatangan */
        .print-sig-box {
            display: block !important;
            margin-top: 30px !important;
            page-break-inside: avoid !important;
        }
    }
</style>

<div class="print-only-table print-header">
    <h2 class="text-xl font-bold uppercase tracking-wide">PUSAT KESELAMATAN KAMPUS (KSAS)</h2>
    <p class="text-xs uppercase font-semibold text-gray-600">Universiti Pendidikan Sultan Idris (UPSI)</p>
    <p class="text-xs text-gray-500 font-medium">LAPORAN RASMI PENGURUSAN KES ADUAN KESELAMATAN DIGITAL</p>
</div>

<table class="print-only-table">
    <tr>
        <th>ID Rujukan Kes</th>
        <td>#{{ $complaint->id }}</td>
    </tr>
    <tr>
        <th>Tajuk Insiden</th>
        <td class="font-bold capitalize">{{ $complaint->title ?? ($complaint->category_id ?? 'Laporan Umum') }}</td>
    </tr>
    <tr>
        <th>Tarikh Direkod</th>
        <td>{{ isset($complaint->created_at) ? date('Y-m-d H:i', strtotime($complaint->created_at)) : 'N/A' }}</td>
    </tr>
    <tr>
        <th>Status Semasa</th>
        <td class="font-bold uppercase">
            @switch(strtolower($complaint->status ?? 'baru'))
            @case('baru') @case('submitted') @case('pending') BARU @break
            @case('in_progress') @case('in progress') DALAM SIASATAN @break
            @case('resolved') SELESAI @break
            @case('rejected') DITOLAK @break
            @default {{ $complaint->status }}
            @endswitch
        </td>
    </tr>
    <tr>
        <th>Lokasi / Blok Kejadian</th>
        <td>{{ $complaint->location ?? 'Tidak Dinyatakan' }}</td>
    </tr>
    <tr>
        <th>Pegawai Pengendali</th>
        <td>{{ $complaint->assigned_to ?? 'Belum Ditugaskan / Barisan Terbuka' }}</td>
    </tr>
    <tr>
        <th>Butiran & Kronologi Kes</th>
        <td style="white-space: pre-line;">{{ $complaint->description ?? 'Tiada butiran teks.' }}</td>
    </tr>
    @if(!empty($complaint->status_remarks))
    <tr>
        <th>Nota / Ulasan Tindakan</th>
        <td class="font-medium text-blue-900">{{ $complaint->status_remarks }}</td>
    </tr>
    @endif
    @if(!empty($complaint->evidence_photo))
    <tr>
        <th>Gambar Bukti Lampiran</th>
        <td>
            @php
            $supabaseUrl = "https://wnlompemvvirpfdouqhs.supabase.co";
            $bucketName = "evidence";
            $cleanedPath = ltrim($complaint->evidence_photo, '/');
            if (str_starts_with($cleanedPath, 'evidence/')) {
            $cleanedPath = substr($cleanedPath, strlen('evidence/'));
            }
            $imageSrc = filter_var($complaint->evidence_photo, FILTER_VALIDATE_URL) ? $complaint->evidence_photo : $supabaseUrl . "/storage/v1/object/public/" . $bucketName . "/" . ltrim($cleanedPath, '/');
            @endphp
            <img src="{{ $imageSrc }}" crossOrigin="anonymous" class="print-img rounded">
        </td>
    </tr>
    @endif
</table>

<div class="print-only-table print-sig-box">
    <div style="float: right; width: 250px; text-align: left; margin-top: 30px;">
        <p class="text-xs text-gray-500" style="font-size: 9pt; margin-bottom: 50px;">Tarikh Cetakan: {{ date('Y-m-d H:i') }}</p>
        <div style="border-bottom: 1px solid #000000; width: 100%; margin-bottom: 5px;"></div>
        <p class="text-xs font-bold uppercase" style="font-size: 10pt; margin: 0;">Tandatangan & Cop Rasmi</p>
        <p class="text-xs text-gray-600" style="font-size: 9pt; margin: 0;">Pengurus Pusat Keselamatan</p>
        <p class="text-xs text-gray-500" style="font-size: 9pt; margin: 0;">Kampus Sultan Abdul Jalil Shah (KSAS), UPSI</p>
    </div>
    <div style="clear: both;"></div>
</div>


<div class="max-w-4xl mx-auto screen-view">
    <a href="{{ route('admin.complaints.index') }}" class="text-sm text-blue-600 hover:underline no-print">&larr; Kembali ke Direktori Aduan</a>

    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 mt-4 space-y-6">

        @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 text-xs font-bold rounded border border-green-200 no-print">
            {{ session('success') }}
        </div>
        @endif

        <div class="flex justify-between items-start border-b border-gray-100 pb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 capitalize">
                    {{ $complaint->title ?? ($complaint->category_id ?? 'Laporan Umum') }}
                </h1>
                <p class="text-sm text-gray-400 mt-1">
                    Direkodkan pada: {{ isset($complaint->created_at) ? date('Y-m-d H:i', strtotime($complaint->created_at)) : 'N/A' }}
                </p>
            </div>
            <span class="px-3 py-1 text-sm font-bold rounded-full uppercase tracking-wider
                {{ in_array(strtolower($complaint->status ?? ''), ['submitted', 'baru', 'pending']) ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                {{ in_array(strtolower($complaint->status ?? ''), ['in progress', 'in_progress']) ? 'bg-blue-100 text-blue-800' : '' }}
                {{ strtolower($complaint->status ?? '') === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                {{ strtolower($complaint->status ?? '') === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
            ">
                Semasa:
                @switch(strtolower($complaint->status ?? 'baru'))
                @case('baru') @case('submitted') @case('pending') 📄 Baru @break
                @case('in_progress') @case('in progress') 🔍 Siasatan @break
                @case('resolved') ✅ Selesai @break
                @case('rejected') ❌ Ditolak @break
                @default {{ $complaint->status }}
                @endswitch
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lokasi / Blok</h3>
                <p class="text-gray-700 font-medium mt-1">{{ $complaint->location ?? 'Tidak Dinyatakan' }}</p>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pengendali Ditugaskan</h3>
                <p class="text-xs text-gray-700 font-bold mt-1 bg-gray-50 p-2.5 rounded border border-gray-100 block truncate">
                    👤 {{ $complaint->assigned_to ?? 'Belum Ditugaskan / Barisan Terbuka' }}
                </p>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kenyataan / Butiran Insiden</h3>
            <p class="text-gray-600 mt-2 bg-gray-50 p-4 rounded border border-gray-100 leading-relaxed">
                {{ $complaint->description ?? 'Tiada nota teks tambahan ditinggalkan oleh pengadu.' }}
            </p>
        </div>

        @if(!empty($complaint->status_remarks))
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nota Tindakan Terakhir Pentadbir</h3>
            <p class="text-sm font-semibold text-blue-800 mt-2 bg-blue-50 p-4 rounded border border-blue-100 leading-relaxed">
                📝 {{ $complaint->status_remarks }}
            </p>
        </div>
        @endif

        @if(!empty($complaint->evidence_photo))
        <div class="border-t border-gray-100 pt-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Gambar Bukti Lampiran</h3>
            <div class="inline-block relative group">
                @php
                $imageSrc = filter_var($complaint->evidence_photo, FILTER_VALIDATE_URL) ? $complaint->evidence_photo : $supabaseUrl . "/storage/v1/object/public/" . $bucketName . "/" . ltrim($cleanedPath, '/');
                @endphp
                <a href="{{ $imageSrc }}" target="_blank" class="block border border-gray-200 p-1 bg-gray-50 rounded-lg shadow-sm hover:shadow transition max-w-sm">
                    <img src="{{ $imageSrc }}" alt="Bukti e-Aduan" class="max-h-64 object-contain rounded-md block">
                    <div class="text-center text-xs font-semibold text-blue-600 mt-2 py-1 bg-white border border-gray-100 rounded">
                        🔍 Buka Gambar dalam Tab Baharu
                    </div>
                </a>
            </div>
        </div>
        @endif

        <div class="border-t border-gray-100 pt-6 bg-slate-50 -mx-8 -mb-8 p-8 rounded-b-lg no-print">
            <h2 class="text-lg font-bold text-slate-700 mb-1">Pengurusan & Agihan Kes Keselamatan</h2>
            <p class="text-xs text-gray-400 mb-4">Pilih fasa tindakan pentadbiran dan pilih anggota keselamatan untuk mengendalikan kes aduan ini.</p>

            <form action="{{ route('admin.complaints.updateStatus', $complaint->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Fasa Status Semasa</label>
                        <select name="status" class="block w-full p-2.5 bg-white border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-gray-700 shadow-sm">
                            <option value="baru" {{ in_array(strtolower($complaint->status ?? ''), ['submitted', 'baru', 'pending']) ? 'selected' : '' }}>📄 Set sebagai Baru</option>
                            <option value="in_progress" {{ in_array(strtolower($complaint->status ?? ''), ['in progress', 'in_progress']) ? 'selected' : '' }}>🔍 Set sebagai Dalam Siasatan</option>
                            <option value="resolved" {{ strtolower($complaint->status ?? '') === 'resolved' ? 'selected' : '' }}>✅ Tandakan Selesai</option>
                            <option value="rejected" {{ strtolower($complaint->status ?? '') === 'rejected' ? 'selected' : '' }}>❌ Tandakan Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Tugaskan Kepada (Pengendali)</label>
                        <select name="assigned_to" class="block w-full p-2.5 bg-white border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-semibold text-gray-700 shadow-sm">
                            <option value="">-- Kekalkan Barisan Terbuka --</option>
                            @foreach($officers as $officer)
                            <option value="{{ $officer->name }}" {{ ($complaint->assigned_to ?? '') === $officer->name ? 'selected' : '' }}>
                                👮 {{ $officer->name }} ({{ $officer->zone_assignment ?? 'Zon Umum' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">
                        Nota Tindakan / Penerangan Status <span class="text-red-500">*</span>
                    </label>
                    <textarea name="status_remarks" rows="3" required placeholder="Sila nyatakan ulasan tindakan kes atau sebab status ditukar..." class="block w-full p-2.5 bg-white border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-medium text-gray-700 shadow-sm">{{ $complaint->status_remarks ?? '' }}</textarea>
                </div>

                <div class="pt-2 flex flex-col md:flex-row justify-end gap-3">
                    <button type="button" onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white text-xs font-black uppercase tracking-wider px-6 py-3 rounded shadow transition-colors w-full md:w-auto text-center">
                        🖨️ Cetak Laporan Kes
                    </button>
                    <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white text-xs font-black uppercase tracking-wider px-6 py-3 rounded shadow transition-colors w-full md:w-auto">
                        💾 Simpan & Kemaskini Rekod Kes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection