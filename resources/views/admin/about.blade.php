@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="border-b border-gray-200 pb-4">
        <h1 class="text-3xl font-bold text-gray-800">Mengenai Sistem</h1>
        <p class="text-sm text-gray-500 mt-1">Maklumat pembangunan dan latar belakang aplikasi e-Aduan Digital KSAS.</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 border-l-4 border-blue-600 pl-3 mb-3">Pengenalan Sistem</h2>
        <p class="text-gray-600 leading-relaxed text-sm">
            Sistem e-Aduan Digital Pusat Keselamatan Kampus (KSAS) Universiti Pendidikan Sultan Idris (UPSI) dibangunkan khas untuk memudahkan pengurusan, agihan, dan pemantauan kes keselamatan aduan warga kampus secara berpusat dan sistematik. Melalui sistem analisis ini, pentadbir dapat mengemas kini status tindakan kes dengan cekap serta menjana laporan rasmi cetakan PDF dengan pantas.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-slate-700 pl-3 mb-4">Dibangunkan Oleh</h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded border border-gray-100">
                        <span class="text-2xl">👩🏻‍🏫</span>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Nur Amira Insyirah binti Jemli</p>
                            <p class="text-xs font-semibold text-gray-500">No. Matrik: D20231106512</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded border border-gray-100">
                        <span class="text-2xl">👩🏻‍🏫</span>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Nor Azza Aziela binti Nor Azlan</p>
                            <p class="text-xs font-semibold text-gray-500">No. Matrik: D20231106489</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded border border-gray-100">
                        <span class="text-2xl">👩🏻‍🏫</span>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Siti Suhaila binti Mohd Termiji</p>
                            <p class="text-xs font-semibold text-gray-500">No. Matrik: D20231106460</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-amber-500 pl-3 mb-3">Kursus / Subjek</h2>
                <p class="text-sm font-bold text-gray-800 bg-amber-50 border border-amber-100 p-3 rounded">
                    📚 DTD3053 PENGATURCARAAN WEB UNTUK SISTEM MAKLUMAT
                </p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-green-600 pl-3 mb-2">Nama Pensyarah</h2>
                <p class="text-sm font-bold text-gray-700 pl-3">
                    🎓 PROFESOR MADYA DR ASLINA BINTI SAAD
                </p>
            </div>
        </div>
    </div>
</div>
@endsection