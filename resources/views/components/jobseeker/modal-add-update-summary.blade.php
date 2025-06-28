<div x-data="{
    summary: @js($summary ?? ''),
    showModal: false
}">

    <!-- Tombol Tambah Ringkasan -->
    <template x-if="!summary">
        <div>
            <button @click="showModal = true; $dispatch('open-modal', '{{ 'summary-modal' }}')"
                class="bg-blue-600  rounded-xl text-white px-4 py-2 hover:bg-blue-700">
                Tambah Ringkasan
            </button>
        </div>
    </template>

    <!-- Ringkasan tampil jika sudah ada -->
    <template x-if="summary">
        <div class="border-4 border-gray-300     p-4 rounded-xl relative">
            <p x-text="summary" class="text-gray-800 whitespace-pre-line pe-20 text-justify"></p>
            <button @click="showModal = true; $dispatch('open-modal', 'summary-modal')"
                class="absolute top-3 right-6 text-primaryColor hover:text-blue-800">
                <i class="fa-regular fa-pen-to-square text-2xl"></i>
            </button>
        </div>
    </template>

    <!-- Modal pakai komponen -->
    <x-modal name="summary-modal" :show="false" max-width="2xl">
        <form method="POST" action="{{ route('profile.update-summary') }}">
            @csrf
            @method('PUT')

            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Ringkasan Diri</h2>

                <textarea name="summary" x-model="summary" class="w-full border-xl rounded p-2 mb-4" rows="5"
                    placeholder="Ceritakan diri Anda">
                </textarea>
                <div class="flex justify-end space-x-2">
                    <button type="button" @click="$dispatch('close-modal', '{{ 'summary-modal' }}')"
                        class="px-4 py-2 border rounded text-gray-600 hover:bg-red-600 hover:text-white">
                        Batal
                    </button>
                    <button type="submit" x-ref="submitBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-800">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </x-modal>
</div>

