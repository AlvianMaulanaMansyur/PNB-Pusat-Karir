<div x-data="educationForm()">
    <p class="text-blue-700 text-2xl font-semibold py-2">Pendidikan</p>
    @foreach ($educations as $key)
        <div class="container border-4 border-gray-300 p-5 my-2 rounded-lg relative">
            <!-- Tombol Edit di pojok kanan atas -->
            <button @click="openEditModal(@js($key))"
                class="absolute top-2 right-6 text-gray-500 hover:text-gray-300">
                <i class="fa-regular fa-pen-to-square text-2xl"></i>
            </button>

            <p class="text-gray-700 text-md">{{ $key->institution }}</p>
            <h2 class="font-semibold text-xl">{{ $key->sertifications }}</h2>

            <div class="flex items-center gap-3">
                <i class="fa-solid fa-graduation-cap"></i>
                <p>{{ $key->degrees }}</p>
            </div>
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-book"></i>
                <p>{{ $key->dicipline }}</p>
            </div>
            <p class="text-sm text-gray-500">Lulus {{ \Carbon\Carbon::parse($key->end_date)->translatedFormat('F Y') }}
            </p>
            <div class="py-4">
                <h2 class="font-semibold py-2">Deskripsi Pengalaman:</h2>
                <p class="text-justify">{!! nl2br(e($key->description)) !!}</p>
            </div>
        </div>
    @endforeach

    <!-- Tombol toggle form tambah -->
    <button type="button" @click="showForm = !showForm"
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
                        <x-text-input id="lembaga" class="block mt-1 w-full" type="text" name="lembaga"
                            :value="old('lembaga')" required />
                        <x-input-error :messages="$errors->get('lembaga')" class="mt-2" />
                    </div>

                    <!-- Sertifikasi -->
                    <div>
                        <x-label-required for="sertifikasi" :value="__('Nama Sertifikasi')" />
                        <x-text-input id="sertifikasi" class="block mt-1 w-full" type="text" name="sertifikasi"
                            :value="old('sertifikasi')" required />
                        <x-input-error :messages="$errors->get('sertifikasi')" class="mt-2" />
                    </div>

                    <!-- Kualifikasi Pendidikan -->
                    <div>
                        <x-label-required for="pendidikan" :value="__('Jenis Pendidikan')" />
                        <x-dropdown.kualifikasi-pendidikan id="pendidikan" class="block mt-1 w-full" name="pendidikan"
                            :selected="old('pendidikan')" required />
                        <x-input-error :messages="$errors->get('pendidikan')" class="mt-2" />
                    </div>

                    <!-- Disiplin Utama -->
                    <div>
                        <x-label-required for="keahlian" :value="__('Jenis Keahlian')" />
                        <x-dropdown.disiplin-utama id="keahlian" class="block mt-1 w-full" name="keahlian"
                            :selected="old('keahlian')" required />
                        <x-input-error :messages="$errors->get('keahlian')" class="mt-2" />
                    </div>

                    <!-- Tanggal Kelulusan -->
                    <div>
                        <x-label-required for="lulus" :value="__('Tanggal Kelulusan')" />
                        <x-text-input id="lulus" class="block mt-1 w-full" type="date" name="lulus"
                            :value="old('lulus')" required />
                        <x-input-error :messages="$errors->get('lulus')" class="mt-2" />
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="py-5">
                    <x-required-hint-label for="deskripsi" :value="__('Deskripsi')" :hint="__(
                        'Jelaskan tentang program yang sedang anda ambil dan yang pernah anda lakukan. Jangan ragu untuk memasukan semua pengalaman anda termasuk hal-hal yang berkaitan dengan pekerjaan yang ingin dilamar.',
                    )" />
                    <x-text-area-input id="deskripsi" class="block mt-1 w-full" name="deskripsi" :selected="old('deskripsi')"
                        required />
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <button @click.prevent="confirmSubmit"
                    class="mt-6 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pendidikan -->
    <x-modal name="edit-education-modal" :show="false" max-width="2xl">
        <form method="POST" :action="'/my-profile/education/edit/' + form.id">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <h2 class="text-lg font-semibold">Edit Pendidikan</h2>

                <x-label-required for="institution" :value="__('Nama Lembaga')" />
                <x-text-input id="institution" class="block w-full" type="text" name="institution"
                    x-model="form.institution" required />

                <x-label-required for="sertifications" :value="__('Nama Sertifikasi')" />
                <x-text-input id="sertifications" class="block w-full" type="text" name="sertifications"
                    x-model="form.sertifications" required />

                <x-label-required for="degrees" :value="__('Jenis Pendidikan')" />
                <x-dropdown.kualifikasi-pendidikan id="degrees" class="block w-full" type="text" name="degrees" x-model="form.degrees"
                    required />

                <x-label-required for="dicipline" :value="__('Jenis Keahlian')" />
                <x-dropdown.disiplin-utama id="dicipline" class="block w-full" type="text" name="dicipline"
                    x-model="form.dicipline" required />

                <x-label-required for="end_date" :value="__('Tanggal Kelulusan')" />
                <x-text-input id="end_date" class="block w-full" type="date" name="end_date" x-model="form.end_date"
                    required />

                <x-label-required for="description" :value="__('Deskripsi')" />
                <textarea name="description" x-model="form.description" rows="4" class="w-full border p-2 rounded" required></textarea>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="$dispatch('close-modal', 'edit-education-modal')"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </x-modal>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function educationForm() {
        return {
            showForm: false,
            form: {
                id: null,
                institution: '',
                degrees: '',
                dicipline: '',
                sertifications: '',
                description: '',
                end_date: '',
            },
            confirmSubmit() {
                Swal.fire({
                    title: "Yakin ingin menambahkan data pendidikan?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#16a34a",
                    cancelButtonColor: "#ef4444",
                    confirmButtonText: "Ya, simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('educationForm').submit();
                    }
                });
            },
            openEditModal(data) {
                this.form = {
                    id: data.id,
                    institution: data.institution,
                    degrees: data.degrees,
                    dicipline: data.dicipline,
                    sertifications: data.sertifications,
                    description: data.description,
                    end_date: data.end_date,
                };
                this.$dispatch('open-modal', 'edit-education-modal');
            }
        }
    }
</script>
