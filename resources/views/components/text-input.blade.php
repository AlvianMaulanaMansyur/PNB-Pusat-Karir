@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-primaryColor rounded-md shadow-sm']) }}>
