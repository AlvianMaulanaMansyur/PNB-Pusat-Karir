@props(['id' => 'country', 'name' => 'country', 'label' => 'Negara'])

<div>
    {{-- <label for="{{ $id }}" class="block font-medium text-sm text-gray-700">{{ $label }}</label> --}}
    <select id="{{ $id }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full border rounded p-2']) }}>
        <option value="">Pilih {{ strtolower($label) }}</option>
    </select>
</div>
