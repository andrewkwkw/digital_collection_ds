<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-white">
                        {{ __('Kelola Tim Kami') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Daftar seluruh anggota tim yang ditampilkan di website.
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700 dark:bg-brand-900/50 dark:text-brand-300 border border-brand-100 dark:border-brand-800">
                    Total: {{ $team->count() }} Anggota
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ALERT MESSAGES --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="flex items-center justify-between p-4 mb-4 text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400 rounded-xl shadow-sm border border-green-200 dark:border-green-900">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="opacity-50 hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- TOP ACTION BAR --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Anggota Tim</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Manajemen data personel perusahaan.</p>
                        </div>
                        
                        {{-- BUTTON SESUAI REQUEST --}}
                        <div class="flex items-center">
                            <a href="{{ route('admin.team.create') }}" 
                                class="group relative inline-flex items-center justify-center px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-full shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 border border-brand-500 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                <svg class="w-5 h-5 me-2 -ms-1 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('Tambah Anggota Baru') }}
                            </a>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Nama & Email
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Posisi / Jabatan
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($team as $index => $member)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($member->photo_path)
                                                        <img class="h-10 w-10 rounded-full object-cover shadow-sm border border-gray-200 dark:border-gray-600"
                                                            src="{{ asset('storage/' . $member->photo_path) }}" 
                                                            alt="{{ $member->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-brand-100 dark:bg-brand-900 flex items-center justify-center border border-brand-200 dark:border-brand-800">
                                                            <span class="text-xs font-bold text-brand-600 dark:text-brand-300">
                                                                {{ substr($member->name, 0, 2) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                        {{ $member->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $member->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-brand-50 text-brand-700 dark:bg-brand-900/30 dark:text-brand-300 border border-brand-100 dark:border-brand-800">
                                                {{ $member->position }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center gap-3">
                                                <a href="{{ route('admin.team.edit', $member->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold transition-colors">
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST"
                                                    class="inline-block" 
                                                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <p>Belum ada anggota tim yang ditambahkan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>