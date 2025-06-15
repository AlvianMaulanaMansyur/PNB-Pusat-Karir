<!-- Modal Update Foto -->
<div x-data="{ open: false }">
    <!-- Trigger -->
    <button @click="open = true" class="border-2 px-5 py-2 rounded-xl hover:bg-blue-900">
        Ubah Foto Profil
    </button>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-transition>
        <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-lg" @click.away="open = false">
            <h2 class="text-xl font-bold mb-4">Ubah Foto Profil</h2>
            <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="relative inline-block group">
                    <img src="{{ $employeeData->photo_profile === 'image/user.png'
                        ? asset($employeeData->photo_profile)
                        : asset('storage/' . $employeeData->photo_profile) }}"
                        alt="Profile" class="rounded-full w-28 h-28 object-cover border-2 border-gray-200" />

                    <label for="photo_profile"
                        class="absolute bottom-1 right-1 bg-white p-1 rounded-full border border-gray-300 cursor-pointer shadow">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M17.414 2.586a2 2 0 010 2.828l-1.172 1.172-2.828-2.828 1.172-1.172a2 2 0 012.828 0zM2 13.586V17h3.414l9.172-9.172-3.414-3.414L2 13.586z" />
                        </svg>
                    </label>

                    <input id="photo_profile" name="photo_profile" type="file" accept="image/*" class="hidden"
                        onchange="confirmUpload(this)">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="open = false" class="px-4 py-2 text-gray-700 hover:underline">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpload(input) {
            if (!input.files.length) return;

            Swal.fire({
                title: "Yakin ingin mengganti foto?",
                text: "Foto lama akan digantikan dengan foto baru.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4A3AFF",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, ganti!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form
                    input.form.submit();
                } else {
                    // Reset input jika user batal
                    input.value = '';
                }
            });
        }
    </script>
