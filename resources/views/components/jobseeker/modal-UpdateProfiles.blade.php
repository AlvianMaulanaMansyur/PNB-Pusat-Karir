<!-- Modal Update Profil -->
<div x-data="profileModal()" x-init="init()" class="relative">
    <!-- Trigger -->
    <button @click="open = true" class="border-2 px-5 py-2 rounded-xl hover:bg-blue-900 font-semibold text-white">
        Ubah
    </button>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-transition>
        <div class="bg-white rounded-2xl w-full max-w-3xl p-8 shadow-lg relative" @click.away="open = false">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Perbarui Profil</h2>

            <form id="profileForm" action="{{ route('profile.update-profiles') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                    <!-- Foto Profil -->
                    <div class="relative group mx-auto md:mx-0">
                        <img :src="photoPreview" alt="Preview" class="rounded-full w-32 h-32 object-cover border-4 border-blue-200 shadow" />

                        <label for="photo_profile"
                            class="absolute bottom-1 right-1 bg-white p-2 rounded-full border border-gray-300 cursor-pointer shadow">
                            <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.414 2.586a2 2 0 010 2.828l-1.172 1.172-2.828-2.828 1.172-1.172a2 2 0 012.828 0zM2 13.586V17h3.414l9.172-9.172-3.414-3.414L2 13.586z" />
                            </svg>
                        </label>

                        <input id="photo_profile" name="photo_profile" type="file" accept="image/*" class="hidden" @change="previewImage">
                    </div>

                    <!-- Input Fields -->
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Depan</label>
                            <input type="text" name="first_name" value="{{ $employeeData->first_name }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Akhiran (Nama Belakang)</label>
                            <input type="text" name="last_name" value="{{ $employeeData->last_name }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Suffix</label>
                            <input type="text" name="suffix" value="{{ $employeeData->suffix }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                            <input type="text" name="no_telp" value="{{ $employeeData->phone }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="button" @click="confirmSubmit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert + Alpine.js Logic -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function profileModal() {
        return {
            open: false,
            photoPreview: '',
            init() {
                // Set default foto dari server
                this.photoPreview = '{{ $employeeData->photo_profile === 'image/user.png' ? asset($employeeData->photo_profile) : asset('storage/' . $employeeData->photo_profile) }}';
            },
            previewImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = e => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            confirmSubmit() {
                Swal.fire({
                    title: "Simpan perubahan?",
                    text: "Semua perubahan akan disimpan.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#4A3AFF",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('profileForm').submit();
                    }
                });
            }
        }
    }
</script>
