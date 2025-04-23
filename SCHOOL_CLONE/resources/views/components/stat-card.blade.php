@props(['title', 'value', 'icon', 'color'])

<div class="bg-slate-800 rounded-lg shadow-md overflow-hidden border border-slate-700 transition duration-300 hover:border-{{ $color }}-500 hover:shadow-lg hover:shadow-{{ $color }}-500/10">
    <div class="flex items-center p-5">
        <div class="text-{{ $color }}-500 bg-{{ $color }}-500 bg-opacity-10 p-3 rounded-lg mr-4">
            <x-icon name="{{ $icon }}" class="h-6 w-6" />
        </div>
        <div class="flex-grow">
            <div class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $title }}</div>
            <div class="text-2xl font-bold text-white mt-1">{{ $value }}</div>
        </div>
    </div>
    <div class="h-1 bg-{{ $color }}-500"></div>
</div>
