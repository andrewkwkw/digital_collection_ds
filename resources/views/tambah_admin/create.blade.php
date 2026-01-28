<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-brand-500/10 rounded-lg">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-xl font-black text-gray-800 dark:text-white leading-tight tracking-tight">
                {{ __('Tambah Admin Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl shadow-brand-500/5 rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Informasi Akun</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pastikan alamat email aktif untuk akses masuk sistem.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold ml-1 mb-1" />
                            <x-text-input id="name" class="block w-full border-gray-200 dark:border-gray-700 focus:border-brand-500 focus:ring-brand-500 rounded-xl" 
                                type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama lengkap..." />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold ml-1 mb-1" />
                            <x-text-input id="email" class="block w-full border-gray-200 dark:border-gray-700 focus:border-brand-500 focus:ring-brand-500 rounded-xl" 
                                type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="font-bold ml-1 mb-1" />
                                <x-text-input id="password" class="block w-full border-gray-200 dark:border-gray-700 focus:border-brand-500 focus:ring-brand-500 rounded-xl"
                                    type="password" name="password" required placeholder="••••••••" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-bold ml-1 mb-1" />
                                <x-text-input id="password_confirmation" class="block w-full border-gray-200 dark:border-gray-700 focus:border-brand-500 focus:ring-brand-500 rounded-xl"
                                    type="password" name="password_confirmation" required placeholder="••••••••" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="border-gray-100 dark:border-gray-700 my-8">

                        <div class="flex items-center justify-between">
                            <a href="{{ route('admin.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-brand-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="bg-brand-600 hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-800 rounded-xl px-6 py-3 shadow-lg shadow-brand-500/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Simpan Admin') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>