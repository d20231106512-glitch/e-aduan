@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-wrap items-center justify-between gap-4 print:hidden">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center gap-3">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase">Bulan</label>
                <select name="month" class="mt-1 block p-2 border border-gray-300 rounded text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    @for($m = 1; $m <= 12; $m++)
                        @php
                        $monthValue=sprintf('%02d', $m);
                        $bulanMelayu=[
                        1=> 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
                        5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
                        ];
                        @endphp
                        <option value="{{ $monthValue }}" {{ $selectedMonth == $monthValue ? 'selected' : '' }}>
                            {{ $bulanMelayu[$m] }}
                        </option>
                        @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase">Tahun</label>
                <select name="year" class="mt-1 block p-2 border border-gray-300 rounded text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    <option value="2026" {{ $selectedYear == '2026' ? 'selected' : '' }}>2026</option>
                    <option value="2025" {{ $selectedYear == '2025' ? 'selected' : '' }}>2025</option>
                </select>
            </div>
            <button type="submit" class="mt-5 bg-slate-800 text-white px-4 py-2 text-sm font-bold rounded hover:bg-slate-700 transition">
                Tapis Analitis
            </button>
        </form>

        <button onclick="window.print()" class="bg-blue-600 text-white px-5 py-2.5 text-sm font-bold rounded shadow hover:bg-blue-700 transition flex items-center gap-2">
            🖨️ Eksport / Cetak Laporan PDF
        </button>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 print:border-0 print:shadow-none space-y-6">

        <div class="text-center border-b-2 border-slate-800 pb-4">
            <h1 class="text-2xl font-black text-slate-900 tracking-wide uppercase">Portal Pengurusan e-Aduan</h1>
            <p class="text-sm text-gray-600 font-medium">Kampus Sultan Azlan Shah (KSAS), Universiti Pendidikan Sultan Idris</p>
            <p class="text-xs text-gray-400 mt-1 uppercase font-bold tracking-widest">
                Ringkasan Insiden Bulanan: @php echo $bulanMelayu[(int)$selectedMonth] ?? date('F', mktime(0, 0, 0, $selectedMonth, 1)); @endphp {{ $selectedYear }}
            </p>
        </div>

        <div class="grid grid-cols-4 gap-4 text-center">
            <div class="p-4 bg-slate-50 rounded border border-gray-100">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Jumlah Laporan</h4>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalComplaints }}</p>
            </div>
            <div class="p-4 bg-yellow-50 rounded border border-yellow-100">
                <h4 class="text-xs font-bold text-yellow-600 uppercase">Baru Dihantar</h4>
                <p class="text-2xl font-extrabold text-yellow-700 mt-1">{{ $pendingCount }}</p>
            </div>
            <div class="p-4 bg-blue-50 rounded border border-blue-100">
                <h4 class="text-xs font-bold text-blue-600 uppercase">Dalam Siasatan</h4>
                <p class="text-2xl font-extrabold text-blue-700 mt-1">{{ $investigatingCount }}</p>
            </div>
            <div class="p-4 bg-green-50 rounded border border-green-100">
                <h4 class="text-xs font-bold text-green-600 uppercase">Selesai</h4>
                <p class="text-2xl font-extrabold text-green-700 mt-1">{{ $resolvedCount }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-bold text-slate-700 uppercase mb-3 border-b border-gray-200 pb-1">Senarai Rekod Insiden Terperinci</h3>
            <table class="w-full text-left text-xs border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-700 font-bold uppercase">
                        <th class="p-2 border border-gray-200">Kategori / Tajuk</th>
                        <th class="p-2 border border-gray-200">Lokasi</th>
                        <th class="p-2 border border-gray-200">Tarikh Log</th>
                        <th class="p-2 border border-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthlyRecords as $record)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-2 border border-gray-200 font-semibold capitalize">
                            {{ $record->title ?? ($record->category ?? 'Laporan Umum') }}
                        </td>
                        <td class="p-2 border border-gray-200 text-gray-600">
                            {{ $record->location ?? 'Tidak Dinyatakan' }}
                        </td>
                        <td class="p-2 border border-gray-200 text-gray-500">
                            {{ isset($record->created_at) ? date('Y-m-d H:i', strtotime($record->created_at)) : 'N/A' }}
                        </td>
                        <td class="p-2 border border-gray-200 font-medium">
                            @switch(strtolower($record->status ?? 'submitted'))
                            @case('baru') @case('submitted') @case('pending') [Baru] @break
                            @case('in_progress') @case('in progress') @case('investigating') [Siasatan] @break
                            @case('resolved') [Selesai] @break
                            @case('rejected') [Ditolak] @break
                            @default [{{ $record->status }}]
                            @endswitch
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-400">Tiada tindakan aduan direkodkan sepanjang tempoh kalendar ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-12 hidden print:flex justify-between items-center text-xs text-gray-500">
            <div>
                <p>Dijana melalui Sistem Pentadbir: {{ date('Y-m-d H:i:s') }}</p>
            </div>
            <div class="text-center w-48 border-t border-slate-400 pt-2">
                <p class="font-bold text-slate-800">Tandatangan Sah</p>
                <p>Pengurusan Keselamatan KSAS</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .w-64 {
            display: none !important;
        }

        body {
            background-color: #ffffff !important;
        }

        .bg-gray-100 {
            background-color: #ffffff !important;
        }
    }
</style>
@endsection