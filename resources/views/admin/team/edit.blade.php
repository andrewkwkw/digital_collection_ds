<x-app-layout>
    {{-- HEADER (Disesuaikan dengan halaman Index) --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-white">
                        {{ __('Edit Anggota Tim') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Perbarui informasi profil, foto, dan dokumen anggota.
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.team.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.team.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid lg:grid-cols-3 gap-8">
                    
                    {{-- LEFT COLUMN: PHOTO & BASIC INFO --}}
                    <div class="lg:col-span-1 space-y-6">
                        
                        {{-- PHOTO UPLOAD CARD --}}
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                             <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Foto Profil
                            </h3>
                            
                            {{-- Init Alpine with existing photo if available --}}
                            <div x-data="{ 
                                photoName: null, 
                                photoPreview: '{{ $teamMember->photo_path ? asset('storage/' . $teamMember->photo_path) : '' }}' 
                            }">
                                <input type="file" name="photo" id="photo" class="hidden" x-ref="photo"
                                    @change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => { photoPreview = e.target.result; };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                    " />

                                <div class="mt-2" x-show="!photoPreview">
                                    <div @click="$refs.photo.click()" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-900 hover:bg-white dark:hover:bg-gray-800 hover:border-brand-500 dark:hover:border-brand-500 transition-all group">
                                        <div class="w-16 h-16 bg-brand-100 dark:bg-brand-900/30 rounded-full flex items-center justify-center text-brand-600 dark:text-brand-400 mb-3 group-hover:scale-110 transition-transform">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Upload Foto Baru</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">JPG/PNG, Max 2MB</p>
                                    </div>
                                </div>

                                <div class="mt-2 text-center" x-show="photoPreview" style="display: none;">
                                    <div class="relative w-full h-64 rounded-xl overflow-hidden group shadow-md mx-auto">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                        <div @click="$refs.photo.click()" class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white">
                                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <span class="text-xs font-bold uppercase tracking-wider">Ganti Foto</span>
                                        </div>
                                    </div>
                                    @if($teamMember->photo_path)
                                        <p class="text-xs text-gray-500 mt-2 italic">*Foto saat ini sudah terpasang</p>
                                    @endif
                                </div>
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>
                        </div>

                        {{-- CV UPLOAD CARD --}}
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                             <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                {{-- Ganti icon warna merah jadi Brand Color --}}
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Curriculum Vitae
                            </h3>
                            
                            @if($teamMember->cv_path)
                                {{-- Background merah diubah ke Brand/Green soft --}}
                                <div class="mb-4 p-3 bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-300 rounded-lg flex items-center justify-between text-sm">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                                        CV Sudah ada
                                    </span>
                                    <a href="{{ asset('storage/' . $teamMember->cv_path) }}" target="_blank" class="font-semibold underline hover:no-underline">Lihat PDF</a>
                                </div>
                            @endif

                            <div x-data="{ fileName: '' }">
                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-900 hover:bg-white dark:hover:bg-gray-800 hover:border-brand-500 dark:hover:border-brand-500 transition-all group p-4 text-center">
                                    <div x-show="!fileName">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-500 mb-2 mx-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-sm text-gray-500">Upload PDF Baru (Max 5MB)</p>
                                    </div>
                                    <div x-show="fileName" class="text-gray-900 dark:text-white font-medium" style="display: none;">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- PDF Icon tetap merah karena itu warna file PDF --}}
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                                            <span x-text="fileName"></span>
                                        </div>
                                        <p class="text-xs text-brand-600 mt-1">File terpilih</p>
                                    </div>
                                    <input type="file" name="cv" accept=".pdf" class="hidden" @change="fileName = $event.target.files[0].name" />
                                </label>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN: FORMS --}}
                    <div class="lg:col-span-2 space-y-8">
                        
                        {{-- PERSONAL INFO --}}
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 pb-4 border-b border-gray-100 dark:border-gray-700">
                                {{-- Ganti Blue ke Brand --}}
                                <span class="bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-300 p-2 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                Profil Pribadi
                            </h3>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                                    {{-- Ganti focus:ring-blue ke focus:ring-brand --}}
                                    <input type="text" name="name" required value="{{ old('name', $teamMember->name) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Contoh: Jhon Doe, S.Kom">
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Posisi / Role</label>
                                    <input type="text" name="position" required value="{{ old('position', $teamMember->position) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Contoh: Mahasiswa Magang / Ketua Lab">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email (Opsional)</label>
                                    <input type="email" name="email" value="{{ old('email', $teamMember->email) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="email@contoh.com">
                                </div>
                                 <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Induk (NIP / NIM)</label>
                                    <input type="text" name="nip" value="{{ old('nip', $teamMember->nip) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Opsional">
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIDN (Khusus Dosen)</label>
                                    <input type="text" name="nidn" value="{{ old('nidn', $teamMember->nidn) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Opsional">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pendidikan / Status Saat Ini</label>
                                    <input type="text" name="education" value="{{ old('education', $teamMember->education) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Contoh: Mahasiswa S1 Sastra Indonesia / S3 Filologi">
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Urutan Tampil (Opsional)</label>
                                    <input type="number" name="order" value="{{ old('order', $teamMember->order) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all">
                                    <p class="text-[10px] text-gray-500 mt-1">Angka lebih kecil tampil lebih dulu.</p>
                                </div>
                            </div>
                        </div>

                        {{-- EXTERNAL PROFILES --}}
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                             <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 pb-4 border-b border-gray-100 dark:border-gray-700">
                                {{-- Ganti Purple ke Brand --}}
                                <span class="bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-300 p-2 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </span>
                                Portofolio & Identitas Peneliti (Opsional)
                            </h3>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sinta ID</label>
                                    {{-- Ganti focus:ring-purple ke focus:ring-brand --}}
                                    <input type="text" name="sinta_id" value="{{ old('sinta_id', $teamMember->sinta_id) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Google Scholar ID</label>
                                    <input type="text" name="scholar_id" value="{{ old('scholar_id', $teamMember->scholar_id) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Scopus ID</label>
                                    <input type="text" name="scopus_id" value="{{ old('scopus_id', $teamMember->scopus_id) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Orcid ID</label>
                                    <input type="text" name="orcid_id" value="{{ old('orcid_id', $teamMember->orcid_id) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bidang Keahlian / Minat</label>
                                    <input type="text" name="expertise" value="{{ old('expertise', $teamMember->expertise) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Contoh: Video Editing, UI/UX, Sejarah Lokal">
                                    <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fokus Riset / Project</label>
                                    <textarea name="research_focus" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Deskripsikan project atau riset yang sedang dikerjakan...">{{ old('research_focus', $teamMember->research_focus) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('admin.team.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors">
                                Batal
                            </a>
                            {{-- Ganti bg-blue ke bg-brand --}}
                            <button type="submit" class="px-6 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-bold shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 transition-all">
                                Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>