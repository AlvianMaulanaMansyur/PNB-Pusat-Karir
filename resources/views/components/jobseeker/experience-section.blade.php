<div x-data="workExperienceForm()">
    <p class="text-blue-700 text-3xl font-semibold py-2">Pengalaman Kerja</p>
    <p class="text-lg text-gray-600">Bagikan pengalaman profesional Anda; Anda bisa memasukkan lebih dari satu pekerjaan.
    @foreach ($experience as $exp)
        <div class="container border-4 border-gray-300 p-5 my-2 rounded-lg relative" x-data="{ open: false }">
            <!-- Tombol Tiga Titik -->
            <div class="absolute top-2 right-4 text-gray-700">
                <button @click="open = !open" class="focus:outline-none">
                    <i class="fas fa-ellipsis-v text-xl"></i>
                </button>

                <!-- Dropdown Aksi -->
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-32 bg-white border border-gray-300 rounded-md shadow-md z-50">
                    <ul class="text-sm text-gray-700 divide-y divide-gray-200">
                        <li>
                            <button @click="openEditModal(@js($exp)); open = false"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                Edit
                            </button>
                        </li>
                        <li>
                            <button @click.prevent="confirmDeletion({{ $exp->id }})"
                                class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">
                                Hapus
                            </button>

                            <!-- Form hapus tersembunyi -->
                            <form x-ref="deleteForm_{{ $exp->id }}"
                                action="{{ route('work-experience.delete', $exp->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Isi Konten Pengalaman -->
            <p class="text-gray-700 text-md">{{ $exp->company }}</p>
            <h2 class="font-semibold text-xl">{{ $exp->position }}</h2>

            <p class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($exp->start_date)->translatedFormat('F Y') }} -
                {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->translatedFormat('F Y') : 'Sekarang' }}
            </p>

            <div class="py-4">
                <h2 class="font-semibold py-2">Deskripsi Pekerjaan:</h2>
                <p class="text-justify">{!! nl2br(e($exp->description)) !!}</p>
            </div>
        </div>
    @endforeach


    <!-- Tombol toggle -->
    <button type="button" @click="showForm = !showForm"
        class="px-4 mt-3 py-2 border-2 border-primaryColor text-primaryColor font-semibold rounded-lg hover:bg-slate-100">
        Tambah Pengalaman
    </button>

    <!-- Form Tambah -->
    <div x-show="showForm" class="mt-4">
        <div class="border-4 p-5 border-primaryColor rounded-xl w-full">
            <div class="py-5">
                <h1 class="font-semibold text-2xl">Pengalaman Kerja</h1>
                <p class="text-sm">Bagikan pengalaman profesional Anda; Anda bisa memasukkan lebih dari satu pekerjaan.
                </p>
            </div>

            <form id="experienceForm" action="{{ route('work-experience.add') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                    <div>
                        <x-label-required for="company" :value="__('Instansi')" />
                        <x-text-input id="company" name="company" class="block mt-1 w-full" required />
                    </div>

                    <div>
                        <x-label-required for="position" :value="__('Posisi')" />
                        <x-text-input id="position" name="position" class="block mt-1 w-full" required />
                    </div>

                    <div>
                        <x-label-required for="start_date" :value="__('Tanggal Mulai')" />
                        <x-text-input id="start_date" name="start_date" type="date" class="block mt-1 w-full"
                            required />
                    </div>

                    <div>
                        <x-input-label for="end_date" :value="__('Tanggal Berakhir')" />
                        <x-text-input id="end_date" name="end_date" type="date" class="block mt-1 w-full" />
                        <small class="text-gray-500 text-sm">Kosongkan jika masih bekerja di sini</small>
                    </div>
                </div>
                <div class="py-5">
                    <x-required-hint-label for="description" :value="__('description')" :hint="'Ceritakan pekerjaan Anda, tanggung jawab, dan pencapaian utama.'" />
                    <x-text-area-input id="description" name="description" class="block mt-1 w-full" required />
                </div>
                <button @click.prevent="confirmSubmit"
                    class="mt-6 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                    Simpan
                </button>
            </form>
        </div>
    </div>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Modal Edit Pengalaman -->
    <x-modal name="edit-experience-modal" :show="false" max-width="2xl">
        <form method="POST" :action="'/my-profile/work-experience/edit/' + form.id">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <h2 class="text-lg font-semibold">Edit Pengalaman Kerja</h2>

                <x-label-required for="company" :value="__('Nama Perusahaan')" />
                <x-text-input id="company" name="company" x-model="form.company" class="block w-full" required />

                <x-label-required for="position" :value="__('Posisi')" />
                <x-text-input id="position" name="position" x-model="form.position" class="block w-full" required />

                <x-label-required for="start_date" :value="__('Tanggal Mulai')" />
                <x-text-input id="start_date" name="start_date" x-model="form.start_date" type="date"
                    class="block w-full" required />

                <x-label-required for="end_date" :value="__('Tanggal Berakhir')" />
                <x-text-input id="end_date" name="end_date" x-model="form.end_date" type="date"
                    class="block w-full" />

                <x-label-required for="description" :value="__('Deskripsi')" />
                <textarea name="description" x-model="form.description" rows="4" class="w-full border p-2 rounded" required></textarea>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="$dispatch('close-modal', 'edit-experience-modal')"
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

<script>
    function workExperienceForm() {
        return {
            showForm: false,
            form: {
                id: null,
                company: '',
                position: '',
                start_date: '',
                end_date: '',
                description: '',
            },

            // Fungsi konfirmasi tambah data
            confirmSubmit() {
                Swal.fire({
                    title: "Yakin ingin menambahkan pengalaman kerja?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#16a34a",
                    cancelButtonColor: "#ef4444",
                    confirmButtonText: "Ya, simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('experienceForm').submit();
                    }
                });
            },

            // Fungsi buka modal edit
            openEditModal(data) {
                this.form = {
                    id: data.id,
                    company: data.company,
                    position: data.position,
                    start_date: data.start_date,
                    end_date: data.end_date,
                    description: data.description,
                };
                this.$dispatch('open-modal', 'edit-experience-modal');
            },

            // ✅ Fungsi konfirmasi hapus data
            confirmDeletion(id) {
                Swal.fire({
                    title: 'Yakin ingin menghapus pengalaman ini?',
                    text: "Tindakan ini tidak dapat dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$refs[`deleteForm_${id}`].submit();
                    }
                });
            },
        }
    }
</script>
