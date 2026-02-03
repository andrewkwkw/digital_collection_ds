<x-app-layout>
    <x-slot name="header">
        {{-- CONTAINER HEADER: Konsisten dengan Dashboard (w-full, justify-between) --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between w-full gap-6">
            
            {{-- BAGIAN KIRI: Icon & Judul (Style sama persis dengan Dashboard) --}}
            <div class="flex items-center gap-4">
                {{-- Icon Box --}}
                <div class="p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    {{-- Icon Folder/Collection untuk Arsip --}}
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                
                {{-- Text Content --}}
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                        {{ __('Daftar Arsip') }}
                    </h2>
                    {{-- Subtitle dinamis dengan jumlah total --}}
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">
                        Total <span class="font-bold text-brand-600 dark:text-brand-400">{{ $archives->total() }}</span> dokumen tersimpan
                    </p>
                </div>
            </div>

            {{-- BAGIAN KANAN: Tombol Action (Menggantikan posisi Tanggal) --}}
            <div class="flex items-center">
                <a href="{{ route('admin.archive.create') }}" 
                   class="group relative inline-flex items-center justify-center px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-full shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 border border-brand-500 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <svg class="w-5 h-5 me-2 -ms-1 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Upload Arsip Baru') }}
                </a>
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Flash Message (Alert) --}}
            @if (session('success'))
                <div class="mb-8 flex items-center p-4 bg-emerald-50/80 dark:bg-emerald-900/20 backdrop-blur-sm border border-emerald-200 dark:border-emerald-800 rounded-2xl text-emerald-800 dark:text-emerald-200 shadow-sm animate-in fade-in slide-in-from-top-2 duration-500">
                    <div class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-800 rounded-full p-1 me-3">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Content Grid --}}
            @if ($archives->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach ($archives as $archive)
                        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/60 shadow-sm hover:shadow-xl hover:shadow-brand-500/5 transition-all duration-300 hover:-translate-y-1 flex flex-col h-full overflow-hidden">
                            
                            {{-- Card Header --}}
                            <div class="p-5 pb-0 flex items-start justify-between relative z-10">
                                <div class="p-2.5 bg-brand-50 dark:bg-brand-900/20 rounded-xl text-brand-600 dark:text-brand-400 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600">
                                    #{{ $archive->id }}
                                </span>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-5 flex-grow flex flex-col">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors line-clamp-2 mb-3" title="{{ $archive->title }}">
                                    {{ $archive->title }}
                                </h3>

                                <div class="mt-auto space-y-2 pt-4 border-t border-gray-50 dark:border-gray-700/50 border-dashed">
                                    @if ($archive->creator)
                                        <div class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                            <svg class="w-3.5 h-3.5 me-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="truncate">{{ $archive->creator }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center text-xs font-medium text-gray-400 dark:text-gray-500">
                                        <svg class="w-3.5 h-3.5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $archive->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Card Footer (Actions) --}}
                            <div class="p-4 bg-gray-50/50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex gap-2">
                                <a href="{{ route('admin.archive.show', $archive->id) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-bold text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-brand-50 hover:text-brand-600 hover:border-brand-200 transition-all duration-200">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.archive.edit', $archive) }}" class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/30 rounded-lg hover:bg-amber-100 hover:border-amber-200 transition-all duration-200">
                                    Edit
                                </a>
                                <form action="{{ route('admin.archive.destroy', $archive) }}" method="POST" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-800/30 rounded-lg hover:bg-red-600 hover:text-white hover:border-red-600 transition-all duration-200" onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10 px-4 md:px-0">
                    {{ $archives->links() }}
                </div>

            @else
                {{-- Empty State (Modern) --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700 relative">
                    <div class="absolute top-0 left-0 w-full h-full bg-grid-slate-100 dark:bg-grid-slate-700/25 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
                    <div class="relative p-16 flex flex-col items-center text-center z-10">
                        <div class="w-24 h-24 bg-brand-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-12 h-12 text-brand-200 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Belum Ada Arsip') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 max-w-sm leading-relaxed">
                            Database arsip saat ini masih kosong. Silakan unggah dokumen pertama Anda untuk memulai manajemen arsip.
                        </p>
                        <a href="{{ route('admin.archive.create') }}" class="mt-8 px-8 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition-all shadow-lg shadow-brand-500/30 hover:-translate-y-1">
                            {{ __('Upload Arsip Pertama') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>