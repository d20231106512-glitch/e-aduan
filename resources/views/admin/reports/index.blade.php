@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-wrap items-center justify-between gap-4 print:hidden">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center gap-3">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase">Month</label>
                <select name="month" class="mt-1 block p-2 border border-gray-300 rounded text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    @for($m = 1; $m <= 12; $m++)
                        @php
                        $monthValue=sprintf('%02d', $m);
                        @endphp
                        <option value="{{ $monthValue }}" {{ $selectedMonth == $monthValue ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                        @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase">Year</label>
                <select name="year" class="mt-1 block p-2 border border-gray-300 rounded text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    <option value="2026" {{ $selectedYear == '2026' ? 'selected' : '' }}>2026</option>
                    <option value="2025" {{ $selectedYear == '2025' ? 'selected' : '' }}>2025</option>
                </select>
            </div>
            <button type="submit" class="mt-5 bg-slate-800 text-white px-4 py-2 text-sm font-bold rounded hover:bg-slate-700 transition">
                Filter Analytics
            </button>
        </form>

        <button onclick="window.print()" class="bg-blue-600 text-white px-5 py-2.5 text-sm font-bold rounded shadow hover:bg-blue-700 transition flex items-center gap-2">
            🖨️ Export / Print PDF Report
        </button>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 print:border-0 print:shadow-none space-y-6">

        <div class="text-center border-b-2 border-slate-800 pb-4">
            <h1 class="text-2xl font-black text-slate-900 tracking-wide uppercase">e-Aduan Management Portal</h1>
            <p class="text-sm text-gray-600 font-medium">Kampus Sultan Azlan Shah (KSAS), Universiti Pendidikan Sultan Idris</p>
            <p class="text-xs text-gray-400 mt-1 uppercase font-bold tracking-widest">
                Monthly Incident Summary: {{ date('F', mktime(0, 0, 0, $selectedMonth, 1)) }} {{ $selectedYear }}
            </p>
        </div>

        <div class="grid grid-cols-4 gap-4 text-center">
            <div class="p-4 bg-slate-50 rounded border border-gray-100">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Total Reports</h4>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalComplaints }}</p>
            </div>
            <div class="p-4 bg-yellow-50 rounded border border-yellow-100">
                <h4 class="text-xs font-bold text-yellow-600 uppercase">Submitted</h4>
                <p class="text-2xl font-extrabold text-yellow-700 mt-1">{{ $pendingCount }}</p>
            </div>
            <div class="p-4 bg-blue-50 rounded border border-blue-100">
                <h4 class="text-xs font-bold text-blue-600 uppercase">Investigating</h4>
                <p class="text-2xl font-extrabold text-blue-700 mt-1">{{ $investigatingCount }}</p>
            </div>
            <div class="p-4 bg-green-50 rounded border border-green-100">
                <h4 class="text-xs font-bold text-green-600 uppercase">Resolved</h4>
                <p class="text-2xl font-extrabold text-green-700 mt-1">{{ $resolvedCount }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-bold text-slate-700 uppercase mb-3 border-b border-gray-200 pb-1">Detailed Incident Records List</h3>
            <table class="w-full text-left text-xs border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-700 font-bold uppercase">
                        <th class="p-2 border border-gray-200">Category / Title</th>
                        <th class="p-2 border border-gray-200">Location</th>
                        <th class="p-2 border border-gray-200">Date Logged</th>
                        <th class="p-2 border border-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthlyRecords as $record)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-2 border border-gray-200 font-semibold capitalize">
                            {{ $record->title ?? ($record->category ?? 'General Report') }}
                        </td>
                        <td class="p-2 border border-gray-200 text-gray-600">
                            {{ $record->location ?? 'Not Specified' }}
                        </td>
                        <td class="p-2 border border-gray-200 text-gray-500">
                            {{ isset($record->created_at) ? date('Y-m-d H:i', strtotime($record->created_at)) : 'N/A' }}
                        </td>
                        <td class="p-2 border border-gray-200 font-medium capitalize">
                            [{{ $record->status }}]
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-400">No complaint actions tracked during this calendar window.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-12 hidden print:flex justify-between items-center text-xs text-gray-500">
            <div>
                <p>Generated via Admin System: {{ date('Y-m-d H:i:s') }}</p>
            </div>
            <div class="text-center w-48 border-t border-slate-400 pt-2">
                <p class="font-bold text-slate-800">Authorized Signature</p>
                <p>KSAS Security Management</p>
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