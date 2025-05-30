@props(['rows' => 5])

<textarea
    {{ $attributes->merge(['class' => 'block mt-1 w-full rounded-md shadow-sm border-gray-700 focus:border-[#7397EA] focus:ring-[#7397EA] align-top']) }}
    rows= "{{ $rows }}"> {{ $slot ?? old($attributes->get('name')) }}
</textarea>
