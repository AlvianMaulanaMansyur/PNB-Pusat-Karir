<div x-data="{
    summary: @js($summary ?? ''),
    showModal: false
}">

    <!-- Tombol Tambah Ringkasan -->
    <template x-if="!summary">
        <div>
            <p>Tambahkan tentang diri Anda</p>
            <button @click="showModal = true; $dispatch('open-modal', '{{ 'summary-modal' }}')"
                class="bg-blue-600  rounded-xl text-white px-4 py-2 hover:bg-blue-700">
                Tambah Ringkasan
            </button>
        </div>
    </template>

    <!-- Ringkasan tampil jika sudah ada -->
    <template x-if="summary">
        <div class="border p-4 rounded-xl relative mx-20 ">
            <p x-text="summary" class="text-gray-800 whitespace-pre-line pe-20"></p>
            <button @click="showModal = true; $dispatch('open-modal', 'summary-modal')"
                class="absolute top-2 right-2 text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
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

                <textarea name="summary" x-model="summary" class="w-full border rounded p-2 mb-4" rows="5"
                    placeholder="Ceritakan diri Anda">
                </textarea>
                <div class="flex justify-end space-x-2">
                    <button type="button" @click="$dispatch('close-modal', '{{ 'summary-modal' }}')"
                        class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" x-ref="submitBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </x-modal>
</div>
