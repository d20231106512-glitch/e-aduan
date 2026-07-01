<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-800">
            {{ __('Padam Akaun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akaun anda dipadamkan, semua rekod termasuk data aduan lama anda akan dibuang secara kekal dari Supabase.') }}
        </p>
    </header>

    <x-danger-button x-data="" @click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Padam Akaun Saya') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-800">
                {{ __('Adakah anda pasti ingin memadamkan akaun ini?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Sila masukkan kata laluan anda untuk mengesahkan bahawa anda mahu memadam akaun ini secara kekal.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Laluan') }}" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="{{ __('Kata Laluan Anda') }}" />
                <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Sahkan Padam Akaun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>