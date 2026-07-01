@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto p-4 space-y-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-gray-900 uppercase">Portal Pengurusan E-Aduan</h1>
            <p class="text-sm text-gray-500 font-medium">Kampus Sultan Azlan Shah (KSAS), Universiti Pendidikan Sultan Idris</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase px-4 py-2.5 rounded transition shadow-sm text-center">
            Lihat Analisis Laporan
        </a>
    </div>

    <form action="{{ route('admin.complaints.index') }}" method="GET" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row gap-4 items-center">
        <div class="w-full flex-1">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Cari Aduan</label>
            <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Taip tajuk aduan di sini..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
        </div>

        <div class="w-full md:w-56">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kategori</label>
            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 capitalize">
                <option value="">-- Semua Kategori --</option>
                @foreach($allCategories as $cat)
                <option value="{{ $cat }}" {{ $selectedCategory == $cat ? 'selected' : '' }}>
                    {{ str_replace('_', ' ', $cat) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-auto flex gap-2 pt-5">
            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase px-5 py-2.5 rounded transition shadow-sm">
                🔍 Tapis
            </button>
            <a href="{{ route('admin.complaints.index') }}" class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs uppercase px-4 py-2.5 rounded transition shadow-sm flex items-center justify-center border border-gray-200">
                🔄 Set Semula
            </a>
        </div>
    </form>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Senarai Rekod Aduan Pelajar</h2>
            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full border border-blue-100">
                Jumlah: {{ count($complaints ?? []) }} Aduan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100/70 border-b border-gray-200 text-gray-500 text-xs font-bold uppercase tracking-wider">
                        <th class="p-4">Tajuk / Kategori</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Tarikh Log</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse($complaints as $complaint)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="p-4 font-bold text-gray-900 capitalize">
                            {{ str_replace('_', ' ', $complaint->title ?? $complaint->category_id ?? 'Aduan Umum') }}
                        </td>
                        <td class="p-4 text-gray-600 capitalize">
                            {{ $complaint->location ?? 'Tidak Dinyatakan' }}
                        </td>
                        <td class="p-4 text-gray-500 font-medium">
                            {{ !empty($complaint->created_at) ? date('Y-m-d H:i', strtotime($complaint->created_at)) : 'N/A' }}
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-xs uppercase tracking-wide px-2.5 py-1 rounded-full
                                {{ in_array(strtolower($complaint->status ?? ''), ['submitted', 'baru', 'pending']) ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                {{ in_array(strtolower($complaint->status ?? ''), ['investigating', 'in progress', 'in_progress', 'siasatan']) ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                {{ in_array(strtolower($complaint->status ?? ''), ['resolved', 'selesai']) ? 'bg-green-50 text-green-700 border border-green-100' : '' }}
                                {{ in_array(strtolower($complaint->status ?? ''), ['rejected', 'ditolak']) ? 'bg-red-50 text-red-700 border border-red-100' : '' }}
                            ">
                                @switch(strtolower($complaint->status ?? 'submitted'))
                                @case('baru') @case('submitted') @case('pending') [Baru] @break
                                @case('in_progress') @case('in progress') [Siasatan] @break
                                @case('resolved') [Selesai] @break
                                @case('rejected') [Ditolak] @break
                                @default [{{ $complaint->status }}]
                                @endswitch
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ url('/admin/complaints/' . $complaint->id) }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-bold text-xs uppercase tracking-wider whitespace-nowrap">
                                <span>Urus Kes</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400 font-medium bg-gray-50/30">
                            Tiada sebarang log aduan aktif dijumpai dalam pangkalan data.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection