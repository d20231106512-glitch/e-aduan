@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Paparan Analisis Pentadbir</h1>

    <div class="mb-8 w-full">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 border-l-4 border-blue-600">
            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Jumlah Aduan Direkodkan</h2>
            <p class="text-4xl font-extrabold text-gray-800 mt-2">{{ $totalComplaints }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Laporan Masuk Terbaharu</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                        <th class="p-3">Kategori / Tajuk</th>
                        <th class="p-3">Lokasi</th>
                        <th class="p-3">Tarikh & Masa</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($latestComplaints as $complaint)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-3 font-semibold text-gray-800 capitalize">
                            <span class="block text-xs font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded inline-block mb-1 border border-blue-100 w-fit">
                                {{ str_replace('_', ' ', $complaint->category_id ?? 'Umum') }}
                            </span>
                            <div class="text-gray-900 font-bold truncate max-w-xs">
                                {{ $complaint->title ?? 'Laporan Tanpa Tajuk' }}
                            </div>
                        </td>
                        <td class="p-3 text-gray-600">{{ $complaint->location ?? 'Tidak Dinyatakan' }}</td>
                        <td class="p-3 text-gray-500">
                            {{ !empty($complaint->created_at) ? date('Y-m-d (H:i)', strtotime($complaint->created_at)) : 'N/A' }}
                        </td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full uppercase tracking-wider
                                {{ in_array(strtolower($complaint->status ?? ''), ['baru', 'submitted', 'pending']) ? 'bg-slate-100 text-slate-700' : '' }}
                                {{ strtolower($complaint->status ?? '') === 'acknowledged' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ in_array(strtolower($complaint->status ?? ''), ['in progress', 'in_progress']) ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ strtolower($complaint->status ?? '') === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ strtolower($complaint->status ?? '') === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                @switch(strtolower($complaint->status ?? 'submitted'))
                                @case('baru') @case('submitted') @case('pending') 📄 Baru @break
                                @case('acknowledged') 📥 Diterima @break
                                @case('in_progress') @case('in progress') 🔍 Siasatan @break
                                @case('resolved') ✅ Selesai @break
                                @case('rejected') ❌ Ditolak @break
                                @default {{ str_replace('_', ' ', $complaint->status) }}
                                @endswitch
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-400">Tiada laporan untuk dipaparkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- 🟢 SUNTIKAN JAVASCRIPT KHAS UNTUK ONBOARDING TOUR HANYA PADA DASHBOARD --}}
@push('scripts')
@if(session('show_tour'))
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        introJs().setOptions({
            steps: [{
                    title: 'Selamat Datang! 👋',
                    intro: 'Selamat datang ke <b>Sistem Pentadbiran e-Aduan Digital KSAS</b>. Mari kami tunjukkan panduan ringkas penggunaan sistem.'
                },
                {
                    element: '#tour-logo',
                    title: 'Gerbang Berpusat KSAS',
                    intro: 'Ini ialah portal berpusat untuk memantau keselamatan dan menangani aduan warga kampus secara digital.'
                },
                {
                    element: '#tour-navigation',
                    title: 'Menu Navigasi Pentadbir',
                    intro: 'Gunakan bar menu ini untuk menjejaki <b>Senarai Aduan</b> aktif, melihat statistik laporan bulanan, atau menukar konfigurasi tetapan.',
                    position: 'right'
                },
                {
                    element: '#tour-logout',
                    title: 'Log Keluar Selamat',
                    intro: 'Klik butang ini setelah selesai tugasan bagi mengekalkan integriti dan keselamatan data fail kes.',
                    position: 'right'
                }
            ],
            showProgress: true,
            showBullets: false,
            exitOnOverlayClick: false,
            doneLabel: 'Faham & Mula Gunakan 🚀',
            nextLabel: 'Seterusnya →',
            prevLabel: '← Kembali'
        }).start();
    });
</script>
@endif
@endpush