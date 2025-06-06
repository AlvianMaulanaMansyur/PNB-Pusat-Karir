@props(['id' => 'city', 'name' => 'city'])

<div>
    <select id="{{ $id }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full border rounded p-2']) }}>
        <option value="">-</option>
    </select>
</div>
