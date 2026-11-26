<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NIS (Nomor Induk Siswa) -->
        <div>
            <x-input-label for="nis" :value="__('NIS (Nomor Induk Siswa)')" />
            <x-text-input id="nis" class="block mt-1 w-full" type="text" name="nis" :value="old('nis')" required autofocus autocomplete="nis" placeholder="Contoh: 12345678" />
            <x-input-error :messages="$errors->get('nis')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Nama Siswa..." />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Kelas -->
        <div class="mt-4">
            <x-input-label for="kelas" :value="__('Kelas')" />
            <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas" :value="old('kelas')" required autocomplete="kelas" placeholder="Contoh: XII DKV 1" />
            <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Minimal 8 karakter" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Ulangi kata sandi" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah terdaftar? Masuk') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar Akun Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>