@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.complaints.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Complaints Directory</a>

    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 mt-4 space-y-6">

        @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 text-xs font-bold rounded border border-green-200">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="p-3 bg-red-100 text-red-800 text-xs font-bold rounded border border-red-200">
            {{ session('error') }}
        </div>
        @endif

        <div class="flex justify-between items-start border-b border-gray-100 pb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 capitalize">
                    {{ $complaint->title ?? ($complaint->category ?? 'General Report') }}
                </h1>
                <p class="text-sm text-gray-400 mt-1">
                    Logged: {{ isset($complaint->created_at) ? date('Y-m-d H:i', strtotime($complaint->created_at)) : 'N/A' }}
                </p>
            </div>
            <span class="px-3 py-1 text-sm font-bold rounded-full uppercase tracking-wider
                {{ in_array($complaint->status ?? '', ['submitted', 'Pending']) ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ ($complaint->status ?? '') === 'investigating' ? 'bg-blue-100 text-blue-800' : '' }}
                {{ ($complaint->status ?? '') === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
            ">
                Current: {{ $complaint->status ?? 'submitted' }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Location / Block</h3>
                <p class="text-gray-700 font-medium mt-1">{{ $complaint->location ?? 'Not Specified' }}</p>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Assigned Handlers (Profiles ID)</h3>
                <p class="text-xs text-gray-600 font-mono mt-1 bg-gray-50 p-1.5 rounded border border-gray-100 block truncate">
                    {{ $complaint->assigned_to ?? 'Unassigned / Open Queue' }}
                </p>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Statement / Incident Details</h3>
            <p class="text-gray-600 mt-2 bg-gray-50 p-4 rounded border border-gray-100 leading-relaxed">
                {{ $complaint->description ?? 'No additional textual notes left by the user.' }}
            </p>
        </div>

        <div class="border-t border-gray-100 pt-6 bg-slate-50 -mx-8 -mb-8 p-8 rounded-b-lg">
            <h2 class="text-lg font-bold text-slate-700 mb-1">Update Incident Tracking Status</h2>
            <p class="text-xs text-gray-400 mb-4">Select the administrative phase level to transition this case file records context inside Supabase.</p>

            <form action="{{ route('admin.complaints.updateStatus', $complaint->id) }}" method="POST" class="flex items-center gap-4 max-w-md">
                @csrf
                @method('PUT')
                <select name="status" class="block w-full p-2.5 bg-white border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm font-medium">
                    <option value="submitted" {{ ($complaint->status ?? '') === 'submitted' ? 'selected' : '' }}>Set as Submitted (Baru)</option>
                    <option value="acknowledged" {{ ($complaint->status ?? '') === 'acknowledged' ? 'selected' : '' }}>Set as Acknowledged (Diterima)</option>
                    <option value="in_progress" {{ ($complaint->status ?? '') === 'in_progress' ? 'selected' : '' }}>Set as In Progress (Siasatan)</option>
                    <option value="resolved" {{ ($complaint->status ?? '') === 'resolved' ? 'selected' : '' }}>Mark as Resolved (Selesai)</option>
                    <option value="rejected" {{ ($complaint->status ?? '') === 'rejected' ? 'selected' : '' }}>Mark as Rejected (Ditolak)</option>
                </select>
                <button type="submit" class="bg-slate-800 text-white text-sm font-bold px-5 py-2.5 rounded hover:bg-slate-700 transition shadow-sm whitespace-nowrap">
                    Apply Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection