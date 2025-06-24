<!-- Tambah Pendidikan Section -->
<div x-data="educationForm()">
    <!-- Tombol toggle form -->
    <button type="button"
        @click="showForm = !showForm"
        class="px-4 py-2 border-2 border-primaryColor text-primaryColor font-semibold rounded-lg hover:bg-slate-100">
        Tambah Pendidikan
    </button>

    <!-- Form tambah pendidikan -->
    <div x-show="showForm" class="mt-4">
        <div class="border-4 p-5 border-primaryColor rounded-xl w-full">
            <div class="py-5">
                <h1 class="font-semibold text-2xl">Latar Belakang Pendidikan</h1>
                <p class="text-sm">Bagikan pencapaian akademis Anda; dipersilakan memasukan banyak pencapaian!</p>
            </div>

            <form id="educationForm" action="{{ route('add.educations') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                    <!-- Nama Lembaga -->
                    <div>
                        <x-label-required for="lembaga" :value="__('Nama Lembaga')" />
                        <x-text-input id="lembaga" class="block mt-1 w-full" type="text" name="lembaga" :value="old('lembaga')" required />
                        <x-input-error :messages="$errors->get('lembaga')" class="mt-2" />
                    </div>

                    <!-- Sertifikasi -->
                    <div>
                        <x-label-required for="sertifikasi" :value="__('Nama Sertifikasi')" />
                        <x-text-input id="sertifikasi" class="block mt-1 w-full" type="text" name="sertifikasi" :value="old('sertifikasi')" required />
                        <x-input-error :messages="$errors->get('sertifikasi')" class="mt-2" />
                    </div>

                    <!-- Kualifikasi Pendidikan -->
                    <div>
                        <x-label-required for="pendidikan" :value="__('Jenis Pendidikan')" />
                        <x-dropdown.kualifikasi-pendidikan id="pendidikan" class="block mt-1 w-full" name="pendidikan" :selected="old('pendidikan')" required />
                        <x-input-error :messages="$errors->get('pendidikan')" class="mt-2" />
                    </div>

                    <!-- Disiplin Utama -->
                    <div>
                        <x-label-required for="keahlian" :value="__('Jenis Keahlian')" />
                        <x-dropdown.disiplin-utama id="keahlian" class="block mt-1 w-full" name="keahlian" :selected="old('keahlian')" required />
                        <x-input-error :messages="$errors->get('keahlian')" class="mt-2" />
                    </div>

                    <!-- Tanggal Kelulusan -->
                    <div>
                        <x-label-required for="lulus" :value="__('Tanggal Kelulusan')" />
                        <x-text-input id="lulus" class="block mt-1 w-full" type="date" name="lulus" :value="old('lulus')" required />
                        <x-input-error :messages="$errors->get('lulus')" class="mt-2" />
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="py-5">
                    <x-required-hint-label for="deskripsi"
                        :value="__('Deskripsi')"
                        :hint="__('Jelaskan tentang program yang sedang anda ambil dan yang pernah anda lakukan. Jangan ragu untuk memasukan semua pengalaman anda termasuk hal-hal yang berkaitan dengan pekerjaan yang ingin dilamar.')" />
                    <x-text-area-input id="deskripsi" class="block mt-1 w-full" name="deskripsi" :selected="old('deskripsi')" required />
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <!-- Tombol Simpan -->
                <button
                    @click.prevent="confirmSubmit"
                    class="mt-6 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- CDN SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script Alpine x SweetAlert -->
<script>
    function educationForm() {
        return {
            showForm: false,
            confirmSubmit() {
                Swal.fire({
                    title: "Yakin ingin menambahkan data pendidikan?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#16a34a", // Tailwind green-600
                    cancelButtonColor: "#ef4444",  // Tailwind red-500
                    confirmButtonText: "Ya, simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('educationForm').submit();
                    }
                });
            }
        }
    }
</script>
