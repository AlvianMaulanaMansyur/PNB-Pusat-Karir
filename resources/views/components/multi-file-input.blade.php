@props([
    'label' => 'Upload File',
    'name' => 'files',
    'id' => $name,
])

<div class="w-full py-4">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>

    <div class="flex items-center border border-gray-600 rounded-md overflow-hidden bg-white">
        <!-- Button -->
        <label for="{{ $id }}"
            class="px-4 py-2 bg-gray-200 text-sm text-gray-700 cursor-pointer hover:bg-gray-400 whitespace-nowrap">
            Choose file
        </label>

        <!-- Placeholder -->
        <span id="{{ $id }}_placeholder" class="px-3 py-2 text-sm text-gray-700 truncate w-full">
            bisa lebih dari satu, silakan pilih file
        </span>
    </div>

    <!-- File List -->
    <ul id="{{ $id }}_list" class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1 hidden"></ul>

    <!-- Hidden file input -->
    <input type="file" id="{{ $id }}" name="{{ $name }}[]" class="hidden" multiple
        {{ $attributes }}
        onchange="
            const input = this;
            const list = document.getElementById('{{ $id }}_list');
            const placeholder = document.getElementById('{{ $id }}_placeholder');

            list.innerHTML = '';

            if (input.files.length === 0) {
                placeholder.textContent = 'No file selected';
                list.classList.add('hidden');
            } else {
                placeholder.textContent = `${input.files.length} file(s) selected`;
                list.classList.remove('hidden');

                for (let i = 0; i < input.files.length; i++) {
                    const li = document.createElement('li');
                    li.textContent = input.files[i].name;
                    list.appendChild(li);
                }
            }
        ">
</div>
