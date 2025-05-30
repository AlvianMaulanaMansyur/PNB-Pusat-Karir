@props(['id' => 'city', 'name' => 'city'])

<div>
    <select id="{{ $id }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full border rounded p-2']) }}>
        <option value="">Pilih Kota</option>
    </select>
</div>
