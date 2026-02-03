<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-white">
                    {{ __('Tambah Admin Baru') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Buat akun administrator baru untuk akses sistem.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-3xl border border-gray-100 dark:border-gray-700 relative">
                
                {{-- Decorative Top Border --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-400 to-brand-600"></div>

                <div class="p-8">
                    <form method="POST" action="{{ route('admin.admin.store') }}" class="space-y-6">
                        @csrf

                        {{-- Nama & Email Group --}}
                        <div class="grid grid-cols-1 gap-6">
                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
                                <x-text-input id="name" 
                                    class="block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 transition-all duration-200" 
                                    type="text" 
                                    name="name" 
                                    :value="old('name')" 
                                    required autofocus 
                                    placeholder="Contoh: Budi Santoso" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Alamat Email')" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                                    </div>
                                    <x-text-input id="email" 
                                        class="block w-full pl-10 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 transition-all duration-200" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        placeholder="nama@domain.com" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-100 dark:border-gray-700"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-3 bg-white dark:bg-gray-800 text-xs text-gray-400 font-medium">Keamanan Akun</span>
                            </div>
                        </div>

                        {{-- Password Group --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Password --}}
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
                                <x-text-input id="password" 
                                    class="block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 transition-all duration-200" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    placeholder="••••••••" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
                                <x-text-input id="password_confirmation" 
                                    class="block w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 transition-all duration-200" 
                                    type="password" 
                                    name="password_confirmation" 
                                    required 
                                    placeholder="••••••••" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-between pt-6">
                            <a href="{{ route('admin.admin.index') }}" 
                               class="group inline-flex items-center text-sm font-semibold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="bg-brand-600 hover:bg-brand-700 focus:ring-brand-500 px-6 py-2.5 rounded-xl shadow-lg shadow-brand-500/30 transform transition-all duration-200 hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('Simpan Admin') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>