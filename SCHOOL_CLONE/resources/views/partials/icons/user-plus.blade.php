<!-- resources/views/components/icon-calendar.blade.php -->
@props(['attributes'])

<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['fill' => 'none', 'viewBox' => '0 0 24 24', 'stroke' => 'currentColor']) }}>
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 3h-1V2a1 1 0 00-2 0v1H8V2a1 1 0 00-2 0v1H5a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM5 7h14v12H5V7z" />
</svg>

<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['fill' => 'none', 'viewBox' => '0 0 24 24', 'stroke' => 'currentColor']) }}>
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 8v6m3-3h-6m-4 4a4 4 0 100-8 4 4 0 000 8zm0 4c-4 0-7 2-7 4v1h14v-1c0-2-3-4-7-4z" />
</svg>
