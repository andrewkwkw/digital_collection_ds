<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Anggota Tim') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Nama -->
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap (Gelar)')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Posisi -->
                            <div>
                                <x-input-label for="position" :value="__('Jabatan/Posisi')" />
                                <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" required placeholder="Contoh: Dosen Prodi Sastra Indonesia" />
                                <x-input-error :messages="$errors->get('position')" class="mt-2" />
                            </div>

                             <!-- Foto -->
                             <div>
                                <x-input-label for="photo" :value="__('Foto Profil (Wajib)')" />
                                <input id="photo" type="file" name="photo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                                <p class="mt-1 text-sm text-gray-500">JPG, PNG, max 2MB.</p>
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Pendidikan -->
                            <div>
                                <x-input-label for="education" :value="__('Pendidikan Terakhir')" />
                                <x-text-input id="education" class="block mt-1 w-full" type="text" name="education" :value="old('education')" placeholder="Contoh: S2, S3" />
                            </div>

                             <!-- NIDN -->
                             <div>
                                <x-input-label for="nidn" :value="__('NIDN')" />
                                <x-text-input id="nidn" class="block mt-1 w-full" type="text" name="nidn" :value="old('nidn')" />
                            </div>

                             <!-- NIP -->
                             <div>
                                <x-input-label for="nip" :value="__('NIP')" />
                                <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" />
                            </div>
                            
                             <!-- CV Upload -->
                             <div>
                                <x-input-label for="cv" :value="__('Upload CV (PDF)')" />
                                <input id="cv" type="file" name="cv" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept=".pdf">
                                <p class="mt-1 text-sm text-gray-500">PDF, max 5MB.</p>
                            </div>

                        </div>

                        <div class="mt-6 border-t pt-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">External IDs & Keahlian</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div>
                                    <x-input-label for="sinta_id" :value="__('Sinta ID')" />
                                    <x-text-input id="sinta_id" class="block mt-1 w-full" type="text" name="sinta_id" :value="old('sinta_id')" />
                                </div>
                                <div>
                                    <x-input-label for="scholar_id" :value="__('Google Scholar ID')" />
                                    <x-text-input id="scholar_id" class="block mt-1 w-full" type="text" name="scholar_id" :value="old('scholar_id')" />
                                </div>
                                <div>
                                    <x-input-label for="scopus_id" :value="__('Scopus ID')" />
                                    <x-text-input id="scopus_id" class="block mt-1 w-full" type="text" name="scopus_id" :value="old('scopus_id')" />
                                </div>
                                <div>
                                    <x-input-label for="orcid_id" :value="__('Orcid ID')" />
                                    <x-text-input id="orcid_id" class="block mt-1 w-full" type="text" name="orcid_id" :value="old('orcid_id')" />
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                     <x-input-label for="expertise" :value="__('Bidang Keahlian')" />
                                     <x-text-input id="expertise" class="block mt-1 w-full" type="text" name="expertise" :value="old('expertise')" placeholder="Contoh: Seni, Pendidikan" />
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                     <x-input-label for="research_focus" :value="__('Fokus Riset')" />
                                     <x-text-input id="research_focus" class="block mt-1 w-full" type="text" name="research_focus" :value="old('research_focus')" placeholder="Contoh: Seni dan Pendidikan" />
                                </div>
                                
                            </div>
                        </div>


                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('admin.team.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
