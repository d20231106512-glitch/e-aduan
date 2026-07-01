@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tetapan Sistem Global</h1>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 font-bold rounded shadow-sm flex items-center gap-2">
        <span>⚠️</span>
        <div>{{ session('error') }}</div>
    </div>
    @endif

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 font-bold rounded shadow-sm flex items-center gap-2">
        <span>✅</span>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit">
            <h2 class="text-xl font-bold text-gray-700 mb-4">➕ Tambah Kenalan Keselamatan</h2>
            <form action="{{ route('admin.settings.storeContact') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Pegawai/Jabatan</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded border border-gray-300 p-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombor Telefon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="mt-1 block w-full rounded border border-gray-300 p-2 text-sm" placeholder="cth., +6015-xxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Zon/Lokasi Bertugas</label>
                    <input type="text" name="zone" value="{{ old('zone') }}" class="mt-1 block w-full rounded border border-gray-300 p-2 text-sm" placeholder="cth., Pos Pengawal 1 KSAS">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white text-sm font-bold px-4 py-2 rounded hover:bg-blue-700 transition">
                    💾 Simpan Kenalan
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-700 mb-4">📞 Direktori Talian Kecemasan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                                <th class="p-3">Nama</th>
                                <th class="p-3">Telefon</th>
                                <th class="p-3">Zon</th>
                                <th class="p-3 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @forelse($contacts as $contact)
                            <tr id="row-{{ $contact->id }}" class="border-b border-gray-100 hover:bg-gray-50">
                                <form action="{{ route('admin.settings.updateContact', $contact->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <td class="p-3">
                                        <span class="view-mode font-medium">{{ $contact->name }}</span>
                                        <input type="text" name="name" value="{{ $contact->name }}" required class="edit-mode hidden w-full rounded border border-gray-300 p-1 text-sm">
                                    </td>

                                    <td class="p-3">
                                        <span class="view-mode text-blue-600 font-mono">{{ $contact->phone_number }}</span>
                                        <input type="text" name="phone" value="{{ $contact->phone_number }}" required class="edit-mode hidden w-full rounded border border-gray-300 p-1 text-sm font-mono">
                                    </td>

                                    <td class="p-3">
                                        <span class="view-mode text-gray-500">{{ $contact->zone_assignment ?? 'Umum' }}</span>
                                        <input type="text" name="zone" value="{{ $contact->zone_assignment }}" class="edit-mode hidden w-full rounded border border-gray-300 p-1 text-sm">
                                    </td>

                                    <td class="p-3 text-center">
                                        <div class="view-mode flex items-center justify-center gap-3">
                                            <button type="button" onclick="enableEdit('{{ $contact->id }}')" class="text-blue-500 hover:text-blue-700 font-semibold flex items-center gap-0.5">
                                                ✏️ Sunting
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-form-{{ $contact->id }}').submit();" class="text-red-500 hover:text-red-700 font-semibold">
                                                🗑️ Padam
                                            </button>
                                        </div>

                                        <div class="edit-mode hidden flex items-center justify-center gap-3">
                                            <button type="submit" class="text-green-600 hover:text-green-800 font-bold">
                                                💾 Simpan
                                            </button>
                                            <button type="button" onclick="disableEdit('{{ $contact->id }}')" class="text-gray-500 hover:text-gray-700 font-semibold">
                                                ❌ Batal
                                            </button>
                                        </div>
                                    </td>
                                </form>

                                <form id="delete-form-{{ $contact->id }}" action="{{ route('admin.settings.destroyContact', $contact->id) }}" method="POST" class="hidden" onsubmit="return confirm('Padam talian kecemasan ini?');">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-400">Tiada kenalan kecemasan disimpan lagi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-700 mb-4">👥 Pengguna Kampus Berdaftar (Pelajar & Staf)</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                                <th class="p-3">Nama</th>
                                <th class="p-3">No Matrik / ID Staf</th>
                                <th class="p-3 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @forelse($users as $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-3 font-medium">{{ $user->name }}</td>
                                <td class="p-3 text-gray-500 font-mono">
                                    {{ $user->no_matrik ?? $user->staff_id ?? 'Tiada Rekod' }}
                                </td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('admin.settings.deleteUser', $user->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti mahu memadam pengguna ini daripada sistem sepenuhnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 px-3 py-1 rounded border border-red-200 hover:bg-red-100 transition text-xs font-bold">
                                            ❌ Padam Pengguna
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-400">Tiada pengguna berdaftar dalam pangkalan data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function enableEdit(id) {
        const row = document.getElementById('row-' + id);
        row.querySelectorAll('.view-mode').forEach(el => el.classList.add('hidden'));
        row.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('hidden'));
    }

    function disableEdit(id) {
        const row = document.getElementById('row-' + id);
        row.querySelectorAll('.edit-mode').forEach(el => el.classList.add('hidden'));
        row.querySelectorAll('.view-mode').forEach(el => el.classList.remove('hidden'));
    }
</script>
@endsection