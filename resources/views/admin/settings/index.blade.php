@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Global System Settings</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Add Security Contact</h2>
            <form action="{{ route('admin.settings.storeContact') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600">Officer/Department Name</label>
                    <input type="text" name="name" required class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                    <input type="text" name="phone_number" required placeholder="e.g., +6015-xxxxxxx" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Zone/Assignment Location</label>
                    <input type="text" name="zone_assignment" placeholder="e.g., KSAS Guard Post 1" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                    Save Contact
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Emergency Contacts Directory</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                                <th class="p-3">Name</th>
                                <th class="p-3">Phone</th>
                                <th class="p-3">Zone</th>
                                <th class="p-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @forelse($contacts as $contact)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-3 font-medium">{{ $contact->name }}</td>
                                <td class="p-3 text-blue-600 font-mono">{{ $contact->phone_number }}</td>
                                <td class="p-3 text-gray-500">{{ $contact->zone_assignment ?? 'General' }}</td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('admin.settings.destroyContact', $contact->id) }}" method="POST" onsubmit="return confirm('Remove this hotline?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-400">No emergency contacts saved yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Registered Campus Users (Students & Staff)</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @forelse($users as $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-3 font-medium">{{ $user->name }}</td>
                                <td class="p-3 text-gray-500">{{ $user->email }}</td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('admin.settings.deleteUser', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user from the system entirely?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 px-3 py-1 rounded border border-red-200 hover:bg-red-100 transition text-xs font-bold">
                                            Delete User
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-400">No registered users in the database.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection