<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-brand-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black leading-tight text-gray-800 dark:text-white tracking-tight">
                    {{ __('Manajemen Akses Admin') }}
                </h2>
            </div>
            <a href="{{ route('admin.admin.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-500/20 transition-all duration-300 hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                {{ __('Daftarkan Admin') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 h-full w-32 bg-brand-500/5 -skew-x-12 translate-x-10 group-hover:bg-brand-500/10 transition-colors"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Kapasitas Otoritas</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white mt-1">
                                {{ $admins->total() }} <span class="text-sm font-medium text-gray-400 tracking-normal">Administrator Terdaftar</span>
                            </h3>
                        </div>
                        <div class="p-4 bg-brand-50 dark:bg-brand-500/10 rounded-2xl text-brand-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl dark:bg-emerald-900/30 dark:text-emerald-200 shadow-sm animate-in fade-in duration-500">
                    <span class="me-3 bg-emerald-500 text-white rounded-full p-1 text-[10px]">✓</span>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-xl dark:bg-red-900/30 dark:text-red-200 shadow-sm">
                    <span class="me-3 bg-red-500 text-white rounded-full p-1 text-[10px]">✕</span>
                    <span class="font-bold text-sm">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50/50 dark:bg-gray-700/30 text-[10px] uppercase tracking-widest font-black text-gray-400 dark:text-gray-500">
                        <tr>
                            <th class="px-8 py-5 text-left">Nama Lengkap</th>
                            <th class="px-8 py-5 text-left">Alamat Email</th>
                            <th class="px-8 py-5 text-center">Kontrol Akses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        @forelse ($admins as $admin)
                            <tr class="group hover:bg-brand-50/30 dark:hover:bg-brand-500/5 transition-all duration-200">
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="h-9 w-9 rounded-full bg-brand-500/10 flex items-center justify-center text-brand-600 font-bold text-sm me-3 group-hover:bg-brand-500 group-hover:text-white transition-all">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ $admin->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 dark:text-gray-400 font-medium">
                                    {{ $admin->email }}
                                </td>
                                <td class="px-8 py-5 text-center text-sm">
                                    <form action="{{ route('admin.admin.destroy', $admin) }}" method="POST" onsubmit="return confirm('Cabut akses admin ini? Akun akan dihapus secara permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center p-2 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all" title="Hapus Akses">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-40">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="text-sm font-bold text-gray-500">Belum ada admin terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                @if($admins->hasPages())
                    <div class="px-8 py-6 bg-gray-50/30 dark:bg-gray-700/10 border-t border-gray-100 dark:border-gray-700">
                        {{ $admins->links() }}
                    </div>
                @endif
            </div>

            <p class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500 italic">
                Aksi penghapusan bersifat permanen. Pastikan setidaknya ada satu admin aktif yang tersisa.
            </p>
        </div>
    </div>
</x-app-layout>