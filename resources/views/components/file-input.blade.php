@props([
    'label' => 'Upload File',
    'name' => 'file',
    'id' => $name,
])

<div class="w-full py-4">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1  ">{{ $label }}</label>

    <div class="flex items-center border border-gray-600 rounded-md overflow-hidden bg-white">
        <!-- Button -->
        <label for="{{ $id }}"
            class="px-4 py-2 bg-gray-200 text-sm text-gray-700 cursor-pointer hover:bg-gray-400 whitespace-nowrap">
            Choose file
        </label>

        <!-- Filename display -->
        <span id="{{ $id }}_name" class="px-3 py-2 text-sm text-gray-700 truncate w-full">Tidak ada file
            terpilih</span>
    </div>

    <!-- Hidden input -->
    <input type="file" id="{{ $id }}" name="{{ $name }}" class="hidden" {{ $attributes }}
        onchange="document.getElementById('{{ $id }}_name').textContent = this.files[0]?.name || 'No file selected';">
</div>
