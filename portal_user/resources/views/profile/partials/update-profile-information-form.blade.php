<section>
    <header>
        <h2 class="text-lg font-medium text-gray-800">
            {{ __('Maklumat Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Kemaskini nama akaun dan ID pengenalan rasmi anda.") }}
        </p>
    </header>

<form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Penuh')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Emel')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <p class="text-xs text-slate-500 mt-1">Emel ini digunakan untuk reset kata laluan.</p>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="identity_id" :value="__('No. Matrik / Staff ID (Tidak Boleh Diubah)')" />
            <x-text-input id="identity_id" type="text" class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed" 
                :value="$user->no_matrik ?? $user->staff_id" disabled />
            <p class="text-xs text-gray-400 mt-1">Sila hubungi pentadbir sistem jika terdapat kesilapan pada ID anda.</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">
                    {{ __('Maklumat berjaya disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>