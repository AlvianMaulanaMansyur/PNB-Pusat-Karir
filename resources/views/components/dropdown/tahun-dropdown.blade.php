@props([
    'name' => 'tahun',
])

<div>
<select name="{{ $name }}" {{ $attributes->merge(['class' => 'block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
    <option value="">Pilih Tahun</option>
    @for ($i = date('Y'); $i >= 1990; $i--)
        <option value="{{ $i }}">{{ $i }}</option>
    @endfor
</select>
</div>