@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Campus Complaints</h1>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-6">

        <form action="{{ route('admin.complaints.index') }}" method="GET" class="flex items-center gap-3 bg-gray-50 p-3 rounded border border-gray-100">
            <div class="flex-1 max-w-xs">
                <label class="block text-xs font-bold text-gray-500 uppercase">Filter By Category</label>
                <select name="category" class="mt-1 block w-full p-2 bg-white border border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500 capitalize">
                    <option value="">-- All Categories --</option>
                    @foreach($allCategories as $category)
                    <option value="{{ $category }}" {{ $selectedCategory == $category ? 'selected' : '' }}>
                        {{ str_replace('_', ' ', $category) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-5 flex gap-2">
                <button type="submit" class="bg-slate-800 text-white px-4 py-2 text-sm font-bold rounded hover:bg-slate-700 transition">
                    Filter
                </button>
                @if(!empty($selectedCategory))
                <a href="{{ route('admin.complaints.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 text-sm font-bold rounded hover:bg-gray-300 transition text-center flex items-center">
                    Clear
                </a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                        <th class="p-3">Category / Title</th>
                        <th class="p-3">Location</th>
                        <th class="p-3">Date & Time Logged</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($complaints as $complaint)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-3 font-semibold text-gray-800 capitalize">
                            <span class="block text-xs font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded inline-block mb-1 border border-blue-100">
                                {{ str_replace('_', ' ', $complaint->category ?? 'General') }}
                            </span>
                            <div class="truncate max-w-xs">{{ $complaint->title ?? 'Untitled Report' }}</div>
                        </td>
                        <td class="p-3 text-gray-600">
                            {{ $complaint->location ?? 'Not Specified' }}
                        </td>
                        <td class="p-3 text-gray-500">
                            {{ isset($complaint->created_at) ? date('Y-m-d (H:i)', strtotime($complaint->created_at)) : 'N/A' }}
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
                        <td class="p-3 text-center">
                            <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-blue-600 hover:text-blue-800 font-bold">
                                View Details &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">No student complaints found matching this criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection