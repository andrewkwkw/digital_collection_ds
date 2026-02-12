<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-white">
                        {{ __('Manajemen Akses') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Daftar administrator yang memiliki akses sistem.
                    </p>
                </div>
            </div>
             <div class="flex items-center">
                 <a href="{{ route('admin.admin.create') }}" 
                   class="group relative inline-flex items-center justify-center px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-full shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 border border-brand-500 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <svg class="w-5 h-5 me-2 -ms-1 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Daftarkan Admin Baru') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false, deleteAction: null }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- STATS CARD --}}
            <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-1 md:col-span-3 bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-brand-50 dark:from-brand-900/20 to-transparent"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Administrator</p>
                            <h3 class="text-3xl font-black text-gray-800 dark:text-white">
                                {{ $admins->total() }} <span class="text-base font-medium text-gray-400">Akun Terdaftar</span>
                            </h3>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-brand-100 dark:bg-brand-900/30 text-brand-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NOTIFICATIONS --}}
            @if (session('success'))
                <div class="mb-6 flex items-center p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-300 animate-in fade-in slide-in-from-top-2">
                    <svg class="w-5 h-5 me-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl dark:bg-red-900/30 dark:border-red-800 dark:text-red-300">
                    <svg class="w-5 h-5 me-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold text-sm">{{ session('error') }}</span>
                </div>
            @endif

            {{-- TABLE --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap text-left">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-700/30 border-b border-gray-100 dark:border-gray-700">
                                <th class="px-8 py-5 text-[10px] uppercase font-black tracking-widest text-gray-400 dark:text-gray-500">
                                    Identitas Admin
                                </th>
                                <th class="px-8 py-5 text-[10px] uppercase font-black tracking-widest text-gray-400 dark:text-gray-500">
                                    Alamat Email
                                </th>
                                <th class="px-8 py-5 text-[10px] uppercase font-black tracking-widest text-gray-400 dark:text-gray-500 text-right">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($admins as $admin)
                                <tr class="group hover:bg-brand-50/30 dark:hover:bg-brand-900/10 transition-colors">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400 flex items-center justify-center text-sm font-bold ring-2 ring-white dark:ring-gray-800 shadow-sm">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800 dark:text-white text-sm">
                                                    {{ $admin->name }}
                                                </div>
                                                <div class="text-[10px] text-gray-400 font-medium">
                                                    ID: #{{ $admin->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $admin->email }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <button type="button" 
                                            @click="deleteAction = '{{ route('admin.admin.destroy', $admin) }}'; showDeleteModal = true"
                                            class="group/btn flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all inline-flex" title="Hapus Akses">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium text-sm">Belum ada data administrator.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                @if($admins->hasPages())
                    <div class="px-8 py-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        {{ $admins->links() }}
                    </div>
                @endif
            </div>

            <p class="mt-6 text-center text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-bold">
                Data Sensitif - Pastikan minimal satu admin aktif
            </p>

            {{-- DELETE CONFIRMATION MODAL --}}
            <div x-cloak x-show="showDeleteModal" 
                class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
                
                {{-- Backdrop --}}
                <div x-show="showDeleteModal" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900/50 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity" 
                    aria-hidden="true" 
                    @click="showDeleteModal = false">
                </div>

                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showDeleteModal" 
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700">
                        
                        <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-white" id="modal-title">Hapus Akses Admin</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Apakah Anda yakin ingin menghapus akses untuk administrator ini? Tindakan ini tidak dapat dibatalkan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <form :action="deleteAction" method="POST" class="inline-flex w-full sm:ml-3 sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-colors">
                                    Ya, Hapus Akses
                                </button>
                            </form>
                            <button type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors" @click="showDeleteModal = false">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>