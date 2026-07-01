@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Analytics Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 border-l-4 border-blue-600">
            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Complaints Logged</h2>
            <p class="text-4xl font-extrabold text-gray-800 mt-2">{{ $totalComplaints }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 border-l-4 border-red-600">
            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Emergency / Critical Incidents</h2>
            <p class="text-4xl font-extrabold text-red-600 mt-2">{{ $emergencyComplaints }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Latest Inbound Reports</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                        <th class="p-3">Category</th>
                        <th class="p-3">Location</th>
                        <th class="p-3">Date & Time</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($latestComplaints as $complaint)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-3 font-semibold text-gray-800">
                            {{ $complaint->category }}
                        </td>
                        <td class="p-3 text-gray-600">{{ $complaint->location }}</td>
                        <td class="p-3 text-gray-500">
                            {{ !empty($complaint->created_at) ? date('Y-m-d (H:i)', strtotime($complaint->created_at)) : 'N/A' }}
                        </td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full uppercase tracking-wider
                                {{ ($complaint->status ?? '') === 'submitted' ? 'bg-slate-100 text-slate-700' : '' }}
                                {{ ($complaint->status ?? '') === 'acknowledged' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ ($complaint->status ?? '') === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ ($complaint->status ?? '') === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ ($complaint->status ?? '') === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ str_replace('_', ' ', $complaint->status ?? 'submitted') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-400">No reports to display.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection