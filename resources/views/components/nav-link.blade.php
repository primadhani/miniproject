@props(['active'])

@php
$classes = ($active ?? false)
    ? 'relative inline-flex items-center px-2 pt-1 text-sm font-semibold text-indigo-600 transition-all duration-300 ease-in-out
       after:absolute after:-bottom-1 after:left-0 after:h-[2px] after:w-full after:bg-indigo-600 after:rounded-full'
    : 'relative inline-flex items-center px-2 pt-1 text-sm font-medium text-gray-500 transition-all duration-300 ease-in-out
       hover:text-indigo-600
       after:absolute after:-bottom-1 after:left-0 after:h-[2px] after:w-0 after:bg-indigo-600 after:rounded-full
       hover:after:w-full after:transition-all after:duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
