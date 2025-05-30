<x-cv-generator-layout :activeStep="$activeStep" :currentCv="$currentCv">
    <input type="hidden" id="current_cv_slug" value="{{ $currentCv->slug ?? '' }}">
    <div class="mb-6" id="informasi-pribadi-container">
        <div class="bg-white p-8 rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Informasi Pribadi</h2>
            <p class="text-sm text-gray-600 mb-6">Lengkapi data diri kamu agar HRD lebih mengenalmu!</p>

            <form id="personal-information-form">
                @csrf

                {{-- Judul CV --}}
                <div class="mb-6 border-b border-gray-300 pb-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Judul CV Anda</h3>
                    <div class="mb-4">
                        <x-input-label for="cv_title" :value="__('Judul CV')" />
                        <x-text-input id="cv_title" name="cv_title" type="text"
                            class="block mt-1 w-full text-sm 2xl:text-lg"
                            placeholder="Contoh: CV Digital Marketer Profesional" required
                            value="{{ old('cv_title', $currentCv->title ?? '') }}" />
                        @error('cv_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Nama Lengkap --}}
                <div class="mb-4">
                    <x-input-label for="nama" :value="__('Nama Lengkap')" />
                    <x-text-input id="nama" name="informasi_pribadi[nama]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: John Doe"
                        value="{{ old('informasi_pribadi.nama', $personalInfo->full_name ?? '') }}" required />
                    @error('informasi_pribadi.nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. Handphone --}}
                <div class="mb-4">
                    <x-input-label for="no_handphone" :value="__('No. Handphone')" />
                    <x-text-input id="no_handphone" name="informasi_pribadi[no_handphone]" type="tel"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: 081234567890"
                        value="{{ old('informasi_pribadi.no_handphone', $personalInfo->phone_number ?? '') }}" />
                    @error('informasi_pribadi.no_handphone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="informasi_pribadi[email]" type="email"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: john.doe@example.com"
                        value="{{ old('informasi_pribadi.email', $personalInfo->email ?? '') }}" />
                    @error('informasi_pribadi.email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- LinkedIn --}}
                <div class="mb-4">
                    <x-input-label for="linkedin" :value="__('LinkedIn (Opsional)')" />
                    <x-text-input id="linkedin" name="informasi_pribadi[linkedin]" type="url"
                        class="block mt-1 w-full text-sm 2xl:text-lg"
                        placeholder="Contoh: https://www.linkedin.com/in/johndoe"
                        value="{{ old('informasi_pribadi.linkedin', $personalInfo->linkedin ?? '') }}" />
                    @error('informasi_pribadi.linkedin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Portofolio --}}
                <div class="mb-4">
                    <x-input-label for="portofolio" :value="__('Portofolio (Opsional)')" />
                    <x-text-input id="portofolio" name="informasi_pribadi[portofolio]" type="url"
                        class="block mt-1 w-full text-sm 2xl:text-lg"
                        placeholder="Contoh: https://www.behance.net/johndoe"
                        value="{{ old('informasi_pribadi.portofolio', $personalInfo->portfolio ?? '') }}" />
                    @error('informasi_pribadi.portofolio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <x-input-label for="alamat" :value="__('Alamat')" />
                    <textarea id="alamat" name="informasi_pribadi[alamat]" rows="3"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Contoh: Jl. Sudirman No. 123, Jakarta Pusat">{{ old('informasi_pribadi.alamat', $personalInfo->address ?? '') }}</textarea>
                    @error('informasi_pribadi.alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi Diri --}}
                <div class="mb-4">
                    <x-input-label for="deskripsi" :value="__('Deskripsi Diri Singkat (Opsional)')" />
                    <textarea id="deskripsi" name="informasi_pribadi[deskripsi]" rows="4"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Tuliskan ringkasan singkat tentang diri Anda, keahlian utama, atau tujuan karir Anda.">{{ old('informasi_pribadi.deskripsi', $personalInfo->summary ?? '') }}</textarea>
                    @error('informasi_pribadi.deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto Profil --}}
                <div class="mb-4">
                    <x-input-label for="foto_profil" :value="__('Foto Profil (Opsional)')" />
                    <button type="button" id="upload-foto-profil-btn"
                        class="mt-1 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Unggah Foto Profil
                    </button>
                    <input type="file" id="foto_profil" name="foto_profil_file" accept="image/*" class="hidden">

                    {{-- Preview Gambar --}}
                    <div class="mt-4">
                        <img class="w-32" id="preview_foto_profil">
                    </div>
                    @error('foto_profil_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

               
                
                {{-- Tombol Simpan --}}
                <div class="mt-8 flex justify-end">
                    <button type="button" id="savePersonalInfoBtn"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let debounceTimer;
            const cvSlug = document.getElementById('current_cv_slug').value;

            // Load data dari sesi saat halaman dimuat
            function loadInformasiFromSession() {
                const databaseFotoProfil = '{{ $personalInfo->profile_photo ?? '' }}';
                console.log(databaseFotoProfil);
                fetch(`/load-session-data/${cvSlug}`)
                    .then(response => response.json())
                    .then(data => {

                        console.log(data.informasi_pribadi);
                        // Load informasi pribadi
                        if (data.informasi_pribadi) {
                            const info = data.informasi_pribadi;
                            document.getElementById('nama').value = info.full_name || '';
                            document.getElementById('no_handphone').value = info.phone_number || '';
                            document.getElementById('email').value = info.email || '';
                            document.getElementById('linkedin').value = info.linkedin_url || '';
                            document.getElementById('portofolio').value = info.portfolio_url || '';
                            document.getElementById('alamat').value = info.address || '';
                            document.getElementById('deskripsi').value = info.summary || '';

                            // Jika tidak ada foto di session, gunakan foto dari database
                            if (!info.profile_photo && databaseFotoProfil) {
                                info.profile_photo = databaseFotoProfil;
                            }

                            const fotoProfilButton = document.getElementById('upload-foto-profil-btn');
                            const previewImg = document.getElementById('preview_foto_profil');

                            if (info.profile_photo) {
                                fotoProfilButton.innerHTML = `
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Foto Terpilih: ${info.profile_photo.split('/').pop()}
                                `;
                                previewImg.src =
                                    `{{ asset('storage') }}/${info.profile_photo}`; // Menggunakan 'storage' path
                                previewImg.classList.remove('hidden');
                            } else {
                                fotoProfilButton.innerHTML = `
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Unggah Foto Profil
                                `;
                                previewImg.classList.add('hidden');
                                previewImg.src = '';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error saat memuat data sesi:', error);
                    });
            }

            // Fungsi Update Preview untuk Informasi Pribadi
            function updatePreview() {
                fetch(
                        `/load-session-data/${cvSlug}`
                        ) // This endpoint should return data using database column names
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('preview-informasi-pribadi');
                        const info = data.informasi_pribadi ||
                        {}; // Expecting data.personal_information from your backend
                        console.log(info);

                        const previewHTML = `
                <div class="mt-4">
                    <div class="flex items-center">
                        ${info.profile_photo ? `
                                            <img src="${window.location.origin}/storage/${info.profile_photo}" alt="Foto Profil"
                                                class="w-20 h-20 rounded-full object-cover mr-4">` : ''
                        }
                        <div>
                            <h3 class="font-bold text-lg">${info.full_name || ''}</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="font-semibold">Kontak</p>
                            <p class="text-gray-600">${info.phone_number || ''}</p>
                            <p class="text-gray-600">${info.email || ''}</p>
                            <p class="text-gray-600">${info.address || ''}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Media Profesional</p>
                            <p class="text-gray-600">
                                ${info.linkedin_url ? `LinkedIn: ${info.linkedin_url}` : ''}
                            </p>
                            <p class="text-gray-600">
                                ${info.portfolio_url ? `Portofolio: ${info.portfolio_url}` : ''}
                            </p>
                        </div>
                    </div>

                    ${info.summary ? `
                                        <div class="mt-4">
                                            <p class="font-semibold">Tentang Saya</p>
                                            <p class="text-gray-700">${info.summary}</p>
                                        </div>` : ''
                    }
                </div>
            `;

                        container.innerHTML = previewHTML;
                    })
                    .catch(error => {
                        console.error('Error fetching data for personal information preview:', error);
                        // Provide a fallback message if data loading fails
                        document.getElementById('preview-informasi-pribadi').innerHTML =
                            '<p class="mt-2 text-gray-700">Informasi pribadi tidak dapat dimuat.</p>';
                    });
            }

            // Call this function when the page loads or when personal information is updated
            // document.addEventListener('DOMContentLoaded', updatePreview);

            // Panggil fungsi load saat halaman dimuat

            // Fungsi untuk menyimpan judul CV secara realtime ke DB
            function saveCvTitleRealtime() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const slug = document.getElementById('current_cv_slug').value;
                    const title = document.getElementById('cv_title').value;

                    if (!slug) {
                        console.warn('Tidak ada CV slug di sesi, tidak dapat menyimpan judul realtime.');
                        return;
                    }

                    // Dapatkan URL dari route helper Laravel
                    const updateTitleUrl = '{{ route('cv.update.title', ['slug' => ':slug']) }}';
                    const url = updateTitleUrl.replace(':slug', encodeURIComponent(slug));

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                title: title
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Judul CV diperbarui realtime:', data.message);
                            } else {
                                console.error('Gagal memperbarui judul CV realtime:', data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error jaringan saat memperbarui judul CV realtime:', error);
                        });
                }, 500);
            }

            // Event listener untuk input judul CV (realtime save)
            document.getElementById('cv_title').addEventListener('input', saveCvTitleRealtime);
            // document.getElementById('cv_description').addEventListener('input', saveCvTitleRealtime);


            // Event listener untuk upload foto profil
            document.getElementById('upload-foto-profil-btn').addEventListener('click', function() {
                document.getElementById('foto_profil').click();
            });

            document.getElementById('foto_profil').addEventListener('change', function(e) {
                const button = this.previousElementSibling;
                const previewImg = document.getElementById('preview_foto_profil');
                const file = this.files[0];

                if (file) {
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Foto Terpilih: ${file.name}
                    `;

                    const formData = new FormData();
                    formData.append('dokumen', file);
                    formData.append('field', 'informasi_pribadi');
                    formData.append('slug', cvSlug);

                    fetch('{{ route('upload.profile.photo') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Foto profil berhasil diunggah:', data.filename);
                                previewImg.src = `{{ asset('storage') }}/${data.filename}`;
                                previewImg.classList.remove('hidden');
                            } else {
                                console.error('Gagal mengunggah foto profil:', data.error);
                                alert('Gagal mengunggah foto profil: ' + (data.error ||
                                    'Terjadi kesalahan.'));
                            }
                        })
                        .catch(error => {
                            console.error('Error jaringan saat mengunggah foto profil:', error);
                            alert(
                                'Terjadi kesalahan jaringan atau server saat mengunggah foto profil.'
                            );
                        });
                } else {
                    // Jika file dihapus dari input
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Unggah Foto Profil
                    `;
                    previewImg.classList.add('hidden');
                    previewImg.src = '';

                    // Kirim pembaruan ke sesi untuk menghapus nama file foto profil
                    fetch('{{ route('save.session.realtime') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                field: 'informasi_pribadi',
                                value: {
                                    profile_photo: ''
                                }, // Set foto_profil menjadi kosong
                                slug: cvSlug
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Foto profil dihapus dari sesi:', data);
                        })
                        .catch(error => {
                            console.error('Error saat menghapus foto profil dari sesi:', error);
                        });
                }
            });

            // Simpan data informasi pribadi (teks) ke sesi secara realtime
            function saveInformasiToSession() {
                // const cvSlug = document.getElementById('current_cv_slug').value;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const formData = {
                        full_name: document.getElementById('nama').value,
                        phone_number: document.getElementById('no_handphone').value,
                        email: document.getElementById('email').value,
                        linkedin_url: document.getElementById('linkedin').value,
                        portfolio_url: document.getElementById('portofolio').value,
                        address: document.getElementById('alamat').value,
                        summary: document.getElementById('deskripsi').value,
                    };

                    fetch('{{ route('save.session.realtime') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                field: 'informasi_pribadi',
                                value: formData,
                                slug: cvSlug
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Informasi pribadi disimpan ke sesi (teks):', data);
                            updatePreview()
                        })
                        .catch(error => {
                            console.error('Error saat menyimpan ke sesi (teks):', error);
                        });
                }, 500);
            }

            function updateFotoPreview(filePath) {
                const previewImg = document.getElementById('preview_foto_profil');
                previewImg.src = `{{ asset('storage') }}/${filePath}`;
                previewImg.classList.remove('hidden');
            }

            // Event listener untuk input teks informasi pribadi
            document.querySelectorAll(
                    '#personal-information-form input[type="text"]:not(#cv_title), #personal-information-form input[type="tel"], #personal-information-form input[type="email"], #personal-information-form input[type="url"], #personal-information-form textarea:not(#cv_description)'
                )
                .forEach(input => {
                    input.addEventListener('input', saveInformasiToSession);
                });

            document.getElementById('savePersonalInfoBtn').addEventListener('click', function() {
                // Ambil data langsung dari form
                const formData = {
                    cv_title: document.getElementById('cv_title').value,
                    nama: document.getElementById('nama').value,
                    no_handphone: document.getElementById('no_handphone').value,
                    email: document.getElementById('email').value,
                    linkedin: document.getElementById('linkedin').value,
                    portofolio: document.getElementById('portofolio').value,
                    alamat: document.getElementById('alamat').value,
                    deskripsi: document.getElementById('deskripsi').value,
                    foto_profil: document.getElementById('preview_foto_profil').src.replace(
                        /^.*\/storage\//, '') // Ambil path dari preview
                };

                // Kirim request dengan data form
                fetch('{{ route('save.personal.information', $currentCv->slug) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Berhasil menyimpan data informasi pribadi')
                            window.location.href = data.redirect_url;
                        } else {
                            alert('Gagal menyimpan: ' + (data.error || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        let errorMessage = 'Terjadi kesalahan jaringan';
                        if (error.errors) {
                            errorMessage = Object.values(error.errors).join('\n');
                        } else if (error.error) {
                            errorMessage = error.error;
                        }
                        alert(errorMessage);
                    });
            });

            // ==================== LOAD DATA DARI DATABASE ====================
            if (cvSlug) {
                fetch(`/cv/${cvSlug}/personal-informations/load`) // Pastikan URL sesuai route
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.informasi_pribadi && data.informasi_pribadi.length > 0) {
                            const p = data.informasi_pribadi[0]; // Ambil data pertama

                            // Isi nilai form
                            document.getElementById('nama').value = p.full_name || '';
                            document.getElementById('no_handphone').value = p.phone_number || '';
                            document.getElementById('email').value = p.email || '';
                            document.getElementById('linkedin').value = p.linkedin_url || '';
                            document.getElementById('portofolio').value = p.portfolio_url || '';
                            document.getElementById('alamat').value = p.address || '';
                            document.getElementById('deskripsi').value = p.summary || '';

                            // Handle foto profil
                            const previewImg = document.getElementById('preview_foto_profil');
                            if (p.profile_photo) {
                                previewImg.src = `{{ asset('storage') }}/${p.profile_photo}`;
                                previewImg.classList.remove('hidden');
                            } else {
                                previewImg.src = '';
                                previewImg.classList.add('hidden');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // alert('Gagal memuat data dari server');
                    });
            }

            // saveInformasiToSession()
            loadInformasiFromSession();
            // updatePreview()


        });
    </script>
</x-cv-generator-layout>
