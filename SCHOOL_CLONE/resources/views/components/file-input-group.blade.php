@props(['label', 'name', 'error' => null, 'helpText' => null, 'accept' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>
    
    <div class="mt-1">
        <input 
            type="file" 
            id="{{ $name }}" 
            name="{{ $name }}"
            @if($accept) accept="{{ $accept }}" @endif
            {{ $attributes->merge(['class' => 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100' . ($error ? ' border-red-300' : '')]) }}
        />
    </div>
    
    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div>